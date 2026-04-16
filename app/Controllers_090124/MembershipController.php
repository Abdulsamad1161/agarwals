<?php

namespace App\Controllers;

use App\Models\LocationModel;
use App\Models\MembershipModel;
use App\Models\ProfileModel;

class MembershipController extends BaseAdminController
{
    protected $membershipModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        checkPermission('membership');
        $this->membershipModel = new MembershipModel();
    }

    /**
     * Users
     */
    public function users()
    {
        $data['title'] = trans("users");
        $numRows = $this->membershipModel->getUserCount();
        $pager = paginate($this->perPage, $numRows);
        $data['users'] = $this->membershipModel->getPaginatedUsers($this->perPage, $pager->offset);
        $data['roles'] = $this->membershipModel->getRoles();
        $data['membershipPlans'] = $this->membershipModel->getPlans();
        $data['membershipPlansUsers'] = $this->membershipModel->getPlansUsers();
        $data['panelSettings'] = getPanelSettings();
		//echo "<pre>";print_r($data);echo "</pre>";die;
        echo view('admin/includes/_header', $data);
        echo view('admin/membership/users');
        echo view('admin/includes/_footer');

    }
	
	/**
     * Users Migration
     */
    public function usersMigration()
    {
        $data['title'] = 'User Migration';
        $numRows = $this->membershipModel->getUserCount();
        $pager = paginate($this->perPage, $numRows);
        $data['panelSettings'] = getPanelSettings();
		$this->dataImport($data);
    }
	
	public function dataImport($data)
	{
		if(!empty($data['members_data']))
		{
			$upload_data_value = $data['members_data'];
		}
		
		if(!empty($upload_data_value))
		{
			$data['enable_upload'] = 1;
			$data['uploaded_data'] = $upload_data_value;
		}
		
		$data['title'] = 'User Migration';
        $numRows = $this->membershipModel->getUserCount();
        $pager = paginate($this->perPage, $numRows);
        $data['panelSettings'] = getPanelSettings();
		
		echo view('admin/includes/_header', $data);
        echo view('admin/membership/memberMigration', $data);
        echo view('admin/includes/_footer');
	}
	
	public function do_excel_import_members()
	{
		$data = array(); 
		if ($_FILES['file_path']['error']!=UPLOAD_ERR_OK)
		{
			$msg = "Import Failed, Check your file and continue uploading...";
			setErrorMessage($msg);
			return redirect()->to(adminUrl('users-migration'));
		}
		else
		{
			$handle = fopen($_FILES['file_path']['tmp_name'], "r");
			
			$fileExtension = pathinfo($_FILES['file_path']['name'], PATHINFO_EXTENSION);
			if (strtolower($fileExtension) !== 'csv') 
			{
				$msg = "Invalid file format. Only CSV files are allowed.";
				setErrorMessage($msg);
				return redirect()->to(adminUrl('users-migration'));
			}
			
	
			if ($handle !== FALSE) 
			{
				//Skip first row
				fgetcsv($handle);
				
				$errorMessages = array();
				
				$rowNumber = 2; 
				
				while (($data_get = fgetcsv($handle)) !== FALSE) {
					
					$firstName = $data_get[0];
					$lastName = $data_get[1];
					$email = $data_get[2];  
					$membershipType = $data_get[3];
					$membershipvalidity = $data_get[4];
					$duration = $data_get[5];

					
					if (empty($firstName)) {
						$errorMessages[] = "Row {$rowNumber}: First Name is required.";
					}
					
					if (empty($email)) {
						$errorMessages[] = "Row {$rowNumber}: Email is required.";
					}
					
					if (empty($membershipType)) {
						$errorMessages[] = "Row {$rowNumber}: Membership Type is required.";
					}
					
					if (empty($membershipvalidity)) {
						$errorMessages[] = "Row {$rowNumber}: Membership validity is required.";
					}
					else 
					{
						if (!preg_match('/^\d{2}-\d{2}-\d{4}$/', $membershipvalidity)) 
						{
							$errorMessages[] = "Row {$rowNumber}: Invalid Membership Validity format. Use 'dd/mm/yyyy'.";
						}
						else 
						{
							$dateParts = explode('-', $membershipvalidity);
							$day = $dateParts[0];
							$month = $dateParts[1];
							$year = $dateParts[2];

							if (!checkdate($month, $day, $year)) 
							{
								$errorMessages[] = "Row {$rowNumber}: Invalid date in Membership Validity.";
							}
						}
					}
					
					if (empty($duration)) {
						$errorMessages[] = "Row {$rowNumber}: Duration is required.";
					}

					$rowNumber++; 
				}

				fclose($handle);

				if (!empty($errorMessages)) {
					// There are validation errors, construct error messages with row numbers
					$formattedErrorMessages = array();
					
					foreach ($errorMessages as $errorMsg) {
						$formattedErrorMessages[] = $errorMsg;
					}

					$msg = implode("<br>", $formattedErrorMessages);
					setErrorMessage($msg);
					return redirect()->to(adminUrl('users-migration'));
				}
				
				$handle = fopen($_FILES['file_path']['tmp_name'], "r");  // Open the file again
				
				fgetcsv($handle);
				
				$i=0; 
				while (($data_get = fgetcsv($handle)) !== FALSE) 
				{ 
					$data['members_data'][] = array(
					'First_Name'	    =>	$data_get[0],
					'Last_Name' 	=>	$data_get[1],
					'Email'	=>	$data_get[2],
					'Membership_type'		=>	$data_get[3],
					'Membership_Validity'	=>	$data_get[4],
					'Duration'	=>	$data_get[5],
					);
	
					$i++;
				}
				fclose($handle);
				
				$enable_upload = 1;
			}	
			else 
			{
				$error_code = $_FILES['file_path']['error'];
				
				if ($error_code == UPLOAD_ERR_NO_TMP_DIR) 
				{
					$msg = "Temporary directory is not accessible. Please contact the administrator.";
				}
				elseif ($error_code == UPLOAD_ERR_CANT_WRITE)
				{
					$msg = "Failed to write to disk. Please try again later.";
				}
				else 
				{
					$msg = "Failed to open the file for unknown reasons. Please check the file and try again.";
				}
				
				setErrorMessage($msg);
				return redirect()->to(adminUrl('users-migration'));
			}
		}
		if($enable_upload == 1 )
		{
			$this->dataImport($data);
		}
	}
	
	function generatePassword($firstName, $email) 
	{
		$firstNamePart = substr($firstName, 0, 3);
		
		$emailPart = substr($email, 0, 3);
		
		$password = $firstNamePart . $emailPart . '23';
		
		return $password;
	}
	
	public function do_excel_import_from_screen_members()
	{
		$successMessages = [];
		$errorMessages = [];

		try {
			$firstNames = $this->request->getVar('First_Name');
			$lastNames = $this->request->getVar('Last_Name');
			$emails = $this->request->getVar('Email');
			$membershipTypes = $this->request->getVar('Membership_type');
			$membershipValidities = $this->request->getVar('Membership_Validity');
			$durations = $this->request->getVar('Duration');

			foreach ($firstNames as $index => $companyName) {
				try {
					$member_data = array(
						'first_name' => $firstNames[$index],
						'last_name' => $lastNames[$index],
						'email' => $emails[$index],
						'username' => $firstNames[$index] . ' ' . $lastNames[$index],
						'password' => $this->generatePassword($firstNames[$index], $emails[$index]),
					);

					if (!$this->authModel->isEmailUnique($emails[$index])) {
						$member = $this->authModel->getUserByEmail($emails[$index]);
						$success = $this->authModel->registerMigrationUpdate($member->id, $member_data['password']);

						if ($success) {
							$successMessages[] = "Data Updated successfully.";
						} else {
							$errorMessages[] = "Data Failed Updating for {$firstNames[$index]}.";
						}
					} else {
						$success = $this->authModel->registerMigration($member_data);

						if ($success) {
							$successMessages[] = "Data Imported successfully.";
						} else {
							$errorMessages[] = "Data Failed Importing for {$firstNames[$index]}.";
						}
					}

					$plan = $this->membershipModel->getPlanByTitleDuration($membershipTypes[$index],$durations[$index]);

					if (!empty($plan)) {
						$plan_data = array(
							'plan_id' => $plan->id,
							'plan_title' => $plan->title,
							'number_of_days' => $plan->number_of_days,
							'price' => $plan->price,
							'user_id' => $success,
							'plan_start_date' => date('Y-m-d H:i:s'),
							'plan_end_date' => $membershipValidities[$index],
						);

						$planSuccess = $this->membershipModel->addUserPlanSubsMigration($plan_data , $success);

						if ($planSuccess) {
							$successMessages[] = "Membership Plans Imported successfully.";
						} else {
							$errorMessages[] = "Failed to add membership plan for {$firstNames[$index]}.";
						}
					} else {
						$errorMessages[] = "Invalid plan title: {$membershipTypes[$index]}. Please check the plan title.";
					}
				} catch (Exception $e) {
					error_log("Database error: " . $e->getMessage());
					$errorMessages[] = "An error occurred during database operation for {$firstNames[$index]}.";
				}
			}

			if (empty($errorMessages)) {
				setSuccessMessage('Members and Their Plans Added Successfully. Confirmation Email Sent.');
			} else {
				$errorMsg = implode("<br>", $errorMessages);
				setErrorMessage($errorMsg);
			}
		} catch (Exception $e) {
			error_log("Unexpected error: " . $e->getMessage());
			setErrorMessage("An unexpected error occurred. Please try again later.");
		}

		return redirect()->to(adminUrl('users-migration'));
	}
	
	public function excel_member_template()
	{
		return $this->response->download('import_members.csv', null);
	}

    /**
     * Add User
     */
    public function addUser()
    {
        $data['title'] = trans("add_user");
        $data['roles'] = $this->membershipModel->getRoles();

        echo view('admin/includes/_header', $data);
        echo view('admin/membership/add_user');
        echo view('admin/includes/_footer');
    }

    /**
     * Add User Post
     */
    public function addUserPost()
    {
        $val = \Config\Services::validation();
        $val->setRule('email', trans("email"), 'required|max_length[200]');
        $val->setRule('password', trans("password"), 'required|min_length[4]|max_length[50]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $email = inputPost('email');
            $username = inputPost('username');
            //is username unique
            if (!$this->authModel->isUniqueUsername($username)) {
                setErrorMessage(trans("msg_username_unique_error"));
                return redirect()->back()->withInput();
            }
            //is email unique
            if (!$this->authModel->isEmailUnique($email)) {
                setErrorMessage(trans("msg_email_unique_error"));
                return redirect()->back()->withInput();
            }
            //add user
            if ($this->authModel->addUser()) {
                setSuccessMessage(trans("msg_administrator_added"));
            } else {
                setErrorMessage(trans("msg_error"));
            }
            redirectToBackUrl();
        }
    }

    /**
     * Edit User
     */
    public function editUser($id)
    {
        $data['title'] = trans("edit_user");
        $data['user'] = getUser($id);
        if (empty($data['user'])) {
            return redirect()->to(adminUrl('members'));
        }
        $role = getRoleById($data['user']->role_id);
        if (empty($role)) {
            return redirect()->to(adminUrl('members'));
        }
        if ($role->is_super_admin == 1) {
            $activeUserRole = getRoleById(user()->role_id);
            if (!empty($activeUserRole) && $activeUserRole->is_super_admin != 1) {
                return redirect()->to(adminUrl('members'));
            }
        }
        $locationModel = new LocationModel();
        $data['countries'] = $locationModel->getCountries();
        $data['states'] = $locationModel->getStatesByCountry($data['user']->country_id);
        $data['cities'] = $locationModel->getCitiesByState($data['user']->state_id);
        $data['panelSettings'] = getPanelSettings();
        echo view('admin/includes/_header', $data);
        echo view('admin/membership/edit_user', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Edit User Post
     */
    public function editUserPost()
    {
        $val = \Config\Services::validation();
        $val->setRule('email', trans("email"), 'required|max_length[200]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $data = [
                'id' => inputPost('id'),
                'username' => inputPost('username'),
                'slug' => inputPost('slug'),
                'email' => inputPost('email')
            ];
            $user = getUser($data['id']);
            if (!empty($user)) {
                $role = getRoleById($user->role_id);
                if (empty($role)) {
                    return redirect()->to(adminUrl('members'));
                }
                if ($role->is_super_admin == 1) {
                    $activeUserRole = getRoleById(user()->role_id);
                    if (!empty($activeUserRole) && $activeUserRole->is_super_admin != 1) {
                        return redirect()->to(adminUrl('members'));
                    }
                }
                //is email unique
                if (!$this->authModel->isEmailUnique($data['email'], $data['id'])) {
                    setErrorMessage(trans("msg_email_unique_error"));
                    redirectToBackUrl();
                }
                //is username unique
                if (!$this->authModel->isUniqueUsername($data['username'], $data['id'])) {
                    setErrorMessage(trans("msg_username_unique_error"));
                    redirectToBackUrl();
                }
                //is slug unique
                if (!$this->authModel->isSlugUnique($data['slug'], $data['id'])) {
                    setErrorMessage(trans("msg_slug_unique_error"));
                    redirectToBackUrl();
                }
                $profileModel = new ProfileModel();
                if ($profileModel->editUser($data['id'])) {
                    setSuccessMessage(trans("msg_updated"));
                    redirectToBackUrl();
                }
            }
        }
        setErrorMessage(trans("msg_error"));
        redirectToBackUrl();
    }

    /**
     * Shop Opening Requests
     */
    public function shopOpeningRequests()
    {
        $data['title'] = trans("shop_opening_requests");
        $numRows = $this->membershipModel->getShopOpeningRequestsCount();
        $pager = paginate($this->perPage, $numRows);
        $data['users'] = $this->membershipModel->getShopOpeningRequestsPaginated($this->perPage, $pager->offset);

        echo view('admin/includes/_header', $data);
        echo view('admin/membership/shop_opening_requests');
        echo view('admin/includes/_footer');
    }

    /**
     * Approve Shop Opening Request
     */
    public function approveShopOpeningRequest()
    {
        $userId = inputPost('id');
        if ($this->membershipModel->approveShopOpeningRequest($userId)) {
            $submit = inputPost('submit');
            $emailContent = trans("your_shop_opening_request_approved");
            $emailButtonText = trans("start_selling");
            if ($submit == 0) {
                $emailContent = trans("msg_shop_request_declined");
                $emailButtonText = trans("view_site");
            }
            //send email
            $user = getUser($userId);
            if (!empty($user) && $this->generalSettings->send_email_shop_opening_request == 1) {
                $emailData = [
                    'email_type' => 'new_shop',
                    'email_address' => $user->email,
                    'email_subject' => trans("shop_opening_request"),
                    'template_path' => 'email/main',
                    'email_data' => serialize(['content' => $emailContent, 'url' => base_url(), 'buttonText' => $emailButtonText])
                ];
                addToEmailQueue($emailData);
            }
            setSuccessMessage(trans("msg_updated"));
            redirectToBackUrl();
        }
        setErrorMessage(trans("msg_error"));
        redirectToBackUrl();
    }

    /**
     * Assign Membership Plan
     */
    public function assignMembershipPlanPost()
    {
        $userId = inputPost('user_id');
        $planId = inputPost('plan_id');
        $user = getUser($userId);
        $plan = $this->membershipModel->getPlan($planId);
        if (!empty($plan) && !empty($user)) {
            $dataTransaction = [
                'payment_method' => '',
                'payment_status' => ''
            ];
            if ($plan->is_free == 1) {
                $this->membershipModel->addUserFreePlan($plan, $user->id);
            } else {
                $this->membershipModel->addUserPlan($dataTransaction, $plan, $user->id);
            }
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    /**
     * Confirm User Email
     */
    public function confirmUserEmail()
    {
        $id = inputPost('id');
        $user = getUser($id);
        if ($this->authModel->verifyEmail($user)) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
    }

    /**
     * Ban or Remove User Ban
     */
    public function banRemoveBanUser()
    {
        $id = inputPost('id');
        if ($this->authModel->banUser($id)) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
    }

    /**
     * Delete User
     */
    public function deleteUserPost()
    {
        $id = inputPost('id');
        if ($this->authModel->deleteUser($id)) {
            setSuccessMessage(trans("msg_deleted"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
    }

    /*
     * --------------------------------------------------------------------
     * Membership Plans
     * --------------------------------------------------------------------
     */

    /**
     * Membership Plans
     */
    public function membershipPlans()
    {
        $data['title'] = trans("membership_plans");
        $data['membershipPlans'] = $this->membershipModel->getPlans();
        $data['panelSettings'] = getPanelSettings();
        echo view('admin/includes/_header', $data);
        echo view('admin/membership/membership_plans');
        echo view('admin/includes/_footer');
    }

    /**
     * Add Plan Post
     */
    public function addPlanPost()
    {
        if ($this->membershipModel->addPlan()) {
            setSuccessMessage(trans("msg_added"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    /**
     * Edit Plan
     */
    public function editPlan($id)
    {
        $data['title'] = trans("edit_plan");
        $data['plan'] = $this->membershipModel->getPlan($id);
        if (empty($data['plan'])) {
            return redirect()->to(adminUrl('membership-plans'));
        }
        echo view('admin/includes/_header', $data);
        echo view('admin/membership/edit_plan');
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Plan Post
     */
    public function editPlanPost()
    {
        $id = inputPost('id', true);
        if ($this->membershipModel->editPlan($id)) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    /**
     * Settings Post
     */
    public function settingsPost()
    {
        if ($this->membershipModel->updateSettings()) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    /**
     * Delete Plan Post
     */
    public function deletePlanPost()
    {
        $id = inputPost('id');
        $this->membershipModel->deletePlan($id);
    }

    /**
     * Membership Transactions
     */
    public function transactionsMembership()
    {
        $data['title'] = trans("membership_transactions");
        $data['numRows'] = $this->membershipModel->getMembershipTransactionsCount(null);
        $pager = paginate($this->perPage, $data['numRows']);
        $data['transactions'] = $this->membershipModel->getMembershipTransactionsPaginated(null, $this->perPage, $pager->offset);

        echo view('admin/includes/_header', $data);
        echo view('admin/membership/transactions');
        echo view('admin/includes/_footer');
    }
	
	public function transactionsMembershipUsers()
    {
        $data['title'] = trans("membership_transactions");
        $data['numRows'] = $this->membershipModel->getMembershipTransactionsCountUsers(null);
        $pager = paginate($this->perPage, $data['numRows']);
        $data['transactions'] = $this->membershipModel->getMembershipTransactionsPaginatedUsers(null, $this->perPage, $pager->offset);

        echo view('admin/includes/_header', $data);
        echo view('admin/membership/transactions_users');
        echo view('admin/includes/_footer');
    }

    /**
     * Approve Payment Post
     */
    public function approvePaymentPost()
    {
        $id = inputPost('id');
        $this->membershipModel->approveTransactionPayment($id);
        setSuccessMessage(trans("msg_updated"));
        redirectToBackUrl();
    }
	
	public function approvePaymentPostUsers()
    {
        $id = inputPost('id');
        $this->membershipModel->approveTransactionPaymentUsers($id);
        setSuccessMessage(trans("msg_updated"));
        redirectToBackUrl();
    }

    /**
     * Delete Transactions Post
     */
    public function deleteTransactionPost()
    {
        $id = inputPost('id');
        $this->membershipModel->deleteTransaction($id);
    } 
	
	/**
     * Delete Transactions Post users
     */
    public function deleteTransactionUsersPost()
    {
        $id = inputPost('id');
        $this->membershipModel->deleteTransactionUsers($id);
    }

    /*
     * --------------------------------------------------------------------
     * Roles & Permissions
     * --------------------------------------------------------------------
     */

    /**
     * Add Role
     */
    public function addRole()
    {
        $data['title'] = trans("add_role");
        echo view('admin/includes/_header', $data);
        echo view('admin/membership/add_role');
        echo view('admin/includes/_footer');
    }


    /**
     * Add Role Post
     */
    public function addRolePost()
    {
        if ($this->membershipModel->addRole()) {
            setSuccessMessage(trans("msg_added"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    /**
     * Roles Permissions
     */
    public function rolesPermissions()
    {
        $data['title'] = trans("roles_permissions");
        $data['description'] = trans("roles_permissions");
        $data['keywords'] = trans("roles_permissions");
        $data['roles'] = $this->membershipModel->getRoles();
        $data['panelSettings'] = getPanelSettings();
        echo view('admin/includes/_header', $data);
        echo view('admin/membership/roles_permissions');
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Role
     */
    public function editRole($id)
    {
        $data['title'] = trans("edit_role");
        $data['role'] = $this->membershipModel->getRole($id);
        if (empty($data['role'])) {
            return redirect()->to(adminUrl('roles-permissions'));
        }
        echo view('admin/includes/_header', $data);
        echo view('admin/membership/edit_role');
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Role Post
     */
    public function editRolePost()
    {
        $id = inputPost('id');
        if ($this->membershipModel->editRole($id)) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    /**
     * Change User Role Post
     */
    public function changeUserRolePost()
    {
        $userId = inputPost('user_id');
        $roleId = inputPost('role_id');
        if ($this->membershipModel->changeUserRole($userId, $roleId)) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    /**
     * Delete Role Post
     */
    public function deleteRolePost()
    {
        $id = inputPost('id');
        $role = $this->membershipModel->getRole($id);
        if (!empty($role)) {
            if ($role->is_default == 1) {
                setErrorMessage(trans("msg_error"));
                exit();
            }
            if ($this->membershipModel->deleteRole($id)) {
                setSuccessMessage(trans("msg_deleted"));
                exit();
            }
        }
        setErrorMessage(trans("msg_error"));
    }
	
	public function epaymentReportMembershipUsers()
	{
		$data['title'] = trans("report");
        $data['tickets_epayment'] = $this->membershipModel->getEpaymentMembershipUsers();
		 
        echo view('admin/includes/_header', $data);
        echo view('admin/membership/report_payment_users', $data);
        echo view('admin/includes/_footer');
	}
	
	public function editMembershipEpaymentDataUsers($id)
	{
		$data['title'] = 'Update Epayment';
        $data['tickets'] = $this->membershipModel->getEpaymentDataMembershipUsers($id);
		
        if (empty($data['tickets'])) 
		{
			setErrorMessage('Error Occured, No relavant data refresh and try again');
            redirectToUrl(adminUrl('transactions-membership-users-epayment'));
        }

        echo view('admin/includes/_header', $data);
        echo view('admin/membership/edit_membership_users_epayment', $data);
        echo view('admin/includes/_footer');
	}
	
	public function editApproveEpayment()
	{
		$status = $this->membershipModel->updateEpaymentApproveMembershipUsers();
		
		if($status)
		{
			$transactionInsertId = helperGetSession('mds_membership_transaction_insert_id');
			$tickets = $this->membershipModel->getMemberShipInvoiceDataUsers($transactionInsertId);
			//echo "<pre>";print_r($tickets);die;
			helperSetSession('tickets', $tickets);
			setSuccessMessage('Membership Approved and mail is sent to the member');
		}
		else
		{
			setErrorMessage(trans("msg_error"));
		}
        return redirect()->to(adminUrl('transactions-membership-users-epayment'));
	}
	
	public function rejectEpaymentApprovalMembershipUsers()
	{
		$random_ref_no = inputPost('id');
		
		$status = $this->membershipModel->rejectEpaymentApprovalMembershipUsers($random_ref_no);
		
		if($status)
		{
			setSuccessMessage('Membership Rejected Successfully');
		}
		else
		{
			setErrorMessage(trans("msg_error"));
		}
	}
	
	public function epaymentReportMembership()
	{
		$data['title'] = trans("report");
        $data['tickets_epayment'] = $this->membershipModel->getEpaymentMembership();
		 
        echo view('admin/includes/_header', $data);
        echo view('admin/membership/report_payment_business', $data);
        echo view('admin/includes/_footer');
	}
	
	public function editMembershipEpaymentData($id)
	{
		$data['title'] = 'Update Epayment';
        $data['tickets'] = $this->membershipModel->getEpaymentDataMembership($id);
		
        if (empty($data['tickets'])) 
		{
			setErrorMessage('Error Occured, No relavant data refresh and try again');
            redirectToUrl(adminUrl('transactions-membership-epayment'));
        }

        echo view('admin/includes/_header', $data);
        echo view('admin/membership/edit_membership_epayment', $data);
        echo view('admin/includes/_footer');
	}
	
	public function editApproveBuisnessEpayment()
	{
		$status = $this->membershipModel->updateEpaymentApproveMembership();
		
		if($status)
		{
			$transactionInsertId = helperGetSession('mds_membership_transaction_insert_id');
			$tickets = $this->membershipModel->getMemberShipInvoiceData($transactionInsertId);
			
			helperSetSession('tickets', $tickets);
			setSuccessMessage('Business Membership Approved and mail is sent to the member');
		}
		else
		{
			setErrorMessage(trans("msg_error"));
		}
        return redirect()->to(adminUrl('transactions-membership-epayment'));
	}
	
	public function rejectEpaymentApprovalMembership()
	{
		$random_ref_no = inputPost('id');
		
		$status = $this->membershipModel->rejectEpaymentApprovalMembership($random_ref_no);
		
		if($status)
		{
			setSuccessMessage('Business Membership Rejected Successfully');
		}
		else
		{
			setErrorMessage(trans("msg_error"));
		}
	}
	
	public function SetSelectedUsers()
	{
		if ($this->request->getVar()) 
		{
			if ($this->request->getVar('confirmed')) {
				$selected = 'confirmed';
			}
			else 
			{
				$selected = 'unconfirmed';
			}
		}
		
		$users = $this->membershipModel->getUsersToSendEmail($selected);
        
		if(!empty($users))
		{
			foreach($users as $user)
			{
				$pass = $this->generatePassword($user->first_name, $user->email);
				
				$success = $this->authModel->registerMigrationUpdate($user->id, $pass);

				if ($success) {
					$successMessages[] = "Data Updated successfully.";
				} else {
					$errorMessages[] = "Data Failed Updating for {$user->username}.";
				}
			}
			
			if (empty($errorMessages)) {
				setSuccessMessage('Email Has Been Sent To The Selected Members');
			}
			else 
			{
				$errorMsg = implode("<br>", $errorMessages);
				setErrorMessage($errorMsg);
			}
		}
		return redirect()->to(adminUrl('users'));
	}
}

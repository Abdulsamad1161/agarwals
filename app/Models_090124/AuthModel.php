<?php namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends BaseModel
{
    protected $builder;
    protected $builderMemberDetails;
    protected $builderMemberPlans;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('users');
		$this->builderMemberDetails = $this->db->table('member_other_details');
		$this->builderMemberPlans = $this->db->table('users_membership_plans_subs');
    }

    //input values
    public function inputValues()
    {
        return [
            'username' => removeSpecialCharacters(inputPost('username')),
            'email' => inputPost('email'),
            'first_name' => inputPost('first_name'),
            'last_name' => inputPost('last_name'),
            'phone_number' => inputPost('phone_number'),
            'password' => inputPost('password')
        ];
    }

    //login
    public function login()
    {
        $data = $this->inputValues();
        $primaryUser = $this->getUserByEmail($data['email']);
		
		$secondaryUser = $this->getUserBySecondaryEmail($data['email']);
		
		if(empty($secondaryUser))
		{
			$userLoginType = 2;
		}
		else
		{
			$userLoginType = 1;
		}
		
		if (empty($primaryUser) && empty($secondaryUser)) 
		{
			setErrorMessage(trans("login_error"));
			return false;
		}
		
		$authenticatedUser = !empty($primaryUser) ? $primaryUser : $secondaryUser;
		
        if (!empty($authenticatedUser)) {
			
			if (!empty($primaryUser)) {
				if (!password_verify($data['password'], $authenticatedUser->password)) {
					setErrorMessage(trans("login_error"));
					return false;
				}
			}
			else
			{
				if (!password_verify($data['password'], $authenticatedUser->secondary_password)) {
					setErrorMessage(trans("login_error"));
					return false;
				}
			}
			
            if ($authenticatedUser->email_status != 1) {
                setErrorMessage(trans("msg_confirmed_required") . "&nbsp;<a href='javascript:void(0)' class='color-link link-underlined link-mobile-alert' onclick=\"sendActivationEmail('" . $authenticatedUser->token . "', 'login');\">" . trans("resend_activation_email") . "</a>");
                return false;
            }
            if ($authenticatedUser->banned == 1) {
                setErrorMessage(trans("msg_ban_error"));
                return false;
            }
			
			if($authenticatedUser->two_factor == 1)
			{
				$this->loginUserOTP($authenticatedUser,$userLoginType);
				return 1;
			}
			else
			{
				$this->loginUser($authenticatedUser);
				return true;	
			}
        }
        setErrorMessage(trans("login_error"));
        return false;
    }

    //login user
    public function loginUser($user)
    {
        if (!empty($user)) {
            $userData = [
                'mds_ses_id' => $user->id,
                'mds_ses_role_id' => $user->role_id,
                'mds_ses_pass' => md5($user->password ?? '')
            ];
            $this->session->set($userData);
        }
    } 
	
	//login user OTP
    public function loginUserOTP($user,$type)
    {
        if (!empty($user)) {
			if($type == 1)
			{
				$this->session->set('emailUser',$user->secondary_email);
			}
			else
			{
				$this->session->set('emailUser',$user->email);
			}
			
            $this->session->set('get_user_id_otp',$user->id);
        }
    }
	
	public function createUserSessionAfterOTP($user_id)
	{
		$user = $this->getUser($user_id);
		if (!empty($user)) {
			$userData = [
                'mds_ses_id' => $user->id,
                'mds_ses_role_id' => $user->role_id,
                'mds_ses_pass' => md5($user->password ?? '')
            ];
            $this->session->set($userData);
			return true;
		}
	}

    //login with facebook
    public function loginWithFacebook($fbUser)
    {
        if (!empty($fbUser)) {
            $user = $this->getUserByEmail($fbUser->email);
            if (empty($user)) {
                if (empty($fbUser->name)) {
                    $fbUser->name = 'user-' . uniqid();
                }
                $username = $this->generateUniqueUsername($fbUser->name);
                $slug = $this->generateUniqueSlug($username);
                $data = [
                    'facebook_id' => $fbUser->id,
                    'email' => $fbUser->email,
                    'email_status' => 1,
                    'token' => generateToken(),
                    'role_id' => 3,
                    'username' => $username,
                    'first_name' => $fbUser->firstName,
                    'last_name' => $fbUser->lastName,
                    'slug' => $slug,
                    'avatar' => '',
                    'user_type' => 'facebook',
                    'last_seen' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                if ($this->generalSettings->vendor_verification_system != 1) {
                    $data['role_id'] = 2;
                }
                if (!empty($data['email'])) {
                    $this->builder->insert($data);
                    $user = $this->getUserByEmail($fbUser->email);
                    if (!empty($user)) {
                        $this->downloadSocialProfileImage($user, $fbUser->pictureURL);
                    }
                }
            }
        }
        if (!empty($user)) {
            if ($user->banned == 1) {
                setErrorMessage(trans("msg_ban_error"));
                return false;
            }
            $this->loginUser($user);
        }
    }

    //login with google
    public function loginWithGoogle($gUser)
    {
        if (!empty($gUser)) {
            $user = $this->getUserByEmail($gUser->email);
            if (empty($user)) {
                if (empty($gUser->name)) {
                    $gUser->name = 'user-' . uniqid();
                }
                $username = $this->generateUniqueUsername($gUser->name);
                $slug = $this->generateUniqueSlug($username);
                $data = [
                    'google_id' => $gUser->id,
                    'email' => $gUser->email,
                    'email_status' => 1,
                    'token' => generateToken(),
                    'role_id' => 3,
                    'username' => $username,
                    'first_name' => $gUser->firstName,
                    'last_name' => $gUser->lastName,
                    'slug' => $slug,
                    'avatar' => '',
                    'user_type' => 'google',
                    'last_seen' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                if ($this->generalSettings->vendor_verification_system != 1) {
                    $data['role_id'] = 2;
                }
                if (!empty($data['email'])) {
                    $this->builder->insert($data);
                    $user = $this->getUserByEmail($gUser->email);
                    if (!empty($user)) {
                        $this->downloadSocialProfileImage($user, $gUser->avatar);
                    }
                }
            }
        }
        if (!empty($user)) {
            if ($user->banned == 1) {
                setErrorMessage(trans("msg_ban_error"));
                return false;
            }
            $this->loginUser($user);
        }
    }

    //login with vk
    public function loginWithVK($vkUser)
    {
        if (!empty($vkUser)) {
            $user = $this->getUserByEmail($vkUser->email);
            if (empty($user)) {
                if (empty($vkUser->name)) {
                    $vkUser->name = 'user-' . uniqid();
                }
                $username = $this->generateUniqueUsername($vkUser->name);
                $slug = $this->generateUniqueSlug($username);
                $data = [
                    'vkontakte_id' => $vkUser->id,
                    'email' => $vkUser->email,
                    'email_status' => 1,
                    'token' => generateToken(),
                    'role_id' => 3,
                    'username' => $username,
                    'first_name' => $vkUser->firstName,
                    'last_name' => $vkUser->lastName,
                    'slug' => $slug,
                    'avatar' => '',
                    'user_type' => 'vkontakte',
                    'last_seen' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                if ($this->generalSettings->vendor_verification_system != 1) {
                    $data['role_id'] = 2;
                }
                if (!empty($data['email'])) {
                    $this->builder->insert($data);
                    $user = $this->getUserByEmail($vkUser->email);
                    if (!empty($user)) {
                        $this->downloadSocialProfileImage($user, $vkUser->avatar);
                    }
                }
            }
        }
        if (!empty($user)) {
            if ($user->banned == 1) {
                setErrorMessage(trans("msg_ban_error"));
                return false;
            }
            $this->loginUser($user);
        }
    }

    //download social profile image
    public function downloadSocialProfileImage($user, $imgURL)
    {
        if (!empty($user) && !empty($imgURL)) {
            $uploadModel = new UploadModel();
            $tempPath = $uploadModel->downloadTempImage($imgURL, 'jpg', 'profile_temp');
            if (!empty($tempPath) && file_exists($tempPath)) {
                $data['avatar'] = $uploadModel->uploadAvatar($tempPath);
            }
            if (!empty($data) && !empty($data['avatar'])) {
                $this->builder->where('id', $user->id)->update($data);
            }
        }
    }
	
	public function inputValuesNew()
    {
        return [
            'username' => removeSpecialCharacters(inputPost('username')),
            'email' => inputPost('email'),
            'first_name' => inputPost('fname'),
            'last_name' => inputPost('lname'),
            'phone_number' => inputPost('phone')
        ];
    }
	
	public function loginUserNew($user)
    {
        if (!empty($user)) {
            $userData = [
                'mds_ses_id' => $user->id,
                'mds_ses_role_id' => $user->role_id,
            ];
            $this->session->set($userData);
        }
    }
	
	public function loginUserNewData($user)
    {
        if (!empty($user)) {
            $userData = [
                'mds_ses_id' => $user->id,
                'mds_ses_role_id' => $user->role_id,
            ];
          return $this->session->set($userData);
        }
    }
	
    //register
    public function registerNew()
    {
        $data = $this->inputValuesNew();
        $data['username'] = $data['first_name'] . ' ' . $data['last_name'];
        $data['slug'] = $this->generateUniqueSlug($data['username']);
        $data['role_id'] = 3;
        $data['user_type'] = 'registered';
        $data['banned'] = 0;
        $data['token'] = generateToken();
        $data['last_seen'] = date('Y-m-d H:i:s');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['email_status'] = 1;
        
        $user = null;
        if ($this->builder->insert($data)) {
            $id = $this->db->insertID();
			
			$other_data['member_id'] = $id;
			$this->builderMemberDetails->insert($other_data);
			
            $this->updateSlug($id);
            $user = $this->getUser($id);
            if (!empty($user)) {
				$this->loginUserNew($user);
            }
            return true;
        }
        return false;
    }
	
	public function register()
    {
        $data = $this->inputValues();
        $data['username'] = $data['first_name'] . ' ' . $data['last_name'];
        $data['slug'] = $this->generateUniqueSlug($data['username']);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['role_id'] = 3;
        $data['user_type'] = 'registered';
        $data['banned'] = 0;
        $data['token'] = generateToken();
        $data['last_seen'] = date('Y-m-d H:i:s');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['email_status'] = 1;
        if ($this->generalSettings->email_verification == 1) {
            $data['email_status'] = 0;
        }
        if ($this->generalSettings->vendor_verification_system != 1) {
            $data['role_id'] = 2;
        }
        $user = null;
        if ($this->builder->insert($data)) {
            $id = $this->db->insertID();
			
			$other_data['member_id'] = $id;
			$this->builderMemberDetails->insert($other_data);
			
            $this->updateSlug($id);
            $user = $this->getUser($id);
            if (!empty($user)) {
                if ($this->generalSettings->email_verification == 1) {
                    $this->addActivationEmail($user);
                    redirectToUrl(generateUrl('register_success') . '?u=' . $user->token);
                } else {
                    $this->loginUser($user);
                }
            }
            return true;
        }
        return false;
    }
	
	//register migration
    public function registerMigration($data)
    {
		$pass = $data['password'];
        $data['username'] = $data['first_name'] . ' ' . $data['last_name'];
        $data['slug'] = $this->generateUniqueSlug($data['username']);
        $data['email'] = $data['email'];
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['role_id'] = 3;
        $data['user_type'] = 'registered';
        $data['banned'] = 0;
        $data['token'] = generateToken();
        $data['last_seen'] = date('Y-m-d H:i:s');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['email_status'] = 1;
        if ($this->generalSettings->email_verification == 1) {
            $data['email_status'] = 0;
        }
        if ($this->generalSettings->vendor_verification_system != 1) {
            $data['role_id'] = 2;
        }
        $user = null;
        if ($this->builder->insert($data)) {
            $id = $this->db->insertID();
			
			$other_data['member_id'] = $id;
			$this->builderMemberDetails->insert($other_data);
			
            $this->updateSlug($id);
            $user = $this->getUser($id);
            if (!empty($user)) {
                if ($this->generalSettings->email_verification == 1) {
                   $this->addActivationEmailMigration($user, $pass);
                } 
            }
            return $id;
        }
        return false;
    }
	
	//register migration update data
    public function registerMigrationUpdate($mem_id, $pass)
    {
        $data['password'] = password_hash($pass, PASSWORD_DEFAULT);
        $data['token'] = generateToken();
        $data['email_status'] = 1;
        if ($this->generalSettings->email_verification == 1) {
            $data['email_status'] = 0;
        }
        if ($this->generalSettings->vendor_verification_system != 1) {
            $data['role_id'] = 2;
        }
        $user = null;
		$this->builder->where('id',$mem_id);
        if ($this->builder->update($data)) {
            $id = $mem_id;
			
            $user = $this->getUser($id);
            if (!empty($user)) {
                if ($this->generalSettings->email_verification == 1) {
                   $this->addActivationEmailMigration($user, $pass);
                } 
            }
            return $id;
        }
        return false;
    }

    //generate unique username
    public function generateUniqueUsername($username)
    {
        $newUsername = $username;
        if (!empty($this->getUserByUsername($newUsername))) {
            $newUsername = $username . ' 1';
            if (!empty($this->getUserByUsername($newUsername))) {
                $newUsername = $username . ' 2';
                if (!empty($this->getUserByUsername($newUsername))) {
                    $newUsername = $username . ' 3';
                    if (!empty($this->getUserByUsername($newUsername))) {
                        $newUsername = $username . '-' . uniqid();
                    }
                }
            }
        }
        return $newUsername;
    }

    //generate uniqe slug
    public function generateUniqueSlug($username)
    {
        $slug = strSlug($username);
        if (!empty($this->getUserBySlug($slug))) {
            $slug = strSlug($username . '-1');
            if (!empty($this->getUserBySlug($slug))) {
                $slug = strSlug($username . '-2');
                if (!empty($this->getUserBySlug($slug))) {
                    $slug = strSlug($username . '-3');
                    if (!empty($this->getUserBySlug($slug))) {
                        $slug = strSlug($username . '-' . uniqid());
                    }
                }
            }
        }
        return $slug;
    }

    //add user
    public function addUser()
    {
        $data = $this->inputValues();
        $data['username'] = $this->generateUniqueUsername($data['first_name'] . ' ' . $data['last_name']);
        $data['slug'] = $this->generateUniqueSlug($data['username']);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['role_id'] = inputPost('role_id');
        $data['user_type'] = 'registered';
        $data['banned'] = 0;
        $data['email_status'] = 1;
        $data['token'] = generateToken();
        $data['last_seen'] = date('Y-m-d H:i:s');
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->builder->insert($data);
    }

    //logout
    public function logout()
    {
        $this->session->remove('mds_ses_id');
        $this->session->remove('mds_ses_role_id');
        $this->session->remove('mds_ses_pass');
    }

    //reset password
    public function resetPassword($user)
    {
        if (!empty($user)) {
            $data = [
                'password' => password_hash(inputPost('password'), PASSWORD_DEFAULT),
                'token' => generateToken()
            ];
            return $this->builder->where('id', $user->id)->update($data);
        }
        return false;
    }

    //update last seen time
    public function updateLastSeen()
    {
        if (authCheck()) {
            $this->builder->where('id', user()->id)->update(['last_seen' => date('Y-m-d H:i:s')]);
        }
    }

    //query user
    public function buildQueryUser()
    {
        $this->builder->resetQuery();
        $this->builder->select('users.*, (SELECT permissions FROM roles_permissions WHERE roles_permissions.id = users.role_id LIMIT 1) AS permissions');
    }

    //get user by id
    public function getUser($id)
    {
        $this->buildQueryUser();
        return $this->builder->where('users.id', clrNum($id))->get()->getRow();
    }

    //get user by email
    public function getUserByEmail($email)
    {
        $this->buildQueryUser();
        return $this->builder->where('users.email', removeSpecialCharacters($email))->get()->getRow();
    }
	
	//get user by secondary email
    public function getUserBySecondaryEmail($email)
    {
        $this->buildQueryUser();
        return $this->builder->where('users.secondary_email', removeSpecialCharacters($email))->get()->getRow();
    }

    //get user by username
    public function getUserByUsername($username)
    {
        $this->buildQueryUser();
        return $this->builder->where('users.username', removeSpecialCharacters($username))->get()->getRow();
    }

    //get user by slug
    public function getUserBySlug($slug)
    {
        $this->buildQueryUser();
        return $this->builder->where('users.slug', removeSpecialCharacters($slug))->get()->getRow();
    }

    //get user by token
    public function getUserByToken($token)
    {
        $this->buildQueryUser();
        return $this->builder->where('users.token', removeSpecialCharacters($token))->get()->getRow();
    }

    //get users
    public function getUsers()
    {
        return $this->builder->orderBy('id')->get()->getResult();
    }

    //get users count
    public function getUsersCount()
    {
        return $this->builder->countAllResults();
    }

    //get users count by role
    public function getVendorsCount()
    {
        $this->filterVendors();
        return $this->builder->countAllResults();
    }

    //get paginated vendors
    public function getVendorsPaginated($perPage, $offset)
    {
        $this->filterVendors();
        return $this->builder->orderBy('num_products DESC, created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //filter vendor
    public function filterVendors()
    {
        $q = removeSpecialCharacters(inputGet('q'));
        $this->builder->select('users.*, (SELECT COUNT(id) FROM products WHERE users.id = products.user_id AND products.status = 1 AND products.visibility = 1 AND products.is_draft = 0 AND products.is_deleted = 0) AS num_products');
        if ($this->generalSettings->vendor_verification_system == 1) {
            $this->builder->where('(SELECT COUNT(id) FROM products WHERE users.id = products.user_id AND products.status = 1 AND products.visibility = 1 AND products.is_draft = 0 AND products.is_deleted = 0) > 0');
        }
        $this->builder->groupStart()->where('banned', 0)->groupEnd();
        if (!empty($q)) {
            $this->builder->groupStart()->like('users.username', cleanStr($q))->groupEnd();
        }
    }

    //get latest users
    public function getLatestUsers($limit)
    {
        return $this->builder->orderBy('id DESC')->get(clrNum($limit))->getResult();
    }

    //update slug
    public function updateSlug($id)
    {
        $user = $this->getUser($id);
        if (empty($user->slug) || $user->slug == '-') {
            $this->builder->where('id', $user->id)->update(['slug' => 'user-' . $user->id]);
        } else {
            if (!$this->isSlugUnique($user->slug, $id) == true) {
                $this->builder->where('id', $user->id)->update([$user->slug . '-' . $user->id]);
            }
        }
    }

    //is slug unique
    public function isSlugUnique($slug, $id)
    {
        if (!empty($this->builder->where('id !=', clrNum($id))->where('slug', cleanStr($slug))->get()->getRow())) {
            return false;
        }
        return true;
    }

    //check if email is unique
    public function isEmailUnique($email, $userId = 0)
    {
        $user = $this->getUserByEmail($email);
        if ($userId == 0) {
            if (!empty($user)) {
                return false;
            }
            return true;
        } else {
            if (!empty($user) && $user->id != $userId) {
                return false;
            }
            return true;
        }
    }

    //check if username is unique
    public function isUniqueUsername($username, $userId = 0)
    {
        $user = $this->getUserByUsername($username);
        if ($userId == 0) {
            if (!empty($user)) {
                return false;
            }
            return true;
        } else {
            if (!empty($user) && $user->id != $userId) {
                return false;
            }
            return true;
        }
    }

    //update user token
    public function updateUserToken($id, $token)
    {
        return $this->builder->where('id', clrNum($id))->update(['token' => $token]);
    }

    //verify email
    public function verifyEmail($user)
    {
        if (!empty($user)) {
            $data = [
                'email_status' => 1,
                'token' => generateToken()
            ];
            return $this->builder->where('id', $user->id)->update($data);
        }
        return false;
    }

    //ban user
    public function banUser($id)
    {
        $user = $this->getUser($id);
        if (!empty($user)) {
            if ($user->banned == 1) {
                $data = ['banned' => 0];
            } else {
                $data = ['banned' => 1];
            }
            return $this->builder->where('id', $user->id)->update($data);
        }
        return false;
    }

    //delete cover image
    public function deleteCoverImage()
    {
        if (authCheck()) {
            return $this->builder->where('id', user()->id)->update(['cover_image' => '']);
        }
    }

    //delete user
    public function deleteUser($id)
    {
        $user = $this->getUser($id);
        if (!empty($user)) {
            deleteFile($user->avatar);
            if (!empty($user)) {
                //delete products
                $productAdminModel= new ProductAdminModel();
                $products = $this->db->table('products')->where('user_id', $user->id)->get()->getResult();
                if (!empty($products)) {
                    foreach ($products as $product) {
                        $productAdminModel->deleteProductPermanently($product->id);
                    }
                }
                return $this->builder->where('id', $user->id)->delete();
            }
        }
        return false;
    }

    //add activation email
    public function addActivationEmail($user, $email = null)
    {
        if ($this->generalSettings->email_verification == 1 && !empty($user)) {
            if (empty($email)) {
                $email = $user->email;
            }
            $token = $user->token;
            if (empty($token)) {
                $token = generateToken();
                $this->updateUserToken($user->id, $token);
            }
            $emailData = [
                'email_type' => 'activation',
                'email_address' => $email,
                'email_data' => serialize([
                    'content' => trans("msg_confirmation_email"),
                    'content_1' => 'Your ABC Member ID : ' . 'ABC-' . $user->id,
                    'url' => base_url() . '/confirm-account?token=' . $token,
                    'buttonText' => trans("confirm_your_account")
                ]),
                'email_priority' => 1,
                'email_subject' => trans("confirm_your_account"),
                'template_path' => 'email/main'
            ];
            addToEmailQueue($emailData);
        }
    }
	
	//add activation email
	public function addActivationEmailMigration($user, $pass, $email = null)
    {
        if ($this->generalSettings->email_verification == 1 && !empty($user)) {
            if (empty($email)) {
                $email = $user->email;
            }
            $token = $user->token;
            if (empty($token)) {
                $token = generateToken();
                $this->updateUserToken($user->id, $token);
            }
            $emailData = [
                'email_type' => 'activation',
                'email_address' => $email,
                'email_data' => serialize([
                    'content' => 'Dear ABC Members, 
									As most of you now know that we have launched our new website (https://&zwnj;www.&zwnj;agarwals&zwnj;.ca/) during our Diwali Gala with enhanced features such as member to member chat, promote your business, tracking your membership, picture and video gallery, charity, and library pages etc. To bring all the current members to our common digital platform, we request you to register your name and family details by login on the new website (under member login tab and then profile management). Initially please use the generic password as mentioned below. You can then set up your own password while you complete your personal details. This is necessary to bring all the members to our new digital platform for future communication and to extend members benefit such as discounted tickets, promoting your business, and invitation to our free events. Please note, going forward we will be sending out all the communication from our new digital platform so members who will not register on the new website will not be able to get any communication in the future. We therefore request you to complete your registration by December 31, 2023 to help us streamline the process. 
									In case, you have any questions or need any further assistance, please reach out to: (1) Raj Agarwala – Membership Lead and Treasurer; Tel# 647-986-2300 (2) Sushil Agrawal – Website Lead and Vice-President; Tel# 416-803-3609 (3) email: info@agarwals.ca',
                    'content_1' => 'Your ABC Member ID : ' . 'ABC-' . $user->id,
                    'content_2' => 'Login Email : ' .$user->email,
                    'content_3' => 'Login Password : ' .$pass,
                    'content_4' => 'To begin, please log in using the credentials provided above and navigate to the "Profile Management" menu. From there, you can change your password.',
                    'url' => base_url() . '/confirm-account?token=' . $token,
                    'buttonText' => trans("confirm_your_account")
                ]),
                'email_priority' => 1,
                'email_subject' => trans("confirm_your_account"),
                'template_path' => 'email/migration'
            ];
            addToEmailQueue($emailData);
        }
    }
	
	public function getMemberPlanUsers()
	{
		$users = $this->builder->orderBy('id')->get()->getResult();
		$nonMembers = [];
		$members = [];

		foreach ($users as $user) {
			// Check if the user's ID exists in the users_membership_plans_subs table
			$userExistsInSubsTable = $this->db->table('users_membership_plans_subs')
				->where('user_id', $user->id)
				->countAllResults() > 0;

			if (!$userExistsInSubsTable) {
				// User is not present in the users_membership_plans_subs table
				$nonMembers[] = $user;
			} else {
				// User is present in the users_membership_plans_subs table
				$membershipPlan = $this->db->table('users_membership_plans_subs')
					->where('user_id', $user->id)
					->get()
					->getRow();

				// Check the specified conditions for membership
				if ($membershipPlan->plan_status == 1 && $membershipPlan->deleted == 0) {
					$members[] = $user;
				} else {
					$nonMembers[] = $user;
				}
			}
		}

		$classifiedUsers = [
			'members' => $members,
			'nonMembers' => $nonMembers,
		];

		// Return the classified users to the controller
		return $classifiedUsers;

	}
	
}

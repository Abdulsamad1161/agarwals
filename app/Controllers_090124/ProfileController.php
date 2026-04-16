<?php

namespace App\Controllers;

use App\Models\ProfileModel;
use App\Models\TicketModel;
use App\Models\SettingsModel;
use App\Models\RSVPFormModel;
use App\Models\CartModel;
use App\Models\OrderModel;
use App\Models\MembershipModel;

class ProfileController extends BaseController
{
    protected $profileModel;
    protected $ticketModel;
    public $settingsModel;
    public $rsvpFormModel;
    public $cartModel;
    public $orderModel;
    public $membershipModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->profileModel = new ProfileModel();
        $this->ticketModel = new TicketModel();
        $this->settingsModel = new SettingsModel();
        $this->rsvpFormModel = new RSVPFormModel();
        $this->cartModel = new CartModel();
        $this->orderModel = new OrderModel();
        $this->membershipModel = new MembershipModel();
    }

    /**
     * Profile
     */
    public function profile($slug)
    {
        $data['user'] = $this->authModel->getUserBySlug($slug);
        if (empty($data['user'])) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = getUsername($data['user']);
        $data['description'] = getUsername($data['user']) . ' - ' . $this->baseVars->appName;
        $data['keywords'] = getUsername($data['user']) . ',' . $this->baseVars->appName;
        $data['showOgTags'] = true;
        $data['ogTitle'] = $data['title'];
        $data['ogDescription'] = $data['description'];
        $data['ogType'] = 'article';
        $data['ogUrl'] = generateProfileUrl($data['user']->slug);
        $data['ogImage'] = getUserAvatar($data['user']);
        $data['ogWidth'] = '200';
        $data['ogHeight'] = '200';
        $data['ogCreator'] = $data['title'];
        $data['activeTab'] = 'products';
        $data['userRating'] = calculateUserRating($data['user']->id);
        $data['queryStringArray'] = getQueryStringArray(null);
        $data['queryStringObjectArray'] = convertQueryStringToObjectArray($data['queryStringArray']);
        $data['category'] = null;
        $data['parentCategory'] = null;
        $categoryId = inputGet('p_cat');
        if (!empty($categoryId)) {
            $data['category'] = $this->categoryModel->getCategory($categoryId);
            if (!empty($data['category']) && $data['category']->parent_id != 0) {
                $data['parentCategory'] = $this->categoryModel->getCategory($data['category']->parent_id);
            }
        }
        $data['categories'] = $this->categoryModel->getVendorCategories($data['category'], $data['user']->id, true, true);
        $data['userSession'] = getUserSession();
        $data['numRows'] = $this->productModel->getProfileProductsCount($data['user']->id, $data['category']);
        $pager = paginate($this->baseVars->perPageProducts, $data['numRows']);
        $data['products'] = $this->productModel->getProfileProductsPaginated($data['user']->id, $data['category'], $this->baseVars->perPageProducts, $pager->offset);

        echo view('partials/_header', $data);
        echo view('profile/profile', $data);
        echo view('partials/_footer');
    }

    /**
     * Wishlist
     */
    public function wishlist($slug)
    {
        $data['user'] = $this->authModel->getUserBySlug($slug);
        if (empty($data['user'])) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("wishlist");
        $data['description'] = trans("wishlist") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("wishlist") . ',' . $this->baseVars->appName;
        $data["activeTab"] = 'wishlist';
        $data['userRating'] = calculateUserRating($data['user']->id);
        $data['userSession'] = getUserSession();
        $data['numRows'] = $this->productModel->getUserWishlistProductsCount($data['user']->id);
        $pager = paginate($this->baseVars->perPageProducts, $data['numRows']);
        $data['products'] = $this->productModel->getPaginatedUserWishlistProducts($data['user']->id, $this->baseVars->perPageProducts, $pager->offset);

        echo view('partials/_header', $data);
        echo view('profile/wishlist', $data);
        echo view('partials/_footer');
    }

    /**
     * Downloads
     */
    public function downloads()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if (!isSaleActive()) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->generalSettings->digital_products_system != 1) {
            return redirect()->to(langBaseUrl());
        }
        $data['user'] = user();
        $data['title'] = trans("downloads");
        $data['description'] = trans("downloads") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("downloads") . ',' . $this->baseVars->appName;
        $data['activeTab'] = 'downloads';
        $data['userRating'] = calculateUserRating($data['user']->id);
        $data['userSession'] = getUserSession();
        $data['numRows'] = $this->productModel->getUserDownloadsCount($data['user']->id);
        $pager = paginate($this->baseVars->perPage, $data['numRows']);
        $data['items'] = $this->productModel->getUserDownloadsPaginated($data['user']->id, $this->baseVars->perPage, $pager->offset);

        echo view('partials/_header', $data);
        echo view('profile/downloads', $data);
        echo view('partials/_footer');
    }

    /**
     * Followers
     */
    public function followers($slug)
    {
        $data['user'] = $this->authModel->getUserBySlug($slug);
        if (empty($data['user'])) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("followers");
        $data['description'] = trans("followers") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("followers") . ',' . $this->baseVars->appName;
        $data['activeTab'] = 'followers';
        $data['userRating'] = calculateUserRating($data['user']->id);
        $data['followers'] = $this->profileModel->getFollowers($data['user']->id);

        echo view('partials/_header', $data);
        echo view('profile/followers', $data);
        echo view('partials/_footer');
    }

    /**
     * Following
     */
    public function following($slug)
    {
        $data['user'] = $this->authModel->getUserBySlug($slug);
        if (empty($data['user'])) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("following");
        $data['description'] = trans("following") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("following") . ',' . $this->baseVars->appName;
        $data['activeTab'] = "following";
        $data['userRating'] = calculateUserRating($data['user']->id);
        $data['followers'] = $this->profileModel->getFollowedUsers($data['user']->id);

        echo view('partials/_header', $data);
        echo view('profile/followers', $data);
        echo view('partials/_footer');
    }

    /**
     * Reviews
     */
    public function reviews($slug)
    {
        if ($this->generalSettings->reviews != 1) {
            return redirect()->to(langBaseUrl());
        }
        $data['user'] = $this->authModel->getUserBySlug($slug);
        if (empty($data['user']) || !isVendor($data['user'])) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = getUsername($data['user']) . ' ' . trans("reviews");
        $data['description'] = getUsername($data['user']) . ' ' . trans("reviews") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = getUsername($data['user']) . ' ' . trans("reviews") . ',' . $this->baseVars->appName;
        $data["activeTab"] = 'reviews';
        $data['userRating'] = calculateUserRating($data['user']->id);
        $data['userSession'] = getUserSession();
        $numRows = $this->commonModel->getVendorReviewsCount($data['user']->id);
        $pager = paginate($this->baseVars->perPage, $numRows);
        $data['reviews'] = $this->commonModel->getVendorReviewsPaginated($data['user']->id, $this->baseVars->perPage, $pager->offset);

        echo view('partials/_header', $data);
        echo view('profile/reviews', $data);
        echo view('partials/_footer');
    }

    /**
     * Update Profile
     */
    public function editProfile()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("update_profile");
        $data['description'] = trans("update_profile") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("update_profile") . ',' . $this->baseVars->appName;
        $data["activeTab"] = 'edit_profile';
        $data['userSession'] = getUserSession();
        $data['otherMemberDetails'] = $this->profileModel->getMemberOtherDetails(user()->id);
        echo view('partials/_header', $data);
        echo view('settings/edit_profile', $data);
        echo view('partials/_footer');
    }
	
	/* public function authCheckRSVPForm()
	{
		$data['title'] = 'RSVP Login';
        $data['description'] = 'RSVP Login' . ' - ' . $this->baseVars->appName;
        $data['keywords'] = 'RSVP Login' . ',' . $this->baseVars->appName;
		
        echo view('partials/_header', $data);
        echo view('rsvp/loginForm');
        echo view('partials/_footer');
	} */

    public function rsvpEventForm()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("rsvpEventForm");
        $data['description'] = trans("rsvpEventForm") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("rsvpEventForm") . ',' . $this->baseVars->appName;
        $data['userSession'] = getUserSession();
        $data['form_data'] = $this->rsvpFormModel->getAllForms();
        echo view('partials/_header', $data);
        echo view('members/rsvp_form', $data);
        echo view('partials/_footer');
    }

    public function rsvpEventFormPost()
    {
		if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->rsvpFormModel->addRSVPformData()) {
			$dataUser = $this->authModel->getUser(user()->id);
			//print_r($dataUser);die;
			$emailData = 
			[
					'email_type' => 'activation',
					'email_address' => $dataUser->email,
					'email_data' => serialize([
						'content' => 'Name: ' . $dataUser->username,
						'content_1' => "Thank you for joining our event! We're excited to have you with us and looking forward to an amazing time together. If you have any questions or need assistance, please feel free to reach out. See you at the event!",
					]),
					'email_priority' => 1,
					'email_subject' => 'RSVP Form Submitted Successfully',
					'template_path' => 'email/rsvp_payment'
			];

			addToEmailQueue($emailData);
            setSuccessMessage('Data Submitted Successfully, Thank You!');
        }
		else
		{
			setErrorMessage('Error Submiting the data');
		}
        return redirect()->to(generateUrl('rsvpEventForm'));
    }
	
	public function feedback()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("feedback");
        $data['description'] = trans("feedback") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("feedback") . ',' . $this->baseVars->appName;
        $data['userSession'] = getUserSession();
        $data['memberDetails'] = $this->profileModel->getMemberDetails(user()->id);
        $data['eventList'] = $this->settingsModel->getAllEventsList();
        echo view('partials/_header', $data);
        echo view('members/feedback', $data);
        echo view('partials/_footer');
    }
	
	public function feedbackGeneralPost()
    {
       if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
		 
		$action = inputPost('submit');
        $val = \Config\Services::validation();
        $val->setRule('email', trans("email"), 'required|max_length[255]');
        $val->setRule('username', trans("name"), 'required|max_length[255]');
        $val->setRule('phone_number', trans("phone_number"), 'required|max_length[255]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } 
		else { 
        if ($this->profileModel->addfeedback()) {
            setSuccessMessage(trans("feedback_submitted_successfully"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        return redirect()->to(generateUrl('feedback'));
		}
    }

	public function feedbackEventPost()
    {
       if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
		 
		$action = inputPost('submit');
        $val = \Config\Services::validation();
        $val->setRule('email', trans("email"), 'required|max_length[255]');
        $val->setRule('username', trans("name"), 'required|max_length[255]');
        $val->setRule('phone_number', trans("phone_number"), 'required|max_length[255]');
        $val->setRule('event_name_date', trans("select_event"), 'required');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } 
		else { 
        if ($this->profileModel->addfeedbackEvent()) {
            setSuccessMessage(trans("feedback_submitted_successfully"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        return redirect()->to(generateUrl('feedback'));
		}
    }

    /**
     * Update Profile Post
     */
    public function editProfilePost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $action = inputPost('submit');
        $val = \Config\Services::validation();
        $val->setRule('email', trans("email"), 'required|max_length[255]');
        $val->setRule('slug', trans("slug"), 'required|max_length[255]');
        $val->setRule('first_name', trans("first_name"), 'required|max_length[255]');
        $val->setRule('last_name', trans("last_name"), 'required|max_length[255]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else { 
            $data = 
			[
                'slug' => strSlug(inputPost('slug')),
                'email' => inputPost('email'),
                'first_name' => inputPost('first_name'),
                'last_name' => inputPost('last_name'),
                'phone_number' => inputPost('phone_number'),
                'send_email_new_message' => inputPost('send_email_new_message'),
                'cover_image_type' => inputPost('cover_image_type'),
                'show_email' => inputPost('show_email'),
                'show_phone' => inputPost('show_phone'),
                'show_location' => inputPost('show_location'),
                'show_profile' => inputPost('show_profile'),
                'two_factor' => inputPost('two_factor'),
                'areas_of_interest' => inputPost('areas_of_interest'),
                'secondary_email' => inputPost('secondary_email_login'),
                'members_in_family' => inputPost('members_in_family')
            ];
			
			if (!empty(inputPost('secondary_password'))) {
				$hashedPassword = password_hash(inputPost('secondary_password'), PASSWORD_DEFAULT);
				$data['secondary_password'] = $hashedPassword;
			}
			
			$data_secondary = 
			[
				'secondary_first_name' => inputPost('secondary_first_name'),
				'secondary_last_name' => inputPost('secondary_last_name'),
				'secondary_email' => inputPost('secondary_email'),
				'secondary_phone_number' => inputPost('secondary_phone_number'),
				'postal_address' => inputPost('postal_address'),
				'descendant_of_agarwal_vaish' => inputPost('descendant_of_agarwal_vaish'),
				'other_name_1' => inputPost('other_name_1'),
				'other_phone_1' => inputPost('other_phone_1'),
				'other_name_2' => inputPost('other_name_2'),
				'other_phone_2' => inputPost('other_phone_2'),
			];
            //is email unique
            if (!$this->authModel->isEmailUnique($data['email'], user()->id)) {
                setErrorMessage(trans("msg_email_unique_error"));
                return redirect()->to(generateUrl('settings', 'edit_profile'));
            }
            //is slug unique
            if (!$this->authModel->isSlugUnique($data['slug'], user()->id)) {
                setErrorMessage(trans("msg_slug_unique_error"));
                return redirect()->to(generateUrl('settings', 'edit_profile'));
            }
            if ($this->profileModel->editProfile($data, $data_secondary, user()->id)) {
                setSuccessMessage(trans("msg_updated"));
            } else {
                setErrorMessage(trans("msg_error"));
            }
            return redirect()->to(generateUrl('settings', 'edit_profile'));
        }
    }

    //delete cover image
    public function deleteCoverImagePost()
    {
        $this->authModel->deleteCoverImage();
    }

    /**
     * Shipping Address
     */
    public function shippingAddress()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("shipping_address");
        $data['description'] = trans("shipping_address") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("shipping_address") . ',' . $this->baseVars->appName;
        $data["activeTab"] = 'shipping_address';
        $data['shippingAddresses'] = $this->profileModel->getShippingAddresses();
        $data['states'] = $this->locationModel->getStatesByCountry(1);
        $data['userSession'] = getUserSession();
        echo view('partials/_header', $data);
        echo view('settings/shipping_address', $data);
        echo view('partials/_footer');
    }

    /**
     * Add Shipping Address Post
     */
    public function addShippingAddressPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if (!$this->profileModel->addShippingAddress()) {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    /**
     * Edit Shipping Address Post
     */
    public function editShippingAddressPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->profileModel->editShippingAddress()) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    /**
     * Delete Shipping Address Post
     */
    public function deleteShippingAddressPost()
    {
        if (!authCheck()) {
            exit();
        }
        if ($this->profileModel->deleteShippingAddress()) {
            setSuccessMessage(trans("msg_deleted"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
    }

    /**
     * volunteer
     */
    public function volunteer()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("volunteer");
        $data['description'] = trans("volunteer") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("volunteer") . ',' . $this->baseVars->appName;
        $data['activeTab'] = 'volunteer';
        $data['userSession'] = getUserSession();
        $data['member'] = $this->profileModel->getMemberDetails();
        echo view('partials/_header', $data);
        echo view('settings/vounteer_form', $data);
        echo view('partials/_footer');
    } 
	
	/**
     * Membership Plans Details
     */
    public function membershipPlansDetails()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("membership_plan_details");
        $data['description'] = trans("membership_plan_details") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("membership_plan_details") . ',' . $this->baseVars->appName;
		$data['userPlan'] = $this->membershipModel->getUserPlanByUserIdUsers(user()->id);
        $data['daysLeft'] = $this->membershipModel->getUserPlanRemainingDaysCountUsers($data['userPlan']);
        $data['activeTab'] = 'membership_plans';
        $data['userSession'] = getUserSession();
        $data['member'] = $this->profileModel->getMemberDetails();
        $data['plan_details'] = $this->profileModel->getMemberPlanDetails();
		
		if($data['daysLeft'] < 0)
		{
			setErrorMessage("Membership has expired. Renew Your Membeship Now!");
		}
		/*
		$data_payment =  $data['plan_details'];
		if($data['daysLeft'] <= 2 && $data['daysLeft'] > 0)
		{
			$emailData = 
			[
					'email_type' => 'activation',
					'email_address' => user()->email,
					'email_data' => serialize([
						'content' => 'Name : '.user()->username,
						'content_1' => 'Phone : '.user()->phone_number,
						'content_2' => 'Membership Name : '.$data_payment->plan_title,
						'content_3' => 'Membership Expiry Date: '.$data_payment->plan_end_date,
						'content_4' => "Renew Your Membeship! If you have any questions or need assistance, feel free to reach out.",
					]),
					'email_priority' => 1,
					'email_subject' => 'Plan Expiry Alert',
					'template_path' => 'email/rsvp_payment'
			];
			
			addToEmailQueue($emailData);
		}
		*/
		
        echo view('partials/_header', $data);
        echo view('settings/membership_plan_details', $data);
        echo view('partials/_footer');
    }
	
	/**
     * Vendor Membership Plans Details
     */
    public function membershipPlansVendorDetails()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("membership_plan_details");
        $data['description'] = trans("membership_plan_details") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("membership_plan_details") . ',' . $this->baseVars->appName;
		$data['userPlan'] = $this->membershipModel->getUserPlanByUserId(user()->id);
        $data['daysLeft'] = $this->membershipModel->getUserPlanRemainingDaysCount($data['userPlan']);
        $data['activeTab'] = 'membership_plans_vendors';
        $data['userSession'] = getUserSession();
        $data['member'] = $this->profileModel->getMemberDetails();
        $data['plan_details'] = $this->profileModel->getMemberPlanDetailsVendor();
		/*
		$data_payment =  $data['plan_details'];
		if($data['daysLeft'] <= 2 && $data['daysLeft'] > 0)
		{
			$emailData = 
			[
					'email_type' => 'activation',
					'email_address' => user()->email,
					'email_data' => serialize([
						'content' => 'Name : '.user()->username,
						'content_1' => 'Phone : '.user()->phone_number,
						'content_2' => 'Membership Name : '.$data_payment->plan_title,
						'content_3' => 'Membership Expiry Date: '.$data_payment->plan_expiy_date,
						'content_6' => "Renew Your Membeship! If you have any questions or need assistance, feel free to reach out.",
					]),
					'email_priority' => 1,
					'email_subject' => 'Plan Expiry Alert',
					'template_path' => 'email/rsvp_payment'
			];
			
			addToEmailQueue($emailData);
		}
		*/
        echo view('partials/_header', $data);
        echo view('settings/membership_plan_details_vendors', $data);
        echo view('partials/_footer');
    } 

	/**
     * Social Media
     */
    public function socialMedia()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("social_media");
        $data['description'] = trans("social_media") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("social_media") . ',' . $this->baseVars->appName;
        $data['activeTab'] = 'social_media';
        $data['userSession'] = getUserSession();
        echo view('partials/_header', $data);
        echo view('settings/social_media', $data);
        echo view('partials/_footer');
    }
	
	/**
     * Volunteer Post
     */
    public function volunteerPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->profileModel->volunteerForm()) {
			$emailData = 
			[
					'email_type' => 'activation',
					'email_address' => $_POST['email'],
					'email_data' => serialize([
						'content' => 'Name : '.$_POST['name'],
						'content_1' => 'Phone : '.$_POST['phone_number'],
						'content_2' => 'Area Of Interest : '.$_POST['area_of_interest'],
						'content_6' => "Thank you for showing interest! Our Team will get back to you very shortly.",
					]),
					'email_priority' => 1,
					'email_subject' => 'Volunteer Form',
					'template_path' => 'email/rsvp_payment'
			];
			
			addToEmailQueue($emailData);
			
            setSuccessMessage(trans("thank_you_for_showing_interest"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        return redirect()->to(generateUrl('settings', 'volunteer'));
    }

    /**
     * Social Media Post
     */
    public function socialMediaPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->profileModel->updateSocialMedia()) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        return redirect()->to(generateUrl('settings', 'social_media'));
    }

    /**
     * Change Password
     */
    public function changePassword()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("change_password");
        $data['description'] = trans("change_password") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("change_password") . ',' . $this->baseVars->appName;
        $data['activeTab'] = 'change_password';
        $data['userSession'] = getUserSession();
        echo view('partials/_header', $data);
        echo view('settings/change_password', $data);
        echo view('partials/_footer');
    }

    /**
     * Change Password Post
     */
    public function changePasswordPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $val = \Config\Services::validation();
        if (!empty(user()->password)) {
            $val->setRule('old_password', trans("old_password"), 'required|max_length[255]');
        }
        $val->setRule('password', trans("password"), 'required|min_length[4]|max_length[100]');
        $val->setRule('password_confirm', trans("password_confirm"), 'required|matches[password]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            if ($this->profileModel->changePassword()) {
                setSuccessMessage(trans("msg_change_password_success"));
            } else {
                setErrorMessage(trans("msg_change_password_error"));
            }
        }
        return redirect()->to(generateUrl('settings', 'change_password'));
    }
	
	/**
     * Change Password Post
     */
    public function changePasswordSecondPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $val = \Config\Services::validation();
        if (!empty(user()->password)) {
            $val->setRule('old_password_second', trans("old_password"), 'required|max_length[255]');
        }
        $val->setRule('password_second', trans("password"), 'required|min_length[4]|max_length[100]');
        $val->setRule('password_confirm_second', trans("password_confirm"), 'required|matches[password_second]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            if ($this->profileModel->changePasswordSecond()) {
                setSuccessMessage(trans("msg_change_password_success"));
            } else {
                setErrorMessage(trans("msg_change_password_error"));
            }
        }
        return redirect()->to(generateUrl('settings', 'change_password'));
    }

    /**
     * Follow Unfollow User
     */
    public function followUnfollowUser()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $this->profileModel->followUnfollowUser();
        redirectToBackUrl();
    }
	
	public function ticketInvoice()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("ticket_invoice");
        $data['description'] = trans("ticket_invoice") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("ticket_invoice") . ',' . $this->baseVars->appName;
        $data['activeTab'] = 'ticket_invoice';
        $data['userSession'] = getUserSession();
        $data['ticket_report'] = $this->ticketModel->getMemberInvoice();
        echo view('partials/_header', $data);
        echo view('settings/ticket_invoice', $data);
        echo view('partials/_footer');
    }
	
	public function MembershipInvoice()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("membership_invoice");
        $data['description'] = trans("membership_invoice") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("membership_invoice") . ',' . $this->baseVars->appName;
        $data['activeTab'] = 'membership_invoice';
        $data['userSession'] = getUserSession();
        $data['ticket_report'] = $this->membershipModel->getMemberInvoice();
        echo view('partials/_header', $data);
        echo view('settings/membership_invoice', $data);
        echo view('partials/_footer');
    }
	
	public function ticketInvoiceEvent($ticket_id)
	{
		$data['tickets'] = $this->ticketModel->getMemberInvoiceEventTicket($ticket_id);
        echo view('ticket_booking/invoice_ticket', $data);
	}
	
	public function rsvpEventFormPaymentPost()
    {
		$payNow = inputPost('payNow') != '' ? inputPost('payNow') : '';
		if(!empty($payNow) && $payNow == 1)
		{
			if ($this->rsvpFormModel->addRSVPformData()) 
			{
				setSuccessMessage(trans("msg_updated"));
				return redirect()->back()->withInput();
			}
			else
			{
				setErrorMessage(trans("msg_error"));
				return redirect()->back()->withInput();
			}
		}
		
		$label18 = inputPost('labeltext18') != '' ? inputPost('labeltext18') : '';
		$label19 = inputPost('labeltext19') != '' ? inputPost('labeltext19') : '';
		$label20 = inputPost('labeltext20') != '' ? inputPost('labeltext20') : '';
		
		$quantitytext18 = inputPost('quantitytext18') != '' ? inputPost('quantitytext18') : '';
		$quantitytext19 = inputPost('quantitytext19') != '' ? inputPost('quantitytext19') : '';
		$quantitytext20 = inputPost('quantitytext20') != '' ? inputPost('quantitytext20') : '';
			
		if(!empty($label18))
		{
			$this->session->set('label18',$label18);
			$this->session->set('quantitytext18',$quantitytext18);
		}
		
		if(!empty($label19))
		{
			$this->session->set('label19',$label19);
			$this->session->set('quantitytext19',$quantitytext19);
		}
		
		if(!empty($label20))
		{
			$this->session->set('label20',$label20);
			$this->session->set('quantitytext20',$quantitytext20);
		}
		
		$rsvpAmount = inputPost('total_amount') != '' ? inputPost('total_amount') : 0.00;
		
		if($rsvpAmount == 0.00 || $rsvpAmount == '')
		{
			setErrorMessage('At least one amount must be selected. If you are not required to make a payment, please check the checkbox next to the submit button.');
			return redirect()->back()->withInput();
		}
		
		$form_id = inputPost('form_id');
		$this->session->set('formID',$form_id);
		$this->session->set('is_epayment',inputPost('is_epayment'));
		$this->session->set('is_paypal',inputPost('is_paypal'));
		$this->session->set('rsvpAmount',$rsvpAmount);
		$id = $this->rsvpFormModel->addRSVPformData();
		$this->session->set('rsvpSubmitId',$id);
		
		if (!authCheck()) {
			setErrorMessage('Login In to proceed');
            return redirect()->to(langBaseUrl());
        }
        if ($id > 0) 
		{
            helperSetSession('modesy_rsvp_form_id', $form_id);
			helperSetSession('modesy_rsvp_request_type', 'paymentRSVP');
			$this->paymentMethod();
        }
		else
		{
			setErrorMessage(trans("msg_error"));
		}
    }
	
	/**
     * Payment Method
     */
    public function paymentMethod()
    {
        $data['title'] = trans("rsvp_payment");
        $data['description'] = trans("rsvp_payment") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("rsvp_payment") . ',' . $this->baseVars->appName;
        $paymentType = 'rsvpPayment';
     
		if ($paymentType == 'rsvpPayment') 
		{
            $data['mdsPaymentType'] = 'rsvpPayment';
			$data['is_epayment'] = $this->session->is_epayment;
            $data['is_paypal'] = $this->session->is_paypal;
            $formId = helperGetSession('modesy_rsvp_form_id');
			
            if (empty($formId)) 
			{
                return redirect()->to(langBaseUrl());
            }
			
            $data['rsvpForm'] = $this->rsvpFormModel->getFormData($formId);
			
            if (empty($data['rsvpForm'])) 
			{
                return redirect()->to(langBaseUrl());
            }
        }
		
        echo view('partials/_header', $data);
        echo view('rsvp/payment_method_rsvp', $data);
        echo view('partials/_footer');
    }
	
	public function paymentMethodPostUsers()
    {
        $mdsPaymentType = inputPost('mds_payment_type');
		
        //validate payment method
        $arrayMethods = array();
        $gateways = getActivePaymentGateways();
        if (!empty($gateways)) {
            foreach ($gateways as $gateway) {
                array_push($arrayMethods, esc($gateway->name_key));
            }
        }
        if ($this->paymentSettings->bank_transfer_enabled) {
            array_push($arrayMethods, 'bank_transfer');
        }
		
        $paymentOption = inputPost('payment_option');
		
        if (!in_array($paymentOption, $arrayMethods)) {
            setErrorMessage(trans("msg_error"));
            return redirect()->to(generateUrl('profilePayment', 'payment_method_users'));
        }
        $this->cartModel->setSessCartPaymentMethod();
		
        $redirect = langBaseUrl();
        if ($mdsPaymentType == 'rsvpPayment') {
            $transactionNumber = 'bank-' . generateToken();
            helperSetSession('mds_membership_bank_transaction_number', $transactionNumber);
            $redirect = generateUrl('profilePayment', 'payment-user') . '?payment_type=rsvpPayment';
        }
		
        return redirect()->to($redirect);
    }
	
	/**
     * Payment
     */
    public function paymentUsers()
    {
        $data['title'] = trans("rsvp_payment");
        $data['description'] = trans("rsvp_payment") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("rsvp_payment") . ',' . $this->baseVars->appName;
        $data['mdsPaymentType'] = 'rsvpPayment';
        $data['userSession'] = getUserSession();
		
	
        //check guest checkout
        if (empty(authCheck()) && $this->generalSettings->guest_checkout != 1) {
            return redirect()->to(generateUrl('profilePayment'));
        }
        //check is set cart payment method
        $data['cartPaymentMethod'] = $this->cartModel->getSessCartPaymentMethod();

        if (empty($data['cartPaymentMethod'])) {
            return redirect()->to(generateUrl('profilePayment', 'payment_method_users'));
        }
        $paymentType = inputGet('payment_type');
		
	
		if ($paymentType == 'rsvpPayment') {
            //rsvpPayment 
            $data['mdsPaymentType'] = 'rsvpPayment';
            $formId = helperGetSession('modesy_rsvp_form_id');
            if (empty($formId)) {
                return redirect()->to(langBaseUrl());
            }
			
            $data['rsvpForm'] = $this->rsvpFormModel->getFormData($formId);
            if (empty($data['rsvpForm'])) {
                return redirect()->to(langBaseUrl());
            }
            //total amount
            $price = $this->session->rsvpAmount;
			/* //$price = getPrice($price, 'database');
			//var_dump($price);
            if ($this->paymentSettings->currency_converter != 1) {
                $price = getPrice($price, 'decimal');
				echo "in";die;
            } */
			
            $objAmount = $this->cartModel->convertCurrencyByPaymentGateway($price, 'ticket_booking');
            $data['totalAmount'] = $objAmount->total;
            $data['currency'] = $objAmount->currency;
            $data['transactionNumber'] = helperGetSession('mds_membership_bank_transaction_number');
            $data['cartTotal'] = null;
        }

        echo view('partials/_header', $data);
        echo view('rsvp/payment_rsvp', $data);
        echo view('partials/_footer');
    }
	
	public function stripePaymentRsvpPost()
    {
        $stripe = getPaymentGateway('stripe');
        if (empty($stripe)) {
            setErrorMessage("Payment method not found!");
            echo json_encode([
                'result' => 0
            ]);
            exit();
        }
        $paymentSession = helperGetSession('mds_payment_cart_data');
        if (empty($paymentSession)) {
            setErrorMessage(trans("invalid_attempt"));
            echo json_encode([
                'result' => 0
            ]);
            exit();
        }
        $paymentObject = inputPost('paymentObject', true);
        if (!empty($paymentObject)) {
            $paymentObject = json_decode($paymentObject);
        }
        $clientSecret = helperGetSession('mds_stripe_client_secret');
        if (!empty($paymentObject) && $paymentObject->client_secret == $clientSecret) {
            $dataTransaction = [
                'payment_method' => $stripe->name,
                'payment_id' => $paymentObject->id,
                'currency' => strtoupper($paymentObject->currency ?? ''),
                'payment_amount' => getPrice($paymentObject->amount, 'decimal'),
                'payment_status' => 'Succeeded'
            ];
            //add order
            $response = $this->executePaymentTicket($dataTransaction, $paymentSession->payment_type, langBaseUrl());
            if ($response->result == 1) {
                setSuccessMessage($response->message);
                echo json_encode([
                    'result' => 1,
                    'redirectUrl' => $response->redirectUrl
                ]);
            } else {
                setErrorMessage($response->message);
                echo json_encode([
                    'result' => 0
                ]);
            }
        } else {
            setErrorMessage(trans("msg_error"));
            echo json_encode([
                'result' => 0
            ]);
        }
        helperDeleteSession('mds_stripe_client_secret');
    }
	
	public function paypalPaymentRsvpPost()
    {
        $paypal = getPaymentGateway('paypal');
        if (empty($paypal)) {
            setErrorMessage("Payment method not found!");
            echo json_encode([
                'result' => 0
            ]);
            exit();
        }
        $paymentId = inputPost('payment_id');
        loadLibrary('Paypal');
        $paypalLib = new \Paypal($paypal);
        //validate the order
        if ($paypalLib->getOrder($paymentId)) {
            $dataTransaction = [
                'payment_method' => 'PayPal',
                'payment_id' => $paymentId,
                'currency' => inputPost('currency'),
                'payment_amount' => inputPost('payment_amount'),
                'payment_status' => inputPost('payment_status'),
            ];
            $mdsPaymentType = inputPost('mds_payment_type');
            //add order
            $response = $this->executePaymentTicket($dataTransaction, $mdsPaymentType, langBaseUrl());
            if ($response->result == 1) {
                setSuccessMessage($response->message);
                echo json_encode([
                    'result' => 1,
                    'redirectUrl' => $response->redirectUrl
                ]);
            } else {
                setErrorMessage($response->message);
                echo json_encode([
                    'result' => 0
                ]);
            }
        } else {
            setErrorMessage(trans("msg_error"));
            echo json_encode([
                'result' => 0
            ]);
        }
    }
	
	public function executePaymentTicket($dataTransaction, $paymentType, $baseUrl)
    {
        //response object
        $response = new \stdClass();
        $response->result = 0;
        $response->message = '';
        $response->redirectUrl = '';
        $baseUrl = $baseUrl . '/';
        $dataTransaction['paymentStatus'] = 'payment_received';

        //check if valid transaction
        if (!$this->orderModel->isValidTransaction('sale', $dataTransaction['payment_id'], $dataTransaction['payment_method'])) {
            $params = '';
            if ($paymentType == 'rsvpPayment') 
			{
                $params = '?payment_type=rsvpPayment';
            }
			
            $response->message = 'Invalid transaction Id!';
            $response->result = 0;
            $response->redirectUrl = $baseUrl . getRoute('profilePayment', true) . getRoute('payment-user') . $params;
            return $response;
        }
		if ($paymentType == 'rsvpPayment') {
            $formId = helperGetSession('modesy_rsvp_form_id');
            
            if (!empty($formId)) {
                 $this->profileModel->addRsvpTransactionUsers($dataTransaction);
                //set response and redirect URLs
                $response->result = 1;
                $response->redirectUrl = $baseUrl . getRoute('membership_payment_completed_rsvp') . '?method=gtw';
            } else {
                //could not added to the database
                $response->message = trans("msg_payment_database_error");
                $response->result = 0;
                $response->redirectUrl = $baseUrl . getRoute('profilePayment', true) . getRoute('payment-user') . '?payment_type=rsvpPayment';
            }
        } 
		
        //reset session for the payment
        helperDeleteSession('mds_payment_cart_data');
        //return response
        return $response;
    }
	
	public function rsvpPaymentCompleted()
    {
        $data['title'] = trans("msg_payment_completed");
        $data['description'] = trans("msg_payment_completed") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("payment") . ',' . $this->baseVars->appName;
        $transactionInsertId = helperGetSession('mds_membership_transaction_insert_id');
        if (empty($transactionInsertId)) {
            return redirect()->to(langBaseUrl());
        }
        $data['transaction'] = $this->profileModel->getrsvpTransactionUsers($transactionInsertId);
        if (empty($data['transaction'])) {
            return redirect()->to(langBaseUrl());
        }
        $data['method'] = inputGet('method');
        $data['transactionNumber'] = inputGet('transaction_number');
		
		$data_payment = $this->rsvpFormModel->getRsvpFormPaymentsID($transactionInsertId);
		
		$emailData = 
		[
				'email_type' => 'activation',
				'email_address' => $data_payment->email,
				'email_data' => serialize([
					'content' => 'Name : '.$data_payment->username,
					'content_1' => 'Phone : '.$data_payment->phone_number,
					'content_2' => 'Form Title : '.$data_payment->form_title,
					'content_3' => 'Payment Method : '.$data_payment->payment_method,
					'content_4' => 'Payment Status : '.$data_payment->payment_status,
					'content_5' => 'Transaction ID : '.$data_payment->transaction_id,
					'content_6' => "Thank you! If you have any questions or need assistance, feel free to reach out.",
				]),
				'email_priority' => 1,
				'email_subject' => 'RSVP Paymemt Confirmation',
				'template_path' => 'email/rsvp_payment'
		];
		
		addToEmailQueue($emailData);

		$data_id = $this->session->rsvpSubmitId;
		$this->rsvpFormModel->updateEpyamentmethodData($data_id,$data_payment->payment_method);
		
        echo view('partials/_header', $data);
        echo view('rsvp/_payment_completed_rsvp', $data);
        echo view('partials/_footer');
    }
	
	public function invoiceRSVPForm($id)
	{
		$data['title'] = trans("invoice");
        $data['description'] = trans("invoice") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("invoice") . ',' . $this->baseVars->appName;
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
		 
        $data['transaction'] =  $this->profileModel->getrsvpTransactionUsers($id);
        if (empty($data['transaction'])) {
            return redirect()->to(langBaseUrl());
        }
		
        $data['user'] = getUser($data['transaction']->member_id);
        if (empty($data['user'])) {
            return redirect()->to(langBaseUrl());
        }
		
        echo view('rsvp/invoice_rsvp', $data);
	}
	
	public function rsvp_payment_epyament()
	{
		$data = inputPost('data');
		$id = $this->session->rsvpSubmitId;
		
		if($this->rsvpFormModel->updateEpyamentmethodData($id,$data))
		{
			echo json_encode([
                    'result' => 1
                ]);
		}
		else
		{
			echo json_encode([
                    'result' => 0
                ]);
		}
	}
}
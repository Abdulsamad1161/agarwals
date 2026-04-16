<?php

namespace App\Controllers;

use App\Models\BlogModel;
use App\Models\CurrencyModel;
use App\Models\FieldModel;
use App\Models\FileModel;
use App\Models\LocationModel;
use App\Models\MembershipModel;
use App\Models\MessageModel;
use App\Models\NewsletterModel;
use App\Models\OrderModel;
use App\Models\PromoteModel;
use App\Models\ShippingModel;
use App\Models\SitemapModel;
use App\Models\UploadModel;
use App\Models\VariationModel;
use App\Models\CartModel;
use App\Models\PageModel;

class MembershipPlansUsersController extends BaseController
{
    protected $cartModel;
	protected $blogModel;
    protected $commentLimit;
    protected $blogPerPage;
    protected $membershipModel;
	
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->blogModel = new BlogModel();
        $this->commentLimit = 6;
        $this->blogPerPage = 12;
		$this->membershipModel = new MembershipModel();
		$this->cartModel = new CartModel();
		$this->pageModel = new PageModel();
    } 

	public function showPlans()
    {
		 $data = [
            'title' => trans("membership"),
            'description' => $this->settings->site_description,
            'keywords' => $this->settings->keywords
        ];
        $data['sliderItems'] = $this->commonModel->getSliderItemsByLang(selectedLangId());
        $data['featuredCategories'] = $this->categoryModel->getFeaturedCategories();
        $data['indexBannersArray'] = $this->commonModel->getIndexBannersArray();
        $data['specialOffers'] = $this->productModel->getSpecialOffers();
        $data['indexCategories'] = $this->categoryModel->getIndexCategories();
        $data['promotedProducts'] = $this->productModel->getPromotedProductsLimited($this->generalSettings->index_promoted_products_count, 0);
        $data['promotedProductsCount'] = $this->productModel->getPromotedProductsCount();
        $data['categoriesProductsArray'] = $this->productModel->getIndexCategoriesProducts($data['indexCategories']);
        $data['userSession'] = getUserSession();
        $data['latestProducts'] = $this->productModel->getProducts($this->generalSettings->index_latest_products_count);
        $data["blogSliderPosts"] = $this->blogModel->getPosts(10);
		$data["page"] = $this->pageModel->getPageMemberBenefits();
		
		if (!empty(authCheck()))
		{
			$data['checkPlanExists'] = $this->membershipModel->getPlansUsersLoggedIn();
			
			$userPlan = $this->membershipModel->getUserPlanByUserIdUsers(user()->id);
		
			$daysLeft = $this->membershipModel->getUserPlanRemainingDaysCountUsers($userPlan);
		}
		
		if(!empty($userPlan))
		{
			if(!empty($data['checkPlanExists']))
			{
				$userPlan = $this->membershipModel->getUserPlanByUserIdUsers(user()->id);
		
				$daysLeft = $this->membershipModel->getUserPlanRemainingDaysCountUsers($userPlan);
				if($daysLeft <= 2 && $daysLeft > 0)
				{
					setErrorMessage("Membership is expiring in $daysLeft day" . ($daysLeft > 1 ? 's' : '') . ". Renew Your Membeship Now!");
					
				}
				elseif($daysLeft < 0)
				{
					setErrorMessage("Membership has expired. Renew Your Membeship Now!");
				}
				else
				{
					setSuccessMessage('Your current Membership is still Active, You can renew once the existing memberhip is about to expire.');
				}
			}
			
		}
		$data['membershipPlans'] = $this->membershipModel->getPlansUsers();
        echo view('partials/_header', $data);
        echo view('members/member_plans', $data);
        echo view('partials/_footer', $data);
	}
	
	public function membershipPlanChoose($planId)
    {
		/* if(isMember())
		{
			setErrorMessage('Currect plan is active');
			return redirect()->to(generateUrl('settings', 'membership_plans'));
		} */
		
        if ($this->generalSettings->email_verification == 1 && user()->email_status != 1) 
		{
            setErrorMessage(trans("msg_confirmed_required"));
            return redirect()->to(generateUrl('settings', 'edit_profile'));
        }

        if (empty($planId)) 
		{
            return redirect()->back();
        }
		
        $plan = $this->membershipModel->getPlanUsers($planId);
		
        if (empty($plan)) {
            return redirect()->back();
        }
		
        helperSetSession('modesy_selected_membership_plan_id', $plan->id);
        helperSetSession('modesy_membership_request_type', 'renew');
		$this->paymentMethod();
    }
	
	/**
     * Payment Method
     */
    public function paymentMethod()
    {
        $data['title'] = trans("membership");
        $data['description'] = trans("membership") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("membership") . ',' . $this->baseVars->appName;
        $paymentType = 'membership';
        if ($paymentType != 'membership' && $paymentType != 'promote') 
		{
            $paymentType = 'sale';
        }
		
		if ($paymentType == 'membership') 
		{
            //membership payment
            if ($this->generalSettings->membership_plans_system != 1) //globally checking membership plans enabled are not
			{
                return redirect()->to(langBaseUrl());
            }

            $data['mdsPaymentType'] = 'membership';
            $planId = helperGetSession('modesy_selected_membership_plan_id');
			
            if (empty($planId)) 
			{
                return redirect()->to(langBaseUrl());
            }
			
            $data['plan'] = $this->membershipModel->getPlanUsers($planId);
			
            if (empty($data['plan'])) 
			{
                return redirect()->to(langBaseUrl());
            }
        }
		//echo "<pre>";print_r($data);die;
        echo view('partials/_header', $data);
        echo view('members/payment_method_user', $data);
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
            return redirect()->to(generateUrl('membershipPlansUsers', 'payment_method_users'));
        }
        $this->cartModel->setSessCartPaymentMethod();
        $redirect = langBaseUrl();
        if ($mdsPaymentType == 'membership') {
            $transactionNumber = 'bank-' . generateToken();
            helperSetSession('mds_membership_bank_transaction_number', $transactionNumber);
            $redirect = generateUrl('membershipPlansUsers', 'payment-user') . '?payment_type=membership';
        }
		
        return redirect()->to($redirect);
    }
	
	/**
     * Payment
     */
    public function paymentUsers()
    {
        $data['title'] = trans("membership");
        $data['description'] = trans("membership") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("membership") . ',' . $this->baseVars->appName;
        $data['mdsPaymentType'] = 'membership';
        $data['userSession'] = getUserSession();
		
	
        //check guest checkout
        if (empty(authCheck()) && $this->generalSettings->guest_checkout != 1) {
            return redirect()->to(generateUrl('membershipPlansUsers'));
        }
        //check is set cart payment method
        $data['cartPaymentMethod'] = $this->cartModel->getSessCartPaymentMethod();

        if (empty($data['cartPaymentMethod'])) {
            return redirect()->to(generateUrl('membershipPlansUsers', 'payment_method_users'));
        }
        $paymentType = inputGet('payment_type');
		
	
		if ($paymentType == 'membership') {
            //membership payment
            if ($this->generalSettings->membership_plans_system != 1) {
                return redirect()->to(langBaseUrl());
            }
            $data['mdsPaymentType'] = 'membership';
            $planId = helperGetSession('modesy_selected_membership_plan_id');
            if (empty($planId)) {
                return redirect()->to(langBaseUrl());
            }
            $membershipModel = new MembershipModel();
            $data['plan'] = $this->membershipModel->getPlanUsers($planId);
            if (empty($data['plan'])) {
                return redirect()->to(langBaseUrl());
            }
            //total amount
            $price = $data['plan']->price;
            if ($this->paymentSettings->currency_converter != 1) {
                $price = getPrice($price, 'decimal');
            }
            $objAmount = $this->cartModel->convertCurrencyByPaymentGateway($price, 'membership');
            $data['totalAmount'] = $objAmount->total;
            $data['currency'] = $objAmount->currency;
            $data['transactionNumber'] = helperGetSession('mds_membership_bank_transaction_number');
            $data['cartTotal'] = null;
        }

        echo view('partials/_header', $data);
        echo view('members/payment_users', $data);
        echo view('partials/_footer');
    }
	
	public function membershipPaymentCompleted()
    {
        $data['title'] = trans("msg_payment_completed");
        $data['description'] = trans("msg_payment_completed") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("payment") . ',' . $this->baseVars->appName;
        $transactionInsertId = helperGetSession('mds_membership_transaction_insert_id');
        if (empty($transactionInsertId)) {
            return redirect()->to(langBaseUrl());
        }
        $data['transaction'] = $this->membershipModel->getMembershipTransactionUsers($transactionInsertId);
        if (empty($data['transaction'])) {
            return redirect()->to(langBaseUrl());
        }
        $data['method'] = inputGet('method');
        $data['transactionNumber'] = inputGet('transaction_number');
		
		$data_payment = $data['transaction'];
		$emailData = 
		[
				'email_type' => 'activation',
				'email_address' => user()->email,
				'email_data' => serialize([
					'content' => 'Name : '.user()->username,
					'content_1' => 'Plan Name : '.$data_payment->plan_title,
					'content_2' => 'Plan Expiry : '.formatDateShort($data_payment->plan_expiry_date),
					'content_3' => 'Payment Method : '.$data_payment->payment_method,
					'content_4' => 'Payment Status : '.$data_payment->payment_status,
					'content_5' => 'Transaction ID : '.$data_payment->payment_id,
					'content_6' => "Thank you! If you have any questions or need assistance, feel free to reach out.",
				]),
				'email_priority' => 1,
				'email_subject' => 'Membership Paymemt Confirmation',
				'template_path' => 'email/rsvp_payment'
		];
		
		addToEmailQueue($emailData);

        echo view('partials/_header', $data);
        echo view('members/membership_payment_completed_users', $data);
        echo view('partials/_footer');
    }
	
	
	public function epaymentMethodBooking()
	{
		$planId = helperGetSession('modesy_selected_membership_plan_id');
		$plan = null;
		if (!empty($planId)) 
		{
			$plan = $this->membershipModel->getPlanUsers($planId);
		}
		
		if (!empty($plan)) {
			//add user membership plan
			$status = $this->membershipModel->updateEpaymentMembershipUsers($plan, user()->id);
			
			if($status)
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
		else 
		{
			echo json_encode([
						'result' => 2
					]);
		}
	}
	
	public function epaymentMethodBookingBuisness()
	{
		$planId = helperGetSession('modesy_selected_membership_plan_id');

		$plan = null;
		if (!empty($planId)) 
		{
			$plan = $this->membershipModel->getPlan($planId);
		}
		
		if (!empty($plan)) {
			//add user membership plan
			$status = $this->membershipModel->updateEpaymentMembership($plan, user()->id);
			
			if($status)
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
		else 
		{
			echo json_encode([
						'result' => 2
					]);
		}
	}
	
}
?>
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
use App\Models\TicketModel;
use App\Models\CartModel;
use App\Models\SettingsModel;

class SponsorshipController extends BaseController
{
	protected $blogModel;
    protected $commentLimit;
    protected $blogPerPage;
    protected $membershipModel;
    protected $ticketModel;
    protected $cartModel;
    public $settingsModel;
	
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->blogModel = new BlogModel();
        $this->commentLimit = 6;
        $this->blogPerPage = 12;
		$this->membershipModel = new MembershipModel();
		$this->ticketModel = new TicketModel();
		$this->cartModel = new CartModel();
		$this->orderModel = new OrderModel();
		$this->settingsModel = new SettingsModel();
    }


    public function index()
    {
		$data = [
            'title' => trans("sponsorship"),
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
		$data['sponsorship'] = $this->settingsModel->getOurSponsorsListGeneral();
		
        echo view('partials/_header', $data);
        echo view('sponsorship/sponsor_index');
        echo view('partials/_footer', $data);
	} 
	
	public function externalOrganization()
    {
		$data = [
            'title' => 'External Organization',
            'description' => $this->settings->site_description,
            'keywords' => $this->settings->keywords
        ];
        
		$data['external'] = $this->pageModel->getExternalOrganizations();
		$data['pagesNote'] = $this->settingsModel->getExternalOrganizationsNote();
        echo view('partials/_header', $data);
        echo view('external_organization/index');
        echo view('partials/_footer', $data);
	} 
	
	public function charityIndex()
	{
		$data = [
            'title' => trans("charity"),
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
		
		$data['charityList'] = $this->ticketModel->getCharityListVisible();
        echo view('partials/_header', $data);
        echo view('charity/charity_index');
        echo view('partials/_footer', $data);
	}
	
	public function sendCharityPostEpayment()
	{
		if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->ticketModel->addCharitySubmitData()) 
		{
           echo json_encode('updated');
        }
		else
		{
			echo json_encode('failed');
		}
	}
	
	public function sendCharityPost()
	{
		$amount = inputPost('amount');
		$fees = inputPost('feesPercent');
		
		if ($amount >= 0 && $fees >= 0) 
		{
			$feeAmount = ($fees / 100) * $amount;

			$finalTotal = $amount + $feeAmount;
		} 
		else 
		{
			setErrorMessage(trans("msg_error"));
		}
		
		$charityID = inputPost('charityID');
		$this->session->set('charityID',$charityID);
		$this->session->set('charityAmount',$finalTotal);
		$this->session->set('charitySubAmount',$amount);
		$this->session->set('charityPaypalAmount',$feeAmount);
		
		if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->ticketModel->addCharitySubmitData()) 
		{
            helperSetSession('modesy_charity_form_id', $charityID);
			helperSetSession('modesy_charity_request_type', 'paymentCharity');
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
        $data['title'] = trans("charity");
        $data['description'] = trans("charity") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("charity") . ',' . $this->baseVars->appName;
        $paymentType = 'charityPayment';
     
		if ($paymentType == 'charityPayment') 
		{
            $data['mdsPaymentType'] = 'charityPayment';
            $charityId = helperGetSession('modesy_charity_form_id');
			
            if (empty($charityId)) 
			{
                return redirect()->to(langBaseUrl());
            }
			
            $data['charityForm'] = $this->ticketModel->getcharityData($charityId);
			
            if (empty($data['charityForm'])) 
			{
                return redirect()->to(langBaseUrl());
            }
        }
		
        echo view('partials/_header', $data);
        echo view('charity/payment_method_charity', $data);
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
            return redirect()->to(generateUrl('charityPayment', 'payment_method_users'));
        }
        $this->cartModel->setSessCartPaymentMethod();
		
        $redirect = langBaseUrl();
        if ($mdsPaymentType == 'charityPayment') {
            $transactionNumber = 'bank-' . generateToken();
            helperSetSession('mds_membership_bank_transaction_number', $transactionNumber);
            $redirect = generateUrl('charityPayment', 'payment-user') . '?payment_type=charityPayment';
        }
		
        return redirect()->to($redirect);
    }
	
	/**
     * Payment
     */
    public function paymentUsers()
    {
        $data['title'] = trans("charity");
        $data['description'] = trans("charity") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("charity") . ',' . $this->baseVars->appName;
        $data['mdsPaymentType'] = 'charityPayment';
        $data['userSession'] = getUserSession();
		
	
        //check guest checkout
        if (empty(authCheck()) && $this->generalSettings->guest_checkout != 1) {
            return redirect()->to(generateUrl('charityPayment'));
        }
        //check is set cart payment method
        $data['cartPaymentMethod'] = $this->cartModel->getSessCartPaymentMethod();

        if (empty($data['cartPaymentMethod'])) {
            return redirect()->to(generateUrl('charityPayment', 'payment_method_users'));
        }
        $paymentType = inputGet('payment_type');
		
	
		if ($paymentType == 'charityPayment') {
            //charityPayment 
            $data['mdsPaymentType'] = 'charityPayment';
            $charityID = helperGetSession('modesy_charity_form_id');
            if (empty($charityID)) {
                return redirect()->to(langBaseUrl());
            }
			
            $data['charityForm'] = $this->ticketModel->getcharityData($charityID);
			$charity_details = $data['charityForm']->charityName;
			helperSetSession('charity_details',$charity_details);
            if (empty($data['charityForm'])) {
                return redirect()->to(langBaseUrl());
            }
            //total amount
            $price = $this->session->charityAmount;
			/* 
				$price = getPrice($price, 'database');
				var_dump($price);
				if ($this->paymentSettings->currency_converter != 1) {
                $price = getPrice($price, 'decimal');
				echo "in";die;
				} 
			*/
			
            $objAmount = $this->cartModel->convertCurrencyByPaymentGateway($price, 'ticket_booking');
            $data['totalAmount'] = $objAmount->total;
            $data['currency'] = $objAmount->currency;
            $data['transactionNumber'] = helperGetSession('mds_membership_bank_transaction_number');
            $data['cartTotal'] = null;
        }
		
        echo view('partials/_header', $data);
        echo view('charity/payment_charity', $data);
        echo view('partials/_footer');
    }
	
	public function stripePaymentCharityPost()
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
	
	public function paypalPaymentCharityPost()
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
            if ($paymentType == 'charityPayment') 
			{
                $params = '?payment_type=charityPayment';
            }
			
            $response->message = 'Invalid transaction Id!';
            $response->result = 0;
            $response->redirectUrl = $baseUrl . getRoute('charityPayment', true) . getRoute('payment-user') . $params;
            return $response;
        }
		if ($paymentType == 'charityPayment') {
            $charityID = helperGetSession('modesy_charity_form_id');
            
            if (!empty($charityID)) {
                 $this->ticketModel->addCharityTransactionUsers($dataTransaction);
                //set response and redirect URLs
                $response->result = 1;
                $response->redirectUrl = $baseUrl . getRoute('membership_payment_completed_charity') . '?method=gtw';
            } else {
                //could not added to the database
                $response->message = trans("msg_payment_database_error");
                $response->result = 0;
                $response->redirectUrl = $baseUrl . getRoute('charityPayment', true) . getRoute('payment-user') . '?payment_type=charityPayment';
            }
        } 
		
        //reset session for the payment
        helperDeleteSession('mds_payment_cart_data');
        //return response
        return $response;
    }
	
	public function charityPaymentCompleted()
    {
        $data['title'] = trans("msg_payment_completed");
        $data['description'] = trans("msg_payment_completed") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("payment") . ',' . $this->baseVars->appName;
        $transactionInsertId = helperGetSession('mds_membership_transaction_insert_id');
		
        if (empty($transactionInsertId)) {
            return redirect()->to(langBaseUrl());
        }
        $data['transaction'] = $this->ticketModel->getcharityTransaction($transactionInsertId);

        if (empty($data['transaction'])) {
            return redirect()->to(langBaseUrl());
        }
        $data['method'] = inputGet('method');
        $data['transactionNumber'] = inputGet('transaction_number');
		
		$data_payment = $this->ticketModel->getcharityTransactionUsers($transactionInsertId);

		$emailData = 
		[
				'email_type' => 'activation',
				'email_address' => $data_payment->email,
				'email_data' => serialize([
					'content' => 'Name : '.$data_payment->name,
					'content_1' => 'Phone : '.$data_payment->phone,
					'content_2' => 'Charity Name : '.$data_payment->charityName,
					'content_3' => 'Payment Method : '.$data_payment->payment_method,
					'content_4' => 'Payment Status : '.$data_payment->payment_status,
					'content_5' => 'Transaction ID : '.$data_payment->transaction_id,
					'content_6' => "Thank you! If you have any questions or need assistance, feel free to reach out.",
				]),
				'email_priority' => 1,
				'email_subject' => 'Charity Paymemt Confirmation',
				'template_path' => 'email/rsvp_payment'
		];
		
		addToEmailQueue($emailData);

        echo view('partials/_header', $data);
        echo view('charity/_payment_completed_charity', $data);
        echo view('partials/_footer');
    }
	
	public function invoiceCharity($id)
	{
		$data['title'] = trans("invoice");
        $data['description'] = trans("invoice") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("invoice") . ',' . $this->baseVars->appName;
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
		 
        $data['transaction'] =  $this->ticketModel->getcharityTransactionUsers($id);
        if (empty($data['transaction'])) {
            return redirect()->to(langBaseUrl());
        }
		
        $data['user'] = getUser($data['transaction']->member_id);
        if (empty($data['user'])) {
            return redirect()->to(langBaseUrl());
        }
		
        echo view('charity/invoice_charity', $data);
	}
	
	public function contactUs()
	{
		$data['title'] = trans("contact-us");
        $data['description'] = trans("contact-us") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("contact-us") . ',' . $this->baseVars->appName;
        $data['userSession'] = getUserSession();
        $data['settings'] = $this->settingsModel->getAllSettingsData();
		
        echo view('partials/_header', $data);
        echo view('aboutUs/contactUs.php', $data);
        echo view('partials/_footer');
	}
	
	public function sendContactUSPost()
	{
		$settings = $this->settingsModel->getAllSettingsData();
		
		$spam_check = inputPost('email_address');
		if($spam_check != '')
		{
			echo json_encode('spam');
		}
		else
		{
			$captcha = inputPost('captcha_text');
			
			if ($captcha != $this->session->captcha_code) {
				echo json_encode('failed');
			}else{
				if ($this->membershipModel->contactUsFormPost()) 
				{
					$emailData = 
					[
							'email_type' => 'activation',
							'email_address' => $settings->contact_email,
							'email_data' => serialize([
								'content' => 'Name : '.inputPost('name'),
								'content_1' => 'Phone : '.inputPost('phone'),
								'content_2' => 'Email : '.inputPost('email'),
								'content_3' => 'Subject : '.inputPost('subject'),
								'content_4' => 'Message : '.inputPost('message'),
								'content_5' => "You have a new Contact Message. Kindly check the data and approve it from webiste.",
							]),
							'email_priority' => 1,
							'email_subject' => 'Contact Email',
							'template_path' => 'email/rsvp_payment'
					];
					addToEmailQueue($emailData);
				   echo json_encode('updated');
				}
				else
				{
					echo json_encode('failed');
				}
			}
		}
	}
	
	public function sendSponsorshipEnquiryPost()
	{
		$settings = $this->settingsModel->getAllSettingsData();
		
		$spam_check = inputPost('email_address');
		if($spam_check != '')
		{
			echo json_encode('spam');
		}
		else
		{
			if ($this->membershipModel->sponsorshipEnquiryPost()) 
			{
				$emailData = 
				[
						'email_type' => 'activation',
						'email_address' => $settings->contact_email,
						'email_data' => serialize([
							'content' => 'Name : '.inputPost('first_name').' '.inputPost('last_name'),
							'content_1' => 'Phone : '.inputPost('phone_number'),
							'content_2' => 'Email : '.inputPost('email'),
							'content_3' => 'Company : '.inputPost('company'),
							'content_4' => 'Message : '.inputPost('message'),
							'content_5' => "You have a new Enquiry email regarding the sponsorship. Kindly check the data and approve it from webiste.",
						]),
						'email_priority' => 1,
						'email_subject' => 'Sponsorship Enquiry Email',
						'template_path' => 'email/rsvp_payment'
				];
				addToEmailQueue($emailData);
			   echo json_encode('updated');
			}
			else
			{
				echo json_encode('failed');
			}
		}
	}
	
	public function ourSponsors()
	{
		$data['title'] = trans("our-sponsors");
        $data['description'] = trans("our-sponsors") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("our-sponsors") . ',' . $this->baseVars->appName;
		$data['ourSponsors'] = $this->membershipModel->getAllOurSponsors();
        $data['userSession'] = getUserSession();
		
        echo view('partials/_header', $data);
        echo view('sponsorship/our_sponsors_index.php', $data);
        echo view('partials/_footer');
	}
	
	public function matrimonialPlatform()
	{
		$data = [
            'title' => trans("matrimonial_platform"),
            'description' => $this->settings->site_description,
            'keywords' => $this->settings->keywords
        ];
		
        echo view('partials/_header', $data);
        echo view('aboutUs/matrimonialPlatform');
        echo view('partials/_footer', $data);
	}
	
	public function signUpForOurNewsletter()
	{
		$data['title'] = trans("newsletter");
        $data['description'] = trans("newsletter") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("newsletter") . ',' . $this->baseVars->appName;
        $data['userSession'] = getUserSession();
		
        echo view('partials/_header', $data);
        echo view('aboutUs/sign_up_for_newsletter.php', $data);
        echo view('partials/_footer');
	}
	
	public function downloadSponsorshipPackage()
	{
		return $this->response->download('uploads/ABC Sponsorship Package 2022 - final.pdf', null);
	}
	
	
	public function libraryIndex()
	{
		$data = [
            'title' => trans("library"),
            'description' => $this->settings->site_description,
            'keywords' => $this->settings->keywords
        ];
		$data['books'] = $this->settingsModel->getAllLibraryBooksSelected();
		$data['categories'] = $this->settingsModel->getAllLibraryCategory();
        echo view('partials/_header', $data);
        echo view('library/library_index',$data);
        echo view('partials/_footer', $data);
	}
	
	public function downloadLibraryPdf($id)
	{
		$path = $this->settingsModel->getLibraryPDFsData($id);
		return $this->response->download($path, null);
	}
	
	public function downloadLibraryMagazinePdf($id)
	{
		$path = $this->settingsModel->getLibraryMagazinePDFsData($id);
		return $this->response->download($path, null);
	}
	
	public function buisnessCommunicationCustomer()
	{
		if (authCheck()) {
			$this->settingsModel->updateBusinessCommunication();
		}			
	}
	
	public function getSubcategoryLibararyData()
	{
		$id = inputPost('parent_id');
		$data = $this->settingsModel->getAllLibraryCategorySub($id);
		$jsonData = json_encode($data);

		echo $jsonData;
	}
	
	public function getSlectedLibararyData()
	{
		$p_id = inputPost('parent_id');
		$s_id = inputPost('sub_category_id');
		$data = $this->settingsModel->getSelectedCategoryLibrary($p_id,$s_id);
		$jsonData = json_encode($data);

		echo $jsonData;
	}
}
?>
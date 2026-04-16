<?php

namespace App\Controllers;

use App\Models\TicketModel;
use App\Models\CartModel;
use App\Models\OrderModel;
use App\Libraries\Ciqrcode;


class TicketBookingController extends BaseController
{
     protected $ticketModel;
	 protected $cartModel;
	 protected $orderModel;
	 protected $ciqrcode;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
		$this->ticketModel = new TicketModel();
		$this->cartModel = new CartModel();
		$this->orderModel = new OrderModel();
		$this->ciqrcode = new Ciqrcode();
    }
	
	/**
     * Ticket Booking
     */
    public function ticketBooking()
    {
        if (!authCheck()) 
		{
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("ticket_booking");
        $data['description'] = trans("ticket_booking") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("ticket_booking") . ',' . $this->baseVars->appName;
		$data['tickets'] = $this->ticketModel->getTickets();
        $data['userSession'] = getUserSession();
		
        echo view('partials/_header', $data);
        echo view('ticket_booking/_index.php', $data);
        echo view('partials/_footer');
    }
	
	/**
     * Ticket Seat Booking
     */
    public function editTicketSeats($eventID)
    {
        if (!authCheck()) 
		{
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("ticket_booking");
        $data['description'] = trans("ticket_booking") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("ticket_booking") . ',' . $this->baseVars->appName;
		$data['tickets'] = $this->ticketModel->getTicket($eventID);
		$data['ticket_id'] = $this->ticketModel->getTicketBookedSeat($eventID);
		$data['seats'] = $this->ticketModel->getSeatMap($eventID);
		$data['get_seats_reserved'] = $this->ticketModel->get_seats_reserved($eventID);
        $data['userSession'] = getUserSession();
		//echo "<pre>";print_r($data);echo "</pre>";
        echo view('partials/_header', $data);
        echo view('ticket_booking/bookseat', $data);
        echo view('partials/_footer');
    }
	
	public function bookSelectedTicket()
	{
        $data['title'] = trans("ticket_booking");
        $data['description'] = trans("ticket_booking") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("ticket_booking") . ',' . $this->baseVars->appName;

		$ticketData = [
                'eventID' => $_POST['eventID'],
                'is_paypal' => $_POST['is_paypal'],
                'is_epayment' => $_POST['is_epayment'],
                'eventStartTime' => $_POST['eventStartTime'],
                'eventEndTime' => $_POST['eventEndTime'],
                'eventDate' => $_POST['eventDate'],
                'eventName' => $_POST['eventName'],
                'eventLocation' => $_POST['eventLocation'],
                'eventImage' => $_POST['eventImage'],
                'eventTotalTickets' => $_POST['eventTotalTickets'],
                'eventTotalPrice' => $_POST['eventTotalPrice'],
                'eventTotalwithoutDiscountPrice' => $_POST['eventTotalwithoutDiscountPrice'],
                'eventTotalDiscountPrice' => $_POST['eventTotalDiscountPrice'],
                'eventTotalDiscountPercenatge' => $_POST['eventTotalDiscountPercenatge'],
                'adultPricetotal' => $_POST['adultPricetotal'],
                'childPricetotal' => $_POST['childPricetotal'],
                'totalAdults' => $_POST['totalAdults'],
                'totalChilds' => $_POST['totalChilds'],
                'totalAvailableSeats' => $_POST['totalAvailableSeats'] - $_POST['eventTotalTickets'],
                'seats' => $_POST['seats'],
                'seatsRef' => $_POST['seatsRef']
            ];
			
		$this->session->set($ticketData);
		
        echo view('partials/_header', $data);
        if (authCheck()) 
		{
            echo view('ticket_booking/bookseatSelected', $data);
        } 
        echo view('partials/_footer');
	}
	
 	public function paymentProceed()
	{
		helperSetSession('modesy_selected_ticket_id', $this->session->eventID);
        helperSetSession('modesy_membership_request_type', 'booking');
		$this->paymentMethodTicket();
	}
	 
	 /**
     * Payment Method
     */
    public function paymentMethodTicket()
    { 	
		$data['title'] = trans("ticket_booking");
        $data['description'] = trans("ticket_booking") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("ticket_booking") . ',' . $this->baseVars->appName;
		
        $paymentType = 'ticketBooking';
		
		if ($paymentType == 'ticketBooking') 
		{
            $data['mdsPaymentType'] = 'ticketBooking';
            $data['is_epayment'] = $this->session->is_epayment;
            $data['is_paypal'] = $this->session->is_paypal;
            $ticketId = helperGetSession('modesy_selected_ticket_id');
			
            if (empty($ticketId)) 
			{
                return redirect()->to(langBaseUrl());
            }
        }
		
        echo view('partials/_header', $data);
        echo view('ticket_booking/_payment_method', $data);
        echo view('partials/_footer');
    }
	
	  /**
     * Payment Method Post
     */
    public function paymentMethodTicketPost()
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
            return redirect()->to(generateUrl('ticketBooking', 'payment_method_ticket'));
        }
        $this->cartModel->setSessCartPaymentMethod();
        $redirect = langBaseUrl();
        if ($mdsPaymentType == 'ticketBooking') {
            $transactionNumber = 'bank-' . generateToken();
            helperSetSession('mds_membership_bank_transaction_number', $transactionNumber);
            $redirect = generateUrl('ticketBooking', 'payment_ticket') . '?payment_type=ticketBooking';
        }
		
        return redirect()->to($redirect);
    }
	
	 /**
     * Payment
     */
    public function payment_ticket()
    {
		$data['title'] = trans("ticket_booking");
        $data['description'] = trans("ticket_booking") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("ticket_booking") . ',' . $this->baseVars->appName;
        $data['mdsPaymentType'] = 'ticketBooking';
        $data['userSession'] = getUserSession();
		
	
        //check guest checkout
        if (empty(authCheck()) && $this->generalSettings->guest_checkout != 1) {
            return redirect()->to(generateUrl('ticketBooking'));
        }
        //check is set cart payment method
		
        $data['cartPaymentMethod'] = $this->cartModel->getSessCartPaymentMethod();
		
        if (empty($data['cartPaymentMethod'])) {
            return redirect()->to(generateUrl('ticketBooking', 'payment_method_users'));
        }
        $paymentType = inputGet('payment_type');
		
	
		if ($paymentType == 'ticketBooking') {
            //ticketBooking payment
            
            $data['mdsPaymentType'] = 'ticketBooking';
            $eventId = helperGetSession('modesy_selected_ticket_id');
            if (empty($eventId)) {
                return redirect()->to(langBaseUrl());
            }
            
            $price = $this->session->eventTotalPrice;
            if ($this->paymentSettings->currency_converter != 1) {
                $price = getPrice($price, 'decimal');
            }
			
            $objAmount = $this->cartModel->convertCurrencyByPaymentGateway($price, 'ticketBooking');
			
            $data['totalAmount'] = $objAmount->total;
            $data['currency'] = $objAmount->currency;
            $data['transactionNumber'] = helperGetSession('mds_membership_bank_transaction_number');
            $data['cartTotal'] = null;
        }
		
        echo view('partials/_header', $data);
        echo view('ticket_booking/_payment', $data);
        echo view('partials/_footer');
    }
	
	public function stripePaymentTikcetPost()
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
	
	public function paypalPaymentTicketPost()
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
            if ($paymentType == 'ticketBooking') 
			{
                $params = '?payment_type=ticketBooking';
            }
			
            $response->message = 'Invalid transaction Id!';
            $response->result = 0;
            $response->redirectUrl = $baseUrl . getRoute('ticketBooking', true) . getRoute('payment_ticket') . $params;
            return $response;
        }
		if ($paymentType == 'ticketBooking') {
            $planId = helperGetSession('modesy_selected_ticket_id');
            
            if (!empty($planId)) {
                //add user ticket
                $this->ticketModel->updateSeatSelected($dataTransaction);
                //set response and redirect URLs
                $response->result = 1;
                $response->redirectUrl = $baseUrl . getRoute('membership_payment_completed_ticket') . '?method=gtw';
            } else {
                //could not added to the database
                $response->message = trans("msg_payment_database_error");
                $response->result = 0;
                $response->redirectUrl = $baseUrl . getRoute('ticketBooking', true) . getRoute('payment_ticket') . '?payment_type=ticketBooking';
            }
        } 
		
        //reset session for the payment
        helperDeleteSession('mds_payment_cart_data');
        //return response
        return $response;
    }
	
	public function ticketPaymentCompleted()
    {
        $data['title'] = trans("msg_payment_completed");
        $data['description'] = trans("msg_payment_completed") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("payment") . ',' . $this->baseVars->appName;
        $transactionInsertId = helperGetSession('mds_membership_transaction_insert_id');
		
        if (empty($transactionInsertId)) {
            return redirect()->to(langBaseUrl());
        }
        $data['transaction'] = $this->ticketModel->getTransactionTicket($transactionInsertId);
		
        if (empty($data['transaction'])) {
            return redirect()->to(langBaseUrl());
        }
        $data['method'] = inputGet('method');
        $data['transactionNumber'] = inputGet('transaction_number');
		
		$data['tickets'] = $this->ticketModel->getBookedTicketData($transactionInsertId);
			
        echo view('partials/_header', $data);
        echo view('ticket_booking/_payment_completed_ticket', $data);
        echo view('partials/_footer');
    }
	
	public function invoiceTicketBooking($id)
	{
		$data['title'] = trans("invoice");
        $data['description'] = trans("invoice") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("invoice") . ',' . $this->baseVars->appName;

        $data['transaction'] =  $this->ticketModel->getTransactionTicket($id);
        if (empty($data['transaction'])) {
            return redirect()->to(langBaseUrl());
        }
		
		$ticket_data['tickets'] = $this->ticketModel->getBookedTicketData($id);
        
        echo view('ticket_booking/invoice_ticket', $ticket_data);
	}
	
	public function ticketSelectionData()
	{
		$event_id_data = $_POST['event_id'];
		$member_id_data = $_POST['member_id'];
		
		
		if($this->ticketModel->tempticketdata($event_id_data,$member_id_data))
		{
			$time_data = $this->ticketModel->getTempticketdata($event_id_data,$member_id_data);
			
			$ticketStartData = [
                'eventID_temp_ticket' => $event_id_data,
                'memberID_temp_ticket' =>$member_id_data,
                'end_time_booking' =>$time_data->end_time,
                'id_booking_temp' =>$time_data->id,
            ];
			
			$this->session->set($ticketStartData);
			
			echo json_encode([
				'result' => 1,
				'start_time' => $time_data->start_time,
				'end_time' => $time_data->end_time,
			]);
		}
		else
		{
			echo json_encode([
				'result' => 0,
			]);
		}
		
		
	}
	
	public function reserveTicketSelectionData()
	{
		$seatID = inputPost('seats');
		
		$this->ticketModel->updateSeatReservedData($seatID);
	}

	public function reserveTicketRemoveData()
	{
		$seatID = inputPost('seats');
		
		$this->ticketModel->updateSeatReservedDataRemove($seatID);
	}

	public function tempTicketDataDeleted()
	{
		if($this->ticketModel->tempticketdataDeleted())
		{
			echo json_encode('deleted');
		}
	}

	public function tempTicketDataReservedNot()
	{
		$seat_id = inputPost('seats');
		$data = $this->ticketModel->get_seats_reserved($this->session->eventID_temp_ticket);
		$seatNumbersReserved = array();
		foreach ($data as $item) 
		{
			$seatArrayReserved = explode(', ', $item->seats);
			foreach ($seatArrayReserved as $seat) 
			{
				$seatNumbersReserved[] = $seat;
			}
		}
		
		if (in_array($seat_id, $seatNumbersReserved)) 
		{
			echo json_encode([
				'result' => 1,
				'seatID' => $seat_id,
			]);
		} else {
			echo json_encode([
				'result' => 0,
			]);
		}
	}
	
	
	public function removeSessionTicketTimeExpired()
	{
		helperDeleteSession('modesy_selected_ticket_id');
		helperDeleteSession('mds_membership_bank_transaction_number');
		helperDeleteSession('mds_membership_transaction_insert_id'); 			
		helperDeleteSession('eventID'); 
		helperDeleteSession('eventStartTime'); 
		helperDeleteSession('eventEndTime'); 
		helperDeleteSession('eventDate'); 
		helperDeleteSession('eventName'); 
		helperDeleteSession('eventLocation'); 
		helperDeleteSession('eventImage'); 
		helperDeleteSession('eventTotalTickets'); 
		helperDeleteSession('eventTotalPrice'); 
		helperDeleteSession('eventTotalwithoutDiscountPrice'); 
		helperDeleteSession('eventTotalDiscountPrice'); 
		helperDeleteSession('eventTotalDiscountPercenatge'); 
		helperDeleteSession('adultPricetotal'); 
		helperDeleteSession('childPricetotal'); 
		helperDeleteSession('totalAdults'); 
		helperDeleteSession('totalChilds'); 
		helperDeleteSession('totalAvailableSeats'); 
		helperDeleteSession('seats'); 
		helperDeleteSession('eventID_temp_ticket'); 
		helperDeleteSession('memberID_temp_ticket'); 
		helperDeleteSession('end_time_booking'); 
		helperDeleteSession('id_booking_temp'); 
		helperDeleteSession('is_paypal'); 
		helperDeleteSession('is_epayment'); 
		
		$this->ticketBooking();
	}
	
	public function getTableNameDefine()
	{
		$search_value = inputPost('row_value');
		$getData = $this->ticketModel->getTableNameDefineTable($search_value);
		$response = [
			'table_name' => $getData->table_name,
			'row_value' => $getData->row_value
		];
		echo json_encode($response);
	}

	function generate_qrcode()
    {
		$data = inputPost('data');
		$data_img = inputPost('data_img');
        /* Load QR Code Library */
         loadLibrary('ciqrcode');

        $save_name  = $data_img . '.png';

        /* QR Code File Directory Initialize */
        $dir = 'assets/media/qrcode/';
        if (! file_exists($dir)) {
            mkdir($dir, 0775, true);
        }

        /* QR Configuration  */
        $config['cacheable']    = true;
        $config['imagedir']     = $dir;
        $config['quality']      = true;
        $config['size']         = '1024';
        $config['black']        = [255, 255, 255];
        $config['white']        = [255, 255, 255];
        $this->ciqrcode->initialize($config);

        /* QR Data  */
        $params['data']     = $data;
        $params['level']    = 'L';
        $params['size']     = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $save_name;

        $this->ciqrcode->generate($params);

        /* Return Data */
        return [
            'content' => $data,
            'file'    => $dir . $save_name,
        ];
    }
	
	public function epaymentMethodBooking()
	{
		$data = $this->ticketModel->updateEpaymentBooking();
		
		if($data)
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
	
	public function resendEmailToMember()
	{
		$transactionInsertId = 1;
		$transaction = $this->ticketModel->getTransactionTicket($transactionInsertId);
		
        if (empty($transaction)) {
            return redirect()->to(langBaseUrl());
        }
		
		$tickets = $this->ticketModel->getBookedTicketDataResendEmail($transactionInsertId,$transaction->member_booking_id);
		
		$data_order = $tickets[0];
		$seatdataArray = $data_order['reference_seats'];
		$seatdataReference = str_replace(['[', ']', '"'], '', $seatdataArray);
		$seatdata =  str_replace(',', ', ', $seatdataReference);
		$emailData = 
		[
				'email_type' => 'activation',
				'email_address' => 'info@agarwals.ca',
				'email_data' => serialize([
					'content' => 'Event Name : '.$data_order['event_name'],
					'content_1' => 'Event Date : '.$data_order['event_date'],
					'content_2' => 'Location : '.$data_order['event_location'],
					'content_3' => 'Time : '.$data_order['event_start_time'],
					'content_4' => 'Name : '.$data_order['username'],
					'content_5' => 'Transaction ID : '.$data_order['transaction_id'],
					'content_9' => 'Total Seats : '.$data_order['totalSeats'],
					'content_8' => $data_order['transaction_id'],
					'content_6' => 'Seat(s) : '.$seatdata,
					'content_7' => "Thank you for joining our event! We're excited to have you with us and look forward to an amazing time together. If you have any questions or need assistance, feel free to reach out. See you at the event!",
				]),
				'email_priority' => 1,
				'email_subject' => 'Ticket Order Confirmation',
				'template_path' => 'email/ticket_order'
		];

		addToEmailQueue($emailData);

	}
	
}
?>
<?php

namespace App\Controllers;

use App\Models\TicketModel;

class TicketController extends BaseAdminController
{
    protected $ticketModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->ticketModel = new TicketModel();
    }
	
	/*
     * --------------------------------------------------------------------
     * TicketManager
     * --------------------------------------------------------------------
     */

    /**
     * TicketManager
     */
    public function ticket()
    {
        checkPermission('blog');
        $data['title'] = trans("ticket_manager");
        $data['tickets'] = $this->ticketModel->getTickets();
        $data['userSession'] = getUserSession();
        echo view('admin/includes/_header', $data);
        echo view('admin/ticket_manager/_index', $data);
        echo view('admin/includes/_footer');
    }
	
	/**
     * Add Ticket Post
     */
    public function addTicketPost()
    {
		/*This is for getting the total no of seats only ----start---*/
		$tables_seats_sections = array();
		$section = 1;

		foreach ($_POST as $key => $value) 
		{
			if (strpos($key, 'tables') === 0 && isset($_POST['seats' . substr($key, 6)])) {
				$seat_key = 'seats' . substr($key, 6);
				$tables_seats_sections[] = array(
					'section' => $section,
					'tables' => $value,
					'seats' => $_POST[$seat_key]
				);
				$section++;
			}
		}

		// Calculate total number of seats
		$totalSeats = 0;
		foreach ($tables_seats_sections as $sectionData) 
		{
			$totalSeats += $sectionData['tables'] * $sectionData['seats'];
		}
		/*This is for getting the total no of seats only ----end---*/
		
		//echo "<pre>";print_r($_POST);die;
		
        //checkPermission('blog');

		if ($this->ticketModel->addTicket($totalSeats)) 
		{
			setSuccessMessage(trans("msg_added"));
			return redirect()->back();
		}
        
        setErrorMessage(trans("msg_error"));
        return redirect()->back()->withInput();
    }
	
	 /**
     * Edit Ticket
     */
    public function editTicket($id)
    {
        //checkPermission('blog');
        $data['title'] = trans("update_post_ticket");
        $data['ticket'] = $this->ticketModel->getTicket($id);
		
        if (empty($data['ticket'])) 
		{
            redirectToUrl(adminUrl('ticket-manager'));
        }

        echo view('admin/includes/_header', $data);
        echo view('admin/ticket_manager/edit_ticket', $data);
        echo view('admin/includes/_footer');
    } 
	
	public function editTicketEpaymentData($id)
    {
        $data['title'] = trans("update_post_ticket");
        $data['tickets'] = $this->ticketModel->getTicketEpaymentData($id);
		
        if (empty($data['tickets'])) 
		{
			setErrorMessage('Error Occured, No relavant data refresh and try again');
            redirectToUrl(adminUrl('ticket-manager'));
        }

        echo view('admin/includes/_header', $data);
        echo view('admin/ticket_manager/edit_ticket_epayment', $data);
        echo view('admin/includes/_footer');
    }
	
	/**
     * Edit Ticket Post
     */
    public function editTicketPost()
    {
        //checkPermission('blog');

		$id = inputPost('id');
		if ($this->ticketModel->editTicket($id)) 
		{
			setSuccessMessage(trans("msg_updated"));
			redirectToUrl(adminUrl('ticket-manager'));
		}
        setErrorMessage(trans("msg_error"));
        return redirect()->back()->withInput();
    }
	
	/**
     * Delete Category Post
     */
    public function deleteTicketPost()
    {
        //checkPermission('blog');
        $id = inputPost('id');
       
		if ($this->ticketModel->deleteTicket($id)) 
		{
			setSuccessMessage(trans("msg_deleted"));
		} 
		else 
		{
			setErrorMessage(trans("msg_error"));
		}
    }
	
	
	public function holdTickets($eventID)
	{
		$data['title'] = trans("update_post_ticket");
        $data['tickets'] = $this->ticketModel->getTicket($eventID);
		$data['ticket_id'] = $this->ticketModel->getTicketBookedSeat($eventID);
		$data['seats'] = $this->ticketModel->getSeatMap($eventID);
		
        if (empty($data['tickets'])) 
		{
            redirectToUrl(adminUrl('ticket-manager'));
        }

        echo view('admin/includes/_header', $data);
        echo view('admin/ticket_manager/hold_tickets', $data);
        echo view('admin/includes/_footer');
	}
	
	
	public function updateHoldTickets()
	{
		$postData = $_POST['seats'];
		$data = [];

		if (isset($postData)) {
			foreach ($postData as $seatsArray) {
				$decodedSeats = json_decode($seatsArray, true); // Decode the JSON-encoded seat array
				
				if ($decodedSeats) {
					foreach ($decodedSeats as $seat) 
					{
						$seatData = ['seat_number' => $seat, 'member_id' => $this->session->mds_ses_id];
						
						// Check if the seat starts with 'Vs' prefix, and if so, add the seat_booking_number
						if (strpos($seat, 'Vs') === 0) 
						{
							$seatData['seat_booking_numbers'] = $seat;
							$seatData['vip_seats'] = 1;
						}
						
						$data[] = $seatData; // Add the seat data to the $data array
					}
				}
			}
		}

		
		//echo "<pre>";print_r($data);die;
		
		if ($this->ticketModel->updateHoldTickets($data)) 
		{
			setSuccessMessage(trans("msg_updated"));
			redirectToUrl(adminUrl('ticket-manager'));
		}
        setErrorMessage(trans("msg_error"));
        return redirect()->back()->withInput();
	}
	
	public function reportTickets($eventID)
	{
		$data['title'] = trans("report");
        $data['ticket_report'] = $this->ticketModel->getTicketReport($eventID);
		$data['tickets'] = $this->ticketModel->getTicket($eventID);
		$data['tickets_overall_total'] = $this->ticketModel->getTicketReportTotal($eventID);
		 
        echo view('admin/includes/_header', $data);
        echo view('admin/ticket_manager/report_tickets', $data);
        echo view('admin/includes/_footer');
	}
	
	public function reportTicketsCheckIn($eventID)
	{
		$data['title'] = 'Attendees Report';
        $data['ticket_report'] = $this->ticketModel->getTicketReportAttendees($eventID);
		$data['tickets'] = $this->ticketModel->getTicket($eventID);
		 
        echo view('admin/includes/_header', $data);
        echo view('admin/ticket_manager/report_members_checkIn', $data);
        echo view('admin/includes/_footer');
	}
	
	public function epaymentReportTickets($eventID)
	{
		$data['title'] = trans("report");
        $data['tickets_epayment'] = $this->ticketModel->getTicketEpaymentReport($eventID);
		$data['tickets'] = $this->ticketModel->getTicket($eventID);
		 
        echo view('admin/includes/_header', $data);
        echo view('admin/ticket_manager/report_tickets_epayment', $data);
        echo view('admin/includes/_footer');
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

	public function updateTableNameDefine()
	{
		$update_value = inputPost('row_value');
		$update_table_name = inputPost('table_name_value');
		$updateData = $this->ticketModel->updateTableNameDefineTable($update_value,$update_table_name);
		
		if($updateData)
		{
			echo json_encode('updated');
		}
		else
		{
			echo json_encode('failed');
		}
	}
	
	public function charity()
	{
		$data['title'] = trans("charity");
        $data['charityList'] = $this->ticketModel->getCharityList();
        $data['userSession'] = getUserSession();
        echo view('admin/includes/_header', $data);
        echo view('admin/charity_manager/charity_index', $data);
        echo view('admin/includes/_footer');
	}
	
	public function charityPost()
	{
		if ($this->ticketModel->addCharity()) 
		{
			setSuccessMessage(trans("msg_added"));
			return redirect()->back();
		}
        
        setErrorMessage(trans("msg_error"));
        return redirect()->back()->withInput();
	}
	
	public function reportCharityList($id)
	{
		$data['title'] = trans("charity_report");
		$data['charityList'] = $this->ticketModel->getCharityListDetailReport($id);

			
        echo view('admin/includes/_header', $data);
        echo view('admin/charity_manager/charity_report', $data);
        echo view('admin/includes/_footer');
	}
	
	public function editCharityList($id)
	{
		$data['title'] = trans("charity_edit");
		$data['charityList'] = $this->ticketModel->getCharityListDetail($id);

			
        echo view('admin/includes/_header', $data);
        echo view('admin/charity_manager/charity_edit', $data);
        echo view('admin/includes/_footer');
	}
	
	public function editCharityPost()
	{
		if ($this->ticketModel->editCharity()) 
		{
			setSuccessMessage(trans("msg_updated"));
			return redirect()->back();
		}
        
        setErrorMessage(trans("msg_error"));
        return redirect()->back()->withInput();
	}
	
	public function charityTransactions()
	{
		$data['title'] = trans("charity");
        $data['charityList'] = $this->ticketModel->getCharityListTransactions();
        $data['userSession'] = getUserSession();
        echo view('admin/includes/_header', $data);
        echo view('admin/charity_manager/charity_transactions', $data);
        echo view('admin/includes/_footer');
	}
	
	public function editApproveEpayment()
	{
		$event_id = inputPost('event_id');
		$mem_id = inputPost('member_id');
		
		$status = $this->ticketModel->updateEpaymentMasterTicket();
		
		if($status)
		{
			$transactionInsertId = helperGetSession('mds_transaction_insert_id');
			$tickets = $this->ticketModel->getBookedTicketDataEpayment($transactionInsertId,$mem_id);
			
			helperSetSession('tickets', $tickets);
			setSuccessMessage('Ticket Approved and mail is sent to the member');
		}
		else
		{
			setErrorMessage(trans("msg_error"));
		}
        return redirect()->to(adminUrl('report-tickets-ePayment/' . $event_id));
	}
	
	public function rejectEpaymentApproval()
	{
		$random_ref_no = inputPost('id');
		
		$status = $this->ticketModel->rejectEpaymentApproval($random_ref_no);
		
		if($status)
		{
			setSuccessMessage('Ticket Booking Rejected Successfully');
		}
		else
		{
			setErrorMessage(trans("msg_error"));
		}
	}
	
	public function updateMemberCheckInTime()
	{
		$invoice = inputPost('row_value');
		
		$encryptionKey = '058e800881aef2fe2b16360ccf6418aae614c11ac72d3d9872c08d480d10e914';
		
		function decryptString($string, $key)
		{
			$cipher = "aes-256-cbc";
			$ivLength = openssl_cipher_iv_length($cipher);

			$data = base64_decode($string);
			$iv = substr($data, 0, $ivLength);
			$encrypted = substr($data, $ivLength);

			return openssl_decrypt($encrypted, $cipher, $key, 0, $iv);
		}
		
		$encryptedString = $invoice;
		$decryptedString = decryptString($encryptedString, $encryptionKey);
		
		$time = inputPost('time');
		
		$existsCheck = $this->ticketModel->existsupdateMemberCheckInTime($decryptedString,$time);
		
		if($existsCheck != null)
		{
			echo json_encode('available');
			die;
		}
		else{
		
			$checkIn = $this->ticketModel->updateMemberCheckInTime($decryptedString,$time);
			
			if($checkIn)
			{
				echo json_encode('updated');
				die;
			}
			else
			{
				echo json_encode('failed');
				die;
			}
		}
	}
	
	public function resendEmailTickets($eventID)
	{
		$data['title'] = trans("report");
		$data['tickets'] = $this->ticketModel->getTicket($eventID);
		$data['ticketsData'] = $this->ticketModel->getTicketBookingEmailData($eventID);
		 
        echo view('admin/includes/_header', $data);
        echo view('admin/ticket_manager/resendEmailTicket', $data);
        echo view('admin/includes/_footer');
	}
	
	public function resendEmailTicketsConfirmed($transactionInsertId,$mem_id,$event_id)
	{
		$tickets = $this->ticketModel->getBookedTicketDataEpayment($transactionInsertId,$mem_id);
	
		$data_order = $tickets[0];
		$seatdataArray = $data_order['reference_seats'];
		$seatdataReference = str_replace(['[', ']', '"'], '', $seatdataArray);
		$seatdata =  str_replace(',', ', ', $seatdataReference);
		$emailData = 
		[
				'email_type' => 'activation',
				'email_address' => $data_order['email'],
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
		setSuccessMessage('Email has been resent to the user.');
		
        return redirect()->to(adminUrl('resend-email-ticket/' . $event_id));
	}
}
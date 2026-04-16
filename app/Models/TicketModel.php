<?php namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends BaseModel
{
    protected $builder;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('ticket_details_event');
        $this->builderTicket = $this->db->table('ticket_book_details');
        $this->builderTicketMaster = $this->db->table('ticket_booking_master');
        $this->builderTicketSeats = $this->db->table('tickets_seat_map');
        $this->builderTicketTemp = $this->db->table('ticket_book_details_temp');
        $this->builderTicketTableNames = $this->db->table('ticket_book_details_table_names');
        $this->builderCharityManager = $this->db->table('charity_manager');
        $this->builderCharitySubmitForm = $this->db->table('charity_form_data');
        $this->builderCharityPayment = $this->db->table('charity_payment');
        $this->builderUsers = $this->db->table('users');
        $this->builderGeneralSettings = $this->db->table('general_settings');
    }
	
	//input values
    public function inputValuesCategory()
    {
		$eventStartTime = inputPost('eventStartTime');

		if ($eventStartTime === "" || $eventStartTime === "00:00" || $eventStartTime === "00:00:00") 
		{
			$eventStartTimeValue = NULL; 
		}
		else 
		{
			$eventStartTimeValue = $eventStartTime; 
		}
		
		$eventEndTime = inputPost('eventEndTime');

		if ($eventEndTime === "" || $eventEndTime === "00:00" || $eventEndTime === "00:00:00") 
		{
			$eventEndTimeValue = NULL; 
		}
		else 
		{
			$eventEndTimeValue = $eventEndTime; 
		}
		
		$ticketDisplayTime = inputPost('ticketDisplayTime'); 
		
		if ($ticketDisplayTime === "" || $ticketDisplayTime === "00:00" || $ticketDisplayTime === "00:00:00") 
		{
			$ticketDisplayTimeValue = NULL; 
		}
		else 
		{
			$ticketDisplayTimeValue = $ticketDisplayTime; 
		}
		
		$g_mem_tp_post = inputPost('g_mem_tp');
		$g_mem_tp = getPrice($g_mem_tp_post, 'database');
        if (empty($g_mem_tp)) {
           $g_mem_tp = 0;
        }
		
		$g_non_mem_tp_post = inputPost('g_non_mem_tp');
		$g_non_mem_tp = getPrice($g_non_mem_tp_post, 'database');
        if (empty($g_non_mem_tp)) {
           $g_non_mem_tp = 0;
        }
		
		$g_child_tp_post = inputPost('g_child_tp');
		$g_child_tp = getPrice($g_child_tp_post, 'database');
        if (empty($g_child_tp)) {
           $g_child_tp = 0;
        }
		
		$s_mem_tp_post = inputPost('s_mem_tp');
		$s_mem_tp = getPrice($s_mem_tp_post, 'database');
        if (empty($s_mem_tp)) {
           $s_mem_tp = 0;
        }
		
		$s_non_mem_tp_post = inputPost('s_non_mem_tp');
		$s_non_mem_tp = getPrice($s_non_mem_tp_post, 'database');
        if (empty($s_non_mem_tp)) {
           $s_non_mem_tp = 0;
        }
		
		$s_child_tp_post = inputPost('s_child_tp');
		$s_child_tp = getPrice($s_child_tp_post, 'database');
        if (empty($s_child_tp)) {
           $s_child_tp = 0;
        }

        return [
            'event_name' => strtoupper(inputPost('eventName')),
            'event_date' => inputPost('eventDate'),
            'event_start_time' => $eventStartTimeValue,
            'event_end_time' => $eventEndTimeValue,
            'event_location' => strtoupper(inputPost('eventLocation')),
            'ticketShowDate' => inputPost('ticketShowDate'),
            'ticketDisplayTime' => $ticketDisplayTimeValue,
            'ticketHideDate' => inputPost('ticketHideDate'),
            'g_mem_tp' => $g_mem_tp,
            'g_non_mem_tp' =>  $g_non_mem_tp,
            'g_child_tp' => $g_child_tp,
            's_mem_tp' => $s_mem_tp,
            's_non_mem_tp' => $s_non_mem_tp,
            's_child_tp' => $s_child_tp,
            'd1_more_than' => inputPost('d1_more_than'),
            'd1_perc' => inputPost('d1_perc'),
            'd2_more_than' => inputPost('d2_more_than'),
            'd2_perc' => inputPost('d2_perc'),
            'd3_more_than' => inputPost('d3_more_than'),
            'd3_perc' => inputPost('d3_perc'),
            'bookinglimit' => inputPost('bookinglimit'),
            'is_paypal' => inputPost('is_paypal'),
            'is_epayment' => inputPost('is_epayment'),
            'paypalCharges' => inputPost('paypalCharges'),
            'member_id' => $this->session->mds_ses_id	
        ];
    }
	
	//input values for seats
    public function inputValuesCategorySeats($event_id)
    {
		$member_id =$this->session->mds_ses_id;
		$tables_seats_sections = array();
		$section = 1;

		foreach ($_POST as $key => $value) 
		{
			if (strpos($key, 'tables') === 0 && isset($_POST['seats' . substr($key, 6)])) 
			{
				$seat_key = 'seats' . substr($key, 6);
				$tables_seats_sections[] = array(
					'sections' => $section,
					'section_name' => $_POST['sectionName' . substr($key, 6)], // Add sectionName here
					'tables' => $value,
					'seats' => $_POST[$seat_key],
					'event_id' => $event_id,
					'member_id' => $member_id
				);
				$section++;
			}
		}

		return $tables_seats_sections;
    }
	
	//add ticket details 
	public function addTicket($totalSeats)
    {
        $data = $this->inputValuesCategory();
		
		$uploadModel = new UploadModel();
        $eventImage = $uploadModel->uploadEventImageTicket('eventImage');
        $eventImage1 = $uploadModel->uploadseatlayoutImage('seatLayoutImage');

        if (!empty($eventImage) && !empty($eventImage['path'])) 
		{
            //deleteFile($this->generalSettings->event_image);
            $data['event_image'] = $eventImage['path'];
        }
		
		if (!empty($eventImage1) && !empty($eventImage1['path'])) 
		{
            $data['seatLayoutImage'] = $eventImage1['path'];
        }
			$data['total_seats'] = $totalSeats;
		
        if ($this->builder->insert($data)) 
		{
			
			$this->builder->orderBy('id','desc');
			$this->builder->limit('1');
			$events = $this->builder->get()->getRow();
			$eventId = $events->id; 
			$data_seats = $this->inputValuesCategorySeats($eventId);
			
			$success = $this->builderTicketSeats->insertBatch($data_seats);
			if($success)
			{
				$insertData = []; 
				$currentTableNumber = 1;

				foreach ($data_seats as $config) 
				{
					$totalRows = $config['tables'];

					for ($i = 1; $i <= $totalRows; $i++) {
						$tableNumber = str_pad($currentTableNumber, 2, '0', STR_PAD_LEFT); 
						$sectionNumber = $config['sections'];
						$eventId = $config['event_id']; 

						$rowValue = "S{$sectionNumber}{$eventId}{$tableNumber}";

						$insertData[] = [
							'table_name' => "Table {$tableNumber}",
							'row_value' => $rowValue,
						];

						$currentTableNumber++;
					}
				}
				
				$this->builderTicketTableNames->insertBatch($insertData);
				
			}
			else
			{
				return false;
			}
			
			if($totalSeats != '')
			{
				$repetitions = $totalSeats;

				$valuesClause = implode(', ', array_fill(0, $repetitions, "($eventId, NULL, NULL)"));

				$sqlQuery = "INSERT INTO ticket_book_details (event_ID, seat_number, member_id) VALUES $valuesClause;";

				// Use the Query Builder to run the query
				$builder = $this->db->query($sqlQuery);
			}
			
            return true;
        }
        return false;
    }
	
	 //get tickets
    public function getTickets()
    {
		$this->builder->where('deleted',0);
        return $this->builder->orderBy('id')->get()->getResult();
    }
	
	 //get ticket
    public function getTicket($id)
    {
        return $this->builder->where('id', clrNum($id))->get()->getRow();
    }

	//get ticket
    public function getTicketBookedSeat($id)
    {
        return $this->builderTicket->where('event_id', $id)
								   ->where('seat_number !=', NULL)
								   ->where('member_id !=', NULL)
								   ->get()->getResultArray();
    }
	
	//edit ticket
    public function editTicket($id)
    {
        $ticket = $this->getTicket($id);
        if (!empty($ticket)) 
		{
            $data = $this->inputValuesCategory();
			
			$uploadModel = new UploadModel();
			$eventImage = $uploadModel->uploadEventImageTicket('eventImage');
			$eventImage1 = $uploadModel->uploadseatlayoutImage('seatLayoutImage');
			if (!empty($eventImage) && !empty($eventImage['path'])) 
			{
				//deleteFile($this->generalSettings->event_image);
				$data['event_image'] = $eventImage['path'];
			}
			
			if (!empty($eventImage1) && !empty($eventImage1['path'])) 
			{
				//deleteFile($this->generalSettings->event_image);
				$data['seatLayoutImage'] = $eventImage1['path'];
			}
			
            if ($this->builder->where('id', $ticket->id)->update($data)) 
			{
                return true;
            }
            return false;
        }
    }
	
	//delete ticket
    public function deleteTicket($id)
    {
        $ticket = $this->getTicket($id);
        if (!empty($ticket)) 
		{
			$data =  ['deleted' => 1 ];
            return $this->builder->where('id', $ticket->id)->update($data);
        }
        return false;
    }
	
	//set cart payment method option session
    public function setSessCartPaymentMethod()
    {
        $std = new \stdClass();
        $std->payment_option = inputPost('payment_option');
        $std->terms_conditions = inputPost('terms_conditions');
        helperSetSession('mds_cart_payment_method', $std);
    }

    //get cart payment method option session
    public function getSessCartPaymentMethod()
    {
        if (!empty(helperGetSession('mds_cart_payment_method'))) {
            return helperGetSession('mds_cart_payment_method');
        }
    }
	
	//convert currency by payment gateway
    public function convertCurrencyByPaymentGateway($total, $paymentType)
    {
        $data = new \stdClass();
        $data->total = $total;
        $data->currency = $this->selectedCurrency->code;
        $paymentMethod = $this->getSessCartPaymentMethod();
        if ($this->paymentSettings->currency_converter != 1) {
            return $data;
        }
        if (empty($paymentMethod)) {
            return $data;
        }
        if (empty($paymentMethod->payment_option) || $paymentMethod->payment_option == 'bank_transfer' || $paymentMethod->payment_option == 'cash_on_delivery') {
            return $data;
        }
        $paymentGateway = getPaymentGateway($paymentMethod->payment_option);
        if (!empty($paymentGateway)) {
            if (empty($paymentGateway->base_currency) || $paymentGateway->base_currency == "all") {
                $newCurrency = $this->selectedCurrency;
            } else {
                $newCurrency = getCurrencyByCode($paymentGateway->base_currency);
            }
            if ($paymentType == 'sale') {
                if ($paymentGateway->base_currency != $this->selectedCurrency->code && $paymentGateway->base_currency != 'all') {
                    if (!empty($newCurrency)) {
                        $newTotal = $this->getCartTotalByCurrency($newCurrency);
                        if (!empty($newTotal)) {
                            $data->total = $newTotal->total;
                            $data->currency = $newCurrency->code;
                        }
                    }
                }
            } elseif ($paymentType == 'membership') {
                $total = getPrice($total, 'decimal');
                $newTotal = convertCurrencyByExchangeRate($total, $newCurrency->exchange_rate);
                if (!empty($newTotal)) {
                    $data->total = $newTotal;
                    $data->currency = $newCurrency->code;
                }
            } elseif ($paymentType == 'promote') {
                $newTotal = convertCurrencyByExchangeRate($total, $newCurrency->exchange_rate);
                if (!empty($newTotal)) {
                    $data->total = $newTotal;
                    $data->currency = $newCurrency->code;
                }
            }
        }
        return $data;
    }
	
	public function updateSeatSelected($dataTransaction)
	{
		$this->builderTicketMaster->orderBy('ticket_id','desc');
		$this->builderTicketMaster->limit(1);
		$query = $this->builderTicketMaster->get()->getResult();
		
		if(count($query) > 0)
		{
			$user = $query; 

			$parts = explode("-", $user[0]->invoice_no);
			$numericPart = (int) end($parts); 

			$newNumericPart = $numericPart + 1;

			$numericPartLength = strlen($numericPart); 
			$newNumericPartPadded = str_pad($newNumericPart, $numericPartLength, '0', STR_PAD_LEFT);

			$inv_no = $parts[0] . "-" . $parts[1] . "-" . $newNumericPartPadded;
		}
		else
		{
			$name = 'ABC-ETB-';
			$next_id = 01;
			$inv_no = $name . $next_id;
		}

		$master_data = array
		(
			'invoice_no' => $inv_no,
			'event_id' => $this->session->eventID,
			'member_booking_id' => $this->session->mds_ses_id,
			'subtotalTicketPrice' => $this->session->eventTotalwithoutDiscountPrice,
			'discountPercentage' => $this->session->eventTotalDiscountPercenatge,
			'discountPrice' => $this->session->eventTotalDiscountPrice,
			'totalTicketPrice' => $this->session->eventTotalPrice,
			'totalSeats' => $this->session->eventTotalTickets,
			'reference_seats' => $this->session->seatsRef,
			'reference_seats_original' => $this->session->seats,
			'transaction_id' => $dataTransaction['payment_id'],
			'payment_method' => $dataTransaction['payment_method'],
            'payment_status' => $dataTransaction['payment_status'],
			'payment_amount' => $dataTransaction['payment_amount'],
		);
		
		$this->db->transStart();
		
		$db      = \Config\Database::connect();
		
		$this->builderTicketMaster->insert($master_data);
		$ticket_id = $db->insertID();
		helperSetSession('mds_membership_transaction_insert_id', $ticket_id);
			
		$seatsTotal =$this->session->seats;
		
		$data = [];
		if(isset($seatsTotal) && is_array($seatsTotal))
		{
			foreach ($seatsTotal as $seatsArray) 
			{
				$decodedSeats = json_decode($seatsArray, true); // Decode the JSON-encoded seat array
				if ($decodedSeats) 
				{
					foreach ($decodedSeats as $seat) 
					{
						$data[] = 
						[
							'ticket_id' => $ticket_id, 
							'seat_booking_numbers' => $seat, 
							'booking_member_id ' => $this->session->mds_ses_id,
							'event_total_tickets ' => $this->session->eventTotalTickets,
							'eventTotalPrice ' => $this->session->eventTotalPrice,
							'eventTotalwithoutDiscountPrice ' => $this->session->eventTotalwithoutDiscountPrice,
							'eventTotalDiscountPrice ' => $this->session->eventTotalDiscountPrice,
							'eventTotalDiscountPercenatge ' => $this->session->eventTotalDiscountPercenatge,
							'adultPricetotal ' => $this->session->adultPricetotal,
							'childPricetotal ' => $this->session->childPricetotal,
							'totalAdults ' => $this->session->totalAdults,
							'totalChilds ' => $this->session->totalChilds,
							'reference_seats ' => $this->session->seatsRef,	
							'reference_seats_original ' => $this->session->seats,	
						];
					}
				}
			}
		}
		

		//echo "<pre>";print_r($data);die;
		
		foreach ($data as $row) 
		{
			$seatNumber = $row['seat_booking_numbers'];
			
			$this->builderTicket->where('booking_member_id', NULL);
			$this->builderTicket->where('vip_seats', 0);
			$this->builderTicket->where('eventTotalPrice',NULL);
			$this->builderTicket->where('seat_number', $seatNumber);
			$this->builderTicket->where('event_id', $this->session->eventID);
			$this->builderTicket->update($row);
		}
		
		$data =  ['total_seats' => $this->session->totalAvailableSeats];
        $this->builder->where('id', $this->session->eventID)->update($data);
		/*
		
		$emailData = 
		[
                'email_type' => 'activation',
                'email_address' => 'samadsami1125@gmail.com',
                'email_data' => serialize([
                    'content' => trans("msg_confirmation_email"),
                    'buttonText' => trans("confirm_your_account")
                ]),
                'email_priority' => 1,
                'email_subject' => trans("confirm_your_account"),
                'template_path' => 'email/main'
        ];
		
        addToEmailQueue($emailData);
		
		*/
		
		$this->db->transComplete();
		return $this->db->transStatus();
	}
	
	public function getTransactionTicket($id)
    {
        return $this->builderTicketMaster->where('ticket_id', clrNum($id))->get()->getRow();
    }
	
	public function getSeatMap($event_id)
	{
		return $this->builderTicketSeats->where('event_id',$event_id)
		                                ->get()->getResultArray();
	}
	
	public function updateHoldTickets($data)
	{
		$visible = inputpost('visibility');
		$event_id = inputpost('eventID');
		$updateVip = inputpost('updateHoldTicket');
		$releaseVip = inputpost('releaseHoldTicket');
		
		$this->db->transStart(); // Start the transaction
		
		if($updateVip == 1)
		{
			if (isset($data) && is_array($data)) 
			{
				foreach ($data as $key) 
				{
					$actualSeat = '';
					$seatNumber = $key['seat_number'];
					$actualSeat = substr($seatNumber, 1);

					$this->builderTicket->where('event_id', $event_id);
					$this->builderTicket->orderBy('id', 'ASC');
					$this->builderTicket->like('seat_number', $actualSeat);
					$this->builderTicket->limit('1');
					$query = $this->builderTicket->get()->getRow();

					if ($query !== null) 
					{
						$event_rows = $query->id;
						$this->builderTicket->where('event_id', $event_id)
							->where('id', $event_rows)
							->update($key);
					}
				}
			}

		}
		else if($releaseVip == 1)
		{
			if (isset($data) && is_array($data)) 
			{
				foreach ($data as $key) 
				{
					$actualSeat = '';
					$seatNumber = $key['seat_number'];
					$actualSeat = substr($seatNumber, 1);
					if (!empty($actualSeat)) {
						
						$actualSeat = "V" . $actualSeat[0] . substr($actualSeat, 1); 
					}
					
					$this->builderTicket->where('event_id', $event_id);
					$this->builderTicket->orderBy('id', 'ASC');
					$this->builderTicket->like('seat_number', $actualSeat);
					$this->builderTicket->limit('1');
					$query = $this->builderTicket->get()->getRow();
					
					$key['vip_seats'] = 0;
					$key['seat_booking_numbers'] = NULL;
					
					if ($query !== null) 
					{
						$event_rows = $query->id;
						$this->builderTicket->where('event_id', $event_id)
							->where('id', $event_rows)
							->update($key);
					}
				}
			}
		}
		else
		{
			if(isset($data) && is_array($data))
			{
				foreach($data as $key)
				{
					$this->builderTicket->where('member_id', NULL); 
					$this->builderTicket->where('seat_number', NULL); 
					$this->builderTicket->where('event_id', $event_id); 
					$this->builderTicket->orderBy('id', 'ASC'); 
					$this->builderTicket->limit('1');
					$query = $this->builderTicket->get()->getRow();

					if($query != '')
					{
						$event_rows = $query->id;
						$this->builderTicket->where('event_id',$event_id)
											->where('id', $event_rows)
											->update($key);
					}
				}
			}
		}

		$this->db->transComplete();
		$data_updated = $this->db->transStatus();
		
		if($data_updated)
		{
			$data =  ['visible' => $visible ];
            return $this->builder->where('id', $event_id)->update($data);
		}
		else
		{
			return false;
		}
	}
	
	public function getBookedTicketDataResendEmail($id,$member_booking_id)
	{
		$data = $this->builderTicketMaster->select('invoice_no,subtotalTicketPrice,discountPercentage,discountPrice,totalTicketPrice,totalSeats,reference_seats,booking_date,transaction_id,event_name,event_date,event_start_time,event_end_time,event_location,first_name,last_name,email,phone_number,username,payment_method,payment_status')
				->join('ticket_details_event','ticket_details_event.id =ticket_booking_master.event_id')
				->join('users','users.id =ticket_booking_master.member_booking_id')
				->where('member_booking_id',$member_booking_id)
				->where('ticket_id',$id)
				->get()->getResultArray();
		
		return $data;
	}
	
	public function getBookedTicketData($id)
	{
		$data = $this->builderTicketMaster->select('invoice_no,subtotalTicketPrice,discountPercentage,discountPrice,totalTicketPrice,totalSeats,reference_seats,booking_date,transaction_id,event_name,event_date,event_start_time,event_end_time,event_location,first_name,last_name,email,phone_number,username,payment_method,payment_status,member_booking_id')
				->join('ticket_details_event','ticket_details_event.id =ticket_booking_master.event_id')
				->join('users','users.id =ticket_booking_master.member_booking_id')
				->where('member_booking_id',$this->session->mds_ses_id)
				->where('ticket_id',$id)
				->get()->getResultArray();
		
		return $data;
	}
	
	public function getBookedTicketDataTrans($id,$data_mem_id)
	{
		$data = $this->builderTicketMaster->select('invoice_no,subtotalTicketPrice,discountPercentage,discountPrice,totalTicketPrice,totalSeats,reference_seats,booking_date,transaction_id,event_name,event_date,event_start_time,event_end_time,event_location,first_name,last_name,email,phone_number,username,payment_method,payment_status')
				->join('ticket_details_event','ticket_details_event.id =ticket_booking_master.event_id')
				->join('users','users.id =ticket_booking_master.member_booking_id')
				->where('member_booking_id',$data_mem_id)
				->where('transaction_id',$id)
				->get()->getResultArray();
		
		return $data;
	}
	
	public function getBookedTicketDataEpayment($id,$mem_id)
	{
		$data = $this->builderTicketMaster->select('invoice_no,subtotalTicketPrice,discountPercentage,discountPrice,totalTicketPrice,totalSeats,reference_seats,booking_date,transaction_id,event_name,event_date,event_start_time,event_end_time,event_location,first_name,last_name,email,phone_number,username,payment_method,payment_status,member_booking_id')
				->join('ticket_details_event','ticket_details_event.id =ticket_booking_master.event_id')
				->join('users','users.id =ticket_booking_master.member_booking_id')
				->where('member_booking_id',$mem_id)
				->where('ticket_id',$id)
				->get()->getResultArray();
		
		return $data;
	}
	
	public function getTicketReport($eventID)
	{
		$data = $this->builderTicketMaster->select('invoice_no,subtotalTicketPrice,discountPercentage,discountPrice,totalTicketPrice,totalSeats,reference_seats,booking_date,transaction_id,username,email,phone_number')
				->join('users','users.id =ticket_booking_master.member_booking_id')
				->where('event_id',$eventID)
				->orderBy('invoice_no','asc')
				->get()->getResultArray();
		
		return $data;
	}
	
	public function getTicketReportAttendees($eventID)
	{
		$data = $this->builderTicketMaster->select('invoice_no,totalTicketPrice,totalSeats,reference_seats,booking_date,transaction_id,username,email,phone_number,checkIn')
				->join('users','users.id =ticket_booking_master.member_booking_id')
				->where('event_id',$eventID)
				->where('present',1)
				->orderBy('invoice_no','asc')
				->get()->getResultArray();
		
		return $data;
	}

	public function getTicketReportTotal($eventID)
	{
		$data = $this->builderTicketMaster->select('sum(subtotalTicketPrice) as sub_total_value, sum(discountPrice) as discount_total_value, sum(totalTicketPrice) as total_value, sum(totalSeats) as total_seats_value')
				->where('event_id',$eventID)
				->get()->getResultArray();
		
		return $data;
	}
	
	public function getMemberInvoice()
	{
		$data = $this->builderTicketMaster->select('invoice_no,totalTicketPrice,booking_date,transaction_id,event_name,event_date,event_location,ticket_id,payment_method, payment_status')
				->join('ticket_details_event','ticket_details_event.id =ticket_booking_master.event_id')
				->join('users','users.id =ticket_booking_master.member_booking_id')
				->where('member_booking_id',$this->session->mds_ses_id)
				->orderBy('ticket_id','desc')
				->get()->getResultArray();
		
		return $data;
	}
	
	public function getMemberInvoiceEventTicket($ticket_id)
	{
		$data = $this->builderTicketMaster->select('invoice_no,subtotalTicketPrice,discountPercentage,discountPrice,totalTicketPrice,totalSeats,reference_seats,booking_date,transaction_id,event_name,event_date,event_start_time,event_end_time,event_location,username,email,phone_number,payment_method, payment_status')
				->join('ticket_details_event','ticket_details_event.id =ticket_booking_master.event_id')
				->join('users','users.id =ticket_booking_master.member_booking_id')
				->where('ticket_id',$ticket_id)
				->get()->getResultArray();
		
		return $data;
	}
	
	public function tempticketdata($event_id_data,$member_id_data)
	{
		$ticketData = $this->getTicket($event_id_data);
		$timelimit = $ticketData->bookinglimit;
		$start_time = time();
		$end_time = $start_time + ($timelimit * 60);
		$data =array(
			'event_id' =>$event_id_data, 
			'member_id' =>$member_id_data, 
			'start_time' =>$start_time, 
			'end_time' =>$end_time, 
		);
		$getDataAvailable = $this->builderTicketTemp->where('event_id',$event_id_data)->where('member_id',$member_id_data)->get()->getResult();
		
		if(count($getDataAvailable) > 0)
		{
			$this->builderTicketTemp->where('event_id',$event_id_data)->where('member_id',$member_id_data)->delete();
		}
		return $this->builderTicketTemp->insert($data);
	}
	
	public function getTempticketdata($event_id_data,$member_id_data)
	{
		$data = $this->builderTicketTemp->where('event_id',$event_id_data)->where('member_id',$member_id_data)->orderBy('id','DESC')->get()->getRow();
		return $data; 
	}
	
	public function getTableNameDefineTable($search_value)
	{
		return $this->builderTicketTableNames->where('row_value',$search_value)->get()->getRow();
	}

	public function updateTableNameDefineTable($update_value,$update_table_name)
	{
		$data = array ('table_name' => $update_table_name);
		return $this->builderTicketTableNames->where('row_value',$update_value)->update($data);
	}
	
	public function updateSeatReservedData($seatID)
	{
		$data = $this->builderTicketTemp->where('event_id',$this->session->eventID_temp_ticket)
										->where('member_id',$this->session->memberID_temp_ticket)
										->get()->getRow();
										
		$newSeatData = $seatID;

		if ($data) {
			
			$existingSeatData = $data->seats;
			
			if ($existingSeatData !== null && $existingSeatData !== '') {
				$updatedSeatData = $existingSeatData . ', ' . $newSeatData;
			} else {
				$updatedSeatData = $newSeatData;
			}
			
			return $this->builderTicketTemp->where('event_id', $this->session->eventID_temp_ticket)
				->where('member_id', $this->session->memberID_temp_ticket)
				->update(['seats' => $updatedSeatData]);
		}
	}

	public function updateSeatReservedDataRemove($seatID)
	{
		$data = $this->builderTicketTemp->where('event_id', $this->session->eventID_temp_ticket)
										->where('member_id', $this->session->memberID_temp_ticket)
										->get()->getRow();

		if ($data) {
			$existingSeatData = $data->seats;

			if ($existingSeatData !== null) {
				$seatArray = explode(', ', $existingSeatData); 
				$index = array_search($seatID, $seatArray); 

				if ($index !== false) {
					unset($seatArray[$index]);
					$updatedSeatData = implode(', ', $seatArray); 

					return $this->builderTicketTemp->where('event_id', $this->session->eventID_temp_ticket)
						->where('member_id', $this->session->memberID_temp_ticket)
						->update(['seats' => $updatedSeatData]);
				}
			}
		}
	}	
	
	public function get_seats_reserved($event_id)
	{
		$data = $this->builderTicketTemp->where('event_id', $event_id)->get()->getResult();
		if(!empty($data))
		{
			$currentTimestamp = time();
			$gracePeriod = 40;

			$newTimestamp = $currentTimestamp + $gracePeriod;

			foreach ($data as $item) {
			
				$endTime = (int)$item->end_time;
				
				if ($endTime <= $newTimestamp) {
					$this->builderTicketTemp->where('id',$item->id)->delete();
				}
			}

		}
		return $this->builderTicketTemp->where('event_id',$event_id)
								->where('member_id !=',user()->id)
								->get()->getResult();
	}
	
	public function tempticketdataDeleted()
	{
		$success =  $this->builderTicketTemp->where('event_id',$this->session->eventID_temp_ticket)
											->where('member_id',$this->session->memberID_temp_ticket)
											->delete();
		if($success)
		{
			$this->session->remove('eventID_temp_ticket');
			$this->session->remove('memberID_temp_ticket');
			$this->session->remove('end_time_booking');
			$this->session->remove('id_booking_temp');
			return true;
		}
	}

	public function addCharity()
	{
		$uploadModel = new UploadModel();
        $charityImage = $uploadModel->uploadCharityImage('charityImage');
		$data = array (
			'charityName' => inputPost('charityName'),
			'charityNote' => inputPost('charityNote'),
			'e_payment_link' => inputPost('e_payment_link'),
			'paypalFees' => inputPost('paypalFees'),
			'member_id' => user()->id,
		);
		
		 if (!empty($charityImage) && !empty($charityImage['path'])) 
		{
            $data['charity_image'] = $charityImage['path'];
        }
		
		return $this->builderCharityManager->insert($data);
	}
	
	public function editCharity()
	{
		$id = inputPost('id');
		$uploadModel = new UploadModel();
        $charityImage = $uploadModel->uploadCharityImage('charityImage');
		$data = array (
			'charityName' => inputPost('charityName'),
			'charityNote' => inputPost('charityNote'),
			'e_payment_link' => inputPost('e_payment_link'),
			'paypalFees' => inputPost('paypalFees'),
			'status' => inputPost('status'),
			'member_id' => user()->id,
		);
		
		 if (!empty($charityImage) && !empty($charityImage['path'])) 
		{
            $data['charity_image'] = $charityImage['path'];
        }
		
		return $this->builderCharityManager->where('id',$id)->update($data);
	}
	
	public function getCharityList()
	{
		return $this->builderCharityManager->get()->getResult();
	}
	
	public function getCharityListDetail($id)
	{
		return $this->builderCharityManager->where('id',$id)->get()->getRow();
	}
	
	public function getCharityListVisible()
	{
		return $this->builderCharityManager->where('status',1)->get()->getResult();
	}
	
	public function addCharitySubmitData()
	{
		$amount = inputPost('amount');
		$fees = inputPost('feesPercent');
		
		if ($amount >= 0 && $fees >= 0) 
		{
			$feeAmount = ($fees / 100) * $amount;

			$finalTotal = $amount + $feeAmount;
		} 
		
		$data = array (
			'charity_id' => inputPost('charityID'),
			'name' => inputPost('username'),
			'email' => inputPost('email'),
			'phone' => inputPost('phone'),
			'note' => inputPost('note'),
			'amount' => $finalTotal,
		);
		
		if ($this->builderCharitySubmitForm->insert($data)) {
            helperSetSession('mds_insert_form_id', $this->db->insertID());
			return true;
        }
		
	}
	
	public function getcharityData($id)
	{
		return $this->builderCharityManager->where('id',$id)->get()->getRow();
	}
	
	public function addCharityTransactionUsers($dataTransaction)
    {
		$charityID_form = helperGetSession('mds_insert_form_id');
		$data_charity_name = $this->builderCharityManager->where('id',$this->session->charityID)->get()->getRow()->charityName;
		$data_charity_user = $this->builderCharitySubmitForm->where('id',$charityID_form)->get()->getRow();
		
        $data = [
            'payment_method' => $dataTransaction['payment_method'],
            'transaction_id' => $dataTransaction['payment_id'],
            'member_id' => user()->id,
            'charityName' => $data_charity_name,
            'name' => $data_charity_user->name,
            'phone' => $data_charity_user->phone,
            'email' => $data_charity_user->email,
            'charity_id' => $this->session->charityID,
            'charity_amount' => $this->session->charitySubAmount,
            'paypal_charges' => $this->session->charityPaypalAmount,
            'payment_amount' => $dataTransaction['payment_amount'],
            'currency' => $dataTransaction['currency'],
            'payment_status' => $dataTransaction['payment_status'],
            'payment_date' => date('Y-m-d H:i:s')
        ];
       
        if ($this->builderCharityPayment->insert($data)) {
            helperSetSession('mds_membership_transaction_insert_id', $this->db->insertID());
        }
    }
	
	public function getcharityTransactionUsers($id)
	{
		return $this->builderCharityPayment->select('name,email,phone, payment_method, payment_status, transaction_id, charityName,member_id,id,payment_date,currency,payment_amount,charity_amount,paypal_charges')
					->where('charity_payment.id',$id)
					->get()
					->getRow();
	}
	
	public function getcharityTransaction($id)
	{
		return $this->builderCharityPayment->where('id',$id)->get()->getRow();
	}
	
	public function getCharityListTransactions()
	{
		return $this->builderCharityPayment->select('name,email,phone, payment_method, payment_status, transaction_id, charityName,member_id,id,payment_date,currency,payment_amount')
					->get()
					->getResult();
	}
	
	public function getCharityListDetailReport($id)
	{
		return $this->builderCharitySubmitForm->where('charity_id',$id)->get()->getResult();
	}
	
	public function updateEpaymentBooking()
	{
		$this->db->transStart();
		$seatsTotal =$this->session->seats;
		
		$data = [];
		if(isset($seatsTotal) && is_array($seatsTotal))
		{
			foreach ($seatsTotal as $seatsArray) 
			{
				$randomNumber = rand(100000, 999999);
				$decodedSeats = json_decode($seatsArray, true); // Decode the JSON-encoded seat array
				if ($decodedSeats) 
				{
					foreach ($decodedSeats as $seat) 
					{
						$data[] = 
						[
							'ticket_id' => -1, 
							'seat_booking_numbers' => $seat, 
							'booking_member_id ' => $this->session->mds_ses_id,
							'event_total_tickets ' => $this->session->eventTotalTickets,
							'eventTotalPrice ' => $this->session->eventTotalPrice,
							'eventTotalwithoutDiscountPrice ' => $this->session->eventTotalwithoutDiscountPrice,
							'eventTotalDiscountPrice ' => $this->session->eventTotalDiscountPrice,
							'eventTotalDiscountPercenatge ' => $this->session->eventTotalDiscountPercenatge,
							'adultPricetotal ' => $this->session->adultPricetotal,
							'childPricetotal ' => $this->session->childPricetotal,
							'totalAdults ' => $this->session->totalAdults,
							'totalChilds ' => $this->session->totalChilds,
							'reference_seats ' => $this->session->seatsRef,	
							'reference_seats_original ' => $this->session->seats,
							'is_epayment ' => 1,
							'random_ref_no' => $randomNumber,
						];
					}
				}
			}
		}
		
		foreach ($data as $row) 
		{
			$seatNumber = $row['seat_booking_numbers'];
			
			$this->builderTicket->where('booking_member_id', NULL);
			$this->builderTicket->where('vip_seats', 0);
			$this->builderTicket->where('eventTotalPrice',NULL);
			$this->builderTicket->where('seat_number', $seatNumber);
			$this->builderTicket->where('event_id', $this->session->eventID);
			$this->builderTicket->update($row);
		}
		
		$data =  ['total_seats' => $this->session->totalAvailableSeats];
        $this->builder->where('id', $this->session->eventID)->update($data);
		
		$this->db->transComplete();
		return $this->db->transStatus();
	}
	
	public function getTicketEpaymentReport($eventID)
	{
		$data = $this->builderTicket->select('booking_member_id,eventTotalPrice,event_total_tickets,reference_seats,reference_seats_original,ticket_booking_date,is_epayment,username,email,phone_number,random_ref_no')
				->join('users','users.id = ticket_book_details.booking_member_id')
				->where('event_id',$eventID)
				->where('is_epayment',1)
				->get()->getResult();
		
		return $data;
	}
	
	public function getTicketEpaymentData($id)
	{
		$data = $this->builderTicket->select('users.id as member_id,event_id,booking_member_id,username,username,email,phone_number,random_ref_no,event_total_tickets,eventTotalPrice,eventTotalwithoutDiscountPrice,eventTotalDiscountPrice,eventTotalDiscountPercenatge,reference_seats,reference_seats_original')
				->join('users','users.id = ticket_book_details.booking_member_id')
				->where('random_ref_no',$id)
				->where('is_epayment',1)
				->get()->getResult();
				
		return $data;
	}
	
	public function updateEpaymentMasterTicket()
	{
		$this->builderTicketMaster->orderBy('ticket_id','desc');
		$this->builderTicketMaster->limit(1);
		$query = $this->builderTicketMaster->get()->getResult();
		
		if(count($query) > 0)
		{
			$user = $query; 

			$parts = explode("-", $user[0]->invoice_no);
			$numericPart = (int) end($parts); 

			$newNumericPart = $numericPart + 1;

			$numericPartLength = strlen($numericPart); 
			$newNumericPartPadded = str_pad($newNumericPart, $numericPartLength, '0', STR_PAD_LEFT);

			$inv_no = $parts[0] . "-" . $parts[1] . "-" . $newNumericPartPadded;
		}
		else
		{
			$name = 'ABC-ETB-';
			$next_id = 01;
			$inv_no = $name . $next_id;
		}
		
		$event_id = inputPost('event_id');
		$totalSeats = inputPost('totalSeats');
		$tableNumbers = inputPost('tableNumbers');
		$paymentMethod = inputPost('paymentMethod');
		$paymentStatus = inputPost('paymentStatus');
		$transId = inputPost('transId');
		$totalRec = inputPost('totalRec');
		$random_ref_no = inputPost('random_ref_no');
		$eventTotalPrice = inputPost('eventTotalPrice');
		$eventTotalwithoutDiscountPrice = inputPost('eventTotalwithoutDiscountPrice');
		$eventTotalDiscountPrice = inputPost('eventTotalDiscountPrice');
		$eventTotalDiscountPercenatge = inputPost('eventTotalDiscountPercenatge');
		$reference_seats_original = inputPost('reference_seats_original');
		$member_id = inputPost('member_id');
		
		$master_data = array
		(
			'invoice_no' => $inv_no,
			'event_id' => $event_id,
			'member_booking_id' => $member_id,
			'subtotalTicketPrice' => number_format((float)$eventTotalwithoutDiscountPrice, 2, '.', ''),
			'discountPercentage' => $eventTotalDiscountPercenatge,
			'discountPrice' => number_format((float)$eventTotalDiscountPrice, 2, '.', ''),
			'totalTicketPrice' => number_format((float)$eventTotalPrice, 2, '.', ''),
			'totalSeats' => $totalSeats,
			'reference_seats' => $tableNumbers,
			'reference_seats_original' => $reference_seats_original,
			'transaction_id' => $transId,
			'payment_method' => $paymentMethod,
            'payment_status' => $paymentStatus,
			'payment_amount' => number_format((float)$totalRec, 2, '.', ''),
		);
		//echo "<pre>";print_r($master_data);die;
		
		$db      = \Config\Database::connect();
		
		$this->builderTicketMaster->insert($master_data);
		$ticket_id = $db->insertID();
		helperSetSession('mds_transaction_insert_id', $ticket_id);
		//echo $ticket_id;die;
		if($ticket_id > 0)
		{
			$data = array('is_epayment' => 0 , 'ticket_id' => $ticket_id);
			$this->builderTicket->where('event_id',$event_id)->where('random_ref_no',$random_ref_no)->update($data);
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function getUserData($id)
	{
		return $this->builderUsers->where('id',$id)->get()->getRow();
	}
	
	public function rejectEpaymentApproval($random_ref_no)
	{
		if(!empty($random_ref_no))
		{
			$refSeats = $this->builderTicket->where('random_ref_no',$random_ref_no)->limit(1)->get()->getRow();
			//print_r($refSeats);
			$event_id = $refSeats->event_id;
			$increase = $refSeats->event_total_tickets;
			
			$member_id = $refSeats->booking_member_id;
			
			$member = $this->getUserData($member_id);
			
			$emailData = 
			[
					'email_type' => 'activation',
					'email_address' => $member->email,
					'email_data' => serialize([
						'content' => 'Name : '.$member->username,
						'content_1' => 'Phone : '.$member->phone_number,
						'content_2' => 'Payment Method : E-transfer Payment',
						'content_3' => 'Status : Failed',
						'content_4' => 'We regret to inform you that we have not received payment for your tickets, and as a result, your reservation has been canceled.',
					]),
					'email_priority' => 1,
					'email_subject' => 'Ticket Order Canceled',
					'template_path' => 'email/rsvp_payment'
			];
			
			addToEmailQueue($emailData);
			
			$data = array 
			(
				'is_epayment' => -1,
				'reference_seats' => NULL,
				'reference_seats_original' => NULL,
				'seat_booking_numbers' => NULL,
				'booking_member_id' => NULL,
				'event_total_tickets' => NULL,
				'eventTotalPrice' => NULL,
				'eventTotalwithoutDiscountPrice' => NULL,
				'eventTotalDiscountPrice' => NULL,
				'eventTotalDiscountPercenatge' => NULL,
				'adultPricetotal' => NULL,
				'childPricetotal' => NULL,
				'totalAdults' => NULL,
				'totalChilds' => NULL,
			);
			
			$success = $this->builderTicket->where('event_id',$event_id)->where('random_ref_no',$random_ref_no)->update($data);
			
			if($success)
			{
				$ticket = $this->builder->where('id',$event_id)->get()->getRow();
				$valueUpdate = $ticket->total_seats;
				
				$totalSeat = $valueUpdate + $increase;
				
				$totalSeat = $valueUpdate + $increase;

				$updateData = array('total_seats' => $totalSeat);
				return $this->builder->where('id', $event_id)->update($updateData);

			}
			else
			{
				return false;
			}
		}
	}
	
	public function updateMemberCheckInTime($invoice,$time)
	{ 
		$data = array(
			'checkIn' => $time,
			'present' => 1,
		);
		return $this->builderTicketMaster->where('invoice_no',$invoice)->update($data);
	}
	
	public function existsupdateMemberCheckInTime($invoice,$time)
	{
		$queryExists = $this->builderTicketMaster->where('invoice_no',$invoice)->where('present',1)->get()->getRow(); 
		
		if($queryExists)
		{
			return $queryExists;
		}
		else
		{
			return null;
		}
	}
	
	public function getTimeZone()
	{
		$data = $this->builderGeneralSettings->where('id',1)->get()->getRow();
		return $data->timezone;
	}
	
	public function getTotalSeatCountAvailable($id)
	{
		return $this->builderTicket->where('event_id',$id)->where('booking_member_id',NULL)->where('vip_seats',0)->countAllResults();
	}
	 
	public function getTicketBookingEmailData($eventID)
	{
		return $this->builderTicketMaster->select('event_id, member_booking_id, username, email, phone_number, ticket_id, totalSeats, reference_seats, totalTicketPrice, booking_date')
										->where('event_id',$eventID)
										->join('users','ticket_booking_master.member_booking_id = users.id')
										->get()->getResult();
	}
}
?>
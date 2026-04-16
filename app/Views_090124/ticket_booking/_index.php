<?php 
use App\Models\TicketModel;
$ticketModel;
$this->ticketModel = new TicketModel();
?>
<div class="container">
	<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8 col-sm-12">
				<div class="title">
					<h1 class="picture_gallery_h1"><?= trans("upcoming_event_booking"); ?></h1>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
    <div class="row">
        <?php 
		$ticketsFound = false;
		
		if(!empty($tickets))
		{ 
		foreach ($tickets as $item): 
		//echo "<pre>";print_r($item);echo"</pre>";
		$currentDate = date('Y-m-d');
		
		$timezone = new DateTimeZone(esc($generalSettings->timezone)); 
		$currentDateTime = new DateTime('now', $timezone);
		$currentTime = $currentDateTime->format('H:i:s');
		$currentTime = date('H:i:s');

		$mergedatetime =  new DateTime($currentDate . ' ' . $currentTime);

		$ticketShowDate = new DateTime($item->ticketShowDate);
		$ticketHideDate = new DateTime($item->ticketHideDate);
		
		$ticketStartTime = $item->ticketDisplayTime;
		$mergedatetime2 =  new DateTime($item->ticketShowDate . ' ' . $ticketStartTime);

		if($item->visible == 1)
		{
			if ($currentDate >= $ticketShowDate->format('Y-m-d') && $currentDate <= $ticketHideDate->format('Y-m-d')) 
			{
				if ($mergedatetime >= $mergedatetime2) 
				{
		?>
				<?php $ticketsFound = true;?>
				<div class="col-12 col-sm-8 col-md-4 col-lg-4">
					<div class="card ticket top-height">
						<img class="card-img custom-size" src="<?= base_url().'/'.$item->event_image; ?>" alt="Event">
						<div class="card-img-overlay d-flex justify-content-end"></div>
						<div class="card-body">
							<h4 class="card-title title_head"><?php echo $item->event_name; ?></h4>
							<div class="row">
								<div class="col-6">
									<p class="card-text"><i class="fa fa-calendar"></i>&nbsp;<?php echo $item->event_date;?></p>
								</div>
								<div class="col-6 text-right">
									<p class="card-text"><i class="fa fa-map-marker"></i>&nbsp;<?php echo $item->event_location;?></p>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-6">
									<p class="card-text"><i class="fa fa-hourglass-1"></i>&nbsp;<?php echo $item->event_start_time;?></p>
								</div>
								<div class="col-6 text-right">
									<p class="card-text"><i class="fa fa-hourglass-end"></i>&nbsp;<?php echo $item->event_end_time;?></p>
								</div>
							</div>
							
							<br>
							<div class="seperator_line"></div>
								<p class="text-align-center"><?= trans('price_details'); ?></p>
							<div class="row">
								<div class="col-6">
									<p class="head_price_p"><?= trans('gold_ticket_price'); ?></p>
									<p class="price text-success"><?= trans('member_ticket'); ?>:&nbsp;<?= $defaultCurrency->symbol; ?><?php echo getPrice($item->g_mem_tp, 'decimal');?></p> 
									<p class="price text-success"><?= trans('non_member_ticket'); ?>:&nbsp;<?= $defaultCurrency->symbol; ?><?php echo getPrice($item->g_non_mem_tp, 'decimal');?></p>
									<p class="price text-success"><?= trans('child_ticket'); ?>:&nbsp;<?= $defaultCurrency->symbol; ?><?php echo getPrice($item->g_child_tp, 'decimal');?></p>
								</div>
								<div class="col-6 text-right">
									<p class="head_price_p"><?= trans('silver_ticket_price'); ?></p>
									<p class="price text-success"><?= trans('member_ticket'); ?>:&nbsp;<?= $defaultCurrency->symbol; ?><?php echo getPrice($item->s_mem_tp, 'decimal');?></p>
									<p class="price text-success"><?= trans('non_member_ticket'); ?>:&nbsp;<?= $defaultCurrency->symbol; ?><?php echo getPrice($item->s_non_mem_tp, 'decimal');?></p>
									<p class="price text-success"><?= trans('child_ticket'); ?>:&nbsp;<?= $defaultCurrency->symbol; ?><?php echo getPrice($item->s_child_tp, 'decimal');?></p>
								</div>
							</div>
							<div class="seperator_line"></div>
							<?php 
								$dataTicketAvailable = $this->ticketModel->getTotalSeatCountAvailable($item->id);
							?>
							<div class="buy d-flex justify-content-between align-items-center">
								<div class="price text-success"><p class="mt-4"><?= trans('n_a'); ?>:&nbsp;<?= $dataTicketAvailable; ?>&nbsp;<?= trans('tickets'); ?></p></div>
								<div class="btn-group">
									  <a href="<?= adminUrl('edit-ticket-seats/' . $item->id); ?>" class="btn btn-md btn-danger btn-radius mt-3"><i class="fa fa-ticket"></i>&nbsp;<?= trans('book_now'); ?></a>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			<?php 	}
			}
			else 
			{?>
				<?php $ticketsFound = true;?>
				<div class="col-12 col-sm-8 col-md-4 col-lg-4">
					<div class="card ticket top-height">
						<img class="card-img custom-size" src="<?= base_url().'/'.$item->event_image; ?>" alt="Event">
						<div class="card-img-overlay d-flex justify-content-end"></div>
						<div class="card-body">
							<h4 class="card-title title_head"><?php echo $item->event_name; ?></h4>
							<div class="row">
								<div class="col-6">
									<p class="card-text"><i class="fa fa-calendar"></i>&nbsp;<?php echo $item->event_date;?></p>
								</div>
								<div class="col-6 text-right">
									<p class="card-text"><i class="fa fa-map-marker"></i>&nbsp;<?php echo $item->event_location;?></p>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-6">
									<p class="card-text"><i class="fa fa-hourglass-1"></i>&nbsp;<?php echo $item->event_start_time;?></p>
								</div>
								<div class="col-6 text-right">
									<p class="card-text"><i class="fa fa-hourglass-end"></i>&nbsp;<?php echo $item->event_end_time;?></p>
								</div>
							</div>
							<br>
							<div class="seperator_line"></div>
								<p class="text-align-center"><?= trans('tickets_unavailable'); ?></p>
						<img class="card-img custom-size shaking-image" src="<?= base_url('assets/images_agarwal/sorry_closed.png'); ?>" alt="Closed">
						<div class="card-img-overlay d-flex justify-content-end"></div>
						</div>
					</div>
				</div>				
		<?php 
			}
		}
		endforeach; 
		}
		?>
		<?php if (!$ticketsFound){ ?>
		<div class="container">
			<div class="over_container">
				<div class="col-md-12 mb-3 col-sm-12" style="text-align:center;">
					<img src = "<?= base_url('assets/images_agarwal/coming-soon.png'); ?>" class="img-fluid" style="height : 60vh;">
				</div>
			</div>
		</div>
		<?php }?>
    </div>
</div>
<?php 
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
helperDeleteSession('seatsRef'); 
helperDeleteSession('eventID_temp_ticket'); 
helperDeleteSession('memberID_temp_ticket'); 
helperDeleteSession('end_time_booking'); 
helperDeleteSession('id_booking_temp'); 
helperDeleteSession('is_epayment'); 
helperDeleteSession('is_paypal'); 
?>
<style>
	.shaking-image 
	{
    bottom: 0;
    animation: shakeImage 4s ease-in-out infinite;
  }

   @keyframes shakeImage {
    0%, 100% {
      transform: translateY(0);
    }
    25% {
      transform: translateY(-2px);
    }
    50% {
      transform: translateY(2px);
    }
    75% {
      transform: translateY(-2px);
    }
  }
	.seperator_line
	{
		border : 1px solid #ccc;
	}
  .ticket 
	{
    border-radius: 10px; /* Adjust the value to control the roundness of the corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Adjust the shadow properties as needed */
    overflow: hidden; /* Ensure content within the card stays within the rounded corners */
	margin : 20px;
	border : 2px solid #d1274b;
  }

  .card-img 
  {
	height: 200px; /* Replace with your desired height */
  display: block;
  margin: 0 auto; /* To horizontally center the images if needed */
  object-fit: cover; /* To maintain aspect ratio without cropping */

  }
  
  .card-img.custom-size {
  height: 200px; /* Replace with your desired height */
  object-fit: cover; /* To maintain aspect ratio without cropping */
}
  
  .card-text
  {
	  color : #CB0162;
  }
  
  .price 
  {
	font-weight: 1000;
  }
  
  .title_head
  {
	text-align: center;
	font-weight: bold;
	color: #d1274b;
  }
  
  .text-align-center
  {
	  text-align : center;
	  font-weight: bold;
  }
  
  .head_price_p
  {
	font-weight: bold;
	color: red;
  }
  
  .btn-danger
{
    background: #e81216;
    background: -moz-linear-gradient(-45deg, #e81216 0%, #f45355 50%, #f6290c 51%, #ed0e11 71%, #fc1b21 100%);
    background: -webkit-linear-gradient(-45deg, #e81216 0%,#f45355 50%,#f6290c 51%,#ed0e11 71%,#fc1b21 100%);
    background: linear-gradient(135deg, #e81216 0%,#f45355 50%,#f6290c 51%,#ed0e11 71%,#fc1b21 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e81216', endColorstr='#fc1b21',GradientType=1 );
    background-size: 400% 400%;
    -webkit-animation: AnimationName 3s ease infinite;
    -moz-animation: AnimationName 3s ease infinite;
    animation: AnimationName 3s ease infinite;
    -webkit-animation: AnimationName 3s ease infinite;
    -moz-animation: AnimationName 3s ease infinite;
    animation: AnimationName 3s ease infinite;
    border: medium none;
}

.btn-radius 
{
	border-radius: 100px !important;
}

@-webkit-keyframes AnimationName 
{
	0%{
		background-position:0% 31%
	}
	50%{
		background-position:100% 70%
	}
	100%{
		background-position:0% 31%
	}
}
@-moz-keyframes AnimationName 
{
	0%{
		background-position:0% 31%
	}
	50%{
		background-position:100% 70%
	}
	100%{
		background-position:0% 31%
	}
}
@keyframes AnimationName 
{
	0%{
		background-position:0% 31%
	}
	50%{
		background-position:100% 70%
	}
	100%{
		background-position:0% 31%
	}
}
	
.btn 
{
	color:white;
	font-size: 13px;
	font-weight: bold;
	letter-spacing: 1px;
	border-radius: 2px;
	padding: 13px 28px;
	text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.14);
	text-transform: uppercase;
	box-shadow: 0 4px 9px 0 rgba(0, 0, 0, 0.2);
}

.picture_gallery_h1
{
	font-size: 30px;
	display: inline-block;
	border-bottom: 5px solid #d1274b;
}

.title
{
	text-align: center;
}
</style>


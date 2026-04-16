<?php $this->session = \Config\Services::session();?>
<div class="col-sm-12 col-lg-4 order-summary-container">
    <h2 class="cart-section-title"><?= trans("ticket_summary"); ?></h2>
    <div class="right">
			<!-- Card -->
			<div class="card booking-card">
		<?php //echo "<pre>";print_r($this->session->eventID);echo "</pre>";die;?>
			  <!-- Card image -->
			  <img class="card-img-top" src="<?= base_url().'/'.$this->session->eventImage; ?>" alt="Event Image">

			  <!-- Card content -->
			  <div class="card-body order-summary">
				<h4><?= $this->session->eventName; ?></h4>
			
				<div class="row">
					<div class="col-6">
						<p class="card-text ticket_bold_text text-yellow"><i class="fa fa-map-marker"></i>&nbsp;<?= $this->session->eventLocation; ?></p>
					</div>
					
					<div class="col-6 text-right">
						<p class="card-text ticket_bold_text text-yellow"><i class="fa fa-calendar"></i>&nbsp;<?= $this->session->eventDate; ?></p>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-6">
						<p class="card-text ticket_bold_text text-yellow"><i class="fa fa-hourglass-1"></i>&nbsp;<?= $this->session->eventStartTime; ?></p>
					</div>
					
					<div class="col-6 text-right">
						<p class="card-text ticket_bold_text text-yellow"><i class="fa fa-hourglass-end"></i>&nbsp;<?= $this->session->eventEndTime; ?></p>
					</div>
				</div>
				<?php 
					$seat_number = json_decode($this->session->seatsRef[0]);
					
					$resultseat_number = implode(', ', $seat_number);
				?>
				
				<br>
				<div class="row">
					<div class="col-12">
						<p class="card-text ticket_bold_text"><i class="fa fa-tags"></i>&nbsp;<?= trans('seat_number'); ?>:&nbsp;<span class="text_blue"><?= $resultseat_number;?></span></p>
					</div>
				</div>
				
				<br>
				<div class="row">
					<div class="col-8">
						<p class="card-text ticket_bold_text"><i class="fa fa-male"></i>&nbsp;<?= trans('adult_ticket'); ?>:</p>
					</div>
					<div class="col-4 text-right">
						<p class="card-text make_red_color"><?= $this->session->totalAdults; ?></p>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-8">
						<p class="card-text ticket_bold_text"><i class="fa fa-child"></i>&nbsp;<?= trans('child_ticket'); ?>:</p>
					</div>
					<div class="col-4 text-right">
						<p class="card-text make_red_color"><?= $this->session->totalChilds; ?></p>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-8">
						<p class="card-text ticket_bold_text"><i class="fa fa-hand-o-right"></i>&nbsp;<?= trans('total_seats'); ?>:</p>
					</div>
					<div class="col-4 text-right">
						<p class="card-text make_red_color"><?= $this->session->eventTotalTickets; ?></p>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-8">
						<p class="card-text ticket_bold_text"><i class="fa fa-male" aria-hidden="true"></i>&nbsp;<?= trans('adult_price'); ?>:</p>
					</div>
					<div class="col-4 text-right">
						<p class="card-text make_red_color" id="totalAdultPrice"><?= $defaultCurrency->symbol; ?><?= $this->session->adultPricetotal?></p>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-8">
						<p class="card-text ticket_bold_text"><i class="fa fa-child" aria-hidden="true"></i>&nbsp;<?= trans('child_price'); ?>:</p>
					</div>
					<div class="col-4 text-right">
						<p class="card-text make_red_color" id="totalChildPrice"><?= $defaultCurrency->symbol; ?><?= $this->session->childPricetotal?></p>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-8">
						<p class="card-text ticket_bold_text"><i class="fa fa-plus-square"></i>&nbsp;<?= trans('subtotal'); ?>:</p>
					</div>
					<div class="col-4 text-right">
						<p class="card-text make_red_color"><?= $defaultCurrency->symbol; ?><?= $this->session->eventTotalwithoutDiscountPrice; ?></p>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-8">
						<p class="card-text ticket_bold_text"><i class="fa fa-tag" aria-hidden="true"></i>&nbsp;<?= trans('discount_percentage'); ?>:</p>
					</div>
					<div class="col-4 text-right">
						<p class="card-text make_red_color" id="discountPercentage"><?= $this->session->eventTotalDiscountPercenatge?>%</p>
					</div>
				</div>
					<br>
				<div class="row">
					<div class="col-8">
						<p class="card-text ticket_bold_text"><i class="fa fa-handshake-o" aria-hidden="true"></i>&nbsp;<?= trans('discount_amount'); ?>:</p>
					</div>
					<div class="col-4 text-right">
						<p class="card-text make_red_color" id="discountAmount"><?= $defaultCurrency->symbol; ?><?= $this->session->eventTotalDiscountPrice?></p>
					</div>
				</div>
				<br>
				<div class="row-custom">
					<p class="line-seperator"></p>
				</div>
				<div class="row">
					<div class="col-8">
						<p class="card-text ticket_bold_text"><i class="fa fa-money"></i>&nbsp;<?= trans('amount_payable'); ?>:</p>
					</div>
					<div class="col-4 text-right">
						<p class="card-text make_red_color text-green"><?= $defaultCurrency->symbol; ?><?= $this->session->eventTotalPrice; ?></p>
					</div>
				</div>
				
				<div class="row-custom">
					<p class="line-seperator"></p>
				</div>
				
				<div class="row-custom m-t-30 m-b-10">
					<form action="<?= base_url('TicketBookingController/paymentProceed'); ?>" method="post">
					<?= csrf_field(); ?> 
						<button type="submit" name="submit" value="update" class="btn btn-danger btn-book" id="pay_now"> <span class="float-left"><?= trans("total"); ?>:&nbsp;<?= $defaultCurrency->symbol; ?><?= $this->session->eventTotalPrice; ?></span> <span class="float-right"><?= trans('pay_now'); ?></span></button>
					</form>
				</div>

			  </div>

			</div>
			<!-- Card -->
			
        
    </div>
</div>

<style>
.booking-card 
{
  border: 2px solid #d1274b;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  
}

.order-summary h4
{
	font-weight: bold;
	text-align: center;
	color: #1E488F;
}


.ticket_bold_text
{
	font-weight: bold;
	font-size: 16px;
}

.make_red_color
{
	font-weight: bold;
	font-size: 18px;
	color : #d1274b;
}

.text_center_btn
{
	text-align : center;
}

.btn-book
{
	border-radius: 20px;
	color: white;
	font-size: 20px;
	border: 1px solid #d1274b;
	width : 100%;
}

.float-left
{
	text-align :left;
}

.text-yellow
{
	color: #FCB001;
}

.card-text i
{
	color : black !important;
}

.text-green
{
	color : #33B864;
}

.text_blue
{
	color: #247AFD;
}
</style>

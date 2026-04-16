<?php  
//echo "<pre>";print_r($tickets);echo "</pre>";die;
$seatsWithV = array();
$seatsWithoutV = array();

foreach ($ticket_id as $seat) 
{
    if (strpos($seat['seat_number'], 'V') === 0 || strpos($seat['seat_number'], 'G') === 0 || strpos($seat['seat_number'], 'S') === 0) 
	{
        $seatsWithV[] = $seat['seat_number'];
    }
}

foreach ($ticket_id as $seat) 
{
    if ($seat['seat_booking_numbers'] != '' && $seat['seat_booking_numbers'] != NULL) 
	{
        $seatsWithoutV[] = $seat['seat_booking_numbers'];
    }
}

$seatNumbers = array();
foreach ($ticket_id as $item) 
{
    $seatArray = json_decode($item['seat_number'], true);
    if (is_array($seatArray)) 
	{
        foreach ($seatArray as $seat) 
		{
            $seatNumbers[] = $seat;
        }
    }
}

$seatNumbersReserved = array();
foreach ($get_seats_reserved as $item) 
{
    $seatArrayReserved = explode(', ', $item->seats);
    foreach ($seatArrayReserved as $seat) 
    {
        $seatNumbersReserved[] = $seat;
    }
}


//echo "<pre>";print_r($seatsWithV);echo "</pre>";
//echo "<pre>";print_r($get_seats_reserved);echo "</pre>";die;
?>
<!-- Modal for ticket selection -->
<div class="modal" id="ticketSelectionModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= trans('select_no_of_tickets'); ?></h5>
        <button type="button" class="close" id ="redirectTobook" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="adultTickets"><?= trans('adult_ticket'); ?>:</label>
          <input type="number" id="adultTickets" class="form-control" value="0" min="0">
        </div>
        <div class="form-group">
          <label for="childTickets"><?= trans('child_ticket'); ?>:</label>
          <input type="number" id="childTickets" class="form-control" value="0" min="0">
        </div>
		
		<p class="text-align-center"><?= trans('price_details'); ?></p>
		<div class="row mb-2">
			<div class="col-6">
				<p class="head_price_p"><?= trans('gold_ticket_price'); ?></p>
				<p class="price text-success"><?= trans('member_ticket'); ?>:&nbsp;<?= $defaultCurrency->symbol; ?><?php echo getPrice($tickets->g_mem_tp, 'decimal');?></p>
				<p class="price text-success"><?= trans('non_member_ticket'); ?>:&nbsp;<?= $defaultCurrency->symbol; ?><?php echo getPrice($tickets->g_non_mem_tp, 'decimal');?></p>
				<p class="price text-success"><?= trans('child_ticket'); ?>:&nbsp;<?= $defaultCurrency->symbol; ?><?php echo getPrice($tickets->g_child_tp, 'decimal');?></p>
			</div>
			<div class="col-6 text-right">
				<p class="head_price_p"><?= trans('silver_ticket_price'); ?></p>
				<p class="price text-success"><?= trans('member_ticket'); ?>:&nbsp;<?= $defaultCurrency->symbol; ?><?php echo getPrice($tickets->s_mem_tp, 'decimal');?></p>
				<p class="price text-success"><?= trans('non_member_ticket'); ?>:&nbsp;<?= $defaultCurrency->symbol; ?><?php echo getPrice($tickets->s_non_mem_tp, 'decimal');?></p>
				<p class="price text-success"><?= trans('child_ticket'); ?>:&nbsp;<?= $defaultCurrency->symbol; ?><?php echo getPrice($tickets->s_child_tp, 'decimal');?></p>
			</div>
		</div>
		<?php if($tickets->d1_more_than > 0 || $tickets->d2_more_than > 0 || $tickets->d3_more_than > 0){ ?>
		<p class="text-align-center">Discount Details</p>
		<div class="row">
		<?php if($tickets->d1_more_than > 0) { ?>
				<div class="col-12">
					<span class="head_price_p">Discount 1 :</span>
					<span class=" price text-success">&nbsp; More than <?= $tickets->d1_more_than;?> tickets : <?= $tickets->d1_perc;?>% discount</span>
				</div>
		<?php } ?>
		
		<?php if($tickets->d2_more_than > 0) { ?>
				<div class="col-12">
					<span class="head_price_p">Discount 2 :</span>
					<span class=" price text-success">&nbsp; More than <?= $tickets->d2_more_than;?> tickets : <?= $tickets->d2_perc;?>% discount</span>
				</div>
		<?php } ?>
		
		<?php if($tickets->d3_more_than > 0) { ?>
				<div class="col-12">
					<span class="head_price_p">Discount 3 :</span>
					<span class=" price text-success">&nbsp; More than <?= $tickets->d3_more_than;?> tickets : <?= $tickets->d3_perc;?>% discount</span>
				</div>
		<?php } ?>
		</div>
		<?php } ?>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-radius" id="confirmTicketSelection"><?= trans('confirm'); ?></button>
      </div>
    </div>
  </div>
</div>


<div class="modal" id="imageLayout" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document" style="max-width : 800px !important;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= trans('seat_layout_image'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="text-align: center;">      
    <img src="<?= base_url().'/'.esc($tickets->seatLayoutImage); ?>" style="max-width: 100%; height: auto;">
</div>

    </div>
  </div>
</div>

<div class="containers">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="row" style="margin-top:5px;">
				<div class="col-md-2" style="text-align : center;">
					<button class="btn btn-sm btn-danger" id="ticket_booking_back"><i class="fa fa-angle-double-left"></i>&nbsp;<?= trans('back'); ?></button>
				</div>
				<div class="col-md-10">
					<div class="timer-container">
						<span class="remaining-text">Remaining Time - </span>
						<span class="timer-text" id="timer">0:00</span>
					</div>
				</div>
			</div>

			<div class="sections-container movie-seat-container" id="seating-container" style="text-align : center !important;">
				<div class="row">
					<div class="col-md-10 col-sm-12">
					
						<ul class="showcase">
							<li>
							  <div class="seats gold">G</div>
							  <small><?= trans('gold_tickets'); ?></small>
							</li>
						
							<li>
							  <div class="seats silver">S</div>
							  <small><?= trans('silver_tickets'); ?></small>
							</li>

							<li>
								<div class="seats gold selected"></div>
								<small><?= trans('gold_selected_ticket'); ?></small>
							</li>
							
							<li>
								<div class="seats silver selected"></div>
								<small><?= trans('silver_selected_ticket'); ?></small>
							</li>

							<li>
								<div class="seats occupied"></div>
								<small><?= trans('occupied_ticket'); ?></small>
							</li>   
						</ul>
					</div>
					
					<div class="col-md-2 col-sm-12">
						<button type="button" class="btn-md btn btn-danger" data-toggle="modal" data-target="#imageLayout"><?= trans('view_seat'); ?></button>
					</div>
				</div>
				<div class="screen"></div>
			<!-- Sections will be added dynamically here -->
			</div>
		</div>
		<div class="col-md-4">
			<div class="booking-card">
				<form action="<?= base_url('TicketBookingController/bookSelectedTicket'); ?>" method="post">
				<?= csrf_field(); ?>
					<h4><?= trans('detailed_booking'); ?></h4>

					<h4 class="card-title title_head"><?php echo $tickets->event_name; ?></h4>
					<div class="row">
						<div class="col-6">
							<p class="card-text"><i class="fa fa-calendar"></i>&nbsp;<?php echo $tickets->event_date;?></p>
						</div>
						<div class="col-6 text-right">
							<p class="card-text"><i class="fa fa-map-marker"></i>&nbsp;<?php echo $tickets->event_location;?></p>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-6">
							<p class="card-text"><i class="fa fa-hourglass-1"></i>&nbsp;<?php echo $tickets->event_start_time;?></p>
						</div>
						<div class="col-6 text-right">
							<p class="card-text"><i class="fa fa-hourglass-end"></i>&nbsp;<?php echo $tickets->event_end_time;?></p>
						</div>
					</div>

					<div class="line-seperator"></div>
					
					<div class="row">
						<!-- Left-aligned div -->
						<div class="col-md-6">
							<p class="card-text"><i class="fa fa-male" aria-hidden="true"></i>&nbsp;<?= trans('adult_ticket'); ?>: <span id="adultCount" class="ticket_bold_text">0</span></p>
							<p class="card-text"><i class="fa fa-child" aria-hidden="true"></i>&nbsp;<?= trans('child_ticket'); ?>: <span id="childCount" class="ticket_bold_text">0</span></p>
							<p class="card-text"><i class="fa fa-users" aria-hidden="true"></i>&nbsp;<?= trans('total_ticket'); ?>: <span id="totalCount" class="ticket_bold_text">0</span></p>
						</div>
						<!-- Right-aligned and centered div -->
						<div class="col-md-6 d-flex align-items-end justify-content-end">
							<button type="button" class="btn btn-danger  btn-radius" data-toggle="modal" data-target="#ticketSelectionModal">
								<?= trans('modify_ticket_count'); ?>
							</button>
						</div>
					</div>
					
					<div class="line-seperator"></div>

					<div class="row">
						<div class="col-8">
							<p class="card-text ticket_bold_text"><i class="fa fa-check-square-o"></i>&nbsp;<?= trans('total_seats_selected'); ?>:</p>
						</div>
						<div class="col-4 text-right">
							<p class="card-text make_red_color" id="seat-count"></p>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-8">
							<p class="card-text ticket_bold_text"><i class="fa fa-male" aria-hidden="true"></i>&nbsp;<?= trans('adult_price'); ?>:</p>
						</div>
						<div class="col-4 text-right">
							<p class="card-text make_red_color" id="totalAdultPrice"><?= $defaultCurrency->symbol; ?><?php echo '';?></p>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-8">
							<p class="card-text ticket_bold_text"><i class="fa fa-child" aria-hidden="true"></i>&nbsp;<?= trans('child_price'); ?>:</p>
						</div>
						<div class="col-4 text-right">
							<p class="card-text make_red_color" id="totalChildPrice"><?= $defaultCurrency->symbol; ?><?php echo '';?></p>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-8">
							<p class="card-text ticket_bold_text"><i class="fa fa-tag" aria-hidden="true"></i>&nbsp;<?= trans('discount_percentage'); ?>:</p>
						</div>
						<div class="col-4 text-right">
							<p class="card-text make_red_color" id="discountPercentage"><?= $defaultCurrency->symbol; ?><?php echo '';?></p>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-8">
							<p class="card-text ticket_bold_text"><i class="fa fa-handshake-o" aria-hidden="true"></i>&nbsp;<?= trans('discount_amount'); ?>:</p>
						</div>
						<div class="col-4 text-right">
							<p class="card-text make_red_color" id="discountAmount"><?= $defaultCurrency->symbol; ?><?php echo '';?></p>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-8">
							<p class="card-text ticket_bold_text"><i class="fa fa-money"></i>&nbsp;<?= trans('total_price'); ?>:</p>
						</div>
						<div class="col-4 text-right">
							<p class="card-text total_ticket_price" id="totalPrice"></p>
						</div>
					</div>
					<br>
					<input type="hidden" value="0" id="aldreadyreserved">
					<input type="hidden" name="seats[]" value="" id="seat-data">
					<input type="hidden" name="seatsRef[]" value="" id="seat-data-ref">
					<div class="text_center_btn">
					<input type="hidden" name="eventID" value="<?php echo $tickets->id;?>" >
					<input type="hidden" name="is_paypal" value="<?php echo $tickets->is_paypal;?>" >
					<input type="hidden" name="is_epayment" value="<?php echo $tickets->is_epayment;?>" >
					<input type="hidden" name="eventStartTime" value="<?php echo $tickets->event_start_time;?>" >
					<input type="hidden" name="eventEndTime" value="<?php echo $tickets->event_end_time;?>" >
					<input type="hidden" name="eventDate" value="<?php echo $tickets->event_date;?>" >
					<input type="hidden" name="eventName" value="<?php echo $tickets->event_name;?>" >
					<input type="hidden" name="eventLocation" value="<?php echo $tickets->event_location;?>" >
					<input type="hidden" name="eventImage" value="<?php echo $tickets->event_image;?>" >
					<input type="hidden" name="eventTotalTickets" value="" id = "seat-count-ticket">
					<input type="hidden" name="eventTotalPrice" value="" id = "total-price-ticket">
					<input type="hidden" name="eventTotalDiscountPrice" value="" id = "discount-price-ticket">
					<input type="hidden" name="eventTotalDiscountPercenatge" value="" id = "discount-percent-ticket">
					<input type="hidden" name="eventTotalwithoutDiscountPrice" value="" id = "totalWithout-disc-ticket"> 
					<input type="hidden" name="adultPricetotal" value="" id = "adult-Price-total"> 
					<input type="hidden" name="childPricetotal" value="" id = "child-Price-total"> 
					<input type="hidden" name="totalAdults" value="" id = "total-Adults"> 
					<input type="hidden" name="totalChilds" value="" id = "total-Childs"> 
					<input type="hidden" name="totalAvailableSeats" value="" id = "total-seats-available"> 
					<button type="submit" class="btn btn-danger btn-radius" id="book-now-btn" style="display: none;"><i class="fa fa-ticket"></i>&nbsp;<?= trans('book_now'); ?></button>
					</div> 
				</form>
			</div>
		</div>
	</div>
</div>

<?php $jsArray = json_encode($seats, JSON_NUMERIC_CHECK);?>
<style>
.timer-container {
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: Arial, sans-serif;
}

.remaining-text {
    font-size: 1.5rem;
    font-weight: bold;
    color: #d1274b;
    margin-right: 10px;
}

.timer-text {
    font-size: 1.8rem;
    font-weight: bold;
    color: #333;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}

.title_head
  {
	text-align: center;
	font-weight: bold;
	color: #d1274b;
  }
.line-seperator
{
	height: 1px;
	width: 100%;
	background-color: #999;
	margin: 1.5rem 0;
}
		  
@media (min-width: 1200px)
.containers {
  max-width: 1500px;
}

.seating-map 
{
	font-family: monospace;
	white-space: pre-wrap;
}

.seat 
{
	display: inline-block;
	width: 20px;
	height: 20px;
	border: 1px solid #555;
	margin: 2px;
	background-color:white;
	text-align: center;
	line-height: 20px;
}

/* Additional CSS for displaying sections in a row */
.sections-container 
{
	overflow-x: auto;
	overflow-y: auto;
	white-space: nowrap;
}

.section-column 
{
	display: inline-block;
	vertical-align: top;
	//width: calc(33.33% - 20px); /* Adjust the width as needed */
	margin-right: 20px;
}
		
.screen
{ 
	height: 25px;
	margin: 15px 0;
	transform: rotateX(-65deg);
	box-shadow: 0 3px 10px rgba(255,255,255,0.7);
	border-top: 100px solid #d7d7d8;
	border-left: 27px solid transparent;
	border-right: 27px solid transparent;
}
  
/* Container for the seats with a fixed height and overflow */
.movie-seat-container 
{
	border: 2px solid #d1274b; /* Add a border */
	padding: 10px; /* Add some padding */
	margin : 15px;
	border-radius: 10px;
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.movie-seat-layout 
{
	display: grid;
	grid-gap: 20px; /* Adjust the gap between seats */
	justify-content: center;
	padding-right : 20px; 
}

.seat 
{
	width: 22px; /* Set the width to 20px */
	height: 22px; /* Set the height to 20px */
	background-color: white;
	cursor: pointer;
	border-radius : 10px 10px 0px 0px;
}

.seats 
{
	width: 22px; /* Set the width to 20px */
	height: 22px; /* Set the height to 20px */
	background-color: white;
	cursor: default;
	border-radius : 10px 10px 0px 0px;
	border : 1px solid black;
}

.selected, .selected_showcase 
{
	background-color: #43ff43;
	border : 1px solid #43ff43;
}

.seats.occupied 
{
	background-color: red;
	cursor :default;
	border : 1px solid red;
}

.showcase 
{
	display: flex;
	justify-content: center;
	list-style-type: none;
}

.showcase li 
{
	display: flex;
	align-items: center;
	justify-content: center;
	margin: 0 10px;
}

.showcase li small 
{
	margin-left: 2px;
}

.booking-card 
{
	border: 2px solid #d1274b;
	padding: 10px;
	margin: 20px;
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
}

.booking-card h4
{
	font-weight: bold;
	text-align: center;
}

.total_ticket_price
{
	font-weight: bold;
	font-size: 18px;
	color: #00af00;
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

.card-text i
{
	color : #d1274b;
}

.seat.occupied 
{
  background-color: red;
  color: white; 
  border : 1px solid red;
}

.seat.sponsors {
  /* Add your custom styles for VIP seats here */
	background-color: #c46eff;
	color: black;
	font-weight: bold;
	border : 1px solid #c46eff;
}

.seats.sponsors 
{
	background-color: #c46eff;
	color: black;
	font-weight: bold;
	border: 1px solid #c46eff;
	cursor: default;
	text-align: center;
}

.text-align-below-section
{
	text-align: center;
	color: #3c49ff;
	font-weight: bold;
}

.gold
{
	background: gold;
	border: 1px solid gold !important;
}

.seats.gold
{
	background: gold;
	color: black;
	font-weight: bold;
	border: 1px solid gold !important;
	cursor: default;
	text-align: center;
}

.silver
{
	background: silver;
	text-align : center;
	border: 1px solid silver;
}

.seats .silver
{
	background: silver;
	color: black;
	font-weight: bold;
	border: 1px solid silver !important;
	cursor: default;
	text-align: center;
}

.seats.gold.selected
{
	background: #80ff80 !important;
	border: 2px solid gold !important;
	font-weight: bold !important;
}

.seat.gold.selected
{
	background: #80ff80 !important;
	border: 2px solid gold !important;
	font-weight: bold !important;
}

.seats.silver.selected
{
	background: #80ff80 !important;
	border: 2px solid silver !important;
	font-weight: bold !important;
}

.seat.silver.selected
{
	background: #80ff80 !important;
	border: 2px solid silver !important;
	font-weight: bold !important;
}

button.close 
{
	background: red;
	padding: 2px 3px 4px 5px !important;
	opacity: 1;
	color: #fff;
}

.seperator_line
{
	border : 1px solid #ccc;
}

.price 
{
	font-weight: 1000;
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

.btn-radius 
{
	border-radius: 100px !important;
}
</style>

<?php $jsArray = json_encode($seats, JSON_NUMERIC_CHECK);?>

<script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
<script>
function generateSeatingMap(sectionsConfig, occupiedSeats) 
{
    let seatingContainer = $("#seating-container");
	let totalTables = 0; // Variable to keep track of the total number of tables
	 let totalseats = 0;
	   let allTableNames = [];
	   
    sectionsConfig.forEach((section, sectionIndex) => {
    let sectionDiv = $("<div>").addClass("section-column");
    sectionDiv.append($(`<div class="seating-map" id="section${sectionIndex + 1}"><h3>${section.sectionName}</h3></div>`));
    seatingContainer.append(sectionDiv);

    let seatingMap = "";
	let totalSeatsInSection = 0; // Variable to count total seats in the section
	for (let table = 1; table <= section.numTables; table++) 
	{
        let tableNumber = (totalTables + table).toString().padStart(2, '0'); // Use totalTables to continue table numbering
		let section_no = section.sectionNo;
		let event_id_table = section.eventID;
		let prefix_section = 'S';
		let tableNameFindValue = prefix_section + section_no + event_id_table+ tableNumber;

		allTableNames.push(tableNameFindValue);
	  
		let tableNameWithSpan = `<span class="table-name edit-icon" id= "${tableNameFindValue}"></span>&nbsp;`;
		
        let seats = "";
        for (let seat = 1; seat <= section.numSeatsPerTable; seat++) {
          let seatId = `s${sectionIndex + 1}t${tableNumber}${seat}`;
          let seatClass = occupiedSeats.includes(seatId) ? "seat occupied" : "seat";
			if (isVipSeat(sectionIndex, tableNumber, seat)) {
            seatClass += " occupied";
			let seatId = `Vs${sectionIndex + 1}t${tableNumber}${seat}`;
			let seatIdRef = `V-${seat}`;
            seats += `<div class="${seatClass}" data-id="${seatId}" data-src = "${seatIdRef}">${seat}</div>`;
          } 
		  else if(isGoldSeat(sectionIndex, tableNumber, seat))
		  {
			if(isGoldSeatOccupied(sectionIndex, tableNumber, seat))
			{
				seatClass += " occupied";
				let seatId = `Gs${sectionIndex + 1}t${tableNumber}${seat}`;
				let seatIdRef = `G`;
				seats += `<div class="${seatClass}" data-id="${seatId}" data-src = "${seatIdRef}">${seat}</div>`;
			}
			else
			{
				if(isSeatNumbersGoldReserved(sectionIndex, tableNumber, seat))
				{
					seatClass += " occupied";
					let seatId = `Gs${sectionIndex + 1}t${tableNumber}${seat}`;
					let seatIdRef = `G`;
					seats += `<div class="${seatClass}" data-id="${seatId}" data-src = "${seatIdRef}">${seat}</div>`;
				}
				else
				{
					seatClass += " gold";
					let seatId = `Gs${sectionIndex + 1}t${tableNumber}${seat}`;
					let seatIdRef = `G`;
					seats += `<div class="${seatClass}" data-id="${seatId}" data-src = "${seatIdRef}">${seat}</div>`;
					totalSeatsInSection++; // Increment the totalSeats count
				}
			}
			
		  }
		  else if(isSilverSeat(sectionIndex, tableNumber, seat))
		  {
			if(isSilverSeatOccupied(sectionIndex, tableNumber, seat))
			{
				seatClass += " occupied";
				let seatId = `Ss${sectionIndex + 1}t${tableNumber}${seat}`;
				let seatIdRef = `S`;
				seats += `<div class="${seatClass}" data-id="${seatId}" data-src = "${seatIdRef}">${seat}</div>`;
			}
			else
			{
				if(isSeatNumbersSilverReserved(sectionIndex, tableNumber, seat))
				{
					seatClass += " occupied";
					let seatId = `Ss${sectionIndex + 1}t${tableNumber}${seat}`;
					let seatIdRef = `S`;
					seats += `<div class="${seatClass}" data-id="${seatId}" data-src = "${seatIdRef}">${seat}</div>`;
				}
				else
				{
					seatClass += " silver";
					let seatId = `Ss${sectionIndex + 1}t${tableNumber}${seat}`;
					let seatIdRef = `S`;
					seats += `<div class="${seatClass}" data-id="${seatId}" data-src = "${seatIdRef}">${seat}</div>`; 
					totalSeatsInSection++; // Increment the totalSeats count
				}
			}
		  }
		  else {
			let seatIdRef = `E`;
            seats += `<div class="${seatClass}" data-id="${seatId}" data-src = "${seatIdRef}">${seat}</div>`;
			totalSeatsInSection++; // Increment the totalSeats count
          }
        }
        seatingMap += tableNameWithSpan + seats + "<br>";
		}
		$(`#section${sectionIndex + 1}`).append(seatingMap);
		
		// Display the total number of seats below the section
		$(`#section${sectionIndex + 1}`).append(`<p class="text-align-below-section">Total Seats Available: ${totalSeatsInSection}</p>`);
	
		totalTables += section.numTables; // Increment totalTables for the next section
		
		totalseats += totalSeatsInSection;
    });
	if (allTableNames.length > 0) {
        allTableNames.forEach(name => enqueueTableName(name));
        // Process any remaining table names in the queue
        processTableNamesQueue();
    }
	
	$("#total-seats-available").val(totalseats);
}
  
const vipSeatNumbers = <?= json_encode($seatsWithV); ?>;

const occupiedSeatNumbers = <?= json_encode($seatsWithoutV); ?>;

const seatNumbersReserved = <?= json_encode($seatNumbersReserved); ?>;


  // Function to check if a seat is a VIP seat
function isVipSeat(sectionIndex, tableNumber, seat) 
{
    // Create the seatId using the sectionIndex, tableNumber, and seat
	const seatId = `Vs${sectionIndex + 1}t${tableNumber}${seat}`;

	// Check if the seatId is present in the array of VIP seat numbers
	return vipSeatNumbers.includes(seatId);
}

  // Function to check if a seat is a Gold seat
function isGoldSeat(sectionIndex, tableNumber, seat) 
{
    // Create the seatId using the sectionIndex, tableNumber, and seat
	const seatId = `Gs${sectionIndex + 1}t${tableNumber}${seat}`;

	// Check if the seatId is present in the array of VIP seat numbers
	return vipSeatNumbers.includes(seatId);
}  

// Function to check if a seat is a occupied
function isGoldSeatOccupied(sectionIndex, tableNumber, seat) 
{
    // Create the seatId using the sectionIndex, tableNumber, and seat
	const seatId = `Gs${sectionIndex + 1}t${tableNumber}${seat}`;

	// Check if the seatId is present in the array of VIP seat numbers
	return occupiedSeatNumbers.includes(seatId);
} 

 // Function to check if a seat is a Silver seat
function isSilverSeat(sectionIndex, tableNumber, seat) 
{
    // Create the seatId using the sectionIndex, tableNumber, and seat
	const seatId = `Ss${sectionIndex + 1}t${tableNumber}${seat}`;

	// Check if the seatId is present in the array of VIP seat numbers
	return vipSeatNumbers.includes(seatId);
}

 // Function to check if a seat is a occupied
function isSilverSeatOccupied(sectionIndex, tableNumber, seat) 
{
    //Create the seatId using the sectionIndex, tableNumber, and seat
	const seatId = `Ss${sectionIndex + 1}t${tableNumber}${seat}`;

	// Check if the seatId is present in the array of VIP seat numbers
	return occupiedSeatNumbers.includes(seatId);
} 

// Function to check if a seat is a occupied
function isSeatNumbersGoldReserved(sectionIndex, tableNumber, seat) 
{
    //Create the seatId using the sectionIndex, tableNumber, and seat
	const seatId = `Gs${sectionIndex + 1}t${tableNumber}${seat}`;

	// Check if the seatId is present in the array of VIP seat numbers
	return seatNumbersReserved.includes(seatId);
}

// Function to check if a seat is a occupied
function isSeatNumbersSilverReserved(sectionIndex, tableNumber, seat) 
{
    //Create the seatId using the sectionIndex, tableNumber, and seat
	const seatId = `Ss${sectionIndex + 1}t${tableNumber}${seat}`;

	// Check if the seatId is present in the array of VIP seat numbers
	return seatNumbersReserved.includes(seatId);
}

function totalCountTicket()
{
	const selectedSeats = $(".seat.selected");
	const totalCount =  $("#totalCount").text();
	
	if(selectedSeats.length == totalCount)
	{
		swal('Total Ticket Count Execeeded','You can update the seat count by clicking on update','warning');
		return 0;
	}
	else
	{
		return 1;
	}
}

function totalCountAdultTicket()
{
	const selectedSeats = $(".seat.selected.adult");
	const totalAdultCount =  $("#adultCount").text();

	if(selectedSeats.length >= totalAdultCount)
	{
		return 1;
	}
}

const seatingData = 
{
	selectedSeats: []
};

function toggleSeatColor(seat)  // on click of seat this function will be called
{
	let previousSpan = $(seat).prevAll("span:first");

    if (previousSpan.length > 0) 
	{
        var prevSpanText = previousSpan.text(); 
		
		let dataSrcRefValue = $(seat).attr("data-src");
		
        if (dataSrcRefValue.indexOf(prevSpanText) === -1) 
		{
            let seatRef = `${prevSpanText}-${dataSrcRefValue}`;

            $(seat).attr("data-src", seatRef);
		}
    } else {
        swal('Warning - Network Issues','please refresh the screen and wait until all the seats are loaded');
    }

	// Check if the seat is already occupied
	if ($(seat).hasClass("occupied")) 
	{
		return; // Don't do anything if the seat is already occupied
	}
	else if ($(seat).hasClass("sponsors")) 
	{
		return; // Don't do anything if the seat is already a sponsors
	}

	const seatId = $(seat).attr("data-id");
	
	const isSeatVIP = vipSeatNumbers.includes(seatId);
	
	var esterremo = getTheSeatDataReserved(seatId).then(function(data) {
		if(data == 1)
		{
			console.log(99);
			return 99;
		}else{
			console.log(98);
			ifNotReserved(seat);
		}
	});
}

function ifNotReserved(seat)
{
	// Check if the seat already has the "selected" class
	if ($(seat).hasClass("gold")) 
	{
		if ($(seat).hasClass("selected")) 
		{
			//you can modify
			const index = seatingData.selectedSeats.indexOf(seat);
			if (index !== -1) 
			{
				seatingData.selectedSeats.splice(index, 1);
				if ($(seat).hasClass("adult")) 
				{
					$(seat).removeClass("adult");
				}
				else if ($(seat).hasClass("child")) 
				{
					$(seat).removeClass("child");
				}
			}

		}
		else 
		{
			var totalCount = totalCountTicket(); //counting total tickets count 
			if(totalCount == 0)
			{
				return;
			}
			else
			{
				// If the seat doesn't have the "sponsors" class, add it to the selectedSeats array
				seatingData.selectedSeats.push(seat);
				var adultCount = totalCountAdultTicket();
				if (adultCount == 1) 
				{
					$(seat).removeClass("adult").addClass("child");
				}
				else 
				{
					$(seat).removeClass("child").addClass("adult");
				}
			}
		}

		// Toggle the "sponsors" class and update the content of each selected seat div
		$(seat).toggleClass("selected");

		seatingData.selectedSeats.forEach((selectedSeat) => 
		{
			const dataId = selectedSeat.getAttribute("data-id");
			const dataSrc = selectedSeat.getAttribute("data-src");

			selectedSeat.setAttribute("data-id", `${dataId}`);
			selectedSeat.setAttribute("data-src", `${dataSrc}`);
			selectedSeat.textContent = `${selectedSeat.textContent}`;

		});
	}
	else if($(seat).hasClass("silver"))
	{
		if ($(seat).hasClass("selected")) 
		{
			// if it is  not vip seat then you can modify
			const index = seatingData.selectedSeats.indexOf(seat);
			if (index !== -1) 
			{
				seatingData.selectedSeats.splice(index, 1);
				if ($(seat).hasClass("adult")) 
				{
					$(seat).removeClass("adult");
				}
				else if ($(seat).hasClass("child")) 
				{
					$(seat).removeClass("child");
				}
			}

		}
		else 
		{
			var totalCount = totalCountTicket();
			if(totalCount == 0)
			{
				return;
			}
			else
			{
				// If the seat doesn't have the "sponsors" class, add it to the selectedSeats array
				seatingData.selectedSeats.push(seat);
				var adultCount = totalCountAdultTicket();
				if (adultCount == 1) 
				{
					$(seat).removeClass("adult").addClass("child");
				}
				else 
				{
					$(seat).removeClass("child").addClass("adult");
				}
			}
		}

		// Toggle the "sponsors" class and update the content of each selected seat div
		$(seat).toggleClass("selected");

		seatingData.selectedSeats.forEach((selectedSeat) => 
		{
			const dataId = selectedSeat.getAttribute("data-id");
			const dataSrc = selectedSeat.getAttribute("data-src");

			selectedSeat.setAttribute("data-id", `${dataId}`);
			selectedSeat.setAttribute("data-src", `${dataSrc}`);
			selectedSeat.textContent = `${selectedSeat.textContent}`;

		});
	}

	const seatData = seatingData.selectedSeats.map((seat) => seat.getAttribute("data-id"));
	
	const seatDataRef = seatingData.selectedSeats.map((seat) => seat.getAttribute("data-src"));

	const seatDataInput = document.getElementById("seat-data");
	seatDataInput.value = JSON.stringify(seatData); 
	
	const seatDataInputRef = document.getElementById("seat-data-ref");
	seatDataInputRef.value = JSON.stringify(seatDataRef); 
	
	let totalAdultSeats = $('.seat.adult').length;
	let totalChildSeats = $('.seat.child').length;
	
	$('#total-Adults').val(totalAdultSeats);
	$('#total-Childs').val(totalChildSeats);
	
	updatePrice();
}
const arrayData = <?php echo $jsArray; ?>;

const sectionsConfig = arrayData.map((section) => {
    return {
		sectionNo: section.sections,
		eventID: section.event_id,
		sectionName: section.section_name,
		numTables: section.tables,
		numSeatsPerTable: section.seats,	
    };
});

const occupiedSeats  = <?= json_encode($seatsWithoutV); ?>; 
 
$(document).on("click", ".seat", function() 
{
	toggleSeatColor(this);
});

$(document).ready(function () 
{
	let numAdultTickets = 0;
	let numChildTickets = 0;
	let seatingMapGenerated = false; // Flag to track if the seating map is generated
	let timingStarted = false;
	let buttonClose = false;

	function openTicketSelectionModal() 
	{
		$(function() {
		$('#ticketSelectionModal').modal({
			backdrop: 'static',
			keyboard: false
		}).modal('show');
		});
	}

	function updateTicketCounts() 
	{
		numAdultTickets = parseInt($("#adultTickets").val()) || 0;
		numChildTickets = parseInt($("#childTickets").val()) || 0;

		$("#adultCount").text(numAdultTickets);
		$("#childCount").text(numChildTickets);
		$("#totalCount").text(numAdultTickets + numChildTickets);
		
		//$('#total-Childs').val(numChildTickets);
		//$('#total-Adults').val(numAdultTickets);
	}

	$("#confirmTicketSelection").click(function () {
		updateTicketCounts();

		$("#ticketSelectionModal").modal("hide");

		// Generate seating map only if it hasn't been generated before
		if (!seatingMapGenerated) {
			generateSeatingMap(sectionsConfig, occupiedSeats);
			seatingMapGenerated = true; // Set the flag to true after generating
		}

		if (!timingStarted) {
			startTicketSessionTiming('<?= user()->id ?>', '<?= $tickets->id ?>');
			timingStarted = true; // Set the flag to true after starting the timing
		}
		
		if (!buttonClose) {
			buttonClose = true;
			$(".close").css("display", "none");
		}
	});
	
	openTicketSelectionModal();
});


function updatePrice() 
{
	let totalAdultPrice = 0;
	let totalChildPrice = 0;
	let goldAdultSeatPrice = parseInt("<?= getPrice($tickets->g_mem_tp, 'decimal')?>");
	let goldAdultSeatNonPrice = parseInt("<?= getPrice($tickets->g_non_mem_tp, 'decimal')?>");
	let goldChildSeatPrice = parseInt("<?= getPrice($tickets->g_child_tp, 'decimal')?>");
	let silverAdultSeatPrice = parseInt("<?= getPrice($tickets->s_mem_tp, 'decimal')?>");
	let silverAdultSeatNonPrice = parseInt("<?= getPrice($tickets->s_non_mem_tp, 'decimal')?>");
	let silverChildSeatPrice = parseInt("<?= getPrice($tickets->s_child_tp, 'decimal')?>");
	
	const seatCountElement = document.getElementById("seat-count");
	const selectedSeats = document.querySelectorAll(".seat.selected");
	const seatCount = selectedSeats.length;
    seatCountElement.textContent = seatCount;
	$('#seat-count-ticket').val(seatCount);
	
	seatingData.selectedSeats.forEach((selectedSeat) => {
    if ($(selectedSeat).hasClass("gold")) 
	{
		if ($(selectedSeat).hasClass("adult")) 
		{
			<?php if(isMember())
			{?>
				totalAdultPrice += goldAdultSeatPrice;
			<?php }
			else
			{?>
				totalAdultPrice += goldAdultSeatNonPrice;
			<?php }?>
		} 
		else if ($(selectedSeat).hasClass("child")) 
		{
			totalChildPrice += goldChildSeatPrice;
		}
    }
	else if ($(selectedSeat).hasClass("silver")) 
	{
 		if ($(selectedSeat).hasClass("adult")) 
		{
			<?php if(isMember())
			{?>
				totalAdultPrice += silverAdultSeatPrice;
			<?php }
			else
			{?>
				totalAdultPrice += silverAdultSeatNonPrice;
			<?php }?>
		} 
		else if ($(selectedSeat).hasClass("child")) 
		{
			totalChildPrice += silverChildSeatPrice;
		}    
    }
  });
  
	let totalPrice = totalAdultPrice + totalChildPrice;
   /* let discountPercentage = 0;
	
	var more_than_1 = "<?= $tickets->d1_more_than ?>";
	var percent_1 = "<?= $tickets->d1_perc ?>";

	var more_than_2 = "<?= $tickets->d2_more_than ?>";
	var percent_2 = "<?= $tickets->d2_perc ?>";

	var more_than_3 = "<?= $tickets->d3_more_than ?>";
	var percent_3 = "<?= $tickets->d3_perc ?>";
	
    // Apply a discount if more than 5 seats are selected
	if(more_than_1 != ' ' && percent_1 != ' ')
	{
		if (seatingData.selectedSeats.length > more_than_1) 
		{
			discountPercentage = percent_1;
		}
	}
	else if(more_than_2 != ' ' && percent_2 != ' ')
	{
		if (seatingData.selectedSeats.length > more_than_2) 
		{
			discountPercentage = percent_2;
		}
	}
	else if(more_than_3 != ' ' && percent_3 != ' ')
	{
		if (seatingData.selectedSeats.length > more_than_3) 
		{
			discountPercentage = percent_3;
		}
	}
	*/
	
	var discountTiers = [];

	if (<?= $tickets->d1_more_than ?> !== 0 && <?= $tickets->d1_perc ?> !== 0) 
	{
		discountTiers.push({ more_than: <?= $tickets->d1_more_than ?>, percent: <?= $tickets->d1_perc ?> });
	}

	if (<?= $tickets->d2_more_than ?> !== 0 && <?= $tickets->d2_perc ?> !== 0) 
	{
		discountTiers.push({ more_than: <?= $tickets->d2_more_than ?>, percent: <?= $tickets->d2_perc ?> });
	}

	if (<?= $tickets->d3_more_than ?> !== 0 && <?= $tickets->d3_perc ?> !== 0) 
	{
		discountTiers.push({ more_than: <?= $tickets->d3_more_than ?>, percent: <?= $tickets->d3_perc ?> });
	}

	var selectedSeatsCount = seatingData.selectedSeats.length;
	var discountPercentage = 0;

	for (var i = 0; i < discountTiers.length; i++) 
	{
		var tier = discountTiers[i];
		if (selectedSeatsCount > tier.more_than) 
		{
			discountPercentage = tier.percent;
		} 
		else 
		{
			break; 
		}
	}

    let discountAmount = (totalPrice * discountPercentage) / 100;

    let discountedTotalPrice = totalPrice - discountAmount;

   //$("#totalPrice").text(discountedTotalPrice.toFixed(2)); // Adjust decimal places as needed

    $("#discountPercentage").text(discountPercentage + "%");
    $("#discountAmount").text("<?= $defaultCurrency->symbol; ?>" + discountAmount.toFixed(2)); // Adjust decimal places as needed

	$("#totalAdultPrice").text("<?= $defaultCurrency->symbol; ?>" + totalAdultPrice.toFixed(2));
	$("#totalChildPrice").text("<?= $defaultCurrency->symbol; ?>" + totalChildPrice.toFixed(2));
	$("#totalPrice").text("<?= $defaultCurrency->symbol; ?>" + discountedTotalPrice.toFixed(2));

	$("#total-price-ticket").val(discountedTotalPrice.toFixed(2));
	$("#discount-price-ticket").val(discountAmount.toFixed(2));
	$("#totalWithout-disc-ticket").val(totalPrice.toFixed(2));
	$("#discount-percent-ticket").val(discountPercentage);
	$("#adult-Price-total").val(totalAdultPrice);
	$("#child-Price-total").val(totalChildPrice);
	
	const payNowButton = document.getElementById('book-now-btn');
    if (selectedSeatsCount > 0) 
	{
        payNowButton.style.display = 'block'; 
    } 
	else 
	{
        payNowButton.style.display = 'none';  
    }
}

$('#redirectTobook').click(function()
{
	window.location.href = "<?= base_url('admin/ticket-booking'); ?>";
});

let tableNamesQueue = [];
const BATCH_SIZE = 10; // Number of requests per batch

function getTableNamesFromDefineBatch(tableNames) {
    var data = {
        'values': tableNames
    };

    $.ajax({
        type: 'POST',
        url: MdsConfig.baseURL + '/TicketBookingController/getTableNamesFromDefine',
		data: JSON.stringify(setAjaxData(data)), 
        contentType: 'application/json',
        dataType: 'json',
        success: function (response) {
            if (response) {
                for (let key in response) {
                    if (response.hasOwnProperty(key)) {
                        let tableName_response = response[key].table_name;
                        let rowValue_response = response[key].row_value;
                        $(`#${rowValue_response}`).html(`${tableName_response}`);
                    }
                }
            }
        }
    });
}

function processTableNamesQueue() {
    while (tableNamesQueue.length > 0) {
        let batch = tableNamesQueue.splice(0, BATCH_SIZE);
        getTableNamesFromDefineBatch(batch);
    }
}

function enqueueTableName(value) {
    tableNamesQueue.push(value);

    if (tableNamesQueue.length >= BATCH_SIZE) {
        // Process queue in batches
        processTableNamesQueue();
    }
}

function setAjaxData(object = null) {
    var data = {
        'sysLangId': MdsConfig.sysLangId,
    };
    data[MdsConfig.csrfTokenName] = $('meta[name="X-CSRF-TOKEN"]').attr('content');
    if (object != null) {
        Object.assign(data, object);
    }
    return data;
}
</script>



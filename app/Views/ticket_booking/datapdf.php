<html>
<head>
<title><?= esc($baseSettings->site_title); ?></title>
</head>
<body>
<div id="element-to-print">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 padding-top">
<div class="card">
	<div class="card-header p-4">
		<img class="d-inline-block" src="data:image/png;base64,<?= base64_encode(file_get_contents(base_url('assets/logo_abc.png'))) ?>" style="width: 130px;height: 65px;">
		<div class="float-right"> <h3 class="mb-0"><?= $tickets[0]['invoice_no'];?>
		</h3>
			Booking Date: <?= $tickets[0]['booking_date'];?></div>
	</div>
	
	<div class="card-body">
		<div class="row">
		<h3 style="text-align:center;font-size: 18px;font-weight: bold;width:100%;color:#d1274b;"><?= trans("ticket_booking_invoice"); ?><h3>
		</div>
		<div class="row mb-4">
			<div style="width : 100% !important">
				<span id="bill_To" class=".span_below">
					<table width="100%" style="font-size: 14px;">
						<tr>
							<td style="width:20%;text-align: left;"><?= trans("event_name"); ?></td>
							<td style="width:5%;font-weight: bold;">:</td>
							<td style="width:25%;text-align: left;font-weight: bold;"><?= $tickets[0]['event_name'];?></td>
							<td style="width:20%;text-align: left;"><?= trans("name"); ?></td>
							<td style="width:5%;font-weight: bold;">:</td>
							<td style="width:25%;text-align: left;font-weight: bold;"><?= $tickets[0]['username'];?></td>
						</tr>
						<tr>
							<td style="width:20%;text-align: left;"><?= trans("event_location"); ?></td>
							<td style="width:5%;font-weight: bold;">:</td>
							<td style="width:25%;text-align: left;font-weight: bold;"><?= $tickets[0]['event_location'];?></td>
							<td style="width:20%;text-align: left;"><?= trans("email"); ?></td>
							<td style="width:5%;font-weight: bold;">:</td>
							<td style="width:25%;text-align: left;font-weight: bold;"><?= $tickets[0]['email'];?></td>
						</tr>
						<tr>
							<td style="width:20%;text-align: left;"><?= trans("event_start_time"); ?></td>
							<td style="width:5%;font-weight: bold;">:</td>
							<td style="width:25%;text-align: left;font-weight: bold;"><?= $tickets[0]['event_start_time'];?></td>
							<td style="width:20%;text-align: left;"><?= trans("phone"); ?></td>
							<td style="width:5%;font-weight: bold;">:</td>
							<td style="width:25%;text-align: left;font-weight: bold;"><?= $tickets[0]['phone_number'];?></td>
						</tr>
						<tr>
							<td style="width:20%;text-align: left;"><?= trans("event_end_time"); ?></td>
							<td style="width:5%;font-weight: bold;">:</td>
							<td style="width:25%;text-align: left;font-weight: bold;"><?= $tickets[0]['event_end_time'];?></td>
							<td style="width:20%;text-align: left;"><?= trans("transaction_id"); ?></td>
							<td style="width:5%;font-weight: bold;">:</td>
							<td style="width:25%;text-align: left;font-weight: bold;"><?= $tickets[0]['transaction_id'];?></td>
						</tr>
						<tr>
							<td style="width:20%;text-align: left;"><?= trans("payment_method"); ?></td>
							<td style="width:5%;font-weight: bold;">:</td>
							<td style="width:25%;text-align: left;font-weight: bold;"><?= getPaymentMethod($tickets[0]['payment_method']); ?></td>
							<td style="width:20%;text-align: left;"><?= trans("payment_status"); ?></td>
							<td style="width:5%;font-weight: bold;">:</td>
							<td style="width:25%;text-align: left;font-weight: bold;"><?= getPaymentStatus($tickets[0]['payment_status']);?></td>
						</tr>
					</table>
				</span>
			</div>
		</div>
		<div class="table-responsive-sm">
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="center">#</th>
						<th><?= trans("seat_numbers"); ?></th>
						<th class="right"><?= trans("total_seats"); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<?php 
						$seatdataArray = $tickets[0]['reference_seats'];
						$seatdataReference = str_replace(['[', ']', '"'], '', $seatdataArray);
						$seatdata =  str_replace(',', ', ', $seatdataReference);
						?>
						<td class="center">1</td>
						<td class="left"><?= $seatdata;?></td>
						<td class="right"><?= $tickets[0]['totalSeats'];?></td>
				</tbody>
			</table>
		</div>
        <img src="data:image/png;base64,<?= base64_encode(file_get_contents(base_url().'/assets/media/qrcode/'.$tickets[0]['transaction_id'].'.png')) ?>" style="width: 125px; height: 125px;">
			<div class="float-right">
				<table class="table table-clear">
					<tbody>
						<tr>
							<td class="left">
								<strong class="text-dark"><?= trans("subtotal"); ?></strong>
							</td>
							<td class="right"><?= $defaultCurrency->symbol; ?><?= $tickets[0]['subtotalTicketPrice'];?></td>
						</tr>
						<tr>
							<td class="left">
								<strong class="text-dark"><?= trans("discount"); ?>&nbsp;(<?= $tickets[0]['discountPercentage'];?>%)</strong>
							</td>
							<td class="right"><?= $defaultCurrency->symbol; ?><?= $tickets[0]['discountPrice'];?></td>
						</tr>
						<tr>
							<td class="left">
								<strong class="text-dark"><?= trans("total"); ?></strong>
							</td>
							<td class="right">
								<strong class="text-dark"><?= $defaultCurrency->symbol; ?><?= $tickets[0]['totalTicketPrice'];?></strong>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

	</div>

	<div class="card-footer bg-white center">
		<p class="mb-0"><?= trans("thank_you_for_joining"); ?></p>
	</div>
</div>
</div>
</body>
<style>
/* Custom styles for layout and text */
.col-lg-4 {
    flex: 0 0 33.333333%; /* Adjust the percentage as needed */
    max-width: 33.333333%; /* Adjust the percentage as needed */
}

.col-sm-5 {
    flex: 0 0 31.666667%; /* Adjust the percentage as needed */
    max-width: 31.666667%; /* Adjust the percentage as needed */
}

.ml-auto {
    margin-left: auto !important;
}

.table-clear {
    clear: both !important;
}

.left {
    text-align: left !important;
}

.text-dark {
    color: #343a40 !important; /* Adjust the color based on your design */
}

/* Custom styles for a table and striped rows */
.table {
    width: 100% !important;
    max-width: 100% !important;
    margin-bottom: 1rem !important;
    background-color: transparent !important;
    border-collapse: collapse !important;
    border-spacing: 0 !important;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, 0.05) !important; /* Adjust the color based on your design */
}

.table th,
.table td {
    padding:0.5rem 1rem !important; /* Adjust the padding based on your design */
    vertical-align: top !important;
    border-top: 1px solid #dee2e6 !important;
}

.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6 !important;
}

.table tbody+tbody {
    border-top: 2px solid #dee2e6 !important;
}

/* Custom class for making a table responsive for small screens */
.table-responsive-sm {
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch !important;
    max-width: 100% !important;
}

/* Custom class for defining a row-like container */
.row {
    display: flex;
    flex-wrap: wrap;
    margin-right: 0px !important; /* Adjust the value based on your design */
    margin-left: 0px !important; /* Adjust the value based on your design */
}


/* Custom classes for defining column width */
.col-sm-6 {
    flex: 0 0 50% !important; /* Adjust the percentage as needed */
    max-width: 50% !important; /* Adjust the percentage as needed */
}

.col-lg-6 {
    flex: 0 0 50% !important; /* Adjust the percentage as needed */
    max-width: 50% !important; /* Adjust the percentage as needed */
}

.mb-4 {
    margin-bottom: 1.5rem !important; /* You can adjust the value based on your design */
}
.p-4 {
	 padding: 1.5rem !important; 
}
.float-right {
    float: right !important;
}

/* Extra-large screens (xl) and up */
@media (min-width: 1200px) {
    .col-xl-12 {
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }
}

/* Large screens (lg) and up */
@media (min-width: 992px) {
    .col-lg-12 {
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }
}

/* Medium screens (md) and up */
@media (min-width: 768px) {
    .col-md-12 {
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }
}

/* Small screens (sm) and up */
@media (min-width: 576px) {
    .col-sm-12 {
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }
}

/* Extra-small screens (xs) and up */
.col-12 {
    flex: 0 0 100% !important;
    max-width: 100% !important;
}

.padding
{
	padding-left: 2rem !important;
	padding-right: 2rem !important;
	padding-top: 1rem !important;
}

.card 
{
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1)  !important;
	border: 2px solid #d1274b !important;
}

.card-header 
{
    background-color: #fff;
    border-bottom: 1px solid #e6e6f2;
}

.right
{
	text-align : right !important;
}

.center
{
	text-align : center;
}

.span_star
{
	color: red;
	font-size: 15px;
	font-weight: bold;
}

.h6_text
{
	font-size : 12px;
}

.createPDF
{
    font-size: 12px;
}

.padding-top
{
	padding-top : 1rem !important;
}
</style>
</html>
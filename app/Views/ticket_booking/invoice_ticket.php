<html>
<head>
<link rel="stylesheet" href="<?= base_url('assets/admin/vendor/font-awesome/css/font-awesome.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>"/>
<script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/html2pdf/html2pdf.bundle.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/html2pdf/html2pdf.bundle.min.js'); ?>"></script>

<title><?= esc($baseSettings->site_title); ?></title>
</head>
<body>
<div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding">
	<div class="row">
		<div class='col-lg-6 col-md-6 col-sm-6'>
			<span style="font-size:16px;color:#d1274b;font-weight:bold;">Download The Invoice For Future Purpose</span>
		</div>
	
		<div class='col-lg-6 col-md-6 col-sm-6' style="text-align:right">
			<button class="btn btn-danger" class="html2PdfConverter" onclick="createPDF()"><i class="fa fa-file-pdf-o"></i>&nbsp;Download Invoice</button>
		</div>
	</div>
</div>
<?php 
$this->session = \Config\Services::session();
echo $this->session->eventID;?>
<div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding">
<div class="card">
	<div class="card-header p-4">
		<img class="d-inline-block" src="<?= getFavicon(); ?>" style="width: 130px;height: 65px;">
		<div class="float-right"> <h3 class="mb-0"><?= $tickets[0]['invoice_no'];?></h3>
			Booking Date: <?= $tickets[0]['booking_date'];?></div>
	</div>
	
	<div class="card-body">
		<div class="row">
		<h3 style="text-align:center;font-size: 18px;font-weight: bold;width:100%;color:#d1274b;"><?= trans("ticket_booking_invoice"); ?><h3>
		</div>
		<div class="row mb-4">
			<div class="col-sm-6 col-lg-6">
				<span id="bill_To" class=".span_below">
					<table width="100%" style="margin-left: 4px;font-size: 14px;">
						<tr>
							<td style="width:30%;text-align: left;"><?= trans("event_name"); ?></td>
							<td style="width:10%;font-weight: bold;">:</td>
							<td style="width:60%;text-align: left;font-weight: bold;"><?= $tickets[0]['event_name'];?></td>
						</tr>
						<tr>
							<td style="width:30%;text-align: left;"><?= trans("event_location"); ?></td>
							<td style="width:10%;font-weight: bold;">:</td>
							<td style="width:60%;text-align: left;font-weight: bold;"><?= $tickets[0]['event_location'];?></td>
						</tr>
						<tr>
							<td style="width:30%;text-align: left;"><?= trans("event_start_time"); ?></td>
							<td style="width:10%;font-weight: bold;">:</td>
							<td style="width:60%;text-align: left;font-weight: bold;"><?= $tickets[0]['event_start_time'];?></td>
						</tr>
						<tr>
							<td style="width:30%;text-align: left;"><?= trans("event_end_time"); ?></td>
							<td style="width:10%;font-weight: bold;">:</td>
							<td style="width:60%;text-align: left;font-weight: bold;"><?= $tickets[0]['event_end_time'];?></td>
						</tr>
						<tr>
							<td style="width:30%;text-align: left;"><?= trans("payment_method"); ?></td>
							<td style="width:10%;font-weight: bold;">:</td>
							<td style="width:60%;text-align: left;font-weight: bold;"><?= getPaymentMethod($tickets[0]['payment_method']); ?></td>
						</tr>
					</table>
				</span>
			</div>
			
			<div class="col-sm-6 col-lg-6">
				  <span id="bill_To" class=".span_below">
					<table width="100%" style="margin-left: 4px;font-size: 14px;">
						<tr>
							<td style="width:30%;text-align: left;"><?= trans("name"); ?></td>
							<td style="width:10%;font-weight: bold;">:</td>
							<td style="width:60%;text-align: left;font-weight: bold;"><?= $tickets[0]['username'];?></td>
						</tr>
						<tr>
							<td style="width:30%;text-align: left;"><?= trans("email"); ?></td>
							<td style="width:10%;font-weight: bold;">:</td>
							<td style="width:60%;text-align: left;font-weight: bold;"><?= $tickets[0]['email'];?></td>
						</tr>
						<tr>
							<td style="width:30%;text-align: left;"><?= trans("phone"); ?></td>
							<td style="width:10%;font-weight: bold;">:</td>
							<td style="width:60%;text-align: left;font-weight: bold;"><?= $tickets[0]['phone_number'];?></td>
						</tr>
						<tr>
							<td style="width:30%;text-align: left;"><?= trans("transaction_id"); ?></td>
							<td style="width:10%;font-weight: bold;">:</td>
							<td style="width:60%;text-align: left;font-weight: bold;"><?= $tickets[0]['transaction_id'];?></td>
						</tr>
						<tr>
							<td style="width:30%;text-align: left;"><?= trans("payment_status"); ?></td>
							<td style="width:10%;font-weight: bold;">:</td>
							<td style="width:60%;text-align: left;font-weight: bold;"><?= getPaymentStatus($tickets[0]['payment_status']);?></td>
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
					</tr>
				</tbody>
			</table>
		</div>
		<div class="row">
			<div class="col-lg-4 col-sm-5">
				<img src = "<?= base_url().'/assets/media/qrcode/'.$tickets[0]['transaction_id'].'.png' ?>" alt ="QR Image" width="125" height="125">
			</div>
			<div class="col-lg-4 col-sm-5 ml-auto">
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
	</div>

	<div class="card-footer bg-white center">
		<p class="mb-0"><?= trans("thank_you_for_joining"); ?></p>
	</div>
</div>
<h6 class="h6_text right"><span class="span_star">*</span>&nbsp;<?= trans("check_your_email_for_summary"); ?></h6>
</div>
<?php 
$this->session->remove('mds_ses_id');
$this->session->remove('mds_ses_role_id');
?>
<!-- Below is the content for exporting in pdf

--------------START---------
-->
<div style='display : none;'>
<div id="element-to-print">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 padding-top">
<div class="card">
	<div class="card-header p-4">
		<img class="d-inline-block" src="<?= getFavicon(); ?>" style="width: 130px;height: 65px;">
		<div class="float-right"> <h3 class="mb-0"><?= $tickets[0]['invoice_no'];?></h3>
			Booking Date: <?= $tickets[0]['booking_date'];?></div>
	</div>
	
	<div class="card-body">
		<div class="row">
		<h3 style="text-align:center;font-size: 18px;font-weight: bold;width:100%;color:#d1274b;"><?= trans("ticket_booking_invoice"); ?><h3>
		</div>
		<div class="row mb-4">
			<div class="col-sm-6 col-lg-6">
				<span id="bill_To" class=".span_below">
					<table width="100%" style="margin-left: 4px;font-size: 14px;">
						<tr>
							<td style="width:30%;text-align: left;"><?= trans("event_name"); ?></td>
							<td style="width:10%;font-weight: bold;">:</td>
							<td style="width:60%;text-align: left;font-weight: bold;"><?= $tickets[0]['event_name'];?></td>
						</tr>
						<tr>
							<td style="width:30%;text-align: left;"><?= trans("event_location"); ?></td>
							<td style="width:10%;font-weight: bold;">:</td>
							<td style="width:60%;text-align: left;font-weight: bold;"><?= $tickets[0]['event_location'];?></td>
						</tr>
						<tr>
							<td style="width:30%;text-align: left;"><?= trans("event_start_time"); ?></td>
							<td style="width:10%;font-weight: bold;">:</td>
							<td style="width:60%;text-align: left;font-weight: bold;"><?= $tickets[0]['event_start_time'];?></td>
						</tr>
						<tr>
							<td style="width:30%;text-align: left;"><?= trans("event_end_time"); ?></td>
							<td style="width:10%;font-weight: bold;">:</td>
							<td style="width:60%;text-align: left;font-weight: bold;"><?= $tickets[0]['event_end_time'];?></td>
						</tr>
					</table>
				</span>
			</div>
			
			<div class="col-sm-6 col-lg-6">
				  <span id="bill_To" class=".span_below">
					<table width="100%" style="margin-left: 4px;font-size: 14px;">
						<tr>
							<td style="width:30%;text-align: left;"><?= trans("name"); ?></td>
							<td style="width:10%;font-weight: bold;">:</td>
							<td style="width:60%;text-align: left;font-weight: bold;"><?= $tickets[0]['username'];?></td>
						</tr>
						<tr>
							<td style="width:30%;text-align: left;"><?= trans("email"); ?></td>
							<td style="width:10%;font-weight: bold;">:</td>
							<td style="width:60%;text-align: left;font-weight: bold;"><?= $tickets[0]['email'];?></td>
						</tr>
						<tr>
							<td style="width:30%;text-align: left;"><?= trans("phone"); ?></td>
							<td style="width:10%;font-weight: bold;">:</td>
							<td style="width:60%;text-align: left;font-weight: bold;"><?= $tickets[0]['phone_number'];?></td>
						</tr>
						<tr>
							<td style="width:30%;text-align: left;"><?= trans("transaction_number"); ?></td>
							<td style="width:10%;font-weight: bold;">:</td>
							<td style="width:60%;text-align: left;font-weight: bold;"><?= $tickets[0]['transaction_id'];?></td>
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
						<td class="center">1</td>
						<td class="left"><?= $tickets[0]['reference_seats'];?></td>
						<td class="right"><?= $tickets[0]['totalSeats'];?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="row">
			<div class="col-lg-4 col-sm-5">
				<img src = "<?= base_url().'/assets/media/qrcode/'.$tickets[0]['transaction_id'].'.png' ?>" alt ="QR Image" width="125" height="125">
			</div>
			<div class="col-lg-4 col-sm-5 ml-auto">
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
	</div>

	<div class="card-footer bg-white center">
		<p class="mb-0"><?= trans("thank_you_for_joining"); ?></p>
	</div>
</div>
<h6 class="h6_text right"><span class="span_star">*</span>&nbsp;<?= trans("check_your_email_for_summary"); ?></h6>
</div>
    </div>
    </div>
<!-- 
--------------END---------
-->
</body>
<style>

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

h3 {
    font-size: 20px;
}

.right
{
	text-align : right;
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

<script>
function redirectToHome()
{
	window.location.href = '<?= generateUrl("settings", "ticket_invoice"); ?>';
}

function createPDF() 
{
	var element = document.getElementById('element-to-print');
	html2pdf(element, {
		margin:0,
		padding:0,
		filename: '<?=  $tickets[0]['username']."-".$tickets[0]['invoice_no'];?>',
		image: { type: 'jpeg', quality: 1 },
		html2canvas: { scale: 1,  logging: true },
		jsPDF: { unit: 'in', format: 'A4', orientation: 'L' },
		class: createPDF
	});
};
</script>
</html>


<?php 
if(!empty($tickets_epayment))
{
?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title"><?= trans('e-payment-report'); ?>&nbsp;-&nbsp;<?= $tickets->event_name?></h3>
                </div>
				<div class="right">
                    <a href="<?= adminUrl('ticket-manager'); ?>" class="btn btn-danger btn-add-new">
                        <i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;<?= trans('back'); ?>
                    </a>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped cs_datatable_lang" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= trans('id'); ?></th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Total Tickets</th>
                                    <th>Reference Seats</th>
                                    <th>Total</th>
                                    <th>Booking Date</th>
                                    <th class="th-options"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
								<?php 
									
									if(!empty($tickets_epayment))
									{
										$resultArray = [];

										foreach ($tickets_epayment as $booking) 
										{
											$seatsArray = json_decode($booking->reference_seats_original);

											$key = $booking->booking_member_id . '-' . $booking->random_ref_no. '-' . $booking->eventTotalPrice . '-' . $booking->event_total_tickets . '-' . implode(',', $seatsArray);

											if (!array_key_exists($key, $resultArray)) 
											{
												$resultArray[$key] = $booking;
											}
										}

										$resultArray = array_values($resultArray);
									} ?>
                                <?php if (!empty($resultArray)):
									$i= 1; 
                                    foreach ($resultArray as $item): ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= esc($item->username); ?></td>
                                            <td><?= esc($item->email); ?></td>
                                            <td><?= esc($item->phone_number); ?></td>
                                            <td><?= esc($item->event_total_tickets); ?></td>
                                            <td><?= esc($item->reference_seats); ?></td>
                                            <td><?= $defaultCurrency->symbol; ?><?= esc($item->eventTotalPrice); ?></td>
                                            <td><?= formatDate($item->ticket_booking_date); ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?><span class="caret"></span></button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li class="green-hover" style="background: #00c300 !important;"><a class="green-hover" style="color: white !important;" href="<?= adminUrl('edit-ticket-epayment-details/' . $item->random_ref_no); ?>"><i class="fa fa-check-circle option-icon"></i><?= trans('approve'); ?></a></li>
														
														<li class="red-hover" style="background: red !important;margin-top: 5px !important;"><a class="red-hover" href="javascript:void(0)" style="color: white !important;" onclick="deleteItem('TicketController/rejectEpaymentApproval','<?= $item->random_ref_no; ?>','<?= trans("confirm_reject", true); ?>');"><i class="fa fa-times-circle option-icon"></i><?= trans('reject'); ?></a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php 
									$i++;
									endforeach;
                                endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } 
else
{
?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title"><?= trans('e-payment-report'); ?></h3>
                </div>
				
				<div class="right">
                    <a href="<?= adminUrl('ticket-manager'); ?>" class="btn btn-danger btn-add-new">
                        <i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;<?= trans('back'); ?>
                    </a>
                </div>
            </div>
			<div class="row">
				<div class="col-12" style="text-align : center;">
					<h3>No Relevant Data</h3>
				</div>
			</div>
        </div>
    </div>
</div>
<?php } ?>
<style>
.red-hover:hover
{
	background : red !important;
}
.green-hover:hover
{
	background : #00c300 !important;
}
</style>

<?php 
$tickets = helperGetSession('tickets');
		
if (!empty($tickets)) 
{ 

$data_order = $tickets[0];
$seatdataArray = $data_order['reference_seats'];
$seatdataReference = str_replace(['[', ']', '"'], '', $seatdataArray);
$seatdata =  str_replace(',', ', ', $seatdataReference);

$encryptionKey = '058e800881aef2fe2b16360ccf6418aae614c11ac72d3d9872c08d480d10e914';
$originalString = $data_order['invoice_no'];
function encryptString($string, $key)
{
    $cipher = "aes-256-cbc";
    $ivLength = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivLength);

    $encrypted = openssl_encrypt($string, $cipher, $key, 0, $iv);

    // Combine the IV and encrypted data
    return base64_encode($iv . $encrypted);
}

$encryptedString = encryptString($originalString, $encryptionKey);


?>
<script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
<script>
callGenerator();
function callGenerator() {
	var data = {
    'data_img': <?php echo json_encode($data_order['transaction_id']); ?>,
    'data': <?php echo json_encode($encryptedString); ?>
};
var data_pdf = {
    'data_id': <?php echo json_encode($data_order['transaction_id']); ?>,
	 'data_mem_id': <?php echo json_encode($data_order['member_booking_id']); ?>
};


    $.ajax({
        type: 'POST',
        url: MdsConfig.baseURL + '/TicketBookingController/generate_qrcode',	
        data: setAjaxData(data),
		 dataType: 'json', // Set the dataType to 'json'
        success: function (response) {
            if (response) {
                
            }
        }
    });
	
	$.ajax({
        type: 'POST',
        url: MdsConfig.baseURL + '/TicketBookingController/generatePdf',	
        data: setAjaxData(data_pdf),
        success: function (response) {
            if (response) {
                
            }
        }
    });
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


<?php 
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
			'content_7' => "E-payment is approved by organization, you can download your invoice from profile,Thank you for joining our event! If you have any questions or need assistance, feel free to reach out. See you at the event!",
		]),
		'email_priority' => 1,
		'email_subject' => 'Ticket Order Confirmation',
		'template_path' => 'email/ticket_order',
		'pdf_file' => $data_order['transaction_id']
];

addToEmailQueue($emailData);

helperDeleteSession('tickets');
helperDeleteSession('mds_transaction_insert_id');
}
?>
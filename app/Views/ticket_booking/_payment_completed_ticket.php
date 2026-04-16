<script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
<?php 
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
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-confirm" style="padding-top:0px !important;">
                    <div class="circle-loader">
                        <div class="checkmark draw"></div>
                    </div>
                    <h1 class="title"><?= trans("msg_payment_completed"); ?></h1>
                    <?php if(!empty(helperGetSession('modesy_membership_request_type')) && helperGetSession('modesy_membership_request_type') == 'booking'): ?>
                    <p class="m-t-15 text-success"><?= trans("msg_ticket_booked_successfully"); ?></p>
					
                    <?php else: ?>
                        <p class="m-t-15 text-success"><?= trans("msg_start_selling"); ?></p>
                    <?php endif;
                    if(!empty($transactionNumber)): ?>
                        <p class="p-order-number"><?= trans("transaction_number"); ?><br><?= esc($transactionNumber); ?></p>
                    <?php endif;
                    if($method != 'gtw'): ?>
                        <p class="p-complete-payment"><?= trans("msg_bank_transfer_text_transaction_completed"); ?></p>
                        <div class="bank-account-container">
                            <?= $paymentSettings->bank_transfer_accounts; ?>
                        </div>
                    <?php endif; ?>
                    <div class="m-t-45 text-center">
                        <a href="<?= base_url('invoice-ticket/'. $transaction->ticket_id); ?>" class="btn btn-lg btn-info color-white" target="_blank"><i class="icon-text-o"></i>&nbsp;&nbsp;<?= trans("view_invoice"); ?></a>
                        <?php if(!empty(helperGetSession('modesy_membership_request_type')) && helperGetSession('modesy_membership_request_type') == 'booking'): ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
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
		'template_path' => 'email/ticket_order',
		'pdf_file' => $data_order['transaction_id']
];

addToEmailQueue($emailData);
?>
<style>
    .circle-loader{margin-bottom:3.5em;border:1px solid rgba(0,0,0,0.2);border-left-color:#5cb85c;animation:loader-spin 1.2s infinite linear;position:relative;display:inline-block;vertical-align:top;border-radius:50%;width:7em;height:7em}.load-complete{-webkit-animation:none;animation:none;border-color:#5cb85c;transition:border 500ms ease-out}.checkmark{display:none}.checkmark.draw:after{animation-duration:800ms;animation-timing-function:ease;animation-name:checkmark;transform:scaleX(-1) rotate(135deg)}.checkmark:after{opacity:1;height:3.5em;width:1.75em;transform-origin:left top;border-right:3px solid #5cb85c;border-top:3px solid #5cb85c;content:'';left:1.75em;top:3.5em;position:absolute}@keyframes loader-spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}@keyframes checkmark{0%{height:0;width:0;opacity:1}20%{height:0;width:1.75em;opacity:1}40%{height:3.5em;width:1.75em;opacity:1}100%{height:3.5em;width:1.75em;opacity:1}}.error-circle{margin-bottom:3.5em;border:1px solid #dc3545;position:relative;display:inline-block;vertical-align:top;border-radius:50%;width:7em;height:7em;line-height:7em;color:#dc3545}.error-circle i{font-size:30px}
</style>
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
helperDeleteSession('is_paypal'); 			
helperDeleteSession('is_epayment'); 		
?>



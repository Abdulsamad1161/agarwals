<script src="<?= base_url('assets/vendor/htm5qr_scanner/html5qrScanner.js'); ?>"></script>

<h1>ABC Ticket QR Reader</h1>
<div class="right" style="margin: 10px;">
	<a href="<?= adminUrl('ticket-manager'); ?>" class="btn btn-danger btn-add-new">
		<i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;<?= trans('back'); ?>
	</a>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                 <div id="reader"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
				<h4>Invoice Number</h4>
				<div class="row row-class" style="padding: 30px !important;">
					<div id="result">
						After Successful scanning Invoice no will be shown here
					</div>
				</div>
            </div>
        </div>
    </div>
</div>

<style>
#reader div img{display : none;}
.row-class
{
	border-radius: 10px !important;
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
	overflow: hidden !important;
	margin: 20px !important;
	border: 2px solid #d1274b !important;
}

#reader
{
	border-radius: 10px !important;
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
	overflow: hidden !important;
	margin: 20px !important;
	border: 2px solid #d1274b !important;
	padding: 7px !important;	
}

#reader_camera_section
{
	padding: 12px 20px !important;
	margin: 8px 0 !important;
	box-sizing: border-box !important;
	background: white !important;
	border: 1px solid #ccc !important;
}

#reader__dashboard_section_csr button
{
	background: #d1274b !important;
	color: white !important;
	border: #d1274b !important;
	padding: 10px !important;
	border-radius: 20px !important;
	font-weight: bold !important;
	margin: 10px !important;
}

#reader__dashboard_section_swaplink
{
	text-decoration: none !important;
	background: #009d00 !important;
	color: white !important;
	padding: 10px !important;
	border-radius: 20px !important;
	margin: 0px !important;
	font-weight: bold !important;
}

h1 {
  text-align: center;
}

.result {
  background-color: green;
  color: #fff;
  padding: 20px;
}

#reader__scan_region {
  background: white;
}

</style>

<script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
<script>
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
			
function onScanSuccess(qrCodeMessage) {
    // Display the scanned result in the result container
    document.getElementById("result").innerHTML =
        '<span class="result">' + qrCodeMessage + "</span>";

    const targetTimeZone = "<?php echo $timezone;?>";
	const currentTimeInTargetZone = new Date().toLocaleTimeString("en-US", { timeZone: targetTimeZone });
    var data = {
				'row_value': qrCodeMessage,
				'time': currentTimeInTargetZone,
			};
			$.ajax({
				type: 'POST',
				url: MdsConfig.baseURL + '/TicketController/updateMemberCheckInTime',    
				data: setAjaxData(data),
				dataType: 'json',
				success: function (response) {
					if (response == 'updated') {
						swal({
						 title: "Success!",
						 text: "Attendee Marked for the event",
						 type: "success",
						 confirmButtonColor: "#DD6B55",
						 confirmButtonText: "ok",
						 }).then((result) => {
							 if(result){
									window.location.reload();
									return ;
							 }
						});
					}
					else if(response == 'available')
					{
						swal({
						 title: "Warning!",
						 text: "Aldready checked In",
						 type: "info",
						 confirmButtonColor: "#DD6B55",
						 confirmButtonText: "ok",
						 }).then((result) => {
							 if(result){
									window.location.reload();
									return ;
							 }
						});
					}
					else
					{
						swal({
						 title: "Error",
						 text: "No data found,Failed to scan the code",
						 type: "warning",
						 confirmButtonColor: "#DD6B55",
						 confirmButtonText: "ok",
						 }).then((result) => {
							 if(result){
									window.location.reload();
									return ;
							 }
						});
					}
			},
        error: function(xhr, textStatus, errorThrown) {
            // Handle any AJAX errors here
            console.error("AJAX error:", errorThrown);
        }
    });
}

function onScanError(errorMessage) {
	console.error(errorMessage);
}

// Setting up Qr Scanner properties
var html5QrCodeScanner = new Html5QrcodeScanner("reader", {
  fps: 10,
  qrbox: 250
});

// in
html5QrCodeScanner.render(onScanSuccess, onScanError);

</script>
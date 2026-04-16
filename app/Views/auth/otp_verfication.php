	<div class="modal" id="otpModal" role="dialog" style="display : none;">
	<div class="modal-dialog modal-dialog-centered login-modal" role="document">
	<div class="modal-content" style="border-radius: 15px !important;">
	<div class="auth-box-modal-login">
	<button type="button" class="close" data-dismiss="modal" onclick="goToHomePageRefresh()"><i class="icon-close"></i></button>
	<div class="title-custom">
		<h1 class="picture_gallery_h1"><?= trans("otp_verification"); ?></h1>
	</div>
	<form id="form_login_otp" novalidate="novalidate">
	<div id="result-login-otp" class="font-size-13"></div>
	<div id="confirmation-result-login-otp" class="font-size-13"></div>
	<div class="form-group">
	<input type="text" name="otp" class="form-control" placeholder="<?= trans("otp"); ?>" maxlength="255" required>
	</div>
	<div class="form-group">
	<button type="submit" class="btn btn-md btn-danger btn-block"><?= trans("login"); ?></button>
	</div>
	</form>
	<p class="text-note-p">We have send you the OTP code to your registered email-id, Kindly enter the code in OTP field.</p>
	</div>
	</div>
	
	</div>
	</div>
	<style>
		.text-note-p
		{
			color: black !important;
			font-weight: bold;
			padding: 18px;
		}
	</style>
<script>
	document.addEventListener('DOMContentLoaded', function() {
	  var modal = new bootstrap.Modal(document.getElementById('otpModal'), {
		backdrop: 'static'
	  });
	  modal.show();
	});
	
	function goToHomePageRefresh()
	{
		window.location.href = MdsConfig.baseURL + '/AuthController/redirecthome';
	}
		
		

</script>
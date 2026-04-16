<div id="wrapper">
    <div class="container">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8 col-sm-12">
				<div class="title">
					<h1 class="picture_gallery_h1"><?= trans("abc_member_register_form"); ?></h1>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
        <div class="auth-container">
            <div class="auth-box">
                <div class="row">
                    <div class="col-12">
                        <h1 class="title"><?= trans("register"); ?></h1>
                        <form action="<?= base_url('register-post'); ?>" method="post" id="form_validate" class="validate_terms" <?= $baseVars->recaptchaStatus ? 'onsubmit="checkRecaptchaRegisterForm(this);"' : ''; ?>>
                            <?= csrf_field(); ?>
                            <div class="social-login">
                                <?= view('auth/_social_login', ['orText' => trans("register_with_email")]); ?>
                            </div>
                            <div id="result-register">
                                <?= view('partials/_messages'); ?>
                            </div>
                            <div class="spinner display-none spinner-activation-register">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                            <div class="form-group">
								<label class="control-label"><?= trans("first_name"); ?>:</label>
                                <input type="text" name="first_name" class="form-control auth-form-input" placeholder="<?= trans("first_name"); ?>" value="<?= old("first_name"); ?>" maxlength="255" required>
                            </div>
                            <div class="form-group">
								<label class="control-label"><?= trans("last_name"); ?>:</label>
                                <input type="text" name="last_name" class="form-control auth-form-input" placeholder="<?= trans("last_name"); ?>" value="<?= old("last_name"); ?>" maxlength="255" required>
                            </div>
                            <div class="form-group">
								<label class="control-label"><?= trans("email"); ?>:</label>
                                <input type="email" name="email" class="form-control auth-form-input" placeholder="<?= trans("email_address"); ?>" value="<?= old("email"); ?>" maxlength="255" required>
                            </div>
							<div class="form-group">
								<label class="control-label"><?= trans("phone_number"); ?>:</label>
                                <input type="text" name="phone_number" class="form-control auth-form-input" placeholder="<?= trans("phone_number"); ?>" value="<?= old("phone_number"); ?>" maxlength="255" required>
                            </div>
                            <div class="form-group">
								<label class="control-label"><?= trans("password"); ?>:</label>
								<div class="input-group">
									<input type="password" name="password" id="password" class="form-control auth-form-input" placeholder="<?= trans("password"); ?>" value="<?= old("password"); ?>" minlength="4" maxlength="255" required>
									<div class="input-group-append">
										<span class="input-group-text" style="background-color: #d1274b !important;">
											<i class="fa fa-eye-slash" id="passwordIcon" style="color: white !important;"></i>
										</span>
									</div>
								</div>
                            </div>
                            <div class="form-group">
								<label class="control-label"><?= trans("password_confirm"); ?>:</label>
								<div class="input-group">
									<input type="password" name="confirm_password" id="confirm_password" class="form-control auth-form-input" placeholder="<?= trans("password_confirm"); ?>" maxlength="255" required>
									<div class="input-group-append">
										<span class="input-group-text" style="background-color: #d1274b !important;">
											<i class="fa fa-eye-slash" id="passwordIconCon" style="color: white !important;"></i>
										</span>
									</div>
								</div>
                            </div>
							<div class="form-group">
								<label for="message">Captcha<span class="text-danger"> *</span></label>
								<span class="reload-icon" id="reloadCaptcha" onclick="refreshCaptcha()" style="cursor: pointer; margin-left: 5px;">
									<i class="fa fa-refresh"></i>
								</span>
								<br>
								
								<div class="input-group">
									<!--<input type="hidden" name="captachIndex" id="captachIndex">-->
									<?php /* <img src="<?= base_url('assets/images_agarwal/captcha/captcha1.jpg'); ?>" name="captcha_image" id="captchaImage" data-value="1" style="height: 50px; width: 150px; border: 1px solid #eeee; background: gray;" class="img-fluid"> */ ?>
									<img src="<?= base_url('captcha'); ?>" name="captcha_image" id="captchaImage" data-value="1" style="height: 50px; width: 150px; border: 1px solid #eeee; background: gray;" class="img-fluid">
									&nbsp;&nbsp;&nbsp;&nbsp;
									<span class="font-weight-bold mt-3" style="font-size: 16px">=</span>
									&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="text" class="form-control" name="captcha_text" style="height: 50px;" required id="captcha_text">
								</div>
							</div>
                            <div class="form-group m-t-5 m-b-15">
                                <div class="custom-control custom-checkbox custom-control-validate-input">
                                    <input type="checkbox" class="custom-control-input" name="terms" id="checkbox_terms" required>
                                    <label for="checkbox_terms" class="custom-control-label">I agree to receive email and SMS related to membership, updates and events, and have read and agree to the&nbsp;
                                        <?php $pageTerms = getPageByDefaultName("terms_conditions", selectedLangId());
                                        if (!empty($pageTerms)): ?>
                                            <a href="<?= generateUrl($pageTerms->page_default_name); ?>" class="link-terms" target="_blank"><strong><?= esc($pageTerms->title); ?></strong></a>
                                        <?php endif; ?>
                                    </label>
                                </div>
                            </div>
                            <?php if ($baseVars->recaptchaStatus): ?>
                                <div class="form-group m-b-15">
                                    <div class="display-flex justify-content-center">
                                        <?php reCaptcha('generate'); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
								<div class="col-12" style="text-align : center;">
									<button type="submit" class="btn btn-danger"><?= trans("register"); ?></button>
								</div>
                            </div>
                            <p class="p-social-media m-0 m-t-15"><?= trans("have_account"); ?>&nbsp;<a href="javascript:void(0)" class="link font-600" data-toggle="modal" data-target="#loginModal"><?= trans("login"); ?></a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('passwordIcon').addEventListener('click', function () {
        var passwordInput = document.getElementById('password');
        var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
	
	document.getElementById('passwordIconCon').addEventListener('click', function () {
        var passwordInput = document.getElementById('confirm_password');
        var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
/*	
	document.addEventListener('DOMContentLoaded', function () {
    var captchaImages = [
        { value: 1, src: "<?= base_url('assets/images_agarwal/captcha/captcha1New.jpg'); ?>" },
        { value: 2, src: "<?= base_url('assets/images_agarwal/captcha/captcha2New.jpg'); ?>" }
    ];

    // Index to keep track of the current image
    var currentImageIndex = 0;

    // Function to update captcha image
    function updateCaptchaImage() {
        var captchaImageElement = document.getElementById('captchaImage');
        captchaImageElement.src = captchaImages[currentImageIndex].src;
		document.getElementById('captachIndex').value = captchaImages[currentImageIndex].value;
        captchaImageElement.setAttribute('data-value', captchaImages[currentImageIndex].value);
    }

    // Function to handle reload icon click
    function reloadCaptcha() {
        // Increment the index or reset to 0 if it reaches the end
        currentImageIndex = (currentImageIndex + 1) % captchaImages.length;
        updateCaptchaImage();
    }

    // Initial load
    updateCaptchaImage();

    // Handle reload icon click
    var reloadCaptchaElement = document.getElementById('reloadCaptcha');
    reloadCaptchaElement.addEventListener('click', reloadCaptcha);
});
*/
	// $(document).ready(function(){
		function refreshCaptcha() {
			fetch("<?= base_url('captcha') ?>")
				.then(response => response.json())
				.then(data => {
					document.getElementById("captchaImage").src = data.captcha_base64;
				});
		}

		// Load CAPTCHA when page loads
		refreshCaptcha();
       // });
	</script>
	
<style>
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

.seperator
{
	border: 1px solid #ccc;
}

.text-center-heading
{
	text-align: center;
	font-size: 18px !important;
	padding: 10px;
}

.text-bold
{
	font-weight :bold;
}

.red
{
	color : #d1274b;
}

.text-email
{
	color : blue;
	text-decoration : underline;
}

.auth-container,.below-container
{
	background: #fff !important;
	width: 600px !important;
	max-width: 100% !important;
	border-radius: 6px !important;
	margin: 20px auto !important;
	border: 1px solid #d1274b !important;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
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

@media (max-width: 576px) {

  .box-image 
	{
      max-width: 335px;
    }

}
@media (max-width: 576px) {

  .box-image 
	{
      display : none;
    }

}
</style>
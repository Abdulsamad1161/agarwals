<div id="wrapper">
    <div class="container">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8 col-sm-12">
				<div class="title">
					<h1 class="picture_gallery_h1"><?= trans("registration_successfull"); ?></h1>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
        <div class="auth-container">
            <div class="auth-box">
                <div class="row">
                    <div class="col-12">
					<div class="row">
                        <div class="col-6"><img src="<?= base_url('assets/images_agarwal/registration_successful.png'); ?>" style= "max-width : 250px;"></div>
                        <div class="col-6" style="display : flex; align-items: center !important;"><h1 class="title text-success"><?= trans("msg_register_success"); ?></h1></div>
						</div>
						<p class="text-center" style="font-size: 15px;">
                            <?= trans("msg_thank_you_join_abc_few_steps_ahead"); ?>
                        </p>
						<p class="text-center" style="font-size: 15px;">
                            <?= trans("you_can_update_your_profile"); ?>
                        </p>
                        <p class="text-center" style="font-size: 15px;">
                            <?= trans("msg_send_confirmation_email"); ?>
                        </p>
                        <div class="form-group m-t-15">
							<div class="col-12" style="text-align : center;">
								<button type="submit" class="btn btn-danger" onclick="sendActivationEmail('<?= esc($user->token); ?>', 'register');"><i class="fa fa-envelope" style="font-size: 15px;" aria-hidden="true"></i>&nbsp;&nbsp;<?= trans("resend_activation_email"); ?></button>
							</div>
                        </div>
                        <div id="confirmation-result-register"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

.auth-container,.below-container
{
	background: #fff !important;
	width: 600px !important;
	max-width: 100% !important;
	border-radius: 6px !important;
	margin: 20px auto !important;
	border: 1px solid #d1274b !important;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
	min-height : 410px !important;
	padding : 10px;
}

.auth-box
{
	width: 600px !important;
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
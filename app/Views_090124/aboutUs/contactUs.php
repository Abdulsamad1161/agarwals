<?php
use App\Models\SettingsModel;
$this->settingsModel = new SettingsModel();
$settings = $this->settingsModel->getAllSettingsData();
?>
<div class="banner">
    <div class="dark-overlay"></div>
	<img src="<?= base_url('assets/images_agarwal/contactUS.jpeg'); ?>" alt="Background Image" class="background-image">
	<div class="content">
    <div class="centered-text">
        <h1 id="typing-animation"></h1>
    </div>
	<div class="centered-text_1">
        <h5 id="">Mississauga, Ontario, Canada</h5>
    </div>
    </div>
    <div class="content_1" id="contactUs">
		<div class="col-md-5 animate-slide-in-left">
			<div class="left-content">
				<div class="left-content-inner text-center">
					<div class="phone details">
						<div class="icon-wrapper"><i class="fa fa-phone custom-icon"><span class="fix-editor">&nbsp;</span></i></div>
						<div class="topic">Phone</div>
						<div class="text-one"><?= esc($settings->contact_phone);?></div>
					</div>
					<br>
					<div class="email details">
						<div class="icon-wrapper"><i class="fa fa-envelope custom-icon"><span class="fix-editor">&nbsp;</span></i></div>
						<div class="topic">Email</div>
						<div class="text-one"><?= esc($settings->contact_email);?></div>
					</div>
					<br>
					<br>
					<div class="connect-us">
						<div class="topic-2 mb-3">Connect with us</div>
						<?php if (!empty($settings->facebook_url)): ?>
							<div class="icon-wrapper"><a href= "<?= $settings->facebook_url; ?>"  target="_blank"><i class="fa fa-facebook facebook custom-icon-other"><span class="fix-editor">&nbsp;</span></i></a></div>
						<?php endif; ?>

						<?php if (!empty($settings->instagram_url)): ?>
							<div class="icon-wrapper"><a href= "<?= $settings->instagram_url; ?>"  target="_blank" style="color: white !important;"><i class="fa fa-instagram instagram custom-icon-other"><span class="fix-editor">&nbsp;</span></i></a></div>
						<?php endif; ?>

						<?php if (!empty($settings->twitter_url)): ?>
							<div class="icon-wrapper"><a href= "<?= $settings->twitter_url; ?>"  target="_blank"><i class="fa fa-twitter twitter custom-icon-other"><span class="fix-editor">&nbsp;</span></i></a></div>
						<?php endif; ?>
					</div>
				</div>
			</div>

		</div>
			
		<div class="col-md-6 animate-slide-in-right">
			<div class="right-content">
				<div class="right-content-inner">
					<h3 class="mb-4 send-msg">Send Us Message</h3>
					<form action="<?= base_url('SponsorshipController/sendContactUSPost'); ?>" method="post" id="contactUsForm">
						 <?= csrf_field(); ?>
						<div class="row">
							<div class="col-md-6 col-lg-6 col-sm-12">
								<div class="form-group">
									<label for="name"><?= trans('name');?><span class="text-danger"> *</span></label>
									<input type="text" class="form-control form-input" id="name" name="name" placeholder = "<?= trans('name');?>" required>
								</div>
							</div>
							<div class="col-md-6 col-lg-6 col-sm-12">
								<div class="form-group">
									<label for="email"><?= trans('email');?><span class="text-danger"> *</span></label>
									<input type="email" class="form-control form-input" id="email" name="email" placeholder = "<?= trans('email');?>" required>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6 col-lg-6 col-sm-12">
								<div class="form-group">
									<label for="phone"><?= trans('phone');?><span class="text-danger"> *</span></label>
									<input type="text" class="form-control form-input" id="phone" name="phone" placeholder = "<?= trans('phone');?>" required>
								</div>
							</div>
							<div class="col-md-6 col-lg-6 col-sm-12">
								<div class="form-group">
									<label for="subject"><?= trans('subject');?><span class="text-danger"> *</span></label>
									<input type="text" class="form-control form-input" id="subject" name="subject" placeholder = "<?= trans('subject');?>" required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="message"><?= trans('message');?><span class="text-danger"> *</span></label>
							<textarea class="form-control form-input" id="message" name="message" rows="4" placeholder = "<?= trans('message');?>" required></textarea>
						</div>
						<input type="text" id="email_address" name="email_address" style="display: none;">
						<button type="submit" class="btn btn-danger btn-radius btn-block"><?= trans('submit');?></button>
					</form>
				</div>
			</div>
		</div>

    </div>
</div>

<script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>

<script>
	document.addEventListener('DOMContentLoaded', function() 
	{
		const text = 'CONTACT US';
		const typingAnimationElement = document.getElementById('typing-animation');
		let index = 0;

		function type() 
		{
			if (index < text.length) 
			{
				typingAnimationElement.textContent += text.charAt(index);
				index++;
				setTimeout(type, 100);
			} 
			else 
			{
				setTimeout(function() 
				{
					typingAnimationElement.textContent = '';
					index = 0;
					type();
				}, 2000); // Pause for 2 seconds before repeating
			}
		}

		type();
    });
	
	$(document).ready(function() {
    $('#contactUsForm').submit(function(event) {
			event.preventDefault(); // Preventing default form submission

			$.ajax({
				type: 'POST',
				url: $(this).attr('action'), 
				data: $(this).serialize(),
				dataType: 'json',
				success: function(response) {
					if (response == 'updated'){
						swal({
						title: 'Submitted Successfully!',
						text: 'Thank you, Our Team Will connect you shortly.'
						}).then(function() {
							 window.location.reload();
						});
					} 
					else if(response == 'spam')
					{
						swal({
						title: 'Sorry!',
						text: 'You are not allowed to submit the form!'
						}).then(function() {
							window.location.reload();
						});
					}
					else {
						swal({
							title: 'Submission Failed!',
							text: 'Server reported a failure.',
						});
					}
				},
				error: function(xhr, status, error) {
					swal({
						title: 'Submission Failed!',
						text: 'Kindly check the filled data!',
					});
				}
			});

		});
	});
</script>

<style>

.instagram
{
	background: #d6249f !important; 
	background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%,#d6249f 60%,#285AEB 90%) !important;
}

.twitter
{
	background: #00ACEE !important;
	color : white !important;	
}

.facebook
{
	background: #2a66cd !important;
	color : white !important;	
}

.send-msg
{
	font-weight: bold;
	text-align: center;
}

/* Add media queries for responsive adjustments */
@media (max-width: 768px) {
  .content_1 {
    flex-direction: column;
  }
  
  .centered-text 
	{
		top: 5% !important;
		font-size: 22px !important;
	}
	.centered-text_1
	{
		top: 10% !important;
		font-size: 18px !important;
	}
	
	.content_1
	{
		top: 13%  !important;
	}
	
	#typing-animation
	{
		font-size : 30px !important;
	}
	
	.left-content
	{
		margin-top : 0 !important;
	}
	
	.banner
	{
		height : 170vh !important;
	}

}
.right-content {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.right-content-inner {
    width: 100%;
}

@media (max-width: 768px) {
    .right-content {
        margin-top: 20px;
    }
}

.text-one
{
	font-size: 17px;
}

.topic 
{
	color: #31ff9e;
	font-size: 20px;
	font-weight: bold;
}

.topic-2
{
	font-size: 20px;
	font-weight: bold;
}

.custom-icon 
{
	font-size: 20px !important;
	background:white !important;
	padding:12px;
	-webkit-border-radius:1100%;
	-moz-border-radius:100%;
	-o-border-radius:100%;
	border-radius:100%;
	color: black !important;
}

.custom-icon-other
{
	font-size: 22px !important;
	padding:14px;
	-webkit-border-radius:1100%;
	-moz-border-radius:100%;
	-o-border-radius:100%;
	border-radius:100%;
}

.fix-editor 
{
	display:none;
}

.icon-wrapper
{
	display:inline-block;
	margin : 3px;
}

#typing-animation
{
	font-size : 55px;
}

.centered-text 
{
	position: absolute;
	top: 15%;
	left: 50%;
	transform: translate(-50%, -50%);
	text-align: center;
	color: white;
	font-size: 36px;
	font-weight: bold;
}
.centered-text_1
{
	position: absolute;
	top: 20%;
	left: 50%;
	transform: translate(-50%, -50%);
	text-align: center;
	color: white;
	font-size: 26px;
	font-weight: bold;
}

.banner 
{
  position: relative;
  height: 135vh; /* Adjust the height as needed */
  overflow: hidden;
}

.dark-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.70); /* Adjust the opacity (last value) to control the darkness */
  background-position: center bottom;
}

.background-image {
  //position: relative;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: top;
}

.content {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  margin-top : 3vh;
}

.content_1 {
  position: absolute;
  top: 30%;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  margin-top : 3vh;
}

/* Add media queries for responsive adjustments */
@media (max-width: 768px) {
  .content {
    flex-direction: column;
  }

}

@media (max-width: 576px) {

  .box-image 
	{
      max-width: 80vh;
      height: 60vh !important;
	  border-radius:10px;
    }

}

.left-content-inner h3 
	{
		font-size: 4vw;
		font-family: Arial, Helvetica, sans-serif;
		background: white;
	}
	
	.left-content-inner p 
	{
		font-size: 2vw;
		font-family: Arial, Helvetica, sans-serif;
		background: white;
	}
	
.left-content {
    /* Your existing styles here */

    /* Add these styles to center the content */
    display: flex;
    justify-content: center;
    align-items: center;
    color: white; /* Set content color to white */
	margin-top : 3rem;
}

.left-content-inner {
    /* Your existing styles here */
    /* You can keep or modify the existing styles */
    color: white; /* Set text color to white */
    text-align: center; /* Center the text within .left-content-inner */
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

.btn-radius 
{
	border-radius: 100px !important;
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
	
  </style>
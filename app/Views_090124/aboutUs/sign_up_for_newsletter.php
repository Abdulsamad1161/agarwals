<div class="banner">
    <div class="dark-overlay"></div>
	<img src="<?= base_url('assets/images_agarwal/newsletter_bg.jpeg'); ?>" alt="Background Image" class="background-image">
	<div class="content">
    <div class="centered-text">
        <h1 id="typing-animation"></h1>
    </div>
	<div class="centered-text_1">
        <h3 id="">Join Mailing List</h3>
    </div>
    </div>
    <div class="content_1" id="newsletter">
		<div class="col-md-4"></div>
		<div class="col-md-4 animate-slide-in-right">
			<div class="right-content">
				<div class="right-content-inner">
					<h3 class="mb-4 send-msg">Sign up for our Newsletter and Emails</h3>
					<div class="col-md-12 mt-3"><div id="form_newsletter_response" style="background: white;border-radius: 60px !important;text-align: center;"></div></div>
					<form id="form_newsletter_footer" class="form-newsletter">
						 <?= csrf_field(); ?>
						<div class="row">
							<div class="col-md-12 col-lg-12 col-sm-12">
								<div class="form-group">
									<label for="first_name"><?= trans('first_name');?></label>
									<input type="text" class="form-control form-input" id="first_name" name="first_name" placeholder = "<?= trans('first_name');?>">
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12 col-lg-12 col-sm-12">
								<div class="form-group">
									<label for="last_name"><?= trans('last_name');?></label>
									<input type="text" class="form-control form-input" id="last_name" name="last_name" placeholder = "<?= trans('last_name');?>">
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12 col-lg-12 col-sm-12">
								<div class="form-group">
									<label for="email"><?= trans('email');?><span class="text-danger"> *</span></label>
									<input type="email" name="email" class="newsletter-input form-control form-input" maxlength="199" placeholder="<?= trans("enter_email"); ?>" required>
								</div>
							</div>
						</div>
						<input type="text" name="url" style="display : none;">
						<button type="submit" class="btn btn-danger btn-radius btn-block"><?= trans('subscribe');?></button>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-4"></div>
    </div>
</div>
<script>
	document.addEventListener('DOMContentLoaded', function() 
	{
		const text = 'Newsletter And Emails';
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
		top: 15% !important;
		font-size: 18px !important;
	}
	
	.content_1
	{
		top: 25%  !important;
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
		height : 100vh !important;
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
  height: 120vh; /* Adjust the height as needed */
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
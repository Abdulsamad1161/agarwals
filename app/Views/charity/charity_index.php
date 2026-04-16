<div class="banner">
    <div class="dark-overlay"></div>
	<img src="<?= base_url().'/'.esc($generalSettings->charity_image); ?>" alt="Background Image" class="background-image">
    <div class="content">
			<!-- Centered text
    <div class="centered-text">
        <h1 id="typing-animation">CHARITY COLLECTION</h1>
    </div> -->
    </div>
</div>
  
<style>
	#typing-animation
	{
		font-size : 55px;
	}
  .centered-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: white;
    font-size: 36px;
    font-weight: bold;
	filter: drop-shadow(2px 4px 6px black);
    background-color: rgba(152, 151, 151, 0.1); 
    box-shadow: inset 0 0 0 200px rgb(255, 255, 255, 0.08);
}
  .banner 
  {
  position: relative;
  height: 35vh; /* Adjust the height as needed */
  overflow: hidden;
}

.dark-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
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

/* Add media queries for responsive adjustments */
@media (max-width: 768px) {
  .content {
    flex-direction: column;
  }
}

.left-content-inner h3 
	{
		font-size: 4vw;
		font-family: Arial, Helvetica, sans-serif;
		background: white;
		-webkit-text-fill-color: transparent;
		-webkit-background-clip: text;	
	}
	
	.left-content-inner p 
	{
		font-size: 2vw;
		font-family: Arial, Helvetica, sans-serif;
		background: white;
		-webkit-text-fill-color: transparent;
		-webkit-background-clip: text;	
	}

  /* Custom CSS to set a fixed height for the card and make the image fit */
  .card {
    position: relative;
    overflow: hidden;
    transition: transform 0.5s ease; /* Add transition property for smooth movement */
  }

  .card img {
    object-fit: cover;
    height: 100%; /* Make the image fill the entire card while preserving aspect ratio */
    width: 100%;
  }
  
  .gallery_card
  {
	  box-shadow : 10px 10px 10px 10px #adadad6e;
  }
  
  .gallery_card:hover {
    transform: translateY(-20px); /* Move the card up by 20px on hover */
}
</style>

<?php 
if(!empty($charityList))
{ ?>

<div class="container">
  <?php $count = 0; ?>
  <div class="row">
    <?php foreach ($charityList as $item): ?>
      <?php if ($count % 3 == 0 && $count != 0): ?>
        </div><div class="row">
      <?php endif; ?>
      <div class="col-12 col-sm-6 col-md-4 mb-3 mt-4">
        <div class="card charity top-height">
			<img class="card-img custom-size" src="<?= base_url().'/'.$item->charity_image; ?>" alt="charity">
			<div class="card-img-overlay d-flex justify-content-end"></div>
			<div class="card-body">
				<h4 class="card-title title_head"><?php echo $item->charityName; ?></h4>
				<br>
				<div class="row">
					<div class="col-12">
						<p class="card-text"><?php echo $item->charityNote;?></p>
					</div>
				</div>
			</div>
			<div class="pay_now" style="text-align: center;">
			<?php if(empty($item->e_payment_link) && $item->e_payment_link == NULL){?>
				<?php if (authCheck()){ ?>
					<div class="btn-group mb-3">
						  <button class="btn btn-md btn-danger btn-radius mt-3 btnModal" data-id = "<?= $item->id;?>" data-toggle="modal" data-src = "<?=$item->paypalFees ;?>" data-target="#charityModal"><i class="fa fa-plus-circle"></i>&nbsp;<?= trans('donate_now'); ?></button>
					</div>	
				<?php  } else {?>
					<div class="btn-group mb-3">
						<a class="btn btn-md btn-danger btn-radius mt-3" href="javascript:void(0)" data-toggle="modal" data-target="#loginModal"><i class="fa fa-plus-circle"></i>&nbsp;<?= trans('donate_now'); ?></a>
					</div>	
				<?php } ?>
			<?php }
			else
			{?>
				<div class="btn-group mb-3">
					  <a href = "<?=$item->e_payment_link ;?>" class="btn btn-md btn-danger btn-radius mt-3"><i class="fa fa-plus-circle"></i>&nbsp;<?= trans('donate_now'); ?></a>
				</div>	
			<?php }?>
			</div>
        </div>
      </div>
      <?php $count++; ?>
    <?php endforeach; ?>
  </div>
</div>
<?php } else
{?>
<div class="container">
	<div class="row">
		<div class="col-md-4 mb-3"></div>
		<div class="col-md-4 mb-3 mt-4 col-sm-12">
			 <img class="img-fluid" src="<?= base_url('assets/images_agarwal/donate.png'); ?>" alt="Stay Tuned">
		</div>
		<div class="col-md-4 mb-3"></div>
	</div>
</div>

<?php }?>
<div class="modal" id="charityModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?= trans('kindly_fill_the_form_details'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('SponsorshipController/sendCharityPost'); ?>" method="post">
                <?= csrf_field(); ?>
			<div class="modal-body">
				<div class="form-group">
					<label for="username"><?= trans('name'); ?>:</label>
					<input type="text" name ="username" class="form-control" placeholder = "<?= trans('name'); ?>" required>
				</div>
				
				<div class="form-group">
				  <label for="phone"><?= trans('phone'); ?>:</label>
				  <input type="text" class="form-control" name = "phone" placeholder = "<?= trans('phone'); ?>" required>
				</div>
				
				<div class="form-group">
				  <label for="email"><?= trans('email'); ?>:</label>
				  <input type="email" class="form-control" name = "email" placeholder = "<?= trans('email'); ?>" required>
				</div>
				
				<div class="form-group">
					<label><?= trans('amount'); ?></label>
					<input type="text" name="amount" class="form-control" placeholder="<?= $baseVars->inputInitialPrice; ?>"maxlength="32" required>
				</div>
				
				<div class="form-group">
					<label><?= trans("others"); ?></label>
					<textarea type="text" class="form-control" name="note" placeholder="<?= trans("others"); ?>"></textarea>
				</div>

			</div>
			<div class="modal-footer">
				<input type="hidden" name="charityID" class="charityID">
				
				<input type="hidden" name="feesPercent" class="feesPercent">
				<button type="submit" class="btn btn-danger btn-radius"><?= trans('submit').' & '.trans('pay_now'); ?></button>
			</div>
			</form>
		</div>
	</div>
</div>

<div class="modal" id="charityModalEPayment" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?= trans('kindly_fill_the_form_details'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('SponsorshipController/sendCharityPostEpayment'); ?>" method="post" id="charityEpaymentForm">
                <?= csrf_field(); ?>
			<div class="modal-body">
				<div class="form-group">
					<label for="username"><?= trans('name'); ?>:</label>
					<input type="text" name ="username" class="form-control" placeholder = "<?= trans('name'); ?>" required>
				</div>
				
				<div class="form-group">
				  <label for="phone"><?= trans('phone'); ?>:</label>
				  <input type="text" class="form-control" name = "phone" placeholder = "<?= trans('phone'); ?>" required>
				</div>
				
				<div class="form-group">
				  <label for="email"><?= trans('email'); ?>:</label>
				  <input type="email" class="form-control" name = "email" placeholder = "<?= trans('email'); ?>" required>
				</div>
				
				<div class="form-group">
					<label><?= trans('amount'); ?></label>
					<input type="text" name="amount" class="form-control" placeholder="<?= $baseVars->inputInitialPrice; ?>"maxlength="32" required>
				</div>
				
				<div class="form-group">
					<label><?= trans("others"); ?></label>
					<textarea type="text" class="form-control" name="note" placeholder="<?= trans("note"); ?>"></textarea>
				</div>
				
				<div class="form-group">
					<p><span class="note"><?php echo trans('note')?> : </span><span class="span_class_text">After Submiting the form you will be redirected to the payment link <span class="payment_link"></span> kindly complete the payment from the link redirected. Thank you!</span></p>
				</div>

			</div>
			<div class="modal-footer">
				<input type="hidden" name="charityID" class="charityID">
				<button type="submit" class="btn btn-danger btn-radius"><?= trans('submit'); ?></button>
			</div>
			</form>
		</div>
	</div>
</div>

<script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>

<script>
	$(".btnModal").click(function () {
        var passedID = $(this).data('id');//get the id of the selected button
        $('.charityID').val(passedID);//set the id to the input on the modal
		
		var feesPercent = $(this).data('src');
		$('.feesPercent').val(feesPercent);
    });
	
	var paymentLink;
	
	$(".btnModalEpayment").click(function () {
        var passedID = $(this).data('id');//get the id of the selected button
        $('.charityID').val(passedID);//set the id to the input on the modal
		
		paymentLink = $(this).data('src');
		
		var passedLink = $(this).data('src');//get the id of the selected button
        $('.payment_link').html('<a class="payment_link_color" href="' + passedLink + '" target="_blank">' + passedLink + '</a>');
    });
	/*This code is for animation of typing animation 
		----Start---
	*/
    /* document.addEventListener('DOMContentLoaded', function() 
	{
		const text = 'ABC CHARITY COLLECTION';
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
    }); */
	/*
		----End---
	*/
	
$(document).ready(function() {
    $('#charityEpaymentForm').submit(function(event) {
        event.preventDefault(); // Preventing default form submission

		$.ajax({
			type: 'POST',
			url: $(this).attr('action'), 
			data: $(this).serialize(),
			dataType: 'json',
			success: function(response) {
				console.log(response);
				if (response == 'updated'){
					swal({
						title: 'Submitted Successfully!',
						text: 'Kindly Complete the payment after redirecting!'
					}).then(function() {
						 window.open(paymentLink, '_blank'); // Open the link in a new tab
					});
				} else {
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

.charity 
{
	border-radius: 10px; /* Adjust the value to control the roundness of the corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Adjust the shadow properties as needed */
    overflow: hidden; /* Ensure content within the card stays within the rounded corners */
	margin : 20px;
	border : 2px solid #d1274b;
}

 .card-img 
  {
	height: 200px; /* Replace with your desired height */
  display: block;
  margin: 0 auto; /* To horizontally center the images if needed */
  object-fit: cover; /* To maintain aspect ratio without cropping */

  }
  
  .card-img.custom-size {
  height: 200px; /* Replace with your desired height */
  object-fit: cover; /* To maintain aspect ratio without cropping */
}
  
  .title_head
  {
	text-align: center;
	font-weight: bold;
	color: #d1274b;
  }
  
  .text-align-center
  {
	  text-align : center;
	  font-weight: bold;
  }
  
  .head_price_p
  {
	font-weight: bold;
	color: red;
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

.picture_gallery_h1
 {
  font-size: 40px;
  display: inline-block;
  border-bottom: 5px solid #d1274b;
}
.title
{
	text-align: center;
}

.overlay {
    display: flex;
    align-items: center;
    justify-content: center;
    background: RGBA(0, 0, 0, .5);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 10000;
}

.img-enlargable {
    cursor: pointer;
}

.overlay img {
    max-width: 80%;
    max-height: 80%;
    cursor: zoom-out;
}

.overlay button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    color: white;
    background: black;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    z-index: 10001;
}

.overlay .prev-button {
    left: 60px;
}

.overlay .next-button {
    right: 60px;
}

.overlay .close-button {
    top: 30px;
    right: 60px;
    font-size: 24px;
    background: transparent;
}

.span_class_text
{
	color: #d1274b;
	font-weight: bold;
}

.payment_link_color
{
	color : blue;
}

.note
{
	font-weight : bold;
}
</style>
<?php 
helperDeleteSession('modesy_charity_form_id');
helperDeleteSession('mds_membership_bank_transaction_number');
helperDeleteSession('mds_membership_transaction_insert_id'); 
helperDeleteSession('mds_insert_form_id'); 
helperDeleteSession('charityID'); 
helperDeleteSession('charitySubAmount'); 
helperDeleteSession('charityPaypalAmount'); 
helperDeleteSession('charityAmount'); ?>
<div class="header_spons">
	<div class="overlay">
		<h1 class="header_spons_h1">Feedback Forms</h1>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12 mb-3 mt-4 col-sm-12" style="text-align:center;">
			<div class="title">
				<h1 class="picture_gallery_h1"><?= trans("general_feedback_form");?></h1>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<?= view('partials/_messages'); ?>
	</div>
</div>

<div class="container">
	<div class="over_container">
		<form action="<?= base_url('ProfileController/feedbackGeneralPost'); ?>" method="post" id="generalForm">
		<?= csrf_field(); ?>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="form-group">
					<label class="control-label"><?= trans("name"); ?></label>
					<input type="text" name="username" class="form-control form-input" value="<?php if(isset($memberDetails->username)){ echo $memberDetails->first_name.' '.$memberDetails->last_name;} ?>" placeholder="<?= trans("name"); ?>" maxlength="250">
				</div>
			</div>
			
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="form-group">
					<label class="control-label"><?= trans("phone_number"); ?></label>
					<input type="text" name="phone_number" class="form-control form-input" value="<?php if(isset($memberDetails->phone_number)){ echo $memberDetails->phone_number;} ?>" placeholder="<?= trans("phone_number"); ?>" maxlength="250">
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="form-group">
					<label class="control-label"><?= trans("email"); ?></label>
					<input type="email" name="email" class="form-control form-input" value="<?php if(isset($memberDetails->email)){ echo $memberDetails->email;} ?>" placeholder="<?= trans("email"); ?>" maxlength="250">
				</div>
			</div>
			
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="form-group">
					<label class="control-label"><?= trans("member_id"); ?></label>
					<input type="text" name="member_id" class="form-control form-input" value="<?php if(isset($memberDetails->id)){ echo $memberDetails->id;} ?>" placeholder="<?= trans("member_id"); ?>" maxlength="250" readonly>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="form-group">
					<label class="control-label"><?= trans("message"); ?></label>
					<textarea type="text" name="message" class="form-control form-input" placeholder="less than 350 words" required><?php if(isset($memberDetails->message)){ echo $memberDetails->message;} ?></textarea>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-12 text-right">
				<button type="submit" class="btn btn-md btn-danger"><?= trans("submit") ?></button>
			</div>
		</div>
		</form>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12 mb-3 mt-4 col-sm-12" style="text-align:center;">
			<div class="title">
				<h1 class="picture_gallery_h1"><?= trans("event_feedback_form");?></h1>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="over_container">
		<form action="<?= base_url('ProfileController/feedbackEventPost'); ?>" method="post" id="eventForm">
		<?= csrf_field(); ?>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="form-group">
					<label class="control-label"><?= trans("name"); ?></label>
					<input type="text" name="username" class="form-control form-input" value="<?php if(isset($memberDetails->username)){ echo $memberDetails->username;} ?>" placeholder="<?= trans("name"); ?>" maxlength="250">
				</div>
			</div>
			
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="form-group">
					<label class="control-label"><?= trans("phone_number"); ?></label>
					<input type="text" name="phone_number" class="form-control form-input" value="<?php if(isset($memberDetails->phone_number)){ echo $memberDetails->phone_number;} ?>" placeholder="<?= trans("phone_number"); ?>" maxlength="250">
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="form-group">
					<label class="control-label"><?= trans("email"); ?></label>
					<input type="email" name="email" class="form-control form-input" value="<?php if(isset($memberDetails->email)){ echo $memberDetails->email;} ?>" placeholder="<?= trans("email"); ?>" maxlength="250">
				</div>
			</div>
			
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="form-group">
					<label class="control-label"><?= trans("member_id"); ?></label>
					<input type="text" name="member_id" class="form-control form-input" value="<?php if(isset($memberDetails->id)){ echo $memberDetails->id;} ?>" placeholder="<?= trans("member_id"); ?>" maxlength="250" readonly>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="form-group">
					<label class="control-label"><?= trans("event_name"); ?></label>
					<select name="event_name_date" class="form-control form-input" required>
					<option value="">-SELECT-</option>
					<?php 
					if(isset($eventList) && is_array($eventList))
					{
						foreach ($eventList as $event) : ?>
						<option value="<?php echo $event->event_name . ' - ' . $event->event_date; ?>">
							<?php echo $event->event_name . ' - ' . $event->event_date; ?>
						</option>
					<?php endforeach; 
					}		?>
					</select>
				</div>
			</div>
		</div>
		
		<div class="row mt-4">
			<div class="col-md-12 col-sm-12 col-lg-12">
				<label for="dining_experience" class="control-label"><?=trans('food_feedback_1');?></label><br>
				
				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-6">
						<div class="custom-control custom-radio">
							<input type="radio" id="dining1" name="dining_experience" class="custom-control-input" value="Excelent">
							<label class="custom-control-label" for="dining1">Excellent</label>
						</div>
					</div>
					
					<div class="col-lg-3 col-md-3 col-sm-6">
						<div class="custom-control custom-radio">
							<input type="radio" id="dining2" name="dining_experience" class="custom-control-input" value="Good">
							<label class="custom-control-label" for="dining2">Good</label>
						</div>
					</div>
					
					<div class="col-lg-3 col-md-3 col-sm-6">
						<div class="custom-control custom-radio">
							<input type="radio" id="dining3" name="dining_experience" class="custom-control-input" value="Average">
							<label class="custom-control-label" for="dining3">Average</label>
						</div>
					</div>
					
					<div class="col-lg-3 col-md-3 col-sm-6">
						<div class="custom-control custom-radio">
							<input type="radio" id="dining4" name="dining_experience" class="custom-control-input" value="Poor">
							<label class="custom-control-label" for="dining4">Poor</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row mt-4">
			<div class="col-md-12 col-sm-12 col-lg-12">
				<label for="decor_experience" class="control-label"><?=trans('decor_feedback_1');?></label><br>
				
				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-6">
						<div class="custom-control custom-radio">
							<input type="radio" id="decor1" name="decor_experience" class="custom-control-input" value="Excelent">
							<label class="custom-control-label" for="decor1">Excellent</label>
						</div>
					</div>
					
					<div class="col-lg-3 col-md-3 col-sm-6">
						<div class="custom-control custom-radio">
							<input type="radio" id="decor2" name="decor_experience" class="custom-control-input" value="Good">
							<label class="custom-control-label" for="decor2">Good</label>
						</div>
					</div>
					
					<div class="col-lg-3 col-md-3 col-sm-6">
						<div class="custom-control custom-radio">
							<input type="radio" id="decor3" name="decor_experience" class="custom-control-input" value="Average">
							<label class="custom-control-label" for="decor3">Average</label>
						</div>
					</div>
					
					<div class="col-lg-3 col-md-3 col-sm-6">
						<div class="custom-control custom-radio">
							<input type="radio" id="decor4" name="decor_experience" class="custom-control-input" value="Poor">
							<label class="custom-control-label" for="decor4">Poor</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row mt-4">
			<div class="col-md-12 col-sm-12 col-lg-12">
				<label for="culturalProgram_experience" class="control-label"><?=trans('culturalProgram_feedback_1');?></label><br>
				
				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-6">
						<div class="custom-control custom-radio">
							<input type="radio" id="culturalProgram1" name="culturalProgram_experience" class="custom-control-input" value="Excelent">
							<label class="custom-control-label" for="culturalProgram1">Excellent</label>
						</div>
					</div>
					
					<div class="col-lg-3 col-md-3 col-sm-6">
						<div class="custom-control custom-radio">
							<input type="radio" id="culturalProgram2" name="culturalProgram_experience" class="custom-control-input" value="Good">
							<label class="custom-control-label" for="culturalProgram2">Good</label>
						</div>
					</div>
					
					<div class="col-lg-3 col-md-3 col-sm-6">
						<div class="custom-control custom-radio">
							<input type="radio" id="culturalProgram3" name="culturalProgram_experience" class="custom-control-input" value="Average">
							<label class="custom-control-label" for="culturalProgram3">Average</label>
						</div>
					</div>
					
					<div class="col-lg-3 col-md-3 col-sm-6">
						<div class="custom-control custom-radio">
							<input type="radio" id="culturalProgram4" name="culturalProgram_experience" class="custom-control-input" value="Poor">
							<label class="custom-control-label" for="culturalProgram4">Poor</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row mt-4">
			<div class="col-md-12 col-sm-12 col-lg-12">
				<label for="registration_experience" class="control-label"><?=trans('registration_feedback_1');?></label><br>
				
				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-6">
						<div class="custom-control custom-radio">
							<input type="radio" id="registration1" name="registration_experience" class="custom-control-input" value="Very Easy">
							<label class="custom-control-label" for="registration1">Very Easy</label>
						</div>
					</div>
					
					<div class="col-lg-3 col-md-3 col-sm-6">
						<div class="custom-control custom-radio">
							<input type="radio" id="registration2" name="registration_experience" class="custom-control-input" value="Easy">
							<label class="custom-control-label" for="registration2">Easy</label>
						</div>
					</div>
					
					<div class="col-lg-3 col-md-3 col-sm-6">
						<div class="custom-control custom-radio">
							<input type="radio" id="registration3" name="registration_experience" class="custom-control-input" value="Neutral">
							<label class="custom-control-label" for="registration3">Neutral</label>
						</div>
					</div>
					
					<div class="col-lg-3 col-md-3 col-sm-6">
						<div class="custom-control custom-radio">
							<input type="radio" id="registration4" name="registration_experience" class="custom-control-input" value="Difficult">
							<label class="custom-control-label" for="registration4">Difficult</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row mt-4">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="form-group">
					<label for="rate_experience" class="control-label"><?=trans('rate_us_feedback');?></label><br>
					<p class="star-rating" id="rate_experience">
						<label for="star5"></label>
						<label for="star4"></label>
						<label for="star3"></label>
						<label for="star2"></label>
						<label for="star1"></label>
					</p>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="form-group">
					<label class="control-label"><?= trans("message"); ?> (<?= trans("others"); ?>)</label>
					<textarea type="text" name="message" class="form-control form-input" placeholder="less than 350 words"  required><?php if(isset($memberDetails->message)){ echo $memberDetails->message;} ?></textarea>
				</div>
			</div>
		</div>
		
		<input type="hidden" name="rating" id="selected-rating" value="">
		<div class="row">
			<div class="col-12 text-right">
				<button type="submit" name="submit" value="update" class="btn btn-md btn-danger"><?= trans("submit") ?></button>
			</div>
		</div>
		</form>
	</div>
</div>


<style>
/* Style for the star rating */
.star-rating {
	display: inline-block;
	font-size: 0;
}

.star-rating label {
	font-size: 30px;
	padding: 7px;
	cursor: pointer;
}

.star-rating label:before {
	content: "\2605"; /* Unicode star character (☆) */
}

.star-rating label.selected:before {
	content: "\2605"; /* Unicode filled star character (★) */
	color: gold; /* Color of the filled star */
}

.header_spons 
{
	text-align: center;
	width: 100%;
	height: auto;
	background-size: cover;
	background-attachment: fixed;
	position: relative;
	overflow: hidden;
	border-radius: 0 0 55% 55% / 50%;
}

.header_spons .overlay
{
	width: 100%;
	height: 100%;
	padding: 5px;
	color: #FFF;
	text-shadow: 2px 1px 2px #a6a6a6;
	background: #d1274b;
	
}

header_spons_h1 
{
	font-size: 35px;
	margin-bottom: 30px;
}

.over_container
{
	border-radius: 10px;
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
	overflow: hidden;
	margin: 20px;
	border: 2px solid #d1274b;
	padding : 25px !important;
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
</style>

<script>
document.getElementById("generalForm").addEventListener("keypress", function (event) {
  if (event.keyCode === 13) {
    event.preventDefault();
  }
});

document.getElementById("eventForm").addEventListener("keypress", function (event) {
  if (event.keyCode === 13) {
    event.preventDefault();
  }
});

 // JavaScript to handle star rating selection
const labels = document.querySelectorAll('.star-rating label');
const selectedRating = document.getElementById('selected-rating');

labels.forEach((label, index) => {
	label.addEventListener('mouseover', () => {
		clearSelectedStars();
		label.classList.add('selected');
		highlightPreviousStars(index);
	});

	label.addEventListener('click', () => {
		clearSelectedStars();
		label.classList.add('selected');
		highlightPreviousStars(index);
		selectedRating.value = index + 1; // Update the hidden input with the selected rating
	});
});

function clearSelectedStars() {
	labels.forEach((label) => {
		label.classList.remove('selected');
	});
}

function highlightPreviousStars(index) {
	for (let i = 0; i <= index; i++) {
		labels[i].classList.add('selected');
	}
}
</script>
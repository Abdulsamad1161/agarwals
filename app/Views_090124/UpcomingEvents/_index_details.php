 <style>
.container_spons {
	display: flex;
	flex-wrap: wrap;
	justify-content: space-between;
	align-items: center;
}

.content_spons {
	flex-basis: calc(60% - 20px);
	padding: 20px;
}

.content_spons h2 {
	margin-top: 0;
}

.content_spons p {
	line-height: 1.6;
}

.image_spons {
	flex-basis: calc(40% - 20px);
	overflow: hidden;
	position: relative;
	  animation: slideInFromBottom 2s forwards; /* Animation applied */
}

.image_spons img {
	width: 100%;
	height: auto;
	display: block;
   // opacity : 0;
}

@keyframes slideInFromBottom {
   0% {
		transform: translateY(100%);
		opacity: 0;
	}
	100% {
		transform: translateY(0);
		opacity: 1;
	}
}

       
@media (max-width: 768px) {
	.container_spons {
		flex-direction: column;
	}

	.content_spons,
	.image_spons {
		flex-basis: 100%;
	}
}

.content_spons p
{
	font-size : 18px;
}

.red
{
	color :	#d1274b !important;
	animation: slideInFromLeft 4s forwards;
}

@keyframes slideInFromLeft {
            0% {
                transform: translateX(-100%);
                opacity: 0;
            }
            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }
.container_spons
{
	padding: 30px !important;
  border: 2px solid #d1274b;
  margin: 10px;
  border-radius: 10px;
  box-shadow: 10px 10px 10px 10px #adadad6e;
  background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
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

/* CSS for Color Cycling Effect */
.animated-text {
    display: inline-block;
    font-size: 32px !important;
    font-weight: bold;
    animation: colorCycle 10s infinite;
}

@keyframes colorCycle {
    0% {
        color: red;
    }
    25% {
        color: blue;
    }
    50% {
        color: green;
    }
    75% {
        color: orange;
    }
    100% {
        color: red;
    }
}
.bottom-border
{
	border-bottom: 2px solid #d1274b;
}
</style>

<div class="container">
	<div class="row">
		<div class="col-md-12 mb-3 mt-4 col-sm-12 title">
			<div class="title">
				<h1 class="picture_gallery_h1"><?= $events->event_name;?></h1>
			</div>
		</div>
	</div>
</div>

<div class="container_spons">
	<div class="content_spons">
		<?php if(!empty($events->event_name)){ ?>
			<div class ="row mb-3 bottom-border">
				<div class="col-md-12 col-sm-12 title">
					<p class="animated-text">
						<?= $events->event_name;?>
					</p>
				</div>
			</div>
		<?php }?>
		
		<?php if(!empty($events->eventDescription)){ ?>
			<div class ="row mb-3">
				<div class="col-md-12 col-sm-12 title">
					<p>
						<?= $events->eventDescription;?>
					</p>
				</div>
			</div>
		<?php }?>
		
		<?php if(!empty($events->event_location)){ ?>
			<div class ="row mb-3">
				<div class="col-md-12 col-sm-12 title">
					<p style="font-weight : bold;font-size : 25px">
						<span class="bottom-border">Event Time & Location</span>
					</p>
					<p>
						<?php if ($events->event_start_time !== '00:00:00' && $events->event_end_time !== '00:00:00') 
						{
							echo '<i class="fa fa-clock-o" style="font-size:20px;color:red"></i>&nbsp;&nbsp;';
							$startTime = date_create($events->event_start_time);
							$endTime = date_create($events->event_end_time);
							echo date_format($startTime, 'g:i A') . ' - ' . date_format($endTime, 'g:i A');
						}
						elseif ($events->event_start_time !== '00:00:00') {
							// Display a FontAwesome 4 icon (adjust the icon class as needed)
							echo '<i class="fa fa-clock-o"></i>&nbsp;';
							
							// Display event start time as desired (e.g., "6:00 AM")
							$startTime = date_create($events->event_start_time);
							echo date_format($startTime, 'g:i A');
						}
						else 
						{
							echo '&nbsp';
						}
						?>
					</p>
						<?php if(!empty($events->event_location)){ ?>
							<p>
								<i class="fa fa-map-marker" style="font-size:20px;color:red"></i>&nbsp;&nbsp;<?= $events->event_location;?>
							</p>
						<?php }
						?>
					
				</div>
			</div>
		<?php }?>
		
		<?php if(!empty($events->description)){ ?>
			<div class ="row mb-3">
				<div class="col-md-12 col-sm-12 title">
					<p>
						<?= $events->description;?>
					</p>
				</div>
			</div>
		<?php }?>
		
		<?php if(!empty($events->note)){ ?>
			<div class ="row mb-3">
				<div class="col-md-12 col-sm-12 title">
					<p style="font-weight : bold;">
						<i class="fa fa-bell" style="font-size:20px;color:red"></i>&nbsp;&nbsp;<span class="bottom-border">Note :</span> &nbsp;&nbsp;
						<?= $events->note;?>
					</p>
				</div>
			</div>
		<?php }?>
		
		<?php if(!empty($events->eventLink)){ ?>
			<div class ="row mb-3">
				<div class="col-md-12 col-sm-12 title">
					<?php if (authCheck()){ ?>
						<?php if(!empty($events->btnName)){
						?>
						<a class="btn btn-sm btn-danger" href="<?= $events->eventLink; ?>"> <?= $events->btnName; ?></a>
						<?php }
						else
						{ ?>
							<a class="btn btn-sm btn-danger" href="<?= $events->eventLink; ?>">Details</a>
						<?php } ?>
					<?php }
					else { ?>
						<?php if(!empty($events->btnName)){ ?>
						<a class="btn btn-sm btn-danger" href="javascript:void(0)" data-toggle="modal" data-target="#loginModal"> <?= $events->btnName; ?></a>
						<?php }
						else
						{ ?>
							<a class="btn btn-sm btn-danger" href="javascript:void(0)" data-toggle="modal" data-target="#loginModal">Details</a>
						<?php } ?>
					<?php }?>
				</div>
			</div>
		<?php }?>
		
		
	</div>
        <div class="image_spons">
            <img src="<?= base_url().'/'.$events->eventImage; ?>" alt="image_spons 1">
        </div>
    </div>	

<style>
.text_center
{
	text-align : center;
}

.btn_width
{
	width : 65%;
}

.card{padding: 30px 40px;margin-top: 60px;margin-bottom: 60px;border: none !important;box-shadow: 0 6px 12px 0 rgba(0,0,0,0.2)}

.form-control-label{margin-bottom: 0}
.input, textarea {padding: 8px 15px;border-radius: 5px !important;margin: 5px 0px;box-sizing: border-box;border: 1px solid #ccc;font-size: 18px !important;font-weight: 300}
.input:focus, textarea:focus{-moz-box-shadow: none !important;-webkit-box-shadow: none !important;box-shadow: none !important;outline-width: 0;font-weight: 400}

.align_right
{
	text-align : right;
}
.form_container 
{
	 background: url("<?= base_url('assets/images_agarwal/sponsorship_enquiry.jpg') ?>");   
    background-size: cover;
}


.btn-radius 
	{
		border-radius: 100px !important;
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

	.btn-lg 
	{
		padding: 18px 49px;
	}
	.btn-danger{
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
</style>
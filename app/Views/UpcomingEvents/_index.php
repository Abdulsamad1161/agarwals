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
		animation: slideInFromBottom 2s forwards;
		/* Animation applied */
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

	.header_spons {
		text-align: center;
		width: 100%;
		height: auto;
		background-size: cover;
		background-attachment: fixed;
		position: relative;
		overflow: hidden;
		border-radius: 0 0 55% 55% / 50%;
	}

	.header_spons .overlay {
		width: 100%;
		height: 100%;
		padding: 5px;
		color: #FFF;
		text-shadow: 2px 1px 2px #a6a6a6;
		background: #d1274b;

	}

	header_spons_h1 {
		font-size: 35px;
		margin-bottom: 30px;
	}

	header_spons_h5 {
		margin-bottom: 10px;
	}

	.content_spons p {
		font-size: 18px;
	}

	.red {
		color: #d1274b !important;
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

	@media (min-width: 768px) {
		.animated-text {
			display: inline-block;
			font-size: 16px;
			font-weight: bold;
			white-space: nowrap;
			overflow: hidden;
		}

	}

	.btn-read-more {
		font-size: 14px !important;
		padding: 11px !important;
		border-radius: 50px !important;
	}

	@media (max-width: 768px) {
		.header_spons_h1 {
			font-size: 35px;
		}

		.btn-read-more {
			padding: 4px !important;
			border-radius: 10px !important;
		}
	}
</style>

<div class="header_spons">
	<div class="overlay">
		<h1 class="header_spons_h1">Upcoming Events</h1>
	</div>
</div>

<div class="event-schedule-area-two bg-color pad100 mt-3 mb-3">
	<div class="container">
		<?php if (!empty($events)) { ?>
			<div class="tab-content" id="myTabContent" style="margin: 2.5rem 0rem !important;">
				<div class="tab-pane fade active show" id="home" role="tabpanel">
					<div class="table-responsive" style="max-height : 80vh;">
						<table class="table text-center">
							<thead>
								<tr>
									<th class="text-center" scope="col">Date</th>
									<th scope="col">Event</th>
									<th class="text-center" scope="col">Details</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$eventsDisplayed = false;
								foreach ($events as $event):
									$currentDate = date('Y-m-d');
									$eventDate = $event->event_date;

									if ($currentDate <= $eventDate) {
										$eventsDisplayed = true;
										?>

										<tr class="inner-box">
											<th scope="row">
												<div class="event-date">
													<?php
													// Format the event date from YYYY-MM-DD to a custom format (e.g., "d M")
													$eventDate = date_create($event->event_date);
													?>
													<span><?= date_format($eventDate, 'd'); ?></span>
													<p><?= date_format($eventDate, 'M'); ?> -
														<?= date_format($eventDate, 'Y'); ?>
													</p>
												</div>
											</th>
											<td>
												<div class="event-wrap">
													<h3><?= htmlspecialchars($event->event_name); ?></h3>
													<div class="meta">
														<div class="time">
															<?php
															if ($event->event_start_time !== '00:00:00' && $event->event_end_time !== '00:00:00') {
																echo '<i class="fa fa-clock-o"></i>&nbsp;';
																$startTime = date_create($event->event_start_time);
																$endTime = date_create($event->event_end_time);
																echo date_format($startTime, 'g:i A') . ' - ' . date_format($endTime, 'g:i A');
															} elseif ($event->event_start_time !== '00:00:00') {
																// Display a FontAwesome 4 icon (adjust the icon class as needed)
																echo '<i class="fa fa-clock-o"></i>&nbsp;';

																// Display event start time as desired (e.g., "6:00 AM")
																$startTime = date_create($event->event_start_time);
																echo date_format($startTime, 'g:i A');
															} else {
																echo '&nbsp;';
															}
															?>
														</div>
													</div>
												</div>
											</td>
											<td>
												<div class="primary-btn">
													<a class="btn btn-sm btn-danger btn-read-more"
														href="<?= adminUrl('show-event-details/' . $event->id); ?>">Read
														More</a>
												</div>
											</td>
										</tr>
										<?php
									}
									?>
								<?php endforeach; ?>
							</tbody>
						</table>
						<?php
						if (!$eventsDisplayed) { ?>
							<div class="col-md-12 text_center">
								<img src="<?= base_url('assets/images_agarwal/stay_tuned.png'); ?>" class='img-fluid'
									alt="Stay Tuned">
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php }
		?>
		<!-- /row end-->
	</div>
</div>

<style>
	#home {
		box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
	}

	.tab-content {
		/* padding: 30px !important; */
		/* border: 2px solid #d1274b; */
		margin: 15px 5px;
		border-radius: 10px;
		box-shadow: 10px 10px 10px 10px #adadad6e;
	}

	.picture_gallery_h1 {
		font-size: 40px;
		display: inline-block;
		border-bottom: 5px solid #d1274b;
	}

	.title {
		text-align: center;
	}

	.text_center {
		text-align: center;
	}

	.btn_width {
		width: 65%;
	}


	.form-control-label {
		margin-bottom: 0
	}

	.input,
	textarea {
		padding: 8px 15px;
		border-radius: 5px !important;
		margin: 5px 0px;
		box-sizing: border-box;
		border: 1px solid #ccc;
		font-size: 18px !important;
		font-weight: 300
	}

	.input:focus,
	textarea:focus {
		-moz-box-shadow: none !important;
		-webkit-box-shadow: none !important;
		box-shadow: none !important;
		outline-width: 0;
		font-weight: 400
	}

	.align_right {
		text-align: right;
	}

	.form_container {
		background: url("<?= base_url('assets/images_agarwal/sponsorship_enquiry.jpg') ?>");
		background-size: cover;
	}


	.btn-radius {
		border-radius: 100px !important;
	}

	.btn {
		color: white;
		font-size: 13px;
		font-weight: bold;
		letter-spacing: 1px;
		border-radius: 2px;
		padding: 13px 28px;
		text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.14);
		text-transform: uppercase;
		box-shadow: 0 4px 9px 0 rgba(0, 0, 0, 0.2);
	}

	.btn-lg {
		padding: 18px 49px;
	}

	.btn-danger {
		background: #e81216;
		background: -moz-linear-gradient(-45deg, #e81216 0%, #f45355 50%, #f6290c 51%, #ed0e11 71%, #fc1b21 100%);
		background: -webkit-linear-gradient(-45deg, #e81216 0%, #f45355 50%, #f6290c 51%, #ed0e11 71%, #fc1b21 100%);
		background: linear-gradient(135deg, #e81216 0%, #f45355 50%, #f6290c 51%, #ed0e11 71%, #fc1b21 100%);
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#e81216', endColorstr='#fc1b21', GradientType=1);
		background-size: 400% 400%;
		-webkit-animation: AnimationName 3s ease infinite;
		-moz-animation: AnimationName 3s ease infinite;
		animation: AnimationName 3s ease infinite;
		-webkit-animation: AnimationName 3s ease infinite;
		-moz-animation: AnimationName 3s ease infinite;
		animation: AnimationName 3s ease infinite;
		border: medium none;
	}

	@-webkit-keyframes AnimationName {
		0% {
			background-position: 0% 31%
		}

		50% {
			background-position: 100% 70%
		}

		100% {
			background-position: 0% 31%
		}
	}

	@-moz-keyframes AnimationName {
		0% {
			background-position: 0% 31%
		}

		50% {
			background-position: 100% 70%
		}

		100% {
			background-position: 0% 31%
		}
	}

	@keyframes AnimationName {
		0% {
			background-position: 0% 31%
		}

		50% {
			background-position: 100% 70%
		}

		100% {
			background-position: 0% 31%
		}
	}

	.event-schedule-area .tab-area .nav-tabs {
		border-bottom: inherit;
	}

	.event-schedule-area .tab-area .nav {
		border-bottom: inherit;
		display: -webkit-box;
		display: -ms-flexbox;
		display: flex;
		-webkit-box-orient: vertical;
		-webkit-box-direction: normal;
		-ms-flex-direction: column;
		flex-direction: column;
		margin-top: 80px;
	}

	.event-schedule-area .tab-area .nav-item {
		margin-bottom: 75px;
	}

	.event-schedule-area .tab-area .nav-item .nav-link {
		text-align: center;
		font-size: 22px;
		color: #333;
		font-weight: 600;
		border-radius: inherit;
		border: inherit;
		padding: 0px;
		text-transform: capitalize !important;
	}

	.event-schedule-area .tab-area .nav-item .nav-link.active {
		color: #4125dd;
		background-color: transparent;
	}

	.event-schedule-area .tab-area .tab-content .table {
		margin-bottom: 0;
		width: 80%;
	}

	.event-schedule-area .tab-area .tab-content .table thead td,
	.event-schedule-area .tab-area .tab-content .table thead th {
		border-bottom-width: 1px;
		font-size: 20px;
		font-weight: 600;
		color: #252525;
	}

	.event-schedule-area .tab-area .tab-content .table td,
	.event-schedule-area .tab-area .tab-content .table th {
		border: 1px solid #b7b7b7;
		padding-left: 30px;
	}

	.event-schedule-area .tab-area .tab-content .table tbody th .heading,
	.event-schedule-area .tab-area .tab-content .table tbody td .heading {
		font-size: 16px;
		text-transform: capitalize;
		margin-bottom: 16px;
		font-weight: 500;
		color: #252525;
		margin-bottom: 6px;
	}

	.event-schedule-area .tab-area .tab-content .table tbody th span,
	.event-schedule-area .tab-area .tab-content .table tbody td span {
		color: #4125dd;
		font-size: 18px;
		text-transform: uppercase;
		margin-bottom: 6px;
		display: block;
	}

	.event-schedule-area .tab-area .tab-content .table tbody th span.date,
	.event-schedule-area .tab-area .tab-content .table tbody td span.date {
		color: #656565;
		font-size: 14px;
		font-weight: 500;
		margin-top: 15px;
	}

	.event-schedule-area .tab-area .tab-content .table tbody th p {
		font-size: 14px;
		margin: 0;
		font-weight: normal;
	}

	.event-schedule-area-two .section-title .title-text h2 {
		margin: 0px 0 15px;
	}

	.event-schedule-area-two ul.custom-tab {
		-webkit-box-pack: center;
		-ms-flex-pack: center;
		justify-content: center;
		border-bottom: 1px solid #dee2e6;
		margin-bottom: 30px;
	}

	.event-schedule-area-two ul.custom-tab li {
		margin-right: 70px;
		position: relative;
	}

	.event-schedule-area-two ul.custom-tab li a {
		color: #252525;
		font-size: 25px;
		line-height: 25px;
		font-weight: 600;
		text-transform: capitalize;
		padding: 35px 0;
		position: relative;
	}

	.event-schedule-area-two ul.custom-tab li a:hover:before {
		width: 100%;
	}

	.event-schedule-area-two ul.custom-tab li a:before {
		position: absolute;
		left: 0;
		bottom: 0;
		content: "";
		background: #4125dd;
		width: 0;
		height: 2px;
		-webkit-transition: all 0.4s;
		-o-transition: all 0.4s;
		transition: all 0.4s;
	}

	.event-schedule-area-two ul.custom-tab li a.active {
		color: #4125dd;
	}

	.event-schedule-area-two .primary-btn {
		margin-top: 40px;
	}

	.event-schedule-area-two .tab-content .table {
		-webkit-box-shadow: 0 1px 30px rgba(0, 0, 0, 0.1);
		box-shadow: 0 1px 30px rgba(0, 0, 0, 0.1);
		margin-bottom: 0;
	}

	.event-schedule-area-two .tab-content .table thead {
		background-image: linear-gradient(to top, #4481eb 0%, #04befe 100%);
		color: #fff;
		font-size: 20px;
	}

	.event-schedule-area-two .tab-content .table thead tr th {
		padding: 20px;
		border: 0;
	}

	.event-schedule-area-two .tab-content .table tbody {
		background: #fff;
	}

	.event-schedule-area-two .tab-content .table tbody tr.inner-box {
		border-bottom: 2px solid #dee2e6;
	}

	.event-schedule-area-two .tab-content .table tbody tr th {
		border: 0;
		padding: 30px 20px;
		vertical-align: middle;
	}

	.event-schedule-area-two .tab-content .table tbody tr th .event-date {
		color: #252525;
		text-align: center;
	}

	.event-schedule-area-two .tab-content .table tbody tr th .event-date span {
		font-size: 50px;
		line-height: 50px;
		font-weight: normal;
	}

	@media (max-width: 768px) {
		.event-schedule-area-two .tab-content .table tbody tr th .event-date span {
			font-size: 28px !important;
			line-height: 32px !important;
		}

		.event-schedule-area-two .tab-content .table tbody tr th {
			padding: 25px 8px !important;
		}

		.event-schedule-area-two .tab-content .table tbody tr td .event-wrap h3 {
			font-size: 20px !important;
		}

		.event-schedule-area-two .tab-content .table tbody tr td {
			padding: 25px 8px !important;
		}
	}

	.event-schedule-area-two .tab-content .table tbody tr td {
		padding: 30px 20px;
		vertical-align: middle;
	}

	.event-schedule-area-two .tab-content .table tbody tr td .r-no span {
		color: #252525;
	}

	.event-schedule-area-two .tab-content .table tbody tr td .event-wrap h3 a {
		font-size: 20px;
		line-height: 20px;
		color: #cf057c;
		-webkit-transition: all 0.4s;
		-o-transition: all 0.4s;
		transition: all 0.4s;
	}

	.event-schedule-area-two .tab-content .table tbody tr td .event-wrap h3 a:hover {
		color: #4125dd;
	}

	.event-schedule-area-two .tab-content .table tbody tr td .event-wrap .categories {
		display: -webkit-inline-box;
		display: -ms-inline-flexbox;
		display: inline-flex;
		margin: 10px 0;
	}

	.event-schedule-area-two .tab-content .table tbody tr td .event-wrap .categories a {
		color: #252525;
		font-size: 16px;
		margin-left: 10px;
		-webkit-transition: all 0.4s;
		-o-transition: all 0.4s;
		transition: all 0.4s;
	}

	.event-schedule-area-two .tab-content .table tbody tr td .event-wrap .categories a:before {
		content: "\f07b";
		font-family: fontawesome;
		padding-right: 5px;
	}

	.event-schedule-area-two .tab-content .table tbody tr td .event-wrap .time span {
		color: #252525;
	}

	.event-schedule-area-two .tab-content .table tbody tr td .event-wrap .organizers {
		display: -webkit-inline-box;
		display: -ms-inline-flexbox;
		display: inline-flex;
		margin: 10px 0;
	}

	.event-schedule-area-two .tab-content .table tbody tr td .event-wrap .organizers a {
		color: #4125dd;
		font-size: 16px;
		-webkit-transition: all 0.4s;
		-o-transition: all 0.4s;
		transition: all 0.4s;
	}

	.event-schedule-area-two .tab-content .table tbody tr td .event-wrap .organizers a:hover {
		color: #4125dd;
	}

	.event-schedule-area-two .tab-content .table tbody tr td .event-wrap .organizers a:before {
		content: "\f007";
		font-family: fontawesome;
		padding-right: 5px;
	}

	.event-schedule-area-two .tab-content .table tbody tr td .primary-btn {
		margin-top: 0;
		text-align: center;
	}

	.event-schedule-area-two .tab-content .table tbody tr td .event-img img {
		width: 100px;
		height: 100px;
	}
</style>
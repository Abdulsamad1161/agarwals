<!-- Font Awesome 5 links-->
<link rel="stylesheet" href="<?= base_url('assets/admin/vendor/font-awesome/css/font-awesome.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/vendor/jsBoxNotice/jBox.all.min.css'); ?>">
<footer>
<?php
use App\Models\SettingsModel;
$this->settingsModel = new SettingsModel();
$settings = $this->settingsModel->getAllSettingsData();
?>
	<div class="footer-wrap">
	<div class="container first_class">
			<div class="row">
				<div class="col-md-4 col-sm-6">
					<h3>BE THE FIRST TO KNOW</h3>
					<p>Get all the latest information on ABC, Events, Membership Plans.
				       Join Us Soon.</p>
				</div>
				<div class="col-md-4 col-sm-6">
				<?php /* <div class="col-md-12">
				<form id="form_newsletter_footer" class="newsletter form-newsletter">
					 <input type="email" name="email" class="newsletter-input" maxlength="199" placeholder="<?= trans("enter_email"); ?>" required>
                    <button value="form" class ="newsletter_submit_btn" type="submit"><i class="fa fa-paper-plane"></i></button>	
					<input type="text" name="url" style="display : none;">
                    
				</form>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-12"><div id="form_newsletter_response" style="background: white;border-radius: 60px !important;text-align: center;"></div></div> */ ?>
				</div>
				<div class="col-md-4 col-sm-6">
				<div class="col-md-12">
					<div class="standard_social_links">
						<div>
							<?php if (!empty($settings->facebook_url)): ?>
								<li class="round-btn btn-facebook">
									<a href="<?= $settings->facebook_url; ?>" target="_blank">
										<i class="fa fa-facebook-f"></i>
									</a>
								</li>
							<?php endif; ?>

							<?php if (!empty($settings->linkedin_url)): ?>
								<li class="round-btn btn-linkedin">
									<a href="<?= $settings->linkedin_url; ?>" target="_blank">
										<i class="fa fa-linkedin" aria-hidden="true"></i>
									</a>
								</li>
							<?php endif; ?>

							<?php if (!empty($settings->twitter_url)): ?>
								<li class="round-btn btn-twitter">
									<a href="<?= $settings->twitter_url; ?>" target="_blank">
										<i class="fa fa-twitter" aria-hidden="true"></i>
									</a>
								</li>
							<?php endif; ?>

							<?php if (!empty($settings->instagram_url)): ?>
								<li class="round-btn btn-instagram">
									<a href="<?= $settings->instagram_url; ?>" target="_blank">
										<i class="fa fa-instagram" aria-hidden="true"></i>
									</a>
								</li>
							<?php endif; ?>

							<?php if (!empty($settings->whatsapp_url)): ?>
								<li class="round-btn btn-whatsapp">
									<a href="<?= $settings->whatsapp_url; ?>" target="_blank">
										<i class="fa fa-whatsapp" aria-hidden="true"></i>
									</a>
								</li>
							<?php endif; ?>

							<?php if (!empty($settings->contact_email)): ?>
								<li class="round-btn btn-envelop">
									<a href="mailto:<?= $settings->contact_email; ?>">
										<i class="fa fa-envelope" aria-hidden="true"></i>
									</a>
								</li>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<div class="clearfix"></div>
				<div class="col-md-12"><h3 style="text-align: right;">Stay Connected</h3></div>
				</div>
			</div>
	</div>
		<div class="second_class">
			<div class="container second_class_bdr">
			<div class="row"> 
				<div class="col-md-4 col-sm-6">
					<div class="footer-logo"> <a href="<?= langBaseUrl(); ?>"><img class="img-fluid" style="max-width : 40% !important;" src="<?= getLogo(); ?>" alt="logo"></a>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<h3>Quick  Links</h3>
					<ul class="footer-links">
						<li><a href="<?= langBaseUrl(); ?>">Home</a>
						</li>
						<li><a href="<?= generateUrl('sponsorships'); ?>">Sponsorships</a>
						</li>
						<li><a href="<?= generateUrl('upcoming-events-calendar'); ?>">Events</a>
						</li>
						<li><a href="<?= generateUrl('abcmembership'); ?>">Membership</a>
						</li>
						<li><a href="<?= generateUrl('gallery'); ?>">Gallery</a>
						</li>
						<li><a href="<?= generateUrl('charity'); ?>">Charity</a>
						</li>
						<li><a href="<?= generateUrl('library'); ?>">Library</a>
						</li>
					</ul>
				</div>
				<div class="col-md-2 col-sm-6">
					<h3>Information</h3>
					<ul class="footer-category">
						<li><a href="<?= generateUrl('aboutUs'); ?>">About Us</a>
						</li>
						<li><a href="<?= generateUrl('aboutUs/boardOfDirectorsList'); ?>">Board of Directors</a>
						</li>
						<li><a href="<?= generateUrl('aboutUs/contactUs'); ?>">Contact Us</a>
						</li>
						<li><a href="<?= generateUrl('aboutUs/sign-up-for-our-newsletter'); ?>">Newsletter and Emails</a>
						</li>
						<li><a href="<?= generateUrl('externalOrganization'); ?>">External Organizations</a>
						</li>
						<li><a href="<?= generateUrl('terms-conditions'); ?>">Terms & Conditions</a>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="col-md-3 col-sm-6">
					<h3>Business</h3>
					<ul class="footer-links">
						<li><a href="<?= generateUrl('shopping'); ?>">Shopping</a>
						</li>
					</ul>
				</div>
			</div>
			
		</div>
		</div>
		
		<div class="row">
			
			<div class="container-fluid">
			<div class="copyright"> Copyright 2023 | Agarwals Based in Canada</div>
			</div>
			
		</div>
	</div>
	
	</footer>
	
<style>
/*
  =========================================================================================
                                    Social Icons
  =========================================================================================
  */
  
	
.round-btn {display: inline;height: 40px; width: 40px; background:#fff;border-radius: 50%;float: left;margin: 15px 8px;box-shadow: 2px 2px 5px 0px rgb(82, 0, 67);border: 1px solid;/*border: 1px solid #622657;*/}
.round-btn a {display: block !important;padding: 7px 12px;font-size: 18px;border-radius: 50%;}
.round-btn .icon {padding: 3px;}
.round-btn .icon img{height: 24px; width: 32px;margin-top: 6px;}
.btn-facebook a {color: #3b5998;padding: 8px 13px;}
.btn-linkedin a {color: #007bb6;}
.btn-twitter a{color: #1c9deb;}
.btn-instagram a{color: #dd3f5c;}
.btn-whatsapp a{color: #155E54;}
.btn-envelop a{color: #D6403A;font-size: 15px; padding: 9px 12px;}
.standard_header .standard_social_links {margin-left: 1rem;}

  /*
  =========================================================================================
                                    footer
  =========================================================================================
  */
  
  .footer-wrap {
    padding-top: 43px;
    background-size: cover;
}

.footer-wrap h3 {
    color: #fff !important;
    font-size: 17px;
    text-transform: uppercase;
    margin-bottom: 25px;
	font-weight : bold;
}

.footer-wrap p {
    font-size: 13px;
    line-height: 24px;
    color: #fff;
    margin-top: 15px;
}

.footer-wrap p a {
    color: #fff;
    text-decoration: underline;
    font-style: italic;
}

.footer-wrap p a:hover {
    text-decoration: none;
    color: #ff7800;
}

.footer-links li a {
    font-size: 13px;
    line-height: 30px;
    color: #fff;
    text-decoration: none;
}


.footer-links li:before {
    content: "\f105";
    font-family: 'FontAwesome';
    padding-right: 10px;
    color: #ccc;
}

.footer-category li a {
    font-size: 13px;
    line-height: 30px;
    color: #fff;
    text-decoration: none;
}

.footer-category li:before {
    content: "\f105";
    font-family: 'FontAwesome';
    padding-right: 10px;
    color: #b3b3b3;
}

.address {
    
    color: #b3b3b3;
    font-size: 14px;
    position: relative;
    padding-left: 30px;
    line-height: 30px;
}

.address:before {
    content: "\f277";
    font-family: 'FontAwesome';
    position: absolute;
    top: 0;
    left: 0;
}

.info a {
 
    color: #b3b3b3;
    font-size: 14px;
    line-height: 30px;
    font-weight: normal;
}

.fa-phone:before {
    content: "\f095";
}

.info a {

    color: #b3b3b3;
    font-size: 14px;
    line-height: 30px;
    font-weight: normal;
}

.fa-fax:before {
    content: "\f1ac";
}

.copyright {
    border-top: 1px solid #aeaeae;
    font-size: 14px;
    color: #000;
    padding-top: 15px;
    text-align: center;
    padding-bottom: 15px;
    background: #aeaeae;
}
footer .second_class{
    border-bottom: 1px solid #444;
    padding-bottom: 25px;
}
footer .first_class {
    padding-bottom: 21px;
    border-bottom: 1px solid #444;
}
footer .first_class p, footer .first_class h3{
    margin: 0 0;
    
}
footer{
    background: #d1274b;
}

footer .newsletter input[type="email"] {
    width: 100%;
    background: #fff;
    color: #333;
    border: 1px solid #222;
    padding: 14px 20px;
    border-radius: 50px;
    margin-top: 12px;
}

.newsletter .newsletter_submit_btn {
    background: #fff;
    position: absolute;
    right: 11px;
    border: 0;
    top: 18px;
    font-size: 17px;
    color: #333;
}


footer .second_class_bdr{
    padding-top: 25px;
    border-top:1px solid #fff;
}

footer .btn-facebook a {
    padding: 6px 14px !important;
}

footer .btn-envelop a {
    color: #D6403A;
    font-size: 15px;
    padding: 12px 12px;
}

footer .round-btn a {
    padding: 6px 12px;
}

footer .round-btn {
    box-shadow: 2px 2px 5px 0px #222 !important;}

footer .round-btn {
    margin: 15px 4px;}
	
footer dl, ol, ul {
    padding-left: 5px;
}
	footer li{
		list-style: none;
	}

@media(max-width:768px){
    .footer-wrap h3 {
    margin-top: 27px;}
    
    footer .round-btn {
    margin: 15px 4px;}
}
@media(max-width:320px){
.copyright {
    font-size: 13px;}
}	
</style>	
	
	


<?php /*
<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="footer-top">
                    <div class="row">
                        <div class="col-12 col-md-3 footer-widget">
                            <div class="row-custom">
                                <div class="footer-logo">
                                    <a href="<?= langBaseUrl(); ?>"><img src="<?= getLogo(); ?>" alt="logo"></a>
                                </div>
                            </div>
                            <div class="row-custom">
                                <div class="footer-about">
                                    <?= $baseSettings->about_footer; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 footer-widget">
                            <div class="nav-footer">
                                <div class="row-custom">
                                    <h4 class="footer-title"><?= trans("footer_quick_links"); ?></h4>
                                </div>
                                <div class="row-custom">
                                    <ul>
                                        <li><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                                        <?php if (!empty($menuLinks)):
                                            foreach ($menuLinks as $menuLink):
                                                if ($menuLink->location == 'quick_links'):
                                                    $itemLink = generateMenuItemUrl($menuLink);
                                                    if (!empty($menuLink->page_default_name)):
                                                        $itemLink = generateUrl($menuLink->page_default_name);
                                                    endif; ?>
                                                    <li><a href="<?= $itemLink; ?>"><?= esc($menuLink->title); ?></a></li>
                                                <?php endif;
                                            endforeach;
                                        endif; ?>
                                        <li><a href="<?= generateUrl('help_center'); ?>"><?= trans("help_center"); ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 footer-widget">
                            <div class="nav-footer">
                                <div class="row-custom">
                                    <h4 class="footer-title"><?= trans("footer_information"); ?></h4>
                                </div>
                                <div class="row-custom">
                                    <ul>
                                        <?php if (!empty($menuLinks)):
                                            foreach ($menuLinks as $menuLink):
                                                if ($menuLink->location == 'information'):
                                                    $itemLink = generateMenuItemUrl($menuLink);
                                                    if (!empty($menuLink->page_default_name)):
                                                        $itemLink = generateUrl($menuLink->page_default_name);
                                                    endif; ?>
                                                    <li><a href="<?= $itemLink; ?>"><?= esc($menuLink->title); ?></a></li>
                                                <?php endif;
                                            endforeach;
                                        endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 footer-widget">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="footer-title"><?= trans("follow_us"); ?></h4>
                                    <div class="footer-social-links">
                                        <?= view('partials/_social_links', ['showRSS' => true]); ?>
                                    </div>
                                </div>
                            </div>
                            <?php if ($generalSettings->newsletter_status == 1): ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="newsletter">
                                            <div class="widget-newsletter">
                                                <h4 class="footer-title"><?= trans("newsletter"); ?></h4>
                                                <form id="form_newsletter_footer" class="form-newsletter">
                                                    <div class="newsletter">
                                                        <input type="email" name="email" class="newsletter-input" maxlength="199" placeholder="<?= trans("enter_email"); ?>" required>
                                                        <button type="submit" name="submit" value="form" class="newsletter-button"><?= trans("subscribe"); ?></button>
                                                    </div>
                                                    <input type="text" name="url">
                                                    <div id="form_newsletter_response"></div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="footer-bottom">
                <div class="container">
                    <div class="copyright">
                        <?= esc($baseSettings->copyright); ?>
                    </div>
                    <?php $envPaymentIcons = getenv('PAYMENT_ICONS');
                    if (!empty($envPaymentIcons)):
                        $paymentIconsArray = explode(',', $envPaymentIcons ?? '');
                        if (!empty($paymentIconsArray) && countItems($paymentIconsArray) > 0):?>
                            <div class="footer-payment-icons">
                                <?php foreach ($paymentIconsArray as $icon):
                                    if (file_exists(FCPATH . 'assets/img/payment/' . $icon . '.svg')):?>
                                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="<?= base_url('assets/img/payment/' . $icon . '.svg'); ?>" alt="<?= $icon; ?>" class="lazyload">
                                    <?php endif;
                                endforeach; ?>
                            </div>
                        <?php
                        endif;
                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</footer>

*/?>
<?php if (empty(helperGetCookie('cks_warning')) && $baseSettings->cookies_warning): ?>
    <div class="cookies-warning">
        <button type="button" aria-label="close" class="close" onclick="hideCookiesWarning();"><i class="icon-close"></i></button>
        <div class="text">
            <?= $baseSettings->cookies_warning_text; ?>
        </div>
        <button type="button" class="btn btn-md btn-block" aria-label="close" onclick="hideCookiesWarning();"><?= trans("accept_cookies"); ?></button>
    </div>
<?php endif; ?>
<a href="javascript:void(0)" class="scrollup"><i class="icon-arrow-up"></i></a>
<script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/plugins-2.3.js'); ?>"></script>
<script src="<?= base_url('assets/js/script-2.3.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/carousel/owl.carousel.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/jsBoxNotice/jBox.all.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/slick-slider/slick.min.js'); ?>"></script>
<script>$('<input>').attr({type: 'hidden', name: 'sysLangId', value: '<?=selectedLangId(); ?>'}).appendTo('form[method="post"]');</script>
<script><?php if (!empty($indexCategories)):foreach ($indexCategories as $category):?>if ($('#category_products_slider_<?= $category->id; ?>').length != 0) {
        $('#category_products_slider_<?= $category->id; ?>').slick({autoplay: false, autoplaySpeed: 4900, infinite: true, speed: 200, swipeToSlide: true, rtl: MdsConfig.rtl, cssEase: 'linear', prevArrow: $('#category-products-slider-nav-<?= $category->id; ?> .prev'), nextArrow: $('#category-products-slider-nav-<?= $category->id; ?> .next'), slidesToShow: 5, slidesToScroll: 1, responsive: [{breakpoint: 992, settings: {slidesToShow: 4, slidesToScroll: 1}}, {breakpoint: 768, settings: {slidesToShow: 3, slidesToScroll: 1}}, {breakpoint: 576, settings: {slidesToShow: 2, slidesToScroll: 1}}]});
    }
    <?php endforeach;
    endif; ?>
    <?php if ($generalSettings->pwa_status == 1): ?>if ('serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            navigator.serviceWorker.register('<?= base_url('pwa-sw.js');?>').then(function (registration) {
            }, function (err) {
                console.log('ServiceWorker registration failed: ', err);
            }).catch(function (err) {
                console.log(err);
            });
        });
    } else {
        console.log('service worker is not supported');
    }
    <?php endif; ?>
</script>
<?php if (!empty($video) || !empty($audio)): ?>
    <script src="<?= base_url('assets/vendor/plyr/plyr.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/plyr/plyr.polyfilled.min.js'); ?>"></script>
    <script>const player = new Plyr('#player');
        $(document).ajaxStop(function () {
            const player = new Plyr('#player');
        });
        const audio_player = new Plyr('#audio_player');
        $(document).ajaxStop(function () {
            const player = new Plyr('#audio_player');
        });
        $(document).ready(function () {
            setTimeout(function () {
                $(".product-video-preview").css("opacity", "1");
            }, 300);
            setTimeout(function () {
                $(".product-audio-preview").css("opacity", "1");
            }, 300);
        });</script>
<?php endif;
if (!empty($loadSupportEditor)):
    echo view('support/_editor');
endif; ?>
<?php if (checkNewsletterModal()): ?>
    <script>$(window).on('load', function () {
            $('#modal_newsletter').modal('show');
        });</script>
<?php endif; ?>
<?= $generalSettings->google_analytics; ?>
<?= $generalSettings->custom_footer_codes; ?>
<script>
function buisnessCustomerCommunication(id, categoryId, userId)
{
	var dataArray = {
				'product_id':id, 
				'vendor_id':userId, 
				'category_id':categoryId
	};
	$.ajax({
		type: 'POST',
		url: MdsConfig.baseURL + '/business-customer-communication',
		data: setAjaxData(dataArray),
		});
}

var msgNew = "<?= $baseVars->unreadMessageCount;?>";

if(msgNew > 0)
{
	new jBox("Notice", {
		attributes: {
		  x: "right",
		  y: "bottom"
		},
		stack: !1,
		animation: {
		  open: "tada",
		  close: "zoomIn"
		},
		color: 'red',
		title: "Information",
		content: "You have a new text message"
	});
}
$(document).ready(function() {
    var images = $('.lazyload');
    var totalImages = images.length;
    var currentIndex = 0;
	/*
    function showImage(index) {
        var src = images.eq(index).attr('data-bg');
        var overlay = $('<div>').addClass('overlay');

        var img = $('<img>').attr('src', src).appendTo(overlay);

        var prevButton = $('<button>').addClass('prev-button').html('&#10094;').click(function(e) {
            e.stopPropagation();
            currentIndex = (currentIndex - 1 + totalImages) % totalImages;
            img.attr('src', images.eq(currentIndex).attr('data-bg'));
        }).appendTo(overlay);

        var nextButton = $('<button>').addClass('next-button').html('&#10095;').click(function(e) {
            e.stopPropagation();
            currentIndex = (currentIndex + 1) % totalImages;
            img.attr('src', images.eq(currentIndex).attr('data-bg'));
        }).appendTo(overlay);

        var closeButton = $('<button>').addClass('close-button').html('&#10005;').click(function() {
            overlay.remove();
        }).appendTo(overlay);

        overlay.click(function(e) {
            if ($(e.target).hasClass('overlay')) {
                overlay.remove();
            }
        });

        overlay.appendTo('body');
    }

    $('.lazyload').addClass('img-enlargable').click(function() {
        currentIndex = images.index($(this));
        showImage(currentIndex);
    });
	
	*/
	
	//applying equal height for top-boxes class
	var tallestBox = 0;
	$(".top-height").each(function() {
		var divHeight = $(this).height();

		if (divHeight > tallestBox)
		{
			tallestBox = divHeight;
		}
	});
	// Apply height & add total vertical padding

	$(".top-height").css("height", tallestBox);
});

        // Attach a click event to the image with the ID "seatImage" 
function startTicketSessionTiming(user_id,event_id)
{
	// Perform an AJAX call
	var dataArray = {
				'member_id':user_id, 
				'event_id':event_id, 
	};
	$.ajax({
		type: 'POST',
		url: MdsConfig.baseURL + '/ticket-selection-data',
		data: setAjaxData(dataArray),
		success: function (response) {
			var obj = JSON.parse(response);
			if (obj.result == 1) {
                   var startTime = parseInt(obj.start_time); // Convert to integer
					var endTime = parseInt(obj.end_time); // Convert to integer
					startTimer(startTime, endTime);
			} else {
				console.log("no");
			}
		}
	});
}

function startTimer(startTime, endTime) {
    var timerText = document.getElementById('timer');

    function updateTimer() {
        var currentTime = new Date().getTime() / 1000; // Convert to seconds
        var remainingTime = endTime - currentTime;

        if (remainingTime <= 0) {
            clearInterval(timerInterval);
            swal({
				title: "Booking Expired",
				text: "We're sorry, but the booking time for this event has expired.",
				icon: "warning",
				buttons: {
					ok: {
						text: "Ok",
						value: true,
						visible: true,
						className: "sweet-alert-button",
						closeModal: true,
					},
				},
				closeOnClickOutside: false,
				closeOnEsc: false,
				})
				.then((willDelete) => {
					if (willDelete) 
					{
						window.location.href = MdsConfig.baseURL + '/admin/ticket-booking-redirect';
					}
				});
        } else {
            var minutes = Math.floor(remainingTime / 60);
            var seconds = Math.floor(remainingTime % 60);
            timerText.textContent = minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
        }
    }

    updateTimer();
    var timerInterval = setInterval(updateTimer, 1000);
}

function leftTicketSessionTiming(startTime, endTime)
{
	 updateTimers(startTime, endTime);
}

function updateTimers(startTime, endTime) {
     var timerText = document.getElementById('timer');

    function updateTimer() {
        var currentTime = new Date().getTime() / 1000; // Convert to seconds
        var remainingTime = endTime - currentTime;

        if (remainingTime <= 0) {
            clearInterval(timerInterval);
			swal({
				title: "Booking Expired",
				text: "We're sorry, but the booking time for this event has expired.",
				icon: "warning",
				buttons: {
					ok: {
						text: "Ok",
						value: true,
						visible: true,
						className: "sweet-alert-button",
						closeModal: true,
					},
				},
				closeOnClickOutside: false,
				closeOnEsc: false,
				})
				.then((willDelete) => {
					if (willDelete) 
					{
						window.location.href = MdsConfig.baseURL + '/admin/ticket-booking-redirect';
					}
				});
        } else {
            var minutes = Math.floor(remainingTime / 60);
            var seconds = Math.floor(remainingTime % 60);
            timerText.textContent = minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
        }
    }

    updateTimer();
    var timerInterval = setInterval(updateTimer, 1000);
}

$(document).ready(function() {
    $("#seating-container").on("click", ".seat", function() {
        let $seat = $(this);
		if(!$seat.hasClass("occupied"))
		{
			if ($seat.hasClass("selected")) {
				let seatId = $seat.data("id");
				removeSeatToTempTable(seatId);
			} else {
				const selectedSeats = $(".seat.selected");
				const totalCount =  $("#totalCount").text();
				
				if(selectedSeats.length != totalCount)
				{
					let seatId = $seat.data("id");
					saveSeatToTempTable(seatId);
				}
			}
		}
    });
});

function saveSeatToTempTable(seatId) 
{
	var dataArray = {
					'seats':seatId, 
		};
		$.ajax({
			type: 'POST',
			url: MdsConfig.baseURL + '/reserve-ticket-selection-data',
			data: setAjaxData(dataArray),
		});
}

function removeSeatToTempTable(seatId) 
{
	var dataArray = {
					'seats':seatId, 
		};
		$.ajax({
			type: 'POST',
			url: MdsConfig.baseURL + '/reserve-ticket-selection-data-remove',
			data: setAjaxData(dataArray),
		});
}



$(document).ready(function() {
    $("#ticket_booking_back").click(function() {
		swal({
		  title: "Redirect back",
		  text: "Are you sure? All your data will be lost!",
		  icon: "info",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) 
		  {
			var dataArray = {
					'seats':'', 
			};
			$.ajax({
				type: 'POST',
				url: MdsConfig.baseURL + '/ticket-temp-selection-data-deleted',
				data: setAjaxData(dataArray),
				success: function (response) {
				if(response)
				{
					window.location.href = '<?= adminUrl('ticket-booking'); ?>';
				}
				}
			});
			
		  } 
		  else
		  {
			  return false;
		  }
		});
							
    });
});

function getTheSeatDataReserved(seatID)
{
	return new Promise(function(resolve) {
	var reserved;
	var dataArray = {
					'seats':seatID, 
	};
	
	$.ajax({
		type: 'POST',
		url: MdsConfig.baseURL + '/ticket-temp-selection-data-reserved-not',
		data: setAjaxData(dataArray),
		success: function (response) {
			var obj = JSON.parse(response);
			if (obj.result == 1) {
				swal('Sorry','The selected seat is reserved choose other seat','info');
				removeSeatToTempTable(seatID)
				$('#aldreadyreserved').val(1);
				 // Remove selected class from the seat
				$(".seat[data-id='" + obj.seatID + "']").removeClass("selected");

				// Remove adult and child classes if present
				$(".seat[data-id='" + obj.seatID + "']").removeClass("adult child");

				// Add occupied class to the seat
				$(".seat[data-id='" + obj.seatID + "']").addClass("occupied");
				reserved = 1;
				resolve(reserved);
			}
			else
			{
				reserved = 0;
				resolve(reserved);
			}	
		}
	});
	});
	/* reserved = $('#aldreadyreserved').val();
	console.log("Return" + reserved);
	return reserved; */
}

 $(document).ready(function () {
	var totalItems = $('#totalItemsCount').html();
	var itemsToDisplay = 3; // Default value
	if (totalItems <= 3) {
		itemsToDisplay = totalItems;
	}
  
	var itemsToDisplay600 = 2;
	if (totalItems < 2) {
		itemsToDisplay600 = 1;
	}
  
	var imgHeight = itemsToDisplay === 1 ? '500px !important' : '';
	
  // Owl Carousel
	var owl = $("#news-slider");
	owl.owlCarousel({
		items: itemsToDisplay,
		loop: true,
		nav: true,
		itemsDesktop: [1199, itemsToDisplay],
		itemsDesktopSmall: [980, itemsToDisplay600],
		itemsMobile: [600, 1],
		pagination: true,
		autoplay: true, // Enable auto carousel
		autoplayTimeout: 3000, // Set the autoplay interval in milliseconds (3 seconds in this example)
		autoplayHoverPause: true, // Pause autoplay when the mouse hovers over the carousel
		navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'], // Customize navigation text with Font Awesome icons
		 responsive: {
		  0: {
			items: 1 
		  },
		  600: {
			items: itemsToDisplay600
		  },
		  992: {
			items: itemsToDisplay 
		  }
		}
	});
	
	if (itemsToDisplay == 1) 
	{
		console.log('a');
		$('#news-slider .post-slide .post-img').css({
			'height': '500px',
			'object-fit': 'cover'
		  });
	  }
});

 $(document).ready(function () {
	var totalItems = $('#totalItemsCountMagazine').html();
	var itemsToDisplay = 3; // Default value
	if (totalItems <= 3) {
		itemsToDisplay = totalItems;
	}
  
	var itemsToDisplay600 = 2;
	if (totalItems < 2) {
		itemsToDisplay600 = 1;
	}
  
	var imgHeight = itemsToDisplay === 1 ? '500px !important' : '';
	
  // Owl Carousel
	var owl = $("#news-slider-magazine");
	owl.owlCarousel({
		items: itemsToDisplay,
		loop: true,
		nav: true,
		itemsDesktop: [1199, itemsToDisplay],
		itemsDesktopSmall: [980, itemsToDisplay600],
		itemsMobile: [600, 1],
		pagination: true,
		autoplay: true, // Enable auto carousel
		autoplayTimeout: 3000, // Set the autoplay interval in milliseconds (3 seconds in this example)
		autoplayHoverPause: true, // Pause autoplay when the mouse hovers over the carousel
		navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'], // Customize navigation text with Font Awesome icons
		 responsive: {
		  0: {
			items: 1 
		  },
		  600: {
			items: itemsToDisplay600
		  },
		  992: {
			items: itemsToDisplay 
		  }
		}
	});
	
	if (itemsToDisplay == 1) 
	{
		console.log('a');
		$('#news-slider .post-slide .post-img').css({
			'height': '500px',
			'object-fit': 'cover'
		  });
	  }
});

$(document).ready(function(){
  // Initialize the Slick slider
  $('.slick-slider').slick({
    centerMode: true,
    centerPadding: '0',
    slidesToShow: 3,
    arrows: false,
    autoplay: true,
	 autoplaySpeed: 1000,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1
        }
      }
    ]
  });

  // Add event handlers for the arrow icons
  $('.prev').click(function() {
    $('.slick-slider').slick('slickPrev'); // Move to the previous slide
  });

  $('.next').click(function() {
    $('.slick-slider').slick('slickNext'); // Move to the next slide
  });
});

$(document).ready(function(){
	var captchaImages = [
        { value: 1, src: "<?= base_url('assets/images_agarwal/captcha/captcha1.jpg'); ?>" },
        { value: 2, src: "<?= base_url('assets/images_agarwal/captcha/captcha2.jpg'); ?>" },
        { value: 3, src: "<?= base_url('assets/images_agarwal/captcha/captcha3.jpg'); ?>" }
    ];
    
    // Index to keep track of the current image
    var currentImageIndex = 0;
    
    // Function to update captcha image
    function updateCaptchaImage() {
        $('#captchaImageForm').attr('src', captchaImages[currentImageIndex].src).data('value', captchaImages[currentImageIndex].value);
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
    $('#reloadCaptchaForm').on('click', function() {
        reloadCaptcha();
    });
	
  // Initialize the Slick slider
  $('.slick-slider').slick({
    centerMode: true,
    centerPadding: '0',
    slidesToShow: 3,
    arrows: false,
    autoplay: true,
	 autoplaySpeed: 1000,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1
        }
      }
    ]
  });

  // Add event handlers for the arrow icons
  $('.prev').click(function() {
    $('.slick-slider').slick('slickPrev'); // Move to the previous slide
  });

  $('.next').click(function() {
    $('.slick-slider').slick('slickNext'); // Move to the next slide
  });
});

var guest = "<?= isGuest();?>";

if(guest)
{
	new jBox("Notice", {
		attributes: {
		  x: "top",
		  y: "left"
		},
		stack: false,
		animation: {
		  open: "tada",
		  close: "zoomIn"
		},
		color: 'blue',
		title: "Information",
		content: "Kindly click on the top right where your name is shown and select the displayed menu.",
		delayOnHover: true, // Delay closing on hover
		autoClose: 10000 
	});
}
</script>
</body>
</html>
<?php if (!empty($isPage404)): exit(); endif; ?>
<link rel="stylesheet" href="<?= base_url('assets/vendor/slick-slider/slick.css'); ?>">	
<link rel="stylesheet" href="<?= base_url('assets/vendor/slick-slider/slick-theme.css'); ?>">
<div class="section-slider">
    <?php if (!empty($sliderItems) && $generalSettings->slider_status == 1):
        echo view('partials/_main_slider');
    endif; ?>
</div>

<div class="containers"> 
    <div class="row">
		<div class="column animate-slide-in-left">
			<img height = "100%" src="<?= base_url().'/'.esc($generalSettings->event_image); ?>" class="img-top img-fluid"  style="margin-top : 10px;border-radius: 10px;">
		</div>
		
		<div class="column animate-slide-in-right">
			<?php
			if(isset($event_images) && is_array($event_images))
			{
			foreach ($event_images as $index => $image) : ?>
				<img id="image<?= $index ?>" src="<?= base_url().'/'.esc($image->image_path); ?>" alt="Image <?= $index + 1 ?>" class="img-top img-fluid box-image<?= $index === 0 ? '' : ' hidden_img'; ?>" style="margin-top : 10px;border-radius: 10px;">
			<?php endforeach;
			}?>
		</div>
    </div>
</div>

<?php
	if(isset($event_images) && is_array($event_images))
	{?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var totalImages = <?= count($event_images) ?>;
    var currentImage = 0;

 function toggleImages() {
        document.getElementById("image" + currentImage).classList.toggle("hidden_img");
        currentImage = (currentImage + 1) % totalImages;
        document.getElementById("image" + currentImage).classList.toggle("hidden_img");
    }

    function changeImageOnClick() {
        document.getElementById("image" + currentImage).classList.toggle("hidden_img");
        currentImage = (currentImage + 1) % totalImages;
        document.getElementById("image" + currentImage).classList.toggle("hidden_img");
    }

    setInterval(toggleImages, 5000);

    // Attach click event handler to each image
    for (var i = 0; i < totalImages; i++) {
         document.getElementById("image" + i).addEventListener("click", changeImageOnClick);
    }
});
</script>
	<?php }?>
<style>
.img-top
{
	max-height : 88%;
	max-width : 88%;
}

.img-top-left
{
	height : 100%;
	max-width : 100%;
}
.column {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 1200px) {
            .column {
                flex-basis: 100%;
            }
        }
		
		@media (max-width: 1400px) {
            
			.center-text-overlay
			{
				display : none;
			}
        }
.center-text-overlay {
    position: absolute;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
	 z-index: 2;
}

.center-text-overlay p {
    margin: 0;
    font-size: 24px; /* Adjust font size as needed */
    color: #333; /* Adjust text color as needed */
}

.hidden_img 
{
    display: none;
}

.banner 
  {
  position: relative;
  height: 95vh; /* Adjust the height as needed */
  overflow: hidden;
}

.dark-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* Adjust the opacity (last value) to control the darkness */
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
@media (max-width: 1400px) {
	.center-text-overlay
	{
		display : none;
	}

}

</style>
  
<section id="cards_below" class="section-bg bg-color-container">
    <div class="container">
		<?php
		$add_card = '';
		$count = 0; ?>
    <div class="rows">
        <?php foreach ($tickets as $item): 
		$currentDate = date('Y-m-d');
		
		$timezone = new DateTimeZone(esc($generalSettings->timezone)); 
		$currentDateTime = new DateTime('now', $timezone);
		$currentTime = $currentDateTime->format('H:i:s');
		$currentTime = date('H:i:s');

		$mergedatetime =  new DateTime($currentDate . ' ' . $currentTime);
	
		$ticketShowDate = new DateTime($item->ticketShowDate);
		$ticketHideDate = new DateTime($item->ticketHideDate);
		
		$ticketStartTime = $item->ticketDisplayTime;
	
		$mergedatetime2 =  new DateTime($item->ticketShowDate . ' ' . $ticketStartTime);
		
		if($item->visible == 1)
		{
			if ($currentDate >= $ticketShowDate->format('Y-m-d') && $currentDate <= $ticketHideDate->format('Y-m-d')) 
			{
				if ($mergedatetime >= $mergedatetime2) 
				{
		?>
            <div class="col-lg-3 col-sm-6">
                <div class="card-up hovercard">
                    <div class="cardheader-1" style="background: url(<?= base_url().'/'.$item->event_image; ?>);"></div>
                    <div class="avatar">
                        <img alt="" src="<?= base_url('assets/images_agarwal/tickets.png'); ?>">
                    </div>
                    <h3 class="name"><?php echo $item->event_name; ?><br><?php echo $item->event_date;?></h3>
					<?php if (authCheck()){ ?>
						<button type="button" class="btn btn-danger btn-lg btn-radius" onclick="redirectToBookTicket('<?= $item->id;?>')"><?= trans('book_now'); ?></button>
					<?php }
					else { ?>
						<a href="javascript:void(0)" class="btn btn-danger btn-lg btn-radius" data-toggle="modal" class="btn btn-info" data-target="#loginModal"><?= trans('book_now'); ?></a>
					<?php }?>
                </div>
            </div>
            <?php $count++; ?>
            <?php if ($count % 4 === 0): ?>
                </div><div class="rows">
            <?php endif; ?>
        <?php
				}
			}
		}
		endforeach; 
		
			$a = count($tickets);
			$b = $a % 4;
			//echo $b;
			
			if($b == '3')
			{
				$add_card = 'show_one';
			?>
				<div class="col-lg-3 col-sm-6">

					<div class="card-up hovercard">
						<div class="cardheader-2">

						</div>
						<div class="avatar">
							<img alt="" src="<?= base_url('assets/images_agarwal/renew_membership.png'); ?>">
						</div>
						<h3 class="name">Purchase / Renew Your<br>Membership Now</h3>
						 <button type="button" class="btn btn-danger btn-lg btn-radius" onclick="redirectToMembership()">Purchase / Renew Now</button>
					</div>

				</div>
			<?php 
			}
			else if($b == 2 || $b == 1)
			{ ?>
				<div class="col-lg-3 col-sm-6">

					<div class="card-up hovercard">
						<div class="cardheader-2">

						</div>
						<div class="avatar">
							<img alt="" src="<?= base_url('assets/images_agarwal/renew_membership.png'); ?>">
						</div>
						<h3 class="name">Purchase / Renew Your<br>Membership Now</h3>
						 <button type="button" class="btn btn-danger btn-lg btn-radius" onclick="redirectToMembership()">Purchase / Renew Now</button>
					</div>

				</div>
			
				<div class="col-lg-3 col-sm-6"> 

					<div class="card-up hovercard">
						<div class="cardheader-3">

						</div>
						<div class="avatar">
							<img alt="" src="<?= base_url('assets/images_agarwal/image_gallery.png'); ?>">
						</div>
					   <h3 class="name">Our<br>Picture Gallery</h3>
						<button type="button" class="btn btn-danger btn-lg btn-radius" onclick="redirectToGallery()">View Now</button>
					</div>

				</div>
				
		<?php 
			}
			else if($b == 0)
			{
				$add_card = 'show_two';
			}
		?>
		
    </div>

	<?php if($add_card == 'show_one' && $add_card !='')
	{
		?>
		<div class="rows">
			<div class="col-lg-3 col-sm-6"> 

					<div class="card-up hovercard">
						<div class="cardheader-3">

						</div>
						<div class="avatar">
							<img alt="" src="<?= base_url('assets/images_agarwal/image_gallery.png'); ?>">
						</div>
					   <h3 class="name">Our<br>Picture Gallery</h3>
						<button type="button" class="btn btn-danger btn-lg btn-radius" onclick="redirectToGallery()">View Now</button>
					</div>

				</div>
		</div>
	<?php  
	}
	else if($add_card == 'show_two' && $add_card !='')
	{
	?>
		<div class="rows">
			<div class="col-lg-3 col-sm-6">

				<div class="card-up hovercard">
					<div class="cardheader-2">

					</div>
					<div class="avatar">
						<img alt="" src="<?= base_url('assets/images_agarwal/renew_membership.png'); ?>">
					</div>
					<h3 class="name">Renew Your<br>Membership Now</h3>
					 <button type="button" class="btn btn-danger btn-lg btn-radius" onclick="redirectToMembership()">Renew Now</button>
				</div>

			</div>

			<div class="col-lg-3 col-sm-6"> 

				<div class="card-up hovercard">
					<div class="cardheader-3">

					</div>
					<div class="avatar">
						<img alt="" src="<?= base_url('assets/images_agarwal/image_gallery.png'); ?>">
					</div>
				   <h3 class="name">Our<br>Picture Gallery</h3>
					<button type="button" class="btn btn-danger btn-lg btn-radius" onclick="redirectToGallery()">View Now</button>
				</div>

			</div>
		</div>
	<?php  
	}
	?>

	</div>
</section>

<style>

.bg-color-container
{
	background-color : #EEE;
}
.card-up 
{
    padding-top: 20px;
    margin: 10px 0 20px 0;
    background-color: rgba(214, 224, 226, 0.2);
    border-top-width: 0;
    border-bottom-width: 2px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
	border-radius:15px;
}

.card-up:hover
{
	//box-shadow: -30px 30px 30px rgba(0, 0, 0, 0.3);
	
	-webkit-box-shadow: 0 20px 40px rgba(72,78,85,.6);
	box-shadow: 0 20px 40px rgba(72,78,85,.6);
	-webkit-transform: translateY(-15px);
	-moz-transform: translateY(-15px);
	-ms-transform: translateY(-15px);
	-o-transform: translateY(-15px);
	transform: translateY(-15px);
	
	-webkit-transition: transform 0.25s ease-in-out;
    -moz-transition:transform 0.25s ease-in-out;
    -ms-transition:transform 0.25s ease-in-out;
}

.card-up.hovercard {
    position: relative;
    padding-top: 0;
    overflow: hidden;
    text-align: center;
	background-color: #fff;
	padding-bottom: 30px;
}

.card-up.hovercard .cardheader-1 
{  
    background-size: cover !important;
    height: 135px;
	background-position : bottom;
}

.card-up.hovercard .cardheader-2 
{
    background: url("<?= base_url('assets/images_agarwal/image-top-2.jpg') ?>");  
    background-size: cover;
     height: 135px;
	background-position : bottom;
}

.card-up.hovercard .cardheader-3 
{
    background: url("<?= base_url('assets/images_agarwal/image-top-3.jpg') ?>");  
    background-size: cover;
    height: 135px;
}

.card-up.hovercard .avatar {
    position: relative;
    top: -50px;
    margin-bottom: -50px;
}

.card-up.hovercard .avatar img {
    width: 100px;
    height: 100px;
    max-width: 100px;
    max-height: 100px;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    border-radius: 50%;
    border: 5px solid rgba(255,255,255,0.5);
}

</style>
  <?php 
  
  /*
<div id="wrapper" class="index-wrapper">
    <div class="container">
        <div class="row">
            <h1 class="index-title"><?= esc($baseSettings->site_title); ?></h1>
            <?php if (countItems($featuredCategories) > 0 && $generalSettings->featured_categories == 1): ?>
                <div class="col-12 section section-categories">
                    <?= view('partials/_featured_categories'); ?>
                </div>
            <?php endif;
            echo view('product/_index_banners', ['bannerLocation' => 'featured_categories']);
            echo view('partials/_ad_spaces', ['adSpace' => 'index_1', 'class' => 'mb-3']);
            echo view('product/_special_offers', ['specialOffers' => $specialOffers]);
            echo view("product/_index_banners", ['bannerLocation' => 'special_offers']);
            if ($generalSettings->index_promoted_products == 1 && $generalSettings->promoted_products == 1 && !empty($promotedProducts)): ?>
                <div class="col-12 section section-promoted">
                    <?= view('product/_featured_products'); ?>
                </div>
            <?php endif;
            echo view('product/_index_banners', ['bannerLocation' => 'featured_products']);
            if ($generalSettings->index_latest_products == 1 && !empty($latestProducts)): ?>
                <div class="col-12 section section-latest-products">
                    <h3 class="title">
                        <a href="<?= generateUrl('products'); ?>"><?= trans("new_arrivals"); ?></a>
                    </h3>
                    <p class="title-exp"><?= trans("latest_products_exp"); ?></p>
                    <div class="row row-product">
                        <?php foreach ($latestProducts as $item): ?>
                            <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                                <?= view('product/_product_item', ['product' => $item, 'promotedBadge' => false, 'isSlider' => 0, 'discountLabel' => 0]); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif;
            echo view('product/_index_banners', ['bannerLocation' => 'new_arrivals']);
            echo view('product/_index_category_products', ['indexCategories' => $indexCategories]);
            echo view('partials/_ad_spaces', ['adSpace' => 'index_2', 'class' => 'mb-3']); ?>

            <?php if ($generalSettings->index_blog_slider == 1 && !empty($blogSliderPosts)): ?>
                <div class="col-12 section section-blog m-0">
                    <h3 class="title"><a href="<?= generateUrl('blog'); ?>"><?= trans("latest_blog_posts"); ?></a></h3>
                    <p class="title-exp"><?= trans("latest_blog_posts_exp"); ?></p>
                    <div class="row-custom">
                        <div class="blog-slider-container">
                            <div id="blog-slider" class="blog-slider">
                                <?php foreach ($blogSliderPosts as $item):
                                    echo view('blog/_blog_item', ['item' => $item]);
                                endforeach; ?>
                            </div>
                            <div id="blog-slider-nav" class="blog-slider-nav">
                                <button class="prev"><i class="icon-arrow-left"></i></button>
                                <button class="next"><i class="icon-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
			
			<!--
			<div class="col-md-6 animate-slide-in-left">
				<div class="left-content">
					<div class="left-content-inner">
						<h3 id="typing-animation"></h3>
						<button type="button" class="btn btn-primary btn-lg btn-radius">ABC PICNIC 2023</button>
						<p>Sunday, July 9th, 2023</p>
					</div>
				</div>
			</div>
			
			<div class="col-md-6 animate-slide-in-right">
				<img src="" alt="Upcomming Event Image" class="box-image">
			</div>
			
			-->
        </div>
    </div>
    </div>
	
	*/?>
	
	<?php /*
	<div class="team-boxed">
        <div class="container">
            <div class="rows people">
                <div class="col-md-6 col-lg-3 item">
                    <div class="box box1"><img class="rounded-circle" src="<?= base_url('assets/images_agarwal/tickets.png'); ?>">
                        <h3 class="name">ABC Diwali<br>Gala 2023<br>Tickets</h3>
                        <button type="button" class="btn btn-danger btn-lg btn-radius">Buy Now</button>
                    </div>
                </div>

				<div class="col-md-6 col-lg-3 item">
                    <div class="box box2"><img class="rounded-circle" src="<?= base_url('assets/images_agarwal/renew_membership.png'); ?>">
                        <h3 class="name">Renew Your<br>Membership<br>Now</h3>
                        <button type="button" class="btn btn-danger btn-lg btn-radius">Renew Now</button>
                    </div>
                </div>

				<div class="col-md-6 col-lg-3 item">
                    <div class="box box3"><img class="rounded-circle" src="<?= base_url('assets/images_agarwal/image_gallery.png'); ?>">
                        <h3 class="name">ABC<br>Picture<br>Gallery</h3>
                        <button type="button" class="btn btn-danger btn-lg btn-radius">View Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	*/?>

	
<section id="clients" class="section-bg">
  <div class="container">
    <div class="section-header">
      <h3>OUR SPONSORS</h3>
      <p>Meet Our Happy Sponsors</p>
    </div>

    <div class="slick-slider">
      <?php foreach ($ourSponsors as $item): ?>
        <div class="slide-item">
          <div class="client-logo">
            <img src="<?= base_url().'/'.$item->image; ?>" class="img-fluid" alt="">
          </div>
        </div>
      <?php endforeach; ?>
    </div>
	
	
	<div class="custom-arrows">
    <div class="icon icon-2 prev">
      <div class="arrow">
        <div class="left-arrow"></div>
      </div>
    </div>
	<div class="icon icon-1 next">
      <div class="arrow">
        <div class="right-arrow"></div>
      </div>
    </div>
	</div>
    
    <div class="section-header subscribe">
      <button type="button" class="btn btn-danger btn-lg btn-radius" onclick="redirectToSponsorNow()">Sponsor Now</button>
      <p>If Interested in Sponsoring Our Event, Click Here</p>
    </div>
  </div>
</section>

<style>
.slick-slider
{
	 border: 3px solid #ff767694;
	 box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
}
/* Style the custom arrows */
.custom-arrows {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 20px;
}

.icon {
  background: #EBBA16;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  float: left;
  margin: 20px;
  height: 50px; /* Reduce the height to make the arrows smaller */
  width: 50px; /* Reduce the width to make the arrows smaller */
  cursor: pointer;
}

/* Arrow specific styles */
.icon-1 .right-arrow {
  border-style: solid;
  border-color: #FFF;
  border-width: 0 6px 6px 0; /* Adjust the border width to make the arrow smaller */
  margin-left: -6px; /* Adjust the margin to center the arrow */
  padding: 8px; /* Adjust the padding to control the arrow size */
  transform: rotate(-45deg);
}

.icon-2 .left-arrow {
  border-style: solid;
  border-color: #FFF;
  border-width: 0 6px 6px 0; /* Adjust the border width to make the arrow smaller */
  margin-right: -6px; /* Adjust the margin to center the arrow */
  padding: 8px; /* Adjust the padding to control the arrow size */
  transform: rotate(135deg);
}

/* Add styles for other custom arrows (icon-3, icon-4, icon-5) as needed */

/* Hover effect for custom arrows */
.icon:hover {
  background-color: #ff5733; /* Change background color on hover */
}


/* Custom CSS styles */
.slick-slider {
  margin: 0 auto;
  background-color: #f4f4f4; /* Set your desired background color */
}

.client-logo img {
  transition: transform 0.2s ease-in-out; /* Add a subtle hover effect */
}

.client-logo img:hover {
  transform: scale(1.05); /* Scale up the image on hover */
}

/* Style navigation arrows and dot indicators here */

</style>

<?php 
shuffle($homePageImages);

$randomImages = array_slice($homePageImages, 0, 6);
?>
<div id="wrapper" class="index-wrapper bg-color-container">
	<div class="container">
		<div class="section-header-h3">
		  <h3>Explore Our Captivating Moments</h3>
		</div>
		<div class="row">
			<div class="col-12 section section-categories">
				<div class="featured-categories">
					<div class="card-columns">
						<div class="image-gallery">
							<?php foreach($randomImages as $item):?>
							
								<div class="card lazyload" data-bg="<?= base_url().'/'.$item->image_path; ?>">
								 <a href="<?= adminUrl('show-image/' . $item->categoryId); ?>" class="label">&nbsp;<i class="fa fa-folder">&nbsp;</i><?= $item->categoryName;?></a>
								</div>
							<?php endforeach;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	
	<style>
	.label {
		width: 100%;
		height: 100%;
		position: absolute;
		top: 0;
		left: 0;
		opacity: 0;
		background: linear-gradient(-45deg, rgba(6, 190, 244, 0.75) 0%, rgba(45, 112, 253, 0.6) 100%);
		transition: all 0.50s linear;
        color: white; /* Text color for the label */
        text-align: center;
        padding: 8px;
        opacity: 0; 
    }

    .card:hover .label {
        opacity: 1; /* Show the label on hover */
		font-size : 25px !important;
		font-weight : bold !important;
		color : white !important;
    }
	/* CSS */
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

	</style>
<section id="below_section" class="section-bg">

<div class="container">
	<div class="section-header-h3">
          <h3>Join Our Community</h3>
        </div>
<ul class="cards">
  <li class="box-shadow">
    <a href="<?= generateUrl('abcmembership'); ?>#memberBenefits" class="card-bs">
      <img src="<?= base_url('assets/images_agarwal/member_home.png'); ?>" class="card__image" alt="" />
      <div class="card__overlay">
        <div class="card__header">                    
          <img class="card__thumb" src="<?= base_url('assets/images_agarwal/membership_icon_1.png'); ?>" alt="" />
          <div class="card__header-text">
            <h3 class="card__title">Membership Benefits</h3>            
            <span>Agarwals Based in Canada member benefits</span>
          </div>
        </div>
       <div class="text_card">
			<button type="button" class="btn btn-danger btn-lg btn-radius">Membership Benefits</button>
		</div>
      </div>
    </a>      
  </li>

  <li class="box-shadow">
    <a href="<?= generateUrl('aboutUs/contactUs'); ?>#conactUs" class="card-bs">
      <img src="<?= base_url('assets/images_agarwal/contact_home.png'); ?>" class="card__image" alt="" />
      <div class="card__overlay">
        <div class="card__header">
		 <img class="card__thumb" src="<?= base_url('assets/images_agarwal/contact_1.png'); ?>" alt="" />
          <div class="card__header-text">
            <h3 class="card__title">Contact Us</h3> 
			<span>If you have any suggestions, Feel free to Email us</span>
          </div>
        </div>
		<div class="text_card">
			<button type="button" class="btn btn-danger btn-lg btn-radius">Contact</button>
		</div>
      </div>
    </a>
  </li>
  
  
  <li class="box-shadow">
    <a href="<?= generateUrl('library'); ?>" class="card-bs"> 
      <img src="<?= base_url('assets/images_agarwal/library_home.png'); ?>" class="card__image" alt="" />
      <div class="card__overlay">
        <div class="card__header">
			<img class="card__thumb" src="<?= base_url('assets/images_agarwal/newsletter_1.png'); ?>" alt="" />
          <div class="card__header-text">
            <h3 class="card__title">Library</h3>
            <span>More Than Books: It's a Journey, Check out our library</span>
          </div>          
        </div>
        <div class="text_card">
			<button type="button" class="btn btn-danger btn-lg btn-radius">Library</button>
		</div>
      </div>
    </a>
  </li>    
</ul>
</div>
</section>

<?php
use App\Models\SettingsModel;
$this->settingsModel = new SettingsModel();
$settings = $this->settingsModel->getAllSettingsData();
?>

<?php if ($settings->showFacebookPage == 1): ?>
<div id="wrapper" class="index-wrapper bg-color-container mt-3 fb-container" style="margin-bottom: 0px !important;">
    <div class="container">
        <div class="section-header-h3 justify-content-center">
            <h3>Connect With Us</h3>
        </div>
        <div class="row mt-4 justify-content-center">
            <?php if ($settings->showFacebookPage == 1): ?>
            <div class="col-md-6 col-lg-4 col-sm-8 mb-4 text-center">
				<div class="iframe-container">
					<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fagarwalsincanada&tabs=timeline%2Cmessages%2Cevents&width=450&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="450" height="500" style="border-radius:15px;border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe> 
				</div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>


<style>
@media (max-width: 500px) {
	.fb-container
	{
		display:none !important;
	}
}
.section-header h3 {
    font-size: 36px;
    color: #283d50;
    text-align: center;
    font-weight: 500;
    position: relative;
}
.section-header-h3 h3 {
    font-size: 36px;
    color: #283d50;
    text-align: center;
    font-weight: 500;
    position: relative;
	margin-bottom:30px;
}

.section-header button 
{
    font-size: 19px;
}

.section-header
{
	text-align : center;
}

.section-header p {
    text-align: center;
    margin: auto;
    font-size: 18px;
    padding-bottom: 30px;
    color: #000;
    width: 50%;
	margin-top : 15px;
}

#cards_below
{
	padding: 40px 0;
}

#below_section
{
	padding: 40px 0;
}

#clients {
    padding: 30px 0;
    
}
#clients .clients-wrap {
    
    margin-bottom: 20px;
}

#clients .client-logo {
    padding: 64px;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -webkit-justify-content: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    border-right: 2px solid #ff767694;
    overflow: hidden;
    background: #fff;
    height: 160px;
}

#clients img {
    transition: all 0.4s ease-in-out;
}
  


.team-boxed {
  color:#313437;
}

.team-boxed p {
  color:#7d8285;
}

.team-boxed h2 {
  font-weight:bold;
  margin-bottom:40px;
  padding-top:40px;
  color:inherit;
}

@media (max-width:767px) {
  .team-boxed h2 {
    margin-bottom:25px;
    padding-top:25px;
    font-size:24px;
  }
}

.team-boxed .intro {
  font-size:16px;
  max-width:500px;
  margin:0 auto;
}

.team-boxed .intro p {
  margin-bottom:0;
}

.team-boxed .people {
  padding:50px 0;
}

.team-boxed .item {
  text-align:center;
}

.team-boxed .item .box {
  text-align:center;
  padding:30px;
  background-color:#fff;
  margin-bottom:30px;
}

.team-boxed .item .box {
	-webkit-box-shadow: 0 1px 1px rgba(72,78,85,.6);
	box-shadow: 0 1px 1px rgba(72,78,85,.6);
	-webkit-transition: all .2s ease-out;
	-moz-transition: all .2s ease-out;
	-ms-transition: all .2s ease-out;
	-o-transition: all .2s ease-out;
	transition: all .2s ease-out;
}

.team-boxed .item .box:hover {
	-webkit-box-shadow: 0 20px 40px rgba(72,78,85,.6);
	box-shadow: 0 20px 40px rgba(72,78,85,.6);
	-webkit-transform: translateY(-15px);
	-moz-transform: translateY(-15px);
	-ms-transform: translateY(-15px);
	-o-transform: translateY(-15px);
	transform: translateY(-15px);
}

.team-boxed .item .box1 
{
  background-color: #eee;
  border-radius: 40px;
}

.team-boxed .item .box2 
{
  background-color: #eee;
  border-radius: 40px;
}

.team-boxed .item .box3 
{
  background-color: #eee;
  border-radius: 40px;
}

.team-boxed .item .name {
  font-weight:bold;
  margin-top:28px;
  margin-bottom:8px;
  color:inherit;
}

.team-boxed .item .title {
  text-transform:uppercase;
  font-weight:bold;
  color:#d0d0d0;
  letter-spacing:2px;
  font-size:13px;
}

.team-boxed .item .description {
  font-size:15px;
  margin-top:15px;
  margin-bottom:20px;
}

.team-boxed .item img {
  max-width:100px;
}

.team-boxed .social {
  font-size:18px;
  color:#a2a8ae;
}

.rows
{
	display: -ms-flexbox;
display: flex;
-ms-flex-wrap: wrap;
flex-wrap: wrap;
margin-right: -15px;
margin-left: -15px;
align-items: center;
justify-content: center;
}

	:root {
  --surface-color: #fff;
  --curve: 40;
}

.box-shadow{
	-webkit-box-shadow: 0 5px 16px rgba(72,78,85,.6);
	box-shadow: 0 5px 16px rgba(72,78,85,.6);
	-webkit-transition: all .2s ease-out;
	-moz-transition: all .2s ease-out;
	-ms-transition: all .2s ease-out;
	-o-transition: all .2s ease-out;
	transition: all .2s ease-out;
	border-radius:48px;
}

.box-shadow:hover{
	-webkit-box-shadow: 0 20px 40px rgba(72,78,85,.6);
	box-shadow: 0 20px 40px rgba(72,78,85,.6);
	-webkit-transform: translateY(-15px);
	-moz-transform: translateY(-15px);
	-ms-transform: translateY(-15px);
	-o-transform: translateY(-15px);
	transform: translateY(-15px);
	border-radius:48px;
}

.cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
 //margin: 4rem 5vw;
  padding: 0;
  list-style-type: none;
}

.card-bs {
  position: relative;
  display: block;
  height: 50vh;  
  border-radius: calc(var(--curve) * 1px);
  overflow: hidden;
  text-decoration: none;
}

.card__image {      
  width: 100%;
  height: auto;
}

.card__overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 1;      
  border-radius: calc(var(--curve) * 1px);    
  background-color: var(--surface-color);      
  transform: translateY(100%);
  transition: .2s ease-in-out;
}

.card-bs:hover .card__overlay {
  transform: translateY(0);
}

.card__header {
  position: relative;
  display: flex;
  align-items: center;
  gap: 2em;
  padding: 2em;
  border-radius: calc(var(--curve) * 1px) 0 0 0;    
  background-color: aliceblue;
  transform: translateY(-100%);
  transition: .2s ease-in-out;
}

.card__arc {
  width: 80px;
  height: 80px;
  position: absolute;
  bottom: 100%;
  right: 0;      
  z-index: 1;
}

.card__arc path {
  fill: var(--surface-color);
  d: path("M 40 80 c 22 0 40 -22 40 -40 v 40 Z");
}       

.card-bs:hover .card__header {
  transform: translateY(0);
}

.card__thumb {
  flex-shrink: 0;
  width: 50px;
  height: 50px;      
  border-radius: 50%;      
}

.card__title {
  font-size: 1.2em !important;
  margin: 0 0 .3em;
  color: #6A515E !important;
}

.card__tagline {
  display: block;
  margin: 1em 0;
  font-family: "MockFlowFont";  
  font-size: .8em; 
  color: #D7BDCA;  
}

.card__status {
  font-size: .8em;
  color: #D7BDCA;
}

.card__description {
  padding: 0 2em 2em;
  margin: 0;
  color: #D7BDCA;
  font-family: "MockFlowFont";   
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 3;
  overflow: hidden;
}  

.text_card
{
	text-align: center;
	margin:0.5rem;
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
</style>

<script>
	/*This code is for animation of typing animation 
		----Start---
	
    document.addEventListener('DOMContentLoaded', function() 
	{
		const text = 'Upcoming Event';
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
	
		----End---
	*/
	
	function redirectToBookTicket(id)
	{
		window.location.href = "<?= adminUrl('edit-ticket-seats/'); ?>/" + id;
	}
	
	function redirectToMembership()
	{
		window.location.href = "<?= generateUrl('abcmembership'); ?>";
	}
	
	function redirectToGallery()
	{
		window.location.href = "<?= generateUrl('gallery'); ?>";
	}
	
	function redirectToSponsorNow()
	{
		window.location.href = "<?= generateUrl('sponsorships'); ?>";
	}
 
</script>
  
<style>	

    /* Animation */
    @keyframes slideInLeft 
	{
      0% {
        transform: translateX(-100%);
      }
      100% {
        transform: translateX(0);
      }
    }

    @keyframes slideInRight 
	{
      0% {
        transform: translateX(100%);
      }
      100% {
        transform: translateX(0);
      }
    }

    .animate-slide-in-left 
	{
		animation: slideInLeft 1s ease-out;
    }

    .animate-slide-in-right 
	{
		animation: slideInRight 1s ease-out;
		text-align : center;
	}

    .left-content 
	{
		display: flex;
		align-items: center;
		justify-content: center;
		height: 100%;
    }

    .left-content-inner 
	{
		text-align: center;
    }
	
	#cards_below h3 
	{
		font-size: 20px;
		font-family: Arial, Helvetica, sans-serif;
		background: linear-gradient( red , blue);
		-webkit-text-fill-color: transparent;
		-webkit-background-clip: text;
		margin : 20px 0px;
	}
	
	.section-header-h3 h3 
	{
		font-size: 36px;
		font-family: Arial, Helvetica, sans-serif;
		background: linear-gradient( red , blue);
		-webkit-text-fill-color: transparent;
		-webkit-background-clip: text;	
	}
	
	#clients h3 
	{
		font-size: 36px;
		font-family: Arial, Helvetica, sans-serif;
		background: linear-gradient( red , blue);
		-webkit-text-fill-color: transparent;
		-webkit-background-clip: text;	
	}
	
	#below_section h3 
	{
		font-size: 36px;
		font-family: Arial, Helvetica, sans-serif;
		background: linear-gradient( red , blue);
		-webkit-text-fill-color: transparent;
		-webkit-background-clip: text;	
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

	.btn-primary 
	{
		background: #5a7ce2;
		background: -moz-linear-gradient(-45deg, #5a7ce2 0%, #8283e8 50%, #5c5de8 51%, #565bd8 71%, #575cdb 100%);
		background: -webkit-linear-gradient(-45deg, #5a7ce2 0%,#8283e8 50%,#5c5de8 51%,#565bd8 71%,#575cdb 100%);
		background: linear-gradient(135deg, #5a7ce2 0%,#8283e8 50%,#5c5de8 51%,#565bd8 71%,#575cdb 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#5a7ce2', endColorstr='#575cdb',GradientType=1 );
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
	
	.subscribe
	{
		margin-top : 40px;
	}
</style>


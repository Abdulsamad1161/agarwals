<style>
  /* Custom CSS to set a fixed height for the card and make the image fit */
  .card {
    position: relative;
    height: 200px; /* Set your desired fixed height */
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

<div class="container">
	<div class="row">
		<div class="col-md-4 mb-3"></div>
		<div class="col-md-4 mb-3 mt-4 col-sm-12">
			<div class="title">
				<h1 class="picture_gallery_h1"><?= $categoty->categoryName;?></h1>
			</div>
		</div>
		<div class="col-md-4 mb-3"></div>
	</div>
</div>


<div id="wrapper" class="index-wrapper">
  <div class="container data_container">
    <?php if (!empty($images)){ ?>
      <?php $chunks = array_chunk($images, 3); ?>
      <?php foreach ($chunks as $row): ?>
        <div class="row">
          <?php foreach ($row as $category): ?>
            <div class="col-md-4 mb-3">
              <div class="card gallery_card">
                <img src="<?= base_url().'/'.esc($category->image_path); ?>" class="card-img-top img-fluid lazyloaded_gallery" alt="Image">
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    <?php  } else { ?>
		<div class="row">
			<div class="col-md-12 text_center">
				 <img src="<?= base_url('assets/images_agarwal/stay_tuned.png'); ?>" alt="Stay Tuned">
			</div>
		</div>
	<?php } ?>
	<div class="row">
	<?= view('partials/_ad_spaces', ['adSpace' => 'products_2', 'class' => 'mt-3']); ?>
	<div class="product-list-pagination n d-flex justify-content-center align-items-center">
		<div class="float-right">
			<?= view('partials/_pagination'); ?>
		</div>
	</div>
 </div>
  </div>
  
</div>

<style>
.data_container
{
	padding: 30px !important;
	border: 2px solid #d1274b;
	border-radius: 10px;
	box-shadow: 10px 10px 10px 10px #adadad6e;
	margin-bottom : 1.5rem !important;
}
.text_center
{
	text-align : center;
}

.text-design
{
  color: white;
  font-weight: bold;
  padding: 6px;
  border-radius: 11px;
  background-image: linear-gradient(to top, #30cfd0 0%, #330867 100%);	
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

</style>

<script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>

<script>

/* This code is for image view in seperate scree */

$(document).ready(function() {
    var images = $('.lazyloaded_gallery');
    var totalImages = images.length;
    var currentIndex = 0;
	
    function showImage(index) 
	{
		console.log(index);
        var src = images.eq(index).attr('src');
        var overlay = $('<div>').addClass('overlay');

        var img = $('<img>').attr('src', src).appendTo(overlay);

        var prevButton = $('<button>').addClass('prev-button').html('&#10094;').click(function(e) {
            e.stopPropagation();
            currentIndex = (currentIndex - 1 + totalImages) % totalImages;
            img.attr('src', images.eq(currentIndex).attr('src'));
        }).appendTo(overlay);

        var nextButton = $('<button>').addClass('next-button').html('&#10095;').click(function(e) {
            e.stopPropagation();
            currentIndex = (currentIndex + 1) % totalImages;
            img.attr('src', images.eq(currentIndex).attr('src'));
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

    $('.lazyloaded_gallery').addClass('img-enlargable').click(function() {
        currentIndex = images.index($(this));
        showImage(currentIndex);
    });
});
</script>

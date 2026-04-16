<div class="banner">
    <div class="dark-overlay"></div>
	<img src="<?= base_url('assets/images_agarwal/matrimonial_image.jpeg'); ?>" alt="Background Image" class="background-image">
    <div class="content">
			<!-- Centered text -->
    <div class="centered-text">
        <h1 id="typing-animation"></h1>
    </div>
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
}
  .banner 
  {
  position: relative;
  height: 55vh; /* Adjust the height as needed */
  overflow: hidden;
}

.dark-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.62);/* Adjust the opacity (last value) to control the darkness */
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
		
</style>

<div class="container">
	<div class="row">
		<div class="col-md-2 mb-3"></div>
		<div class="col-md-8 mb-3 mt-4 col-sm-12">
			<div class="title">
				<h1 class="picture_gallery_h1">Matrimonial Platform Details</h1>
			</div>
		</div>
		<div class="col-md-2 mb-3"></div>
	</div>
    <div class="row padding_row">
		<p>
			&emsp;&emsp;<i class="fa fa-angle-right red" aria-hidden="true"></i>&emsp;&emsp;We are pleased to inform you that for the benefit of ABC members, we have partnered with ICVivah, an external organization, to provide a matrimonial platform that is free of charge.<br>

			&emsp;&emsp;<i class="fa fa-angle-right red" aria-hidden="true"></i>&emsp;&emsp;Families that are interested may register their daughter or son by creating a profile at below provided link.<br>

			&emsp;&emsp;<i class="fa fa-angle-right red" aria-hidden="true"></i>&emsp;&emsp;Link : <span class="note"><a class="note" href = "https://icvivah.com/landingpage" target ="_blank">https://icvivah.com/landingpage</a></span><br>
			
			&emsp;&emsp;<i class="fa fa-angle-right red" aria-hidden="true"></i>&emsp;&emsp;If you require more information about the platform, please contact at  <i class="fa fa-envelope red" aria-hidden="true"></i>  <span class="note-black">info@icvivah.com </span>or  <i class="fa fa-phone red" aria-hidden="true"></i> <span class="note-black">416-803-3609 (Sushil and Sangita Agrawal / Namarata Maheshwari)</span>.<br>

			&emsp;&emsp;<i class="fa fa-angle-right red" aria-hidden="true"></i>&emsp;&emsp;Please note that ABC is not directly or indirectly associated with ICVIVAH, which is an independent not-for-profit organization.<br>

		</p>
	</div>
</div>
<script>
	/*This code is for animation of typing animation 
		----Start---
	*/
    document.addEventListener('DOMContentLoaded', function() 
	{
		const text = 'ABC Matrimonial Platform';
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
	/*
		----End---
	*/
</script>

<style>
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
	color : blue;
}

.note-black
{
	font-weight : bold;
}

.padding_row
{
	padding: 30px !important;
	border: 2px solid #d1274b;
	margin: 10px;
	border-radius: 10px;
	box-shadow: 10px 10px 10px 10px #adadad6e;
	font-size : 20px;
}
</style>
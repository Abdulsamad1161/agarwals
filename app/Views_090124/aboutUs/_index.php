<style>

.container_spons 
{
	display: flex;
	flex-wrap: wrap;
	justify-content: space-between;
	align-items: center;
}

.content_spons 
{
	flex-basis: calc(60% - 20px);
	padding: 20px;
}

.content_spons h2 
{
	margin-top: 0;
}

.content_spons p 
{
	line-height: 1.6;
}

.image_spons 
{
	flex-basis: calc(40% - 20px);
	overflow: hidden;
	position: relative;
	animation: slideInFromBottom 2s forwards; /* Animation applied */
}

.image_spons img 
{
	width: 100%;
	height: auto;
	display: block;
   // opacity : 0;
}

@keyframes slideInFromBottom 
{
   0% {
		transform: translateY(100%);
		opacity: 0;
	}
	100% {
		transform: translateY(0);
		opacity: 1;
	}
}


@media (max-width: 768px) 
{
	.container_spons {
		flex-direction: column;
	}

	.content_spons,
	.image_spons {
		flex-basis: 100%;
	}
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

header_spons_h5 
{
	margin-bottom: 10px;
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

@keyframes slideInFromLeft 
{
	0% {
		transform: translateX(-100%);
		opacity: 0;
	}
	100% {
		transform: translateX(0);
		opacity: 1;
	}
}
		
.over_container
{
	border-radius: 10px;
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
	overflow: hidden;
	margin: 20px;
	border: 2px solid #d1274b;
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

.underline_head
{
	border-bottom : 2px solid #d1274b;
}
</style>
	
<div class="header_spons">
	<div class="overlay">
		<h1 class="header_spons_h1"><?= trans("about-us");?></h1>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12 mb-3 mt-4 col-sm-12" style="text-align:center;">
			<div class="title">
				<h1 class="picture_gallery_h1">About Agarwals Based in Canada​</h1>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="over_container">
		<div class="content_spons">
			<?= $page1->page_content; ?>
		</div>
	
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12 mb-3 mt-4 col-sm-12" style="text-align:center;">
			<div class="title">
				<h1 class="picture_gallery_h1">Our Vision and Mission is split into 6 core areas​</h1>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="over_container">
		<div class="content_spons">
			<?= $page2->page_content; ?>
		</div>
	
	</div>
</div>
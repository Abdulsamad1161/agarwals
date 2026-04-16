 <style>
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

.title .fa{
  color:#fff;
  font-size: 60px;
  width: 100px;
  height: 100px;
  border-radius:  50%;
  text-align: center;
  line-height: 100px;
  -webkit-box-shadow: 0 10px 10px rgba(0,0,0,.1) ;
          box-shadow: 0 10px 10px rgba(0,0,0,.1) ;

}
.title h2 {
  position: relative;
  margin: 20px  0 0;
  padding: 0;
  color: #FD4659;
  font-size: 28px;
 z-index: 2;
 font-weight: bold;
}
.price,.option{
  position: relative;
  z-index: 2;
}
.price h4 {
margin: 0;
padding: 10px 0 ;
color: #02066F;
font-size: 40px;
font-weight: bold;
}

.price h6 {
margin: 0;
padding: 10px 0 ;
color: #08787F;
font-size: 40px;
}
.option ul {
  margin: 0;
  padding: 0;

}
.option ul li {
margin: 0 0 10px;
padding: 0;
list-style: none;
color: #FE2C54;
font-size: 16px;
}
.card-mem-mp a {
  position: relative;
  z-index: 2;
  background: #fff;
  color : black;
  width: 150px;
  height: 40px;
  line-height: 40px;
  border-radius: 40px;
  display: block;
  text-align: center;
  margin: 20px auto 0 ;
  font-size: 16px;
  cursor: pointer;
  -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, .1);
          box-shadow: 0 5px 10px rgba(0, 0, 0, .1);

}
.card-mem-mp a:hover{
    text-decoration: none;
}

.over_container
{
	border-radius: 10px;
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
	overflow: hidden;
	margin: 20px;
	border: 2px solid #d1274b;
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

.back-color
{
	background-image: linear-gradient(to top, #d5d4d0 0%, #d5d4d0 1%, #eeeeec 31%, #efeeec 75%, #e9e9e7 100%);
}
</style>
	
<div class="header_spons">
	<div class="overlay">
		<h1 class="header_spons_h1">Membership Plans</h1>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12 mb-3 mt-4 col-sm-12" style="text-align:center;">
			<div class="title">
				<h1 class="picture_gallery_h1"><?= trans("choose_your_plan");?></h1>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="over_container back-color">
	<?php 
		if(!empty($checkPlanExists))
		{ ?>
			<div class="row">
				<div class="col-sm-12">
					<?= view('partials/_messages'); ?>
				</div>
			</div>
		<?php } ?>
	<div class="row" style="margin-bottom: 10px;">
	<?php if(!empty($membershipPlans))
	{ ?>
    <?php $count = 0; ?>
    <?php foreach ($membershipPlans as $plan): ?>
        <?php if ($count % 3 === 0): ?>
            </div><div class="row">
        <?php endif; ?>
        <div class="col-sm-4 col-md-4 col-lg-4">
            <div class="card-mem">
                <div class="text-center top-height">
						<div class="product-image">
							<img src="<?= base_url().'/'.$plan->imageUrl; ?>" alt="OFF-white Red Edition" draggable="false" />
						</div>
						<div class="title">
							<h2><?= $plan->title;?></h2>
						</div>
						<div class="price">
							<h4><sup><?= $defaultCurrency->symbol; ?></sup><?= !empty($plan->price) ? getPrice($plan->price, 'input') : ''; ?></h4>
							<h6><?= $plan->number_of_days;?></h6>
						</div>
						<div class="option">
							<ul>
							<?php $features = getMembershipPlanFeatures($plan->features, selectedLangId());
                                if (!empty($features)):
                                    foreach ($features as $feature):?>
                                       <li>
											<i class="fa fa-check" aria-hidden="true"></i> 
											<?= esc($feature); ?>
										</li>
                                    <?php endforeach;
                                endif; ?>
							</ul>
						</div>
						
						<?php if (authCheck()){ ?>
							<a class="btn btn-danger btn-sm btn-radius" href="<?= adminUrl('membership-plan-choose/' . $plan->id); ?>">Buy Now</a>
						<?php }
						else { ?>
							<a class="btn btn-danger btn-sm btn-radius" href="javascript:void(0)" data-toggle="modal" data-target="#loginModal">Buy Now</a>
						<?php }?>
				</div>
            </div>
        </div>
        <?php $count++; ?>
    <?php endforeach; ?>
</div>
<?php }
		else
			{ ?>
				<div class="col-md-12" style="text-align:center">
					 <img src="<?= base_url('assets/images_agarwal/stay_tuned.png'); ?>" alt="Stay Tuned">
				</div>
			<?php } ?>
</div>
</div>

<style>
	img {
    max-width: 100%;
    height: 100%;
    user-select: none;
}

.card-mem {
    position: relative;
    padding: 1rem;
    box-shadow: -1px 15px 30px -12px rgb(32, 32, 32);
    border-radius: 0.9rem;
    background-color: white;
	margin : 20px !important;
}

.product-image {
    height: 230px;
    width: 100%;
}
</style>

<div class="container" id="memberBenefits">
	<div class="row">
		<div class="col-md-12 mb-3 mt-4 col-sm-12" style="text-align:center;">
			<div class="title">
				<h1 class="picture_gallery_h1"><?= trans("membership_benefits");?></h1>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="over_container">
		<div class="content_spons">
			<?= $page->page_content; ?>
		</div>	
	</div>
</div>
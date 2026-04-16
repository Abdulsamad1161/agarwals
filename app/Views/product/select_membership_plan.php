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
  color: #fff;
  font-size: 28px;
 z-index: 2;
}
.price,.option{
  position: relative;
  z-index: 2;
}
.price h4 {
margin: 0;
padding: 20px 0 ;
color: #fff;
font-size: 60px;
}

.price h6 {
margin: 0;
padding: 10px 0 ;
color: #fff;
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
color: #fff;
font-size: 16px;
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

.price-box
{
	padding: 30px !important;
	border: 2px solid #d1274b !important;
	margin: 10px !important;
	border-radius: 10px !important;
	box-shadow: 10px 10px 10px 10px #adadad6e !important;
}
</style>
	
<div class="header_spons">
	<div class="overlay">
		<h1 class="header_spons_h1">Business Membership Plans</h1>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12 mb-3 mt-4 col-sm-12" style="text-align:center;">
			<div class="title">
				<h1 class="picture_gallery_h1">Select Your Business Plan</h1>
			</div>
			<div class="row">
				<div class="col-12">
					<p class="start-selling-description text-muted"><?= trans("select_your_plan_exp"); ?></p>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div id="content" class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb"></ol>
                </nav>
                <div class="form-add-product">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-12">
                            <div class="row">
                                <div class="col-12">
                                    <?= view('partials/_messages'); ?>
                                </div>
                            </div>
                            <form action="<?= base_url('renew-membership-plan-post'); ?>" method="post">
                                <?= csrf_field(); ?>
                                <?php if (!empty($membershipPlans)): ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="price-box-container">
                                                <?php foreach ($membershipPlans as $plan):
                                                    $validPlan = 1;
                                                    if ($plan->is_unlimited_number_of_ads != 1 && $userAdsCount > $plan->number_of_ads) {
                                                        $validPlan = 0;
                                                    }
                                                    if ($plan->is_free == 1 && user()->is_used_free_plan == 1) {
                                                        $validPlan = 0;
                                                    } ?>
                                                    <div class="price-box">
                                                        <?php if ($plan->is_popular == 1): ?>
                                                            <div class="ribbon ribbon-top-right"><span><?= trans("popular"); ?></span></div>
                                                        <?php endif; ?>
                                                        <div class="price-box-inner">
                                                            <div class="pricing-name text-center">
                                                                <h4 class="name font-600"><?= getMembershipPlanName($plan->title_array, selectedLangId()); ?></h4>
                                                            </div>
															
                                                            <div class="plan-price text-center">
                                                                <h3><strong class="price font-700">
                                                                        <?php if ($plan->price == 0):
                                                                            echo trans("free");
                                                                        else:
                                                                            echo priceFormatted($plan->price, $paymentSettings->default_currency, true);
                                                                        endif; ?>
                                                                    </strong>
                                                                </h3>
                                                            </div>
															
															<div class="plan-price text-center">
                                                                <h3><strong class="font-700" style="font-size: 40px;color: #2e2eff;">
                                                                        <?php 
                                                                            echo $plan->number_of_days;
                                                                         ?>
                                                                    </strong>
                                                                </h3>
                                                            </div>
                                                            <div class="price-features">
                                                                <?php $features = getMembershipPlanFeatures($plan->features_array, selectedLangId());
                                                                if (!empty($features)):
                                                                    foreach ($features as $feature):?>
                                                                        <p>
                                                                            <i class="icon-check-thin"></i>
                                                                            <?= esc($feature); ?>
                                                                        </p>
                                                                    <?php endforeach;
                                                                endif; ?>
                                                            </div>
                                                            <div class="text-center btn-plan-pricing-container">
                                                                <?php if ($validPlan == 1):
                                                                    if ($requestType == 'renew'): ?>
                                                                        <button type="submit" name="plan_id" value="<?= $plan->id; ?>" class="btn btn-md btn-danger btn-radius"><?= trans("choose_plan"); ?></button>
                                                                    <?php elseif ($requestType == 'new'): ?>
                                                                        <a href="<?= generateUrl('start_selling'); ?>?plan=<?= $plan->id; ?>" class="btn btn-md btn-custom"><?= trans("choose_plan"); ?></a>
                                                                    <?php endif;
                                                                else: ?>
                                                                    <button type="button" class="btn btn-md btn-danger btn-radius btn-pricing-table-disabled"><?= trans("choose_plan"); ?></button>
                                                                    <?php if ($plan->is_free == 1 && user()->is_used_free_plan == 1): ?>
                                                                        <span class="warning-pricing-table-plan text-muted"><?= trans("warning_plan_used"); ?></span>
                                                                    <?php else: ?>
                                                                        <span class="warning-pricing-table-plan text-muted"><?= trans("warning_cannot_choose_plan"); ?></span>
                                                                    <?php endif;
                                                                endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
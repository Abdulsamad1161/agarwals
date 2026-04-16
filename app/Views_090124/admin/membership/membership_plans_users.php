<div class="row">
    <div class="col-lg-7 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("create_new_plan"); ?></h3>
            </div>
            <form action="<?= base_url('MembershipPlansController/addPlanPostUser'); ?>" method="post"  enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= trans("title"); ?></label>
                            <input type="text" class="form-control m-b-5" name="title" placeholder="<?= trans("title"); ?>" maxlength="255" required>
                    </div>

                    <div class="form-inline m-b-15">
                        <label class="control-label m-b-5"><?= trans("duration") . " (" . trans("time_limit_for_plan") . ")"; ?></label>
                        <div>
                            <div class="form-group form-group-duration">
                                <input type="text" class="form-control form-input m-r-10" name="number_of_days" placeholder="<?= trans("duration") ?>&nbsp;&nbsp;(E.g: 1 Year)" required style="min-width: 400px; max-width: 100%;">
                            </div>
                        </div>
                    </div>
                    <div class="form-inline m-b-15">
                        <label class="control-label m-b-5"><?= trans("price"); ?></label>
                        <div>
                            <div class="form-group form-group-price">
                                <div class="input-group" style="min-width: 410px; max-width: 100%; padding-right: 10px;">
                                    <span class="input-group-addon"><?= $defaultCurrency->symbol; ?></span>
                                    <input type="text" name="price" class="form-control form-input price-input validate-price-input" placeholder="<?= $baseVars->inputInitialPrice; ?>" onpaste="return false;" maxlength="32" required>
                                </div>
                            </div>
                        </div>
                    </div>
					
					<div class="form-inline m-b-15">
						<div class="form-group">
							<label class="control-label">Membership Image</label>
							<div class="display-block">
								<a class='btn btn-info btn-sm btn-file-upload'>
									Upload Image
									<input type="file" name="memImage" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info2').html($(this).val());">
								</a>
								(.png, .jpg, .jpeg)
							</div>
							<span class='label label-info' id="upload-file-info2"></span>
						</div>
                    </div>
     

                    <div class="form-group">
                        <label class="control-label"><?= trans("features"); ?></label>
                        <hr style="margin-top: 5px;margin-bottom: 5px;">
                        <div class="membership-plans-container">
                            <div class="feature">
                                <p class="m-b-5"><?= trans("feature"); ?></p>
                                <?php foreach ($activeLanguages as $language): ?>
                                    <input type="text" name="feature_<?= $language->id; ?>[]" class="form-control m-b-5" placeholder="<?= esc($language->name); ?>" required>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <button type="button" class="btn btn-sm btn-success" onclick="addMembershipFeature();">
                                    <i class="fa fa-plus"></i>&nbsp;<?= trans("add_feature"); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
					<div class="pull-left">
						<span>(Link to get Images - "https://www.freepik.com/")</span>
					</div>
                    <button type="submit" class="btn btn-primary pull-right"><?= trans("submit"); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if (!empty($membershipPlans)): ?>
    <div class="row" style="margin-bottom: 100px;">
        <div class="col-sm-12 m-b-15">
            <h3 class="box-title" style="font-size: 18px; font-weight: 600;"><?= trans("membership_plans"); ?></h3>
        </div>
        <div class="col-sm-12">
                <?php foreach ($membershipPlans as $plan): 
				//echo "<pre>";print_r($plan);die;
				?>
                    <div class="col-sm-4 col-md-4 col-lg-4" style="margin-top: 40px;">
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
							<p>
							<a class="btn-sm btn btn-success" href="<?= adminUrl('edit-plan-user/' . $plan->id); ?>"><?= trans("edit"); ?></a>
							</p>
							<p>
							<a class="btn-sm btn btn-success" href="javascript:void(0)" onclick="deleteItem('MembershipPlansController/deletePlanPostUsers','<?= $plan->id; ?>','<?= trans("confirm_delete", true); ?>');"><i class="fa fa-trash-o"></i></a>
							</p>
						<!-- <a href="#">Order Now </a> -->
						</div>
						</div>
					</div>  
                <?php endforeach; ?>

        </div>
    </div>
<?php endif; ?>

<script>
    function addMembershipFeature() 
	{
        var feature = '<div class="feature">\n';
        feature += '<p class="m-b-5"><?= trans("feature"); ?><span class="btn btn-xs btn-danger btn-delete-membership-feature m-l-5"><i class="fa fa-times"></i></span></p>\n';
        <?php foreach ($activeLanguages as $language): ?>
        feature += '<input type="text" name="feature_<?= $language->id; ?>[]" class="form-control m-b-5" placeholder="<?= esc($language->name); ?>" required>';
        <?php endforeach; ?>
        feature += '</div>';
        $('.membership-plans-container').append(feature);
    }
    $(document).on('click', '.btn-delete-membership-feature', function () {
        $(this).closest('.feature').remove();
    });
</script>

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

.card::before{
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 40%;
  background: rgba(255, 255, 255, .1);
z-index: 1;
-webkit-transform: skewY(-5deg) scale(1.5);
        transform: skewY(-5deg) scale(1.5);
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
.card a {
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
.card a:hover{
    text-decoration: none;
}
</style>

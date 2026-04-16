<div id="wrapper">
    <div class="container">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8 col-sm-12">
				<div class="title">
					<h1 class="picture_gallery_h1">Current Buisness Membership Plan</h1>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
        <div class="row">
            <div class="col-sm-12 col-md-3">
                <div class="row-custom">
                    <?= view("settings/_tabs"); ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-9">
                <div class="row-custom">
                    <div class="profile-tab-content">
                        <?= view('partials/_messages');
						?>
						<?php if ($plan_details) { ?>
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="form-group">
									<label class="control-label"><?= trans('membership').' '.trans('name'); ?></label>
									<input type="text" class="form-control form-input" value="<?= $plan_details->plan_title; ?>" readonly>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="form-group">
									<label class="control-label"><?= trans('membership').' '.trans('duration'); ?></label>
									<input type="text" class="form-control form-input" value="<?= $plan_details->number_of_days; ?>" readonly>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="form-group">
									<label class="control-label"><?= trans('membership').' '.trans('price'); ?></label>
									<input type="text" class="form-control form-input" value="<?= $defaultCurrency->symbol.''.getPrice($plan_details->price, 'decimal');?>" readonly>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="form-group">
									<label class="control-label"><?= trans('membership').' '.trans('status'); ?></label>
									<input type="text" class="form-control form-input" value="<?= $plan_details->plan_status == 1 ? 'Active' : 'Inactive'; ?>" readonly>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="form-group">
									<label class="control-label"><?= trans('membership').' '.trans('start_date'); ?></label>
									<input type="text" class="form-control form-input" value="<?= date('d - M - Y', strtotime($plan_details->plan_start_date)); ?>" readonly>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="form-group">
									<label class="control-label"><?= trans('membership').' '.trans('end_date'); ?></label>
									<input type="text" class="form-control form-input" value="<?= date('d - M - Y', strtotime($plan_details->plan_end_date)); ?>" readonly>
								</div>
							</div>
						</div>
						
						<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center align-items-center">
									<div class="box">
									<span class="text-danger" style="background: #f00;padding: 10px;color: white !important;font-size: 20px;border-radius: 29px;">(<?= ucfirst(trans("days_left")); ?>:&nbsp;<?= $daysLeft < 0 ? 0 : $daysLeft; ?>)</span>
									</div>
								</div>
						</div>
							
							
						<?php }
						else
						{?>
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center align-items-center">
									<div class="box">
										<p class="no_plans_p">No current Active Plans</p>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center align-items-center">
									<div class="box">
										<a class="btn btn-sm btn-danger btn-radius"href="<?= generateDashUrl("add_product"); ?>"><span><?php echo trans('buy_now'); ?></span>
										</a>
									</div>
								</div>
							</div>
						<?php 
						}?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>

.no_plans_p
{
    font-size: 25px;
    font-weight: bold;
}

.profile-tab-content
{
	border-radius: 10px !important; 
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
	border: 2px solid #d1274b !important; 
	margin: 5px !important;
	padding: 10px !important;
}

.picture_gallery_h1
{
	font-size: 25px;
	display: inline-block;
	border-bottom: 5px solid #d1274b;
	font-weight : bold;
}

.title
{
	text-align: center;
	margin-bottom : 30px;
}

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

.text-right
{
	text-align : right;
}
</style>
<div id="wrapper">
    <div class="container">
		<?php /*
		
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
                    </ol>
                </nav>
            </div>
        </div>
		*/ ?>
		
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8 col-sm-12">
				<div class="title">
					<h1 class="picture_gallery_h1"><?= trans("social_media_settings"); ?></h1>
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
                        <?= view('partials/_messages'); ?>
                        <form action="<?= base_url('social-media-post'); ?>" method="post" id="form_validate">
                            <?= csrf_field(); ?>
							
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans('personal_website_url'); ?></label>
										<input type="text" class="form-control form-input" name="personal_website_url" placeholder="<?= trans('personal_website_url'); ?>" value="<?= esc(user()->personal_website_url); ?>" maxlength="900">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans('facebook_url'); ?></label>
										<input type="text" class="form-control form-input" name="facebook_url" placeholder="<?= trans('facebook_url'); ?>" value="<?= esc(user()->facebook_url); ?>" maxlength="900">
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans('twitter_url'); ?></label>
										<input type="text" class="form-control form-input" name="twitter_url" placeholder="<?= trans('twitter_url'); ?>" value="<?= esc(user()->twitter_url); ?>" maxlength="900">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans('instagram_url'); ?></label>
										<input type="text" class="form-control form-input" name="instagram_url" placeholder="<?= trans('instagram_url'); ?>" value="<?= esc(user()->instagram_url); ?>" maxlength="900">
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans('pinterest_url'); ?></label>
										<input type="text" class="form-control form-input" name="pinterest_url" placeholder="<?= trans('pinterest_url'); ?>" value="<?= esc(user()->pinterest_url); ?>" maxlength="900">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans('telegram_url'); ?></label>
										<input type="text" class="form-control form-input" name="telegram_url" placeholder="<?= trans('telegram_url'); ?>" value="<?= esc(user()->telegram_url); ?>" maxlength="900">
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans('linkedin_url'); ?></label>
										<input type="text" class="form-control form-input" name="linkedin_url" placeholder="<?= trans('linkedin_url'); ?>" value="<?= esc(user()->linkedin_url); ?>" maxlength="900">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans('vk_url'); ?></label>
										<input type="text" class="form-control form-input" name="vk_url" placeholder="<?= trans('vk_url'); ?>" value="<?= esc(user()->vk_url); ?>" maxlength="900">
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans('whatsapp_url'); ?></label>
										<input type="text" class="form-control form-input" name="whatsapp_url" placeholder="<?= trans('whatsapp_url'); ?>" value="<?= esc(user()->whatsapp_url); ?>" maxlength="900">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans('youtube_url'); ?></label>
										<input type="text" class="form-control form-input" name="youtube_url" placeholder="<?= trans('youtube_url'); ?>" value="<?= esc(user()->youtube_url); ?>" maxlength="900">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12 text-right">
									<button type="submit" class="btn btn-md btn-danger"><?= trans("save_changes") ?></button>
								</div>
							</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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
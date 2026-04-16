<div id="wrapper">
    <div class="container">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8 col-sm-12">
				<div class="title">
					<h1 class="picture_gallery_h1"><?= trans("reset_password"); ?></h1>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
        <div class="auth-container">
            <div class="auth-box">
                <div class="row">
                    <div class="col-12">
                        <form action="<?= base_url('forgot-password-post'); ?>" method="post" id="form_validate">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <p class="p-social-media m-0"><?= trans("reset_password_subtitle"); ?></p>
                            </div>
                            <?= view('partials/_messages'); ?>
                            <div class="form-group m-b-30">
                                <input type="email" name="email" class="form-control auth-form-input" placeholder="<?= trans("email_address"); ?>" value="<?= old("email"); ?>" maxlength="255" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-danger btn-block"><?= trans("submit"); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.picture_gallery_h1
{
	font-size: 30px;
	display: inline-block;
	border-bottom: 5px solid #d1274b;
}

.title
{
	text-align: center;
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

.btn-radius 
{
	border-radius: 100px !important;
}

.auth-box
{
	background: #fff !important;
	border-radius: 6px !important;
	margin: 20px auto !important;
	border: 1px solid #d1274b !important;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
	padding : 10px;
}
</style>
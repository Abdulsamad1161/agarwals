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
					<h1 class="picture_gallery_h1"><?= trans("password_settings"); ?></h1>
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
						<h4 class="data-pass-change">Primary Login</h4>
                        <form action="<?= base_url('change-password-post'); ?>" method="post" id="form_validate">
                            <?= csrf_field(); ?>
                            <?php if (!empty(user()->password)): ?>
                                <div class="form-group">
                                    <label class="control-label"><?= trans("old_password"); ?></label>
									<div class="input-group">
										<input type="password" name="old_password" id= "old_password" class="form-control form-input" value="<?= old("old_password"); ?>" placeholder="<?= trans("old_password"); ?>" maxlength="255" required>
										<div class="input-group-append">
											<span class="input-group-text" style="background-color: #d1274b !important;">
												<i class="fa fa-eye-slash" id="primaryOldPass" style="color: white !important;"></i>
											</span>
										</div>
									</div>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label class="control-label"><?= trans("password"); ?></label>
								<div class="input-group">
									<input type="password" name="password" id="password" class="form-control form-input" value="<?= old("password"); ?>" placeholder="<?= trans("password"); ?>" minlength="4" maxlength="255" required>
									<div class="input-group-append">
										<span class="input-group-text" style="background-color: #d1274b !important;">
											<i class="fa fa-eye-slash" id="primaryNewPass" style="color: white !important;"></i>
										</span>
									</div>
								</div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?= trans("password_confirm"); ?></label>
								<div class="input-group">
									<input type="password" name="password_confirm" id="password_confirm" class="form-control form-input" value="<?= old("password_confirm"); ?>" placeholder="<?= trans("password_confirm"); ?>" maxlength="255" required>
									<div class="input-group-append">
										<span class="input-group-text" style="background-color: #d1274b !important;">
											<i class="fa fa-eye-slash" id="primaryConPass" style="color: white !important;"></i>
										</span>
									</div>
								</div>
                            </div>
							
							<div class="row">
								<div class="col-12 text-right">
									<button type="submit" class="btn btn-md btn-danger"><?= trans("change_password") ?></button>
								</div>
							</div>
                        </form>
						<h4 class="data-pass-change">Secondary Login</h4>
						<form action="<?= base_url('change-password-second-post'); ?>" method="post" id="form_validate">
                            <?= csrf_field(); ?>
                            <?php if (!empty(user()->secondary_password)): ?>
                                <div class="form-group">
                                    <label class="control-label"><?= trans("old_password"); ?></label>
									<div class="input-group">
										<input type="password" name="old_password_second" id="old_password_second" class="form-control form-input" value="<?= old("old_password"); ?>" placeholder="<?= trans("old_password"); ?>" maxlength="255" required>
										<div class="input-group-append">
											<span class="input-group-text" style="background-color: #d1274b !important;">
												<i class="fa fa-eye-slash" id="secondOldPass" style="color: white !important;"></i>
											</span>
										</div>
									</div>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label class="control-label"><?= trans("password"); ?></label>
								<div class="input-group">
									<input type="password" name="password_second" id="password_second" class="form-control form-input" value="<?= old("password"); ?>" placeholder="<?= trans("password"); ?>" minlength="4" maxlength="255" required>
									<div class="input-group-append">
										<span class="input-group-text" style="background-color: #d1274b !important;">
											<i class="fa fa-eye-slash" id="secondNewPass" style="color: white !important;"></i>
										</span>
									</div>
								</div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?= trans("password_confirm"); ?></label>
								<div class="input-group">
									<input type="password" name="password_confirm_second" id="password_confirm_second" class="form-control form-input" value="<?= old("password_confirm"); ?>" placeholder="<?= trans("password_confirm"); ?>" maxlength="255" required>
									<div class="input-group-append">
										<span class="input-group-text" style="background-color: #d1274b !important;">
											<i class="fa fa-eye-slash" id="secondConPass" style="color: white !important;"></i>
										</span>
									</div>
								</div>
                            </div>
							
							<div class="row">
								<div class="col-12 text-right">
									<button type="submit" class="btn btn-md btn-danger"><?= trans("change_password") ?></button>
								</div>
							</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('primaryOldPass').addEventListener('click', function () {
        var passwordInput = document.getElementById('old_password');
        var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
	
	document.getElementById('primaryNewPass').addEventListener('click', function () {
        var passwordInput = document.getElementById('password');
        var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
	
	document.getElementById('primaryConPass').addEventListener('click', function () {
        var passwordInput = document.getElementById('password_confirm');
        var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
	
	document.getElementById('secondOldPass').addEventListener('click', function () {
        var passwordInput = document.getElementById('old_password_second');
        var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
	
	document.getElementById('secondNewPass').addEventListener('click', function () {
        var passwordInput = document.getElementById('password_second');
        var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
	
	document.getElementById('secondConPass').addEventListener('click', function () {
        var passwordInput = document.getElementById('password_confirm_second');
        var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>

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

.data-pass-change
{
	padding: 5px;
	color: #d1274b;
	font-weight: bold;
	text-align: center;
	font-size: 26px;
}
</style>
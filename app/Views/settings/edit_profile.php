<?php 
if(isset($otherMemberDetails) && is_array($otherMemberDetails) && count($otherMemberDetails) > 0) 
{
	$otherMemberDetails = $otherMemberDetails[0]; 
}
?>
<div id="wrapper">
    <div class="container">
	<?php /*
		
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= esc($title); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
		*/ ?>
		
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8 col-sm-12">
				<div class="title">
					<h1 class="picture_gallery_h1"><?= trans("profile_settings"); ?></h1>
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
                        <form action="<?= base_url('edit-profile-post'); ?>" method="post" id="form_validate" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <div id="edit_profile_cover" class="edit-profile-cover edit-cover-no-image">
                                    <div class="edit-avatar">
                                        <a class="btn btn-md btn-custom btn-file-upload">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>
                                            </svg>
                                            <input type="file" name="file" size="40" accept=".png, .jpg, .jpeg, .gif" data-img-id="img_preview_avatar" onchange="showImagePreview(this);">
                                        </a>
                                        <img src="<?= getUserAvatar(user()); ?>" alt="<?= esc(getUsername(user())); ?>" id="img_preview_avatar" class="img-thumbnail" width="180" height="180">
                                    </div>
                                    <div class="btn-container">
                                        <a class="btn btn-md btn-custom btn-file-upload btn-edit-cover">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">
                                                <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>
                                            </svg>
                                            <input type="file" name="image_cover" size="40" accept=".png, .jpg, .jpeg, .gif" data-img-id="edit_profile_cover" onchange="showImagePreview(this, true);">
                                        </a>
                                        <?php if (!empty(user()->cover_image)): ?>
                                            <a class="btn btn-md btn-custom btn-file-upload btn-edit-cover" onclick="deleteCoverImage();">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                                </svg>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if (!empty(user()->cover_image)): ?>
                                    <style>#edit_profile_cover {
                                        background-image: url('<?= base_url((user()->cover_image)); ?>');
                                    }</style><?php endif; ?>
                                <p class="mb-4"><small class="text-muted">*<?= trans("warning_edit_profile_image"); ?></small></p>
                            </div>
							
							<div class="row">
								<div class="col-md-12 heading-col">Primary Member Details</div>
							</div>
							
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label">
											<?= trans("email_address"); ?>
											<?php if ($generalSettings->email_verification == 1): ?>
												<?php if (user()->email_status == 1): ?>
													<small class="text-success">(<?= trans("confirmed"); ?>)</small>
												<?php else: ?>
													<small class="text-danger">(<?= trans("unconfirmed"); ?>)</small>
													<a href="javascript:void(0)" class="color-link link-underlined font-weight-normal" onclick="sendActivationEmail('<?= user()->token; ?>', 'profile');"><?= trans("resend_activation_email"); ?></a>
													<div class="display-inline-block font-weight-normal m-l-5" id="confirmation-result-profile"></div>
												<?php endif;
											endif; ?>
										</label>
										<input type="email" name="email" class="form-control form-input" value="<?= esc(user()->email); ?>" placeholder="<?= trans("email_address"); ?>" required>
									</div>
								</div>
								
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans("phone_number"); ?></label>
										<input type="text" name="phone_number" class="form-control form-input" value="<?= esc(user()->phone_number); ?>" placeholder="<?= trans("phone_number"); ?>" maxlength="100">
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans("first_name"); ?></label>
										<input type="text" name="first_name" class="form-control form-input" value="<?= esc(user()->first_name); ?>" placeholder="<?= trans("first_name"); ?>" maxlength="250" required>
									</div>
								</div>
								
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans("last_name"); ?></label>
										<input type="text" name="last_name" class="form-control form-input" value="<?= esc(user()->last_name); ?>" placeholder="<?= trans("last_name"); ?>" maxlength="250" required>
									</div>
								</div>
							</div>
                            
								<?php /* <label class="control-label"><?= trans("slug"); ?></label>*/?>
                                <input type="hidden" name="slug" class="form-control form-input" value="<?= esc(user()->slug); ?>" placeholder="<?= trans("slug"); ?>" maxlength="200" required>
                         
                            
							<!-- custom added -->
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans("members_in_family"); ?></label>
										<input type="number" name="members_in_family" class="form-control form-input" value="<?= esc(user()->members_in_family); ?>" placeholder="<?= trans("members in family"); ?>" maxlength="100">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans("areas_of_interest"); ?></label>
										<input type="text" name="areas_of_interest" class="form-control form-input" value="<?= esc(user()->areas_of_interest); ?>" placeholder="<?= trans("area of interest.."); ?>" maxlength="100">
									</div>
								</div>
							</div>
							<!-- custom added -->
							<div class="seperator"></div>
							
							<div class="row">
								<div class="col-md-12 heading-col"><?= trans("secondary_member_details"); ?></div>
							</div>
							
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans("first_name"); ?></label>
										<input type="text" name="secondary_first_name" class="form-control form-input" value="<?php if(isset($otherMemberDetails->secondary_first_name)) { echo  $otherMemberDetails->secondary_first_name; }?>" placeholder="<?= trans("first_name"); ?>" maxlength="250">
									</div>
								</div>
								
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans("last_name"); ?></label>
										<input type="text" name="secondary_last_name" class="form-control form-input" value="<?php if(isset($otherMemberDetails->secondary_last_name)){ echo $otherMemberDetails->secondary_last_name; }?>" placeholder="<?= trans("last_name"); ?>" maxlength="250">
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans("email"); ?></label>
										<input type="email" name="secondary_email" class="form-control form-input" value="<?php if(isset($otherMemberDetails->secondary_email)){ echo $otherMemberDetails->secondary_email; } ?>" placeholder="<?= trans("email"); ?>" maxlength="250">
									</div>
								</div>
								
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans("phone_number"); ?></label>
										<input type="text" name="secondary_phone_number" class="form-control form-input" value="<?php if(isset($otherMemberDetails->secondary_phone_number)){ echo $otherMemberDetails->secondary_phone_number;}?>" placeholder="<?= trans("phone_number"); ?>" maxlength="250">
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label">Secondary login Email</label>
										<input type="email" name="secondary_email_login" class="form-control form-input" value="<?php echo esc(user()->secondary_email)?>" placeholder="<?= trans("email"); ?>" maxlength="250">
									</div>
								</div>
								
								<div class="col-lg-6 col-md-6 col-sm-12">
									<?php if (!empty(user()->secondary_password)) { ?>
										<!-- Password is already available, hide the field -->
										<label class="control-label">Secondary Password</label>
										<input type="text" class="form-control form-input data-pass" value="* * * * * *" maxlength="250" readonly>
									<?php } else { ?>
										<!-- Password is not available, show the input field -->
										<div class="form-group">
											<label class="control-label">Secondary Password</label>
											<input type="text" name="secondary_password" class="form-control form-input" value="" placeholder="password" maxlength="250">
										</div>
									<?php } ?>
								</div>

							</div>
							
							<div class="seperator"></div>
							
							<div class="row">
								<div class="col-md-12 heading-col"><?= trans("other_details"); ?></div>
							</div>
							
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans("postal_address"); ?></label>
										<textarea type="text" name="postal_address" class="form-control form-input" placeholder="<?= trans("postal_address"); ?>" maxlength="250"><?php if(isset($otherMemberDetails->postal_address)){ echo $otherMemberDetails->postal_address;} ?></textarea>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12">
									<div class="form-group">
										<div class="row">
											<div class="col-12">
												<label class="control-label"><?= trans('descendant_of_agarwal_vaish'); ?></label>
											</div>
											<div class="col-md-3 col-sm-4 col-12 col-option">
												<div class="custom-control custom-radio">
													<input type="radio" name="descendant_of_agarwal_vaish" value="1" id="descendant_of_agarwal_vaish_1" class="custom-control-input" <?php if(isset($otherMemberDetails->descendant_of_agarwal_vaish)){ echo  $otherMemberDetails->descendant_of_agarwal_vaish == 1 ? 'checked' : ''; }?>>
													<label for="descendant_of_agarwal_vaish_1" class="custom-control-label"><?= trans("yes"); ?></label>
												</div>
											</div>
											<div class="col-md-3 col-sm-4 col-12 col-option">
												<div class="custom-control custom-radio">
													<input type="radio" name="descendant_of_agarwal_vaish" value="0" id="descendant_of_agarwal_vaish_2" class="custom-control-input" <?php if(isset($otherMemberDetails->descendant_of_agarwal_vaish)){ echo $otherMemberDetails->descendant_of_agarwal_vaish != 1 ? 'checked' : ''; } ?>>
													<label for="descendant_of_agarwal_vaish_2" class="custom-control-label"><?= trans("no"); ?></label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-12">
									<p>
									<span class="text-bold">Endorsements if required</span>: &nbsp;If neither of two members from the family is an Agarwal or Vaish, two ABC members in good standing need to endorse the new member’s family:
									</p>
								</div>
							</div>
							
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans("name"); ?></label>
										<input type="text" name="other_name_1" class="form-control form-input" value="<?php if(isset($otherMemberDetails->other_name_1)){ echo $otherMemberDetails->other_name_1;}?>" placeholder="<?= trans("name"); ?>" maxlength="250">
									</div>
								</div>
								
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans("phone_number"); ?></label>
										<input type="text" name="other_phone_1" class="form-control form-input" value="<?php if(isset($otherMemberDetails->other_phone_1)){ echo $otherMemberDetails->other_phone_1;} ?>" placeholder="<?= trans("phone_number"); ?>" maxlength="250">
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans("name"); ?></label>
										<input type="text" name="other_name_2" class="form-control form-input" value="<?php if(isset($otherMemberDetails->other_name_2)){ echo $otherMemberDetails->other_name_2;} ?>" placeholder="<?= trans("name"); ?>" maxlength="250">
									</div>
								</div>
								
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<label class="control-label"><?= trans("phone_number"); ?></label>
										<input type="text" name="other_phone_2" class="form-control form-input" value="<?php if(isset($otherMemberDetails->other_phone_2)){ echo $otherMemberDetails->other_phone_2;} ?>" placeholder="<?= trans("phone_number"); ?>" maxlength="250">
									</div>
								</div>
							</div>
							
							
							<div class="seperator"></div>
							
							<div class="row">
								<div class="col-md-12 heading-col">Privacy Settings</div>
							</div>
							
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<div class="row">
											<div class="col-12">
												<label class="control-label"><?= trans('email_option_send_email_new_message'); ?></label>
											</div>
											<div class="col-md-6 col-sm-4 col-12 col-option">
												<div class="custom-control custom-radio">
													<input type="radio" name="send_email_new_message" value="1" id="send_email_new_message_1" class="custom-control-input" <?= user()->send_email_new_message == 1 ? 'checked' : ''; ?>>
													<label for="send_email_new_message_1" class="custom-control-label"><?= trans("yes"); ?></label>
												</div>
											</div>
											<div class="col-md-6 col-sm-4 col-12 col-option">
												<div class="custom-control custom-radio">
													<input type="radio" name="send_email_new_message" value="0" id="send_email_new_message_2" class="custom-control-input" <?= user()->send_email_new_message != 1 ? 'checked' : ''; ?>>
													<label for="send_email_new_message_2" class="custom-control-label"><?= trans("no"); ?></label>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group">
										<div class="row">
											<div class="col-12">
												<label class="control-label"><?= trans('cover_image_type'); ?></label>
											</div>
											<div class="col-md-6 col-sm-4 col-12 col-option">
												<div class="custom-control custom-radio">
													<input type="radio" name="cover_image_type" value="full_width" id="cover_image_type_1" class="custom-control-input" <?= user()->cover_image_type == 'full_width' ? 'checked' : ''; ?>>
													<label for="cover_image_type_1" class="custom-control-label"><?= trans("full_width"); ?></label>
												</div>
											</div>
											<div class="col-md-6 col-sm-4 col-12 col-option">
												<div class="custom-control custom-radio">
													<input type="radio" name="cover_image_type" value="boxed" id="cover_image_type_2" class="custom-control-input" <?= user()->cover_image_type == 'boxed' ? 'checked' : ''; ?>>
													<label for="cover_image_type_2" class="custom-control-label"><?= trans("boxed"); ?></label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
                            
                            
                            <?php if ($generalSettings->hide_vendor_contact_information != 1): ?>
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group m-t-15">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" name="show_email" value="1" id="checkbox_show_email" class="custom-control-input" <?= user()->show_email == 1 ? 'checked' : ''; ?>>
											<label for="checkbox_show_email" class="custom-control-label"><?= trans("show_my_email"); ?></label>
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group m-t-15">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" name="show_phone" value="1" id="checkbox_show_phone" class="custom-control-input" <?= user()->show_phone == 1 ? 'checked' : ''; ?>>
											<label for="checkbox_show_phone" class="custom-control-label"><?= trans("show_my_phone"); ?></label>
										</div>
									</div>
								</div>
                            </div>
                            <?php endif; ?>
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group m-t-15">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" name="show_location" value="1" id="checkbox_show_location" class="custom-control-input" <?= user()->show_location == 1 ? 'checked' : ''; ?>>
											<label for="checkbox_show_location" class="custom-control-label"><?= trans("show_my_location"); ?></label>
										</div>
									</div>
								</div>
								
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="form-group m-t-15">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" name="show_profile" value="1" id="checkbox_show_profile" class="custom-control-input" <?= user()->show_profile == 1 ? 'checked' : ''; ?>>
											<label for="checkbox_show_profile" class="custom-control-label"><?= trans("show_profile"); ?></label>
										</div>
									</div>
								</div>
                            </div>
							
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12">
									<div class="form-group m-t-15 m-b-30">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" name="two_factor" value="1" id="checkbox_two_factor" class="custom-control-input" <?= user()->two_factor == 1 ? 'checked' : ''; ?>>
											<label for="checkbox_two_factor" class="custom-control-label"><?= trans("two_factor"); ?><span style="color: green;font-size: 12px;font-weight: bold;"> (OTP will be sent to the registered email)</span></label>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-12 text-right">
									<button type="submit" name="submit" value="update" class="btn btn-md btn-danger"><?= trans("save_changes") ?></button>
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
	margin: 5px !important; 
	border: 2px solid #d1274b !important; 
	padding: 10px !important;
}

.seperator
{
	border: 1px solid #ccc !important;
	margin: 15px 0px !important;
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

.heading-col
{
	text-align: center;
	font-size: 20px;
	color: #d1274b;
	font-weight: bold;
	margin: 10px 0px 25px;
}

.text-bold
{
	font-weight : bold;
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

.data-pass
{
	color : red !important;
	font-weight : bold !important;
}
</style>
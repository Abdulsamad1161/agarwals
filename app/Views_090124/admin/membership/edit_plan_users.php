<div class="row">
    <div class="col-lg-7 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("edit_plan"); ?></h3>
            </div>
            <form action="<?= base_url('MembershipPlansController/editPlanPostUsers'); ?>" method="post"  enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= $plan->id; ?>">
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= trans("title"); ?></label>
                            <input type="text" class="form-control m-b-5" name="title" value="<?= $plan->title; ?>" placeholder="" maxlength="255" required>
                    </div>
					
                    <div class="form-inline m-b-15">
                        <label class="control-label m-b-5"><?= trans("duration") . " (" . trans("time_limit_for_plan") . ")"; ?></label>
                        <div>
                            <div class="form-group form-group-duration">
                                <input type="text" name="number_of_days" value="<?= !empty($plan->number_of_days) ? $plan->number_of_days : ''; ?>" class="form-control form-input m-r-10" placeholder="<?= trans("duration") ?>&nbsp;&nbsp;(E.g: 1 Year)" style="min-width: 400px; max-width: 100%;">
                            </div>
                        </div>
                    </div>
					
                    <div class="form-inline m-b-15">
                        <label class="control-label m-b-5"><?= trans("price"); ?></label>
                        <div>
                            <div class="form-group form-group-price">
                                <div class="input-group" style="min-width: 410px; max-width: 100%; padding-right: 10px;">
                                    <span class="input-group-addon"><?= $defaultCurrency->symbol; ?></span>
                                    <input type="text" name="price" value="<?= !empty($plan->price) ? getPrice($plan->price, 'input') : ''; ?>" class="form-control form-input price-input validate-price-input" placeholder="<?= $baseVars->inputInitialPrice; ?>" onpaste="return false;" maxlength="32" required>
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
                            <?php $mainFeatures = getMembershipPlanFeatures($plan->features, selectedLangId());
                            if (!empty($mainFeatures)):
                                $index = 0;
                                foreach ($mainFeatures as $feature): ?>
                                    <div class="feature">
                                        <p class="m-b-5"><?= trans("feature"); ?>
                                            <?php if ($index != 0): ?>
                                                <span class="btn btn-xs btn-danger btn-delete-membership-feature m-l-5"><i class="fa fa-times"></i></span>
                                            <?php endif; ?>
                                        </p>
                                        <?php foreach ($activeLanguages as $language):
                                            $langFeatures = getMembershipPlanFeatures($plan->features, $language->id); ?>
                                            <input type="text" name="feature_<?= $language->id; ?>[]" value="<?= !empty($langFeatures[$index]) ? $langFeatures[$index] : ''; ?>" class="form-control m-b-5" placeholder="<?= esc($language->name); ?>" required>
                                        <?php endforeach;
                                        $index++; ?>
                                    </div>
                                <?php endforeach;
                            else: ?>
                                <div class="feature">
                                    <p class="m-b-5"><?= trans("feature"); ?></p>
                                    <?php foreach ($activeLanguages as $language): ?>
                                        <input type="text" name="feature_<?= $language->id; ?>[]" class="form-control m-b-5" placeholder="<?= esc($language->name); ?>" required>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
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
                    <a href="<?= adminUrl('membership-plan-user'); ?>" class="btn btn-danger pull-left"><?= trans("back"); ?></a>
                    <button type="submit" class="btn btn-primary pull-right"><?= trans("save_changes"); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function addMembershipFeature() {
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

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('charity_edit'); ?></h3>
                </div>
				
				<div class="right">
                    <a href="<?= adminUrl('charity-manager'); ?>" class="btn btn-danger btn-add-new">
                        <i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;<?= trans('back'); ?>
                    </a>
                </div>
            </div>
			<form action="<?= base_url('TicketController/editCharityPost'); ?>" method="post">
                <?= csrf_field(); ?>
			<div class="box-body">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="form-group">
							<label><?= trans("charity_name"); ?></label>
							<input type="text" class="form-control" name="charityName" placeholder="<?= trans("charity_name"); ?>" value="<?= $charityList->charityName;?>" required>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="form-group">
							<label><?= trans("charity_note"); ?></label>
							<textarea type="text" class="form-control" name="charityNote" placeholder="<?= trans("charity_note"); ?>"><?= $charityList->charityNote;?></textarea>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="form-group">
							<label><?= trans("link_e_payment"); ?></label>
							<input type="text" class="form-control" name="e_payment_link" placeholder="<?= trans("link_e_payment"); ?>" value="<?= $charityList->e_payment_link;?>">
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="form-group">
							<label><?= 'Paypal Charges in %'; ?></label>
							<input type="number" class="form-control" name="paypalFees" min="0" placeholder="0%" value= "<?= $charityList->paypalFees;?>">
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-6">
									<label><?= trans('visibility'); ?></label>
								</div>
								<div class="col-sm-3 col-xs-12 col-option">
									<input type="radio" name="status" value="1"  class="square-purple" <?php echo ($charityList->status == 1) ? 'checked' : ''?>>
									<label for="row_width_1" class="option-label"><?= trans('visible'); ?></label>
								</div>
								<div class="col-sm-3 col-xs-12 col-option">
									<input type="radio" name="status" value="0"  class="square-purple" <?php echo ($charityList->status == 0) ? 'checked' : ''?>>
									<label for="row_width_2" class="option-label"><?= trans('invisible'); ?></label>
								</div>
							</div>
						</div>
					</div>
                </div>
							
				<input type="hidden" name = "id" value="<?= $charityList->id;?>">
			</div>
			<div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
            </div>
			</form>
		</div>
	</div>
</div>
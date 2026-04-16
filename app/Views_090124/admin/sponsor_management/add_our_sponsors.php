<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('add_sponsors'); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl("our-sponsors"); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= trans('our-sponsors-list'); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('AdminController/addOurSponsorsPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= trans('name'); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?= trans('name'); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans("sponsors_website_link"); ?></label>
                        <input type="text" class="form-control" name="linkSponsor" placeholder="<?= trans("sponsors_website_link"); ?>">
                    </div>
					
					<div class="form-group">
                        <label class="control-label"><?= trans('order'); ?></label>
                        <input type="number" class="form-control" name="order" placeholder="<?= trans('order'); ?>" value="<?= $order;?>" required min="1">
                    </div>
				
					<div class="form-group">
						<label class="control-label"><?= trans('sponsors_image'); ?></label>
						<div class="display-block">
							<a class='btn btn-success btn-sm btn-file-upload'>
								<?= trans('upload_sponsors_image'); ?>
								<input type="file" name="sponsorImage" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info1').html($(this).val());" required>
							</a>
							(.png, .jpg, .jpeg, .gif, .svg)
						</div>
						<span class='label label-info' id="upload-file-info1"></span>
					</div>
                    
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('add_sponsor'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
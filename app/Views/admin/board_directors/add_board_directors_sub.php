<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title">Add Past President</h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl("board-of-directors-sub"); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;Past Presidents
                    </a>
                </div>
            </div>
            <form action="<?= base_url('AdminController/addBoardDirectorsSubPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= trans('name'); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?= trans('name'); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans("description"); ?> (<?= trans('profile'); ?>)</label>
                        <input type="text" class="form-control" name="description" placeholder="<?= trans("description"); ?> (<?= trans('profile'); ?>)" required>
                    </div>
					
					<div class="form-group">
                        <label class="control-label"><?= trans('order'); ?></label>
                        <input type="number" class="form-control" name="order" placeholder="<?= trans('order'); ?>" value="<?= $order;?>" required min="1">
                    </div>
				
					<div class="form-group">
						<label class="control-label"><?= trans('profile_image'); ?></label>
						<div class="display-block">
							<a class='btn btn-success btn-sm btn-file-upload'>
								<?= trans('upload_profile_image'); ?>
								<input type="file" name="userImage" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info1').html($(this).val());" required>
							</a>
							(.png, .jpg, .jpeg, .gif, .svg)
						</div>
						<span class='label label-info' id="upload-file-info1"></span>
					</div>
                    
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('add_director'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
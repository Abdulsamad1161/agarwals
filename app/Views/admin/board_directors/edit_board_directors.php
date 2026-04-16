<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('edit_director'); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl("board-of-directors"); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= trans('board-of-directors'); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('AdminController/editBoardDirectorsPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
					 <input type="hidden" class="form-control" name="id" value="<?= $boardMembers->id;?>">
                    <div class="form-group">
                        <label class="control-label"><?= trans('name'); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?= trans('name'); ?>" value="<?= $boardMembers->name;?>" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans("description"); ?> (<?= trans('profile'); ?>)</label>
                        <input type="text" class="form-control" name="description" value="<?= $boardMembers->description;?>" placeholder="<?= trans("description"); ?> (<?= trans('profile'); ?>)" required>
                    </div>
					
					<div class="form-group">
                        <label class="control-label"><?= trans('order'); ?></label>
                        <input type="number" class="form-control" name="order" value="<?= $boardMembers->order;?>" placeholder="<?= trans('order'); ?>" required min="1">
                    </div>
					
					<div class="row">
						<div class="form-group">
							<div class="col-md-6 col-lg-6 col-sm-12" style="text-align : center;">
								<label class="control-label"><?= trans('profile_image_uploaded'); ?> (you can delete and upload the new image if required)</label>
								<div class="image-card">
									<img src="<?= base_url().'/'.$boardMembers->image; ?>" alt="Image" class="card-image" style= "height : 40vh;max-width: 100%;">
									<div class="card-buttons" style="margin-top:7px;">
										<a class="btn btn-sm btn-danger" onclick="deleteItem('AdminController/deleteBoardDirectorImagePost','<?= $boardMembers->id; ?>','<?= trans("confirm_delete_images", true); ?>');"><?= trans("delete"); ?></a>
									</div>
								</div>
							</div>
							
							<div class="col-md-6 col-lg-6 col-sm-12">
								<label class="control-label"><?= trans('profile_image'); ?></label>
								<div class="display-block">
									<a class='btn btn-success btn-sm btn-file-upload'>
										<?= trans('upload_profile_image'); ?>
										<input type="file" name="userImage" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info1').html($(this).val());" <?php if($boardMembers->image == Null && $boardMembers->image == ''){ echo 'required';}  ?>>
									</a>
									(.png, .jpg, .jpeg, .gif, .svg)
								</div>
								<span class='label label-info' id="upload-file-info1"></span>
							</div>
						</div>
					</div>
                    
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('edit_director'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.image-card
{
	border-radius: 10px;
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
	overflow: hidden;
	margin: 6px;
	border: 2px solid #d1274b;
	padding: 6px;
}

</style>
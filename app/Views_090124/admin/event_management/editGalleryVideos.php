<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('edit_video'); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl("event-settings"); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;<?= trans('back'); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('AdminController/editvideoGalleryPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
					<input type="hidden" class="form-control" name="id" value="<?= $galleryVideos->id;?>">
                    <div class="form-group">
                        <label class="control-label"><?= trans('video_name'); ?></label>
                        <input type="text" class="form-control" name="videoName" value="<?= $galleryVideos->videoName;?>" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans("video_file_name"); ?> (<?= trans('profile'); ?>)</label>
                        <input type="text" class="form-control" name="uploaldFileName" value="<?= $galleryVideos->uploaldFileName;?>"  required>
                    </div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-sm-6">
								<label>Downloadable</label>
							</div>
							<div class="col-sm-3 col-xs-12 col-option">
								<input type="radio" name="downloadVideo" value="1"  class="square-purple" <?php echo ($galleryVideos->downloadVideo == 1) ? 'checked' : ''?>>
								<label for="row_width_1" class="option-label">Yes</label>
							</div>
							<div class="col-sm-3 col-xs-12 col-option">
								<input type="radio" name="downloadVideo" value="0"  class="square-purple" <?php echo ($galleryVideos->downloadVideo == 0) ? 'checked' : ''?>>
								<label for="row_width_2" class="option-label">No</label>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="form-group">
							<div class="col-md-6 col-lg-6 col-sm-12" style="text-align : center;">
								<label class="control-label"><?= trans('thumbnail_image'); ?> (you can delete and upload the new image if required)</label>
								<div class="image-card">
									<img src="<?= base_url().'/'.$galleryVideos->thumbImage; ?>" alt="Image" class="card-image" style= "height : 40vh;max-width: 100%;">
									<div class="card-buttons" style="margin-top:7px;">
										<a class="btn btn-sm btn-danger" onclick="deleteItem('AdminController/deleteVideoGalleryPost','<?= $galleryVideos->id; ?>','<?= trans("confirm_delete_images", true); ?>');"><?= trans("delete"); ?></a>
									</div>
								</div>
							</div>
							
							<div class="col-md-6 col-lg-6 col-sm-12">
								<label class="control-label"><?= trans('thumbnail_image'); ?></label>
								<div class="display-block">
									<a class='btn btn-success btn-sm btn-file-upload'>
										<?= trans('thumbnail_image_select'); ?>
										<input type="file" name="thumbImage" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info1').html($(this).val());" <?php if($galleryVideos->thumbImage == Null && $galleryVideos->thumbImage == ''){ echo 'required';}  ?>>
									</a>
									(.png, .jpg, .jpeg, .gif, .svg)
								</div>
								<span class='label label-info' id="upload-file-info1"></span>
							</div>
						</div>
					</div>
                    
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('edit_video'); ?></button>
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
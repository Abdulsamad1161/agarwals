<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('gallery_list'); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl("edit-image-gallery-category"); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= trans('back'); ?>
                    </a>
                </div>
            </div>
			<div class="row">
            <?php foreach($galleryImages as $item) {?>
					<div class="col-md-3 col-lg-3 col-sm-6" style="text-align : center;">
						<div class="image-card">
							<img src="<?= base_url().'/'.$item->image_path; ?>" alt="Image" class="card-image" style= "height : 40vh;max-width: 100%;">
							<div class="card-buttons" style="margin-top:7px;">
								<a class="btn btn-sm btn-danger" onclick="deleteItem('AdminController/deleteGalleryImagesData','<?= $item->id; ?>','<?= trans("confirm_delete_images", true); ?>');"><?= trans("delete"); ?></a>
							</div>
						</div>
					</div>	
			<?php }?>
			</div>
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
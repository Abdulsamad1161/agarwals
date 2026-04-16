<div class="row">
    <div class="col-sm-12 title-section">
        <h3><?= trans('event_settings'); ?></h3>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Add Page Images</h3>
            </div>
            <form action="<?= base_url('AdminController/eventSettingsPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
					<div class="form-group">
						<label class="control-label">Home Page Image</label>
						<div class="display-block">
							<a class='btn btn-success btn-sm btn-file-upload'>
								Upload Image
								<input type="file" name="eventImage" size="40" accept=".png, .jpg, .jpeg" onchange="$('#upload-file-info35').html($(this).val());">
							</a>
							(.png, .jpg, .jpeg)
						</div>
						<span class='label label-info' id="upload-file-info35"></span>
					</div>
					
					<div class="form-group">
						<label class="control-label">Gallery Page Image</label>
						<div class="display-block">
							<a class='btn btn-success btn-sm btn-file-upload'>
								Upload Image
								<input type="file" name="gallery_image" size="40" accept=".png, .jpg, .jpeg" onchange="$('#upload-file-info36').html($(this).val());">
							</a>
							(.png, .jpg, .jpeg)
						</div>
						<span class='label label-info' id="upload-file-info36"></span>
					</div>
					
					<div class="form-group">
						<label class="control-label">Library Page Image</label>
						<div class="display-block">
							<a class='btn btn-success btn-sm btn-file-upload'>
								Upload Image
								<input type="file" name="library_image" size="40" accept=".png, .jpg, .jpeg" onchange="$('#upload-file-info37').html($(this).val());">
							</a>
							(.png, .jpg, .jpeg)
						</div>
						<span class='label label-info' id="upload-file-info37"></span>
					</div>
					
					<div class="form-group">
						<label class="control-label">Charity Page Image</label>
						<div class="display-block">
							<a class='btn btn-success btn-sm btn-file-upload'>
								Upload Image
								<input type="file" name="charity_image" size="40" accept=".png, .jpg, .jpeg" onchange="$('#upload-file-info38').html($(this).val());">
							</a>
							(.png, .jpg, .jpeg)
						</div>
						<span class='label label-info' id="upload-file-info38"></span>
					</div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Add Image</button>
                </div>
            </form>
        </div>
		
		<div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("add_landing_images"); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/landingeventSettingPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
						<label class="control-label"><?= trans('event_image'); ?></label>
						<div class="display-block">
							<a class='btn btn-success btn-sm btn-file-upload'>
								<?= trans('event_image_select'); ?>
								<input type="file" name="fileuploads[]" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info1').html($(this).val());" multiple required>
							</a>
							(.png, .jpg, .jpeg, .gif, .svg)
						</div>
						<span class='label label-info' id="upload-file-info1"></span>
					</div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('add_event'); ?></button>
                </div>
            </form>
        </div>
    </div>
<div class="col-lg-6 col-md-12">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= trans("list_of_images"); ?></h3>
        </div>
        <?= csrf_field(); ?>
        <div class="box-body">
            <div class="row">
                <?php foreach ($events_images as $index => $image) : ?>
                    <div class="col-md-6 col-lg-6 col-sm-12" style="text-align : center;">
                        <div class="image-card">
                            <img src="<?= base_url().'/'.$image->image_path; ?>" alt="Image <?= $index + 1 ?>" class="card-image" style= "height : 40vh;max-width: 100%;">
                            <div class="card-buttons" style="margin-top:7px;">
                                <a class="btn btn-sm btn-danger" onclick="deleteItem('AdminController/deleteEventImagesPost','<?= $image->id; ?>','<?= trans("confirm_delete_images", true); ?>');"><?= trans("delete"); ?></a>
                            </div>
                        </div>
                    </div>
                    <?php if (($index + 1) % 2 === 0) : ?>
                        </div><div class="row">
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

</div>


<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("add_events"); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/eventSettingsAddPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("event_name"); ?></label>
                        <input type="text" class="form-control" name="eventname" placeholder="<?= trans("event_name"); ?>" value="" maxlength="200" required>
                    </div>
					
					<div class="form-group">
                        <label><?= trans("event_date"); ?></label>
                        <input type="date" class="form-control" name="eventdate" placeholder="<?= trans("event_date"); ?>" value="" maxlength="200" required>
                    </div>
					
					<div class="form-group">
                        <label><?= trans("event_start_time"); ?></label>
						<input type="time" class="form-control" name="startTime">
                    </div>

					<div class="form-group">
                        <label><?= trans("event_end_time"); ?></label>
						<input type="time" class="form-control" name="endTime">
                    </div>  
					
					<div class="form-group">
                        <label><?= trans("event_location"); ?></label>
                        <input type="text" class="form-control" name="eventLocation" placeholder="<?= trans("event_location"); ?>" value="" maxlength="200" required>
                    </div>
					
					<div class="form-group">
                        <label>City & Country (Short Location)</label>
                        <input type="text" class="form-control" name="shortLocation" placeholder="<?= trans("event_location"); ?>" value="" maxlength="200" required>
                    </div>
					
					<div class="form-group">
                        <label><?= trans("button_name"); ?></label>
                        <input type="text" class="form-control" name="btnName" placeholder="Ex :<?= trans("buy_now"); ?>" value="" maxlength="200">
                    </div>
					
					<div class="form-group">
                        <label><?= trans("link"); ?> (you can directly copy and paste the url) </label>
                        <input type="text" class="form-control" name="linkToRedirect" placeholder="<?= trans("link"); ?>" value="">
                    </div>
					
					<div class="form-group">
                        <label><?= trans("about_the_event"); ?></label>
                        <textarea type="text" class="form-control" name="eventDescription" placeholder="<?= trans("about_the_event"); ?>" ></textarea>
                    </div>
					
					<div class="form-group">
                        <label><?= trans("description"); ?></label>
                        <textarea type="text" class="form-control" name="description" placeholder="<?= trans("description"); ?>" ></textarea>
                    </div>
					
					<div class="form-group">
                        <label><?= trans("note"); ?> (important note others if required)</label>
                        <textarea type="text" class="form-control" name="note" placeholder="<?= trans("description"); ?>" ></textarea>
                    </div>

					<div class="form-group">
						<label class="control-label"><?= trans('event_poster'); ?></label>
						<div class="display-block">
							<a class='btn btn-success btn-sm btn-file-upload'>
								<?= trans('event_poster_select'); ?>
								<input type="file" name="eventImage" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info7').html($(this).val());">
							</a>
							(.png, .jpg, .jpeg, .gif, .svg)
						</div>
						<span class='label label-info' id="upload-file-info7"></span>
					</div>
					
					<div class="form-group">
						<label class="control-label"><?= trans('oragnizerImage'); ?></label>
						<div class="display-block">
							<a class='btn btn-success btn-sm btn-file-upload'>
								<?= trans('oragnizer_image_select'); ?>
								<input type="file" name="oragnizerImage" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info8').html($(this).val());">
							</a>
							(.png, .jpg, .jpeg, .gif, .svg)
						</div>
						<span class='label label-info' id="upload-file-info8"></span>
					</div>
					
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('add_event'); ?></button>
                </div>
            </form>
        </div>
    </div>   
</div>

<div class="row">
	<div class="col-lg-6 col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title"><?= trans('event_lists'); ?></h3>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped cs_datatable_lang" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= trans('id'); ?></th>
                                    <th><?= trans('event_name'); ?></th>
                                    <th><?= trans('event_date'); ?></th>
                                    <th class="th-options"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($eventsList)):
									$i = 1;
                                    foreach ($eventsList as $item): ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= esc($item->event_name); ?></td>
                                            <td><?= esc($item->event_date); ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?><span class="caret"></span></button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li><a href="<?= adminUrl('edit-eventList-details/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a></li>
														
                                                        <li><a href="javascript:void(0)" onclick="deleteItem('AdminController/deleteEventListPost','<?= $item->id; ?>','<?= trans("confirm_delete", true); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php 
									$i++;
									endforeach;
                                endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-lg-6 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("add_gallery_image"); ?></h3>
				<div class="right">
                    <a href="<?= adminUrl("edit-image-gallery-category"); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= trans('gallery_images'); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('AdminController/eventSettingsPostImages'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label">Select Category</label>
                        <select name="category" class="form-control form-input">
							<option value="">
									--Select--
								</option>
							<?php 
								
								if(!empty($categoryImages)){
								foreach ($categoryImages as $category): ?>
								<option value="<?= $category->categoryId; ?>">
									<?= $category->categoryName; ?>
								</option>
							<?php endforeach; 
								}
								 ?>
						</select>
                    </div>
					
					<div class="form-group">
                        <label class="control-label"><?= trans('images_gallery'); ?> (select multiple images)</label>
                        <div class="display-block">
                            <a class='btn btn-danger btn-file-upload'>
                                <i class="fa fa-image"></i>&nbsp;&nbsp;<?= trans('select_gallery_images'); ?>
                                <input type="file" name="fileuploads[]"  required multiple>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
					<?php /* <a href="<?= adminUrl("select-home-page-images"); ?>" class="btn btn-success pull-left">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;Select Home Page Images
                    </a> */ ?>
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('add_images_gallery'); ?></button>
                </div>
            </form>
        </div>
    </div>
	
	<div class="col-lg-6 col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Add Gallery Images Category</h3>
				<div class="right">
                    <a href="<?= adminUrl("edit-image-gallery-category-list"); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;Edit Gallery Category
                    </a>
                </div>
            </div>
            <form action="<?= base_url('AdminController/galleryImagescategoryPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
				
				<div class="box-body">
					<div class="form-group">
                        <label>Category Name</label>
                        <input type="text" class="form-control" name="categoryName" placeholder="Ex : ABC DIWALI GALA" required>
                    </div>
					
					<div class="form-group">
                        <label>Order</label>
                        <input type="number" class="form-control" name="order" placeholder="1" required min="1">
                    </div>
					
					<div class="form-group">
						<label class="control-label">Front Image</label>
						<div class="display-block">
							<a class='btn btn-success btn-sm btn-file-upload'> 
								Upload Front Image
								<input type="file" name="frontImage" size="40" accept=".png, .jpg, .jpeg" onchange="$('#upload-file-info13').html($(this).val());">
							</a>
							(.png, .jpg, .jpeg)
						</div>
						<span class='label label-info' id="upload-file-info13"></span>
					</div>
                </div>
				
				<div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Add Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-lg-6 col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("add_gallery_video"); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/galleryVideoPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
				
				<div class="box-body">
					<div class="form-group">
                        <label><?= trans("video_name"); ?></label>
                        <input type="text" class="form-control" name="videoName" placeholder="Ex : ABC DIWALI GALA" required>
                    </div>
					
					<div class="form-group">
                        <label><?= trans("video_file_name"); ?></label>
                        <input type="text" class="form-control" name="uploaldFileName" placeholder="Ex : abc.mp4" required>
                    </div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-sm-6">
								<label>Downloadable</label>
							</div>
							<div class="col-sm-3 col-xs-12 col-option">
								<input type="radio" name="downloadVideo" value="1"  class="square-purple" checked>
								<label for="row_width_1" class="option-label">Yes</label>
							</div>
							<div class="col-sm-3 col-xs-12 col-option">
								<input type="radio" name="downloadVideo" value="0"  class="square-purple">
								<label for="row_width_2" class="option-label">No</label>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label"><?= trans('thumbnail_image'); ?></label>
						<div class="display-block">
							<a class='btn btn-success btn-sm btn-file-upload'>
								<?= trans('thumbnail_image_select'); ?>
								<input type="file" name="thumbImage" size="40" accept=".png, .jpg, .jpeg" onchange="$('#upload-file-info10').html($(this).val());">
							</a>
							(.png, .jpg, .jpeg)
						</div>
						<span class='label label-info' id="upload-file-info10"></span>
					</div>
                </div>
				
				<div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('add_video'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-lg-6 col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title"><?= trans('galley_video_list'); ?></h3>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped cs_datatable_lang" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= trans('id'); ?></th>
                                    <th><?= trans('video_name'); ?></th>
                                    <th><?= trans('video_file_name'); ?></th>
                                    <th class="th-options"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($galleryVideoList)):
									$i = 1;
                                    foreach ($galleryVideoList as $item): ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= esc($item->videoName); ?></td>
                                            <td><?= esc($item->uploaldFileName); ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?><span class="caret"></span></button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li><a href="<?= adminUrl('edit-video-gallery/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a></li>
														
                                                        <li><a href="javascript:void(0)" onclick="deleteItem('AdminController/deleteGalleryVideoDataPost','<?= $item->id; ?>','<?= trans("confirm_delete", true); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php 
									$i++;
									endforeach;
                                endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
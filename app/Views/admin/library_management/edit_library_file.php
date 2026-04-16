<div class="row">
    <div class="col-sm-12 title-section">
        <h3><?= trans('library-management'); ?></h3>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Edit File</h3>
				
				<div class="right">
					<a href="<?= adminUrl('library-list-pdf'); ?>" class="btn btn-danger btn-add-new">
						<i class="fa fa-bars"></i>&nbsp;&nbsp;Back
					</a>
				</div>
            </div>
			
			
		
            <form action="<?= base_url('AdminController/editlibraryPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("name"); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?= trans("name"); ?>" value= "<?= $page->name;?>" required>
                    </div>
					
					<div class="form-group">
                        <label>Order</label>
                         <input type="number" class="form-control" name="order" placeholder="ex: 1" min="1"  value= "<?= $page->order;?>" required>
                    </div>
					
					<div class="form-group">
                        <label><?= trans('parent_category'); ?></label>
                        <select class="form-control" name="category_id" required id="parent_category">
							<option value="" selected>--SELECT--</option>
                            <?php if (!empty($categories)):
                                foreach ($categories as $parentCategory):
								?>
                                    <option value="<?= $parentCategory->id; ?>" <?php echo ($page->parent_id == $parentCategory->id) ? 'selected' : ''; ?>>
										<?= $parentCategory->catgeoryName; ?>
									</option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
					
					<div class="form-group" id="sub_category_container" style="display: none;">
						<label>Sub Category</label>
						<select class="form-control" name="sub_category" id="sub_category">
						</select>
					</div>

					
					<div class="form-group">
						<label class="control-label"><?= trans('cover_image'); ?></label>
						<div class="display-block">
							<a class='btn btn-success btn-sm btn-file-upload'>
								<?= trans('upload_image_cover'); ?>
								<input type="file" name="coverImage" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info1').html($(this).val());">
							</a>
							(.png, .jpg, .jpeg, .gif, .svg)
						</div>
						<span class='label label-info' id="upload-file-info1"></span>
					</div>
					
					<div class="form-group">
						<label class="control-label"><?= trans('upload_file'); ?></label> 
						<div class="display-block">
							<a class='btn btn-success btn-md btn-file-upload'>
								<?= trans('browse_file'); ?>
								<input type="file" name="fileUpload" accept=".pdf" onchange="$('#upload-file-info2').html($(this).val());" >
							</a>
							(.pdf)
						</div>
						<span class='label label-info' id="upload-file-info2"></span>
					</div>
					<input type="hidden" name="id" value="<?php echo $page->id;?>">
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('add_file'); ?></button>
                </div>
            </form>
        </div>  
    </div>
</div>

<script>
// JavaScript code
document.getElementById('parent_category').addEventListener('change', function () {
    var parentCategoryId = this.value;
	
	if(parentCategoryId == '')
	{
		 var subCategoryContainer = document.getElementById('sub_category_container');
		subCategoryContainer.style.display = 'none';
		$('#sub_category').empty();
		return false;
	}
	// Get the sub-category container
    var subCategoryContainer = document.getElementById('sub_category_container');

    if (parentCategoryId === '0') {
        // If the parent category is set to "None," hide the sub-category container
        subCategoryContainer.style.display = 'none';
    } else {
        // If a parent category is selected, show the sub-category container
        subCategoryContainer.style.display = 'block'; // You can also use 'inline' or 'inline-block' if needed
    }
	
	var subCategoryDropdown = document.getElementById('sub_category');
	
    var data = {
        'parent_id': parentCategoryId
    };
    $.ajax({
        url: MdsConfig.baseURL + '/AdminController/getSubcategoryLibararyData',	
        data: setAjaxData(data),
        type: 'POST',
        dataType: 'json',
        success: function (data) {
			
            $('#sub_category').empty();
			
			if (data.length === 0) {
				subCategoryContainer.style.display = 'none';
				subCategoryDropdown.removeAttribute('required');
				subCategoryDropdown.removeAttribute('name');
				swal('No sub category data available','','info');
			} else {
					$.each(data, function (key, value) {
						var option = $('<option>', {
							value: value.id,
							text: value.catgeoryName
						});

						// Check if the current option's value matches the sub_parent_id
						if ($page.sub_parent_id && value.id == $page.sub_parent_id) {
							option.prop('selected', true);
						}

						$('#sub_category').append(option);
					});

					// Show the sub-category container after updating the options
					subCategoryContainer.style.display = 'block';
				}
        },
        error: function () {
            swal('Warning','No Related Data Found','info');
        }
    });
});

function setAjaxData(object = null) {
    var data = {
        'sysLangId': MdsConfig.sysLangId,
    };
    data[MdsConfig.csrfTokenName] = $('meta[name="X-CSRF-TOKEN"]').attr('content');
    if (object != null) {
        Object.assign(data, object);
    }
    return data;
}
</script>
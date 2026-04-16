<div class="row">
    <div class="col-sm-12 title-section">
        <h3><?= trans('library-management'); ?></h3>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("add_file_details"); ?></h3>
				
				<div class="right">
					<a href="<?= adminUrl('library-list-pdf'); ?>" class="btn btn-danger btn-add-new">
						<i class="fa fa-bars"></i>&nbsp;&nbsp;<?= trans('file_list'); ?>
					</a>
				</div>
				
				<p style="color:red;font-weight:bold;">Note : The order will be in descending order on the library page.</p>
            </div>
			
			
		
            <form action="<?= base_url('AdminController/libraryPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("name"); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?= trans("name"); ?>" required>
                    </div>
					
					<div class="form-group">
                        <label>Order</label>
                         <input type="number" class="form-control" name="order" placeholder="ex: 1" min="1"  required>
                    </div>
					
					<div class="form-group">
                        <label><?= trans('parent_category'); ?></label>
                        <select class="form-control" name="category_id" required id="parent_category">
							<option value="" selected>--SELECT--</option>
                            <?php if (!empty($categories)):
                                foreach ($categories as $parentCategory):
								?>
                                    <option value="<?= $parentCategory->id; ?>"><?= $parentCategory->catgeoryName; ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
					
					<div class="form-group" id="sub_category_container" style="display: none;">
						<label>Sub Category</label>
						<select class="form-control" name="sub_category" id="sub_category" required>
						</select>
					</div>

					
					<div class="form-group">
						<label class="control-label"><?= trans('cover_image'); ?></label>
						<div class="display-block">
							<a class='btn btn-success btn-sm btn-file-upload'>
								<?= trans('upload_image_cover'); ?>
								<input type="file" name="coverImage" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info1').html($(this).val());" required>
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
								<input type="file" name="fileUpload" accept=".pdf" onchange="$('#upload-file-info2').html($(this).val());" required>
							</a>
							(.pdf)
						</div>
						<span class='label label-info' id="upload-file-info2"></span>
					</div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('add_file'); ?></button>
                </div>
            </form>
        </div>  
    </div>
	
	<div class="col-lg-6 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title">Category Lists</h3>
                </div>
				
				<div class="right">
					<a href="<?= adminUrl('add-category-pdf-list'); ?>" class="btn btn-danger btn-add-new">
						<i class="fa fa-plus"></i>&nbsp;&nbsp;Add Category
					</a>
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
                                    <th>Category Name</th>
                                    <th class="th-options"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($categories)):
                                    foreach ($categories as $item): ?>
                                        <tr>
                                            <td><?= esc($item->id); ?></td>
                                            <td><?= esc($item->catgeoryName); ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?><span class="caret"></span></button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li><a href="<?= adminUrl('edit-library-category-details/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;
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
					$('#sub_category').append($('<option>', {
						value: value.id,
						text: value.catgeoryName
					}));
				});
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
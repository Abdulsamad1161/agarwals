<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('add_category'); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('library'); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= trans('library'); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('AdminController/addCategoryLibraryPost'); ?>" method="post">
                <?= csrf_field(); ?>
            <div class="box-body">
                    <div class="form-group">
                        <label class="control-label">Category Name</label>
                        <input type="text" class="form-control" name="catgeoryName" placeholder="Category Name" value="">
                    </div>
					
                    <div class="form-group">
                        <label><?= trans('parent_category'); ?></label>
                        <select class="form-control" name="category_id" required>
                            <option value="0"><?= trans('none'); ?></option>
                            <?php if (!empty($parentCategories)):
                                foreach ($parentCategories as $parentCategory):
								?>
                                    <option value="<?= $parentCategory->id; ?>"><?= $parentCategory->catgeoryName; ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
					
					<div class="form-group">
                        <div class="row">
                            <div class="col-sm-4 col-xs-12">
                                <label><?= trans('visibility'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="visibility" value="1" id="visibility_1" class="square-purple" checked>
                                <label for="visibility_1" class="option-label"><?= trans('show'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="visibility" value="0" id="visibility_2" class="square-purple">
                                <label for="visibility_2" class="option-label"><?= trans('hide'); ?></label>
                            </div>
                        </div>
                    </div>
					
					
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('add_category'); ?></button>
                </div>
			</div>
			</form>
		</div>
	</div>
</div>
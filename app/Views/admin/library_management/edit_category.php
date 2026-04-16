<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title">Edit Category</h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('library'); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= trans('library'); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('AdminController/editCategoryLibraryPost'); ?>" method="post">
                <?= csrf_field(); ?>
				<input type="hidden" name="id" value="<?= $parentCategory->id; ?>">
            <div class="box-body">
                    <div class="form-group">
                        <label class="control-label">Category Name</label>
                        <input type="text" class="form-control" name="catgeoryName" placeholder="Category Name" value="<?= $parentCategory->catgeoryName; ?>">
                    </div>
					
					<div class="form-group">
                        <div class="row">
                            <div class="col-sm-4 col-xs-12">
                                <label><?= trans('visibility'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="visibility" value="1" id="visibility_1" class="square-purple" <?php if($parentCategory->visible == 1){ echo 'checked';}?>>
                                <label for="visibility_1" class="option-label"><?= trans('show'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="visibility" value="0" id="visibility_2" class="square-purple"  <?php if($parentCategory->visible == 0){ echo 'checked';}?>>
                                <label for="visibility_2" class="option-label"><?= trans('hide'); ?></label>
                            </div>
                        </div>
                    </div>
					
					
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Edit Category</button>
                </div>
			</div>
			</form>
		</div>
	</div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title">Edit your Sub Categories</h3>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= trans('id'); ?></th>
                                    <th>Category Name</th>
                                    <th>Parent Category</th>
                                    <th><?= trans('visibility'); ?></th>
                                    <th class="th-options"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($categories)):
									$i= 1;
                                    foreach ($categories as $item): ?>
                                        <tr>
										<form action="<?= base_url('AdminController/editsubCategoryLibraryPost'); ?>" method="post">
										<?= csrf_field(); ?>
                                            <td><?= $i; ?></td>
                                            <td>
												<input type="text" class="form-control" name = "catgeoryName" value="<?= $item->catgeoryName ;?>"></td>
                                            <td>
											<div class="form-group">
												<select class="form-control" name="category_id" required>
													<?php if (!empty($parentCategories)):
														foreach ($parentCategories as $parentCategory):
															?>
															<option value="<?= $parentCategory->id; ?>" <?php if ($item->parent_id == $parentCategory->id) echo 'selected'; ?>>
																<?= $parentCategory->catgeoryName; ?>
															</option>
														<?php endforeach;
													endif; ?>
												</select>
											</div>
											</td>
											<td>
												<div class="form-group">
													<input type="radio" name="visible_<?= $i ?>" value="1" id="visible_<?= $i ?>_1" <?php echo ($item->visible == 1) ? 'checked' : ''; ?>>
													<label for="visible<?= $i ?>_1" class="option-label"><?= trans('yes'); ?></label>
													&nbsp;&nbsp;&nbsp;
													<input type="radio" name="visible_<?= $i ?>" value="0" id="visible_<?= $i ?>_0" <?php echo ($item->visible == 0) ? 'checked' : ''; ?>>
													<label for="visible_<?= $i ?>_0" class="option-label"><?= trans('no'); ?></label>
												</div>
											</td>
											
											<td><button type="submit" class="btn btn-md btn-success" style="font-size : 12px;"><?= trans('save_changes'); ?></button></td>
											<input type="hidden" name="id" value="<?= $item->id;?>">
										</form>
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
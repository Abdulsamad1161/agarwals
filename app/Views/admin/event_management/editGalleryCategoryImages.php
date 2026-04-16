<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title">Edit Your Gallery Category</h3>
                </div>
				
				<div class="right">
                    <a href="<?= adminUrl("event-settings"); ?>" class="btn btn-danger">
                         <i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;Back
                    </a>
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
                                    <th>Order</th>
                                    <th>Visibility</th>
                                    <th>Front Image</th>
                                    <th class="th-options"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($galleryImages)):
									$i= 1;
                                    foreach ($galleryImages as $item): ?>
                                        <tr>
										<form action="<?= base_url('AdminController/editFormFieldsPost'); ?>" method="post"  enctype="multipart/form-data">
										<?= csrf_field(); ?>
                                            <td><?= $i; ?></td>
                                            <td><input type="text" class="form-control" name = "categoryName" value="<?= $item->categoryName ;?>"></td>
											<td><input type="number" class="form-control" name = "order" value="<?= $item->order ;?>"></td>
                                            <td>
											<div class="form-group">
												<input type="radio" name="visible_<?= $i ?>" value="1" id="isRequired_<?= $i ?>_1" <?php echo ($item->visible == 1) ? 'checked' : ''; ?>>
												<label for="isRequired_<?= $i ?>_1" class="option-label"><?= trans('yes'); ?></label>
												&nbsp;&nbsp;&nbsp;
												<input type="radio" name="visible_<?= $i ?>" value="0" id="isRequired_<?= $i ?>_0" <?php echo ($item->visible == 0) ? 'checked' : ''; ?>>
												<label for="isRequired_<?= $i ?>_0" class="option-label"><?= trans('no'); ?></label>
											</div>
											</td>
											<td><input type="file" name="frontImage" size="40" accept=".png, .jpg, .jpeg" onchange="$('#upload-file-info13').html($(this).val());"></td>
											<td><button type="submit" class="btn btn-md btn-success" style="font-size : 12px;"><?= trans('save_changes'); ?></button></td>
											<input type="hidden" name="categoryId" value="<?= $item->categoryId;?>">
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
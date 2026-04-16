<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Sponsorship Management</h3>
            </div>
			
            <form action="<?= base_url('AdminController/editSponsorshipGeneral'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label>Button Label</label>
                        <input type="text" class="form-control" name="btn_name" placeholder="<?= trans("name"); ?>" value= "<?= $sponsorship->btn_name;?>" required>
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
					
					<div class="form-group">
						<label class="control-label">Sponsorship Image</label>
						<div class="display-block">
							<a class='btn btn-success btn-sm btn-file-upload'>
								Sponsorship Image Upload
								<input type="file" name="sponsorshipImage" size="40" accept=".png, .jpg, .jpeg" onchange="$('#upload-file-info1').html($(this).val());">
							</a>
							(.png, .jpg, .jpeg)
						</div>
						<span class='label label-info' id="upload-file-info1"></span>
					</div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('add_file'); ?></button>
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
                    <h3 class="box-title"><?= trans('our-sponsors-list'); ?></h3>
                </div>
				
				<div class="right">
					<a href="<?= adminUrl('add-our-sponsors'); ?>" class="btn btn-success btn-add-new">
						<i class="fa fa-plus"></i>&nbsp;&nbsp;<?= trans('add_sponsor'); ?>
					</a>
				</div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped data_table" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= trans('id'); ?></th>
                                    <th><?= trans('name'); ?></th>
                                    <th><?= trans('sponsors_website_link'); ?></th>
                                    <th><?= trans('order'); ?></th>
                                    <th><?= trans('option'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($sponsorsList)):
									$i = 1;
                                    foreach ($sponsorsList as $item): ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= esc($item->name); ?></td>
                                            <td><?= esc($item->linkSponsor); ?></td>
                                            <td><?= esc($item->order); ?></td>
                                            <td>
												<div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?><span class="caret"></span></button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li><a href="<?= adminUrl('edit-sponsor/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a></li>
														
                                                        <li><a href="javascript:void(0)" onclick="deleteItem('AdminController/deleteOurSponsorPost','<?= $item->id; ?>','<?= trans("confirm_delete", true); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a></li>
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
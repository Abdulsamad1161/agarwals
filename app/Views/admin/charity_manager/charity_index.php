<div class="row">
    <div class="col-sm-12 title-section">
        <h3><?= trans('charity_manager'); ?></h3>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("add_charity_details"); ?></h3>
            </div>
            <form action="<?= base_url('TicketController/charityPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("charity_name"); ?></label>
                        <input type="text" class="form-control" name="charityName" placeholder="<?= trans("event_name"); ?>" required>
                    </div>
					
					<div class="form-group">
                        <label><?= trans("charity_note"); ?></label>
                        <textarea type="text" class="form-control" name="charityNote" placeholder="<?= trans("event_date"); ?>" required></textarea>
                    </div>
					
					<div class="form-group">
						<label><?= trans("link_e_payment"); ?></label>
						<input type="text" class="form-control" name="e_payment_link" placeholder="<?= trans("link_e_payment"); ?>">
					</div>
					
					<div class="form-group">
						<label><?= 'Paypal Charges in %'; ?></label>
						<input type="number" class="form-control" name="paypalFees" min="0" placeholder="0%">
					</div>
					
					<div class="form-group">
						<label class="control-label"><?= trans('charity_image'); ?></label>
						<div class="display-block">
							<a class='btn btn-success btn-sm btn-file-upload'>
								<?= trans('charity_upload_image'); ?>
								<input type="file" name="charityImage" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info1').html($(this).val());" multiple required>
							</a>
							(.png, .jpg, .jpeg, .gif, .svg)
						</div>
						<span class='label label-info' id="upload-file-info1"></span>
					</div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('charity_add'); ?></button>
                </div>
            </form>
        </div>  
    </div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title"><?= trans('charity_list'); ?></h3>
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
                                    <th><?= trans('charity_name'); ?></th>
                                    <th><?= trans('charity_note'); ?></th>
                                    <th class="th-options"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($charityList)):
									$i = 1;
                                    foreach ($charityList as $item): ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= esc($item->charityName); ?></td>
                                            <td><?= esc($item->charityNote); ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?><span class="caret"></span></button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li><a href="<?= adminUrl('edit-charityList-details/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a></li>
														<li><a href="<?= adminUrl('report-charityList-details/' . $item->id); ?>"><i class="fa fa-file option-icon"></i><?= trans('report'); ?></a></li>
														<li><a href="javascript:void(0)" onclick="deleteItem('AdminController/deleteCharityData','<?= $item->id; ?>','<?= trans("confirm_delete", true); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a></li>
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

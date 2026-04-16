<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
				<?php
				$currentUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$lastSegment = basename(parse_url($currentUrl, PHP_URL_PATH));

				if($lastSegment == 'deleted-rsvp-form')
				{
					$deleted = 1;
				}
				else
				{
					$deleted = 0;
				}
				
				if($deleted == 1)
				{
				?>
					<div class="left">
						<h3 class="box-title"><?= trans('list_of_rsvp_forms'); ?> - Deleted</h3>
					</div>
					<div class="right">
					   <a href="<?= adminUrl('rsvp-form-report'); ?>" class="btn btn-success btn-add-new">
							<i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;Back
						</a>
					</div>
				<?php } else { ?>
					<div class="left">
						<h3 class="box-title"><?= trans('list_of_rsvp_forms'); ?></h3>
					</div>
					<div class="right">
					   <a href="<?= adminUrl('deleted-rsvp-form'); ?>" class="btn btn-danger btn-add-new">
							<i class="fa fa-trash"></i>&nbsp;&nbsp;Deleted RSVP Form
						</a>
					</div>
				<?php } ?>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped data_table" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= trans('id'); ?></th>
                                    <th><?= trans('form_title'); ?></th>
                                    <th><?= trans('form_sub_title'); ?></th>
                                    <th><?= trans('note'); ?></th>
                                    <th><?= trans('status'); ?></th>
                                    <th class="th-options"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($formList)):
                                    foreach ($formList as $item): ?>
                                        <tr>
                                            <td><?= esc($item->form_id); ?></td>
                                            <td><?= esc($item->form_name); ?></td>
                                            <td><?= esc($item->form_sub_name); ?></td>
                                            <td><?= esc($item->form_note); ?></td>
                                            <td>
                                                <?php if ($item->status == 1): ?>
                                                    <label class="label bg-olive label-table"><?= trans('active'); ?></label>
                                                <?php else: ?>
                                                    <label class="label bg-danger label-table"><?= trans('inactive'); ?></label>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?>
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu options-dropdown">
														<?php 
														if($deleted == 1)
														{
														?>
															<li><a href="<?= adminUrl('report-rsvp-form/' . $item->form_id); ?>"><i class="fa fa-file-text option-icon"></i><?= trans('report'); ?></a></li>
															<li><a href="javascript:void(0)" onclick="deleteItem('RSVPController/deleteUndoRSVPForm','<?= $item->form_id; ?>','<?= 'Are you sure you want to revert this form ?'; ?>');"><i class="fa fa-trash option-icon"></i>Undo Delete</a></li>
														<?php } else { ?>
															<li><a href="<?= adminUrl('edit-rsvp-form/' . $item->form_id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a></li>
															<li><a href="<?= adminUrl('report-rsvp-form/' . $item->form_id); ?>"><i class="fa fa-file-text option-icon"></i><?= trans('report'); ?></a></li>
															<li><a href="javascript:void(0)" onclick="deleteItem('RSVPController/deleteRSVPForm','<?= $item->form_id; ?>','<?= trans("confirm_delete", true); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a></li>
														<?php } ?>
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
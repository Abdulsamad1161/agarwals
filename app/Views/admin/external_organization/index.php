<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title">Note Manager</h3>
                </div>
            </div>
			<form action="<?= base_url('AdminController/editExternalOrganizationNote'); ?>" method="post">
                <?= csrf_field(); ?>
			<div class="box-body">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="form-group">
							<label><?= trans("note"); ?></label>
							<textarea type="text" class="form-control" name="external_organizations" placeholder="<?= trans("note"); ?>"><?php echo $pagesNote; ?></textarea>
						</div>
					</div>
				</div>	
			</div>
			<div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
            </div>
			</form>
		</div>
	</div>
</div>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title">External Organization</h3>
        </div>
		
		<div class="right">
            <a href="<?= adminUrl('add-external-organization'); ?>" class="btn btn-success btn-add-new">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;Add More
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <thead>
                        <tr role="row">
                            <th width="20"><?= trans('id'); ?></th>
                            <th><?= trans('name'); ?></th>
                            <th><?= trans('link'); ?></th>
                            <th><?= trans('description'); ?></th>
                            <th class="th-options"><?= trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($pages)):
                            foreach ($pages as $item): ?>
                                <tr>
                                    <td><?= esc($item->id); ?></td>
                                    <td><?= esc($item->name); ?></td>
                                    <td><?= esc($item->link); ?></td>
                                    <td>
                                        <?= esc($item->description)?>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <li><a href="<?= adminUrl('edit-external-organization/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a></li>
												<li><a href="javascript:void(0)" onclick="deleteItem('AdminController/deleteExternalOrganization','<?= $item->id; ?>','<?= trans("confirm_delete", true); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a></li>
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
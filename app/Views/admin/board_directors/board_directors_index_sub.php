<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title">Past Presidents List</h3>
                </div>
				
				<div class="right">
					<a href="<?= adminUrl('add-board-directors-sub'); ?>" class="btn btn-success btn-add-new">
						<i class="fa fa-plus"></i>&nbsp;&nbsp;Add Past President
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
                                    <th><?= trans('description'); ?></th>
                                    <th><?= trans('order'); ?></th>
                                    <th><?= trans('option'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($boardMembers)):
									$i = 1;
                                    foreach ($boardMembers as $item): ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= esc($item->name); ?></td>
                                            <td><?= esc($item->description); ?></td>
                                            <td><?= esc($item->order); ?></td>
                                            <td>
												<div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?><span class="caret"></span></button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li><a href="<?= adminUrl('edit-board-directors-sub/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a></li>
														
                                                        <li><a href="javascript:void(0)" onclick="deleteItem('AdminController/deleteBoardDirectorSubPost','<?= $item->id; ?>','<?= trans("confirm_delete", true); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a></li>
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
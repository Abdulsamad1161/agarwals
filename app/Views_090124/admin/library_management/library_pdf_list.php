<?php if($listName == 'libraryFile')
{?>
<div class="row">
	<div class="col-lg-12 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title"><?= trans('Library_file_list'); ?></h3>
                </div>
				
				<div class="right">
					<a href="<?= adminUrl('library'); ?>" class="btn btn-danger">
						<i class="fa fa-bars"></i>&nbsp;&nbsp;<?= trans('back'); ?>
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
                                    <th><?= trans('name'); ?></th>
                                    <th>Order</th>
                                    <th class="th-options"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($libraryListPdf)):
									$i = 1;
                                    foreach ($libraryListPdf as $item): ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= esc($item->name); ?></td>
                                            <td><?= esc($item->order); ?></td>
                                            <td>
												<a class="btn btn-warning" href="<?= adminUrl('edit-library-list-pdf/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
												<a href="javascript:void(0)" class='btn bg-purple' onclick="deleteItem('AdminController/deleteLibraryPdfFile','<?= $item->id; ?>','<?= trans("confirm_delete", true); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
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
<?Php } 
else
{?>
<div class="row">
	<div class="col-lg-12 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title"><?= trans('magazine_file_list'); ?></h3>
                </div>
				
				<div class="right">
					<a href="<?= adminUrl('library'); ?>" class="btn btn-danger">
						<i class="fa fa-bars"></i>&nbsp;&nbsp;<?= trans('back'); ?>
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
                                    <th><?= trans('name'); ?></th>
                                    <th class="th-options"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($libraryListMagazinePdf)):
									$i = 1;
                                    foreach ($libraryListMagazinePdf as $item): ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= esc($item->name); ?></td>
                                            <td>
                                                <a href="javascript:void(0)" class='btn bg-purple' onclick="deleteItem('AdminController/deleteLibraryPdfMagazine','<?= $item->id; ?>','<?= trans("confirm_delete", true); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
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
<?php } ?>
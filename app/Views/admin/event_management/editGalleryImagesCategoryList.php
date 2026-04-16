<div class="row">
	<div class="col-lg-6 col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title">Image Category List</h3>
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
                            <table class="table table-bordered table-striped cs_datatable_lang" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= trans('id'); ?></th>
                                    <th>Category Name</th>
                                    <th class="th-options"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($galleryImages)):
									$i = 1;
                                    foreach ($galleryImages as $item): ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= esc($item->categoryName); ?></td>
                                            <td style="text-align : center;">
                                                <a class="btn btn-md btn-danger" href="<?= adminUrl('edit-image-gallery/' . $item->categoryId); ?>"><i class="fa fa-eye"></i>&nbsp;&nbsp;View More</a>
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
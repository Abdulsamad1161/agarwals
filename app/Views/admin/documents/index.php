<div class="row">
    <div class="col-sm-12 title-section">
        <h3>Documents</h3>
    </div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Add Documents</h3>
            </div>
			
            <form action="<?= base_url('AdminController/addDocumentsPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
				
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-4">
								<div class="form-group">
									<label>Document Name</label>
									<input type="text" class="form-control" name="documentName" placeholder="Ex : Terms and Conditions" required>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Order</label>
									<input type="number" class="form-control" name="order" placeholder="Ex : 1" min="1" required>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label">Document Upload (<span style="color:red;font-weight:bold;">Note : Only PDFs can be uploaded.</span>)</label>
									<div class="display-block">
										<a class='btn btn-success btn-sm btn-file-upload'>
											Select PDF Document
											<input type="file" name="document" size="40" accept=".pdf" onchange="$('#upload-file-info10').html($(this).val());">
										</a>
										(.pdf)
									</div>
									<span class='label label-info' id="upload-file-info10"></span>
								</div>
							</div>
						</div>
					</div>
                </div>
				
				<div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Add Document</button>
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
                    <h3 class="box-title">Document List</h3>
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
                                    <th>Document Name</th>
                                    <th>Order</th>
                                    <th class="th-options"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($documentList)):
									$i = 1;
                                    foreach ($documentList as $item): ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= esc($item->documentName); ?></td>
                                            <td><?= esc($item->order); ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?><span class="caret"></span></button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li><a href="<?= adminUrl('edit-documents/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a></li>
														
                                                        <li><a href="javascript:void(0)" onclick="deleteItem('AdminController/deleteDocumentsPost','<?= $item->id; ?>','<?= trans("confirm_delete", true); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a></li>
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
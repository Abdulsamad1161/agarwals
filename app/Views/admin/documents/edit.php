<div class="box-header with-border">
	<h3 class="box-title">Documents</h3>
	<div class="right">
		<a href="<?= adminUrl("documents"); ?>" class="btn btn-success btn-add-new">
			<i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;Back
		</a>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Documents</h3>
            </div>
			
            <form action="<?= base_url('AdminController/editDocumentsPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
				
				<div class="box-body">
					
					<div class="form-group">
						<label>Document Name</label>
						<input type="text" class="form-control" name="documentName" value="<?= $documentData->documentName; ?>" required>
					</div>
					
					<div class="form-group">
						<label>Order</label>
						<input type="number" class="form-control" name="order" value="<?= $documentData->order; ?>" min="1" required>
					</div>
							
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
						<br>
						<span class='label label-warning' >Aldready Uploaded File : <?= $documentData->document; ?></span>
					</div>
                </div>
				
				<div class="box-footer">
					<input type="hidden" name="id" value="<?= $documentData->id; ?>">
                    <button type="submit" class="btn btn-primary pull-right">Edit Document</button>
                </div>
            </form>
        </div>
    </div>
</div>

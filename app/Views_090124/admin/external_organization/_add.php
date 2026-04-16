<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title">Add External Organization</h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl("external-organization"); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;External Organization
                    </a>
                </div>
            </div>
            <form action="<?= base_url('AdminController/addExternalOrganizationPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= trans('name'); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?= trans('title'); ?>" required>
                    </div>
					
					<div class="form-group">
                        <label class="control-label"><?= trans('description'); ?></label>
						<textarea class="form-control" name="description" placeholder="add a description......" rows="4" cols="50" required> </textarea>
                    </div>
					
					<div class="form-group">
                        <label class="control-label"><?= trans('link'); ?></label>
                        <input type="text" class="form-control" name="link" placeholder="<?= trans('link'); ?>" required>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
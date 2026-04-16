<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title">Edit External Organization</h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl("external-organization"); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;External Organization
                    </a>
                </div>
            </div>
            <form action="<?= base_url('AdminController/editExternalOrganizationPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= trans('name'); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?= trans('title'); ?>" value="<?= esc($page->name); ?>" required>
                    </div>
					
					<div class="form-group">
                        <label class="control-label"><?= trans('description'); ?></label>
						<textarea class="form-control" name="description" placeholder="add a description......" rows="4" cols="50" required><?= esc($page->description); ?></textarea>
                    </div>
					
					<div class="form-group">
                        <label class="control-label"><?= trans('link'); ?></label>
                        <input type="text" class="form-control" name="link" placeholder="<?= trans('link'); ?>" value="<?= esc($page->link); ?>" required>
                    </div>
					
					<input type="hidden" value="<?= esc($page->id); ?>" name="id">
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>
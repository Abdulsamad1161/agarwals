<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('update_page'); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/editPageContentPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= $page->id; ?>">
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= trans('title'); ?></label>
                        <input type="text" class="form-control" name="title" placeholder="<?= trans('title'); ?>" value="<?= esc($page->title); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Location</label>
                        <input type="text" class="form-control" name="location" placeholder="location" value="<?= esc($page->location); ?>">
                    </div>
					
					<div class="form-group">
                        <label class="control-label">Page Content</label>
                        <textarea class="form-control" rows="15" cols="70" name="pageContent"><?= esc($page->page_content); ?></textarea>
                    </div>

                    
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
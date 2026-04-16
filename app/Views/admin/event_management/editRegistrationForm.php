<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title">Edit Registration JOT Form</h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl("event-settings"); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;<?= trans('back'); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('AdminController/editRegistrationFormPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <input type="hidden" class="form-control" name="id" value="<?= $galleryVideos->id; ?>">
                    <div class="form-group">
                        <label class="control-label">JOT Form URL</label>
                        <input type="text" class="form-control" name="jot_form_url"
                            value="<?= $galleryVideos->jot_form_url; ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date"
                            value="<?= $galleryVideos->start_date; ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label">End Date</label>
                        <input type="date" class="form-control" name="end_date" value="<?= $galleryVideos->end_date; ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Select Event</label>
                        <select class="form-control" name="event_id" required>
                            <option value="">--CHOOSE EVENT--</option>
                            <?php foreach ($eventsList as $events) { ?>
                                <option value="<?= $events->id; ?>" <?php if($events->id == $galleryVideos->event_id){ echo 'selected'; } ?>>
                                    <?= $events->event_name . ' (' . $events->event_date . ')'; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Edit Form</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<style>
    .image-card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin: 6px;
        border: 2px solid #d1274b;
        padding: 6px;
    }
</style>
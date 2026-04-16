<div class="row">
    <div class="col-sm-12 title-section">
        <h3><?= trans('newsletter'); ?></h3>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('users'); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/newsletterSendEmail'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="email_type" value="registered_user">
                <div class="box-body">
                    <div class="tableFixHead">
                        <table class="table table-users">
                            <thead>
                            <tr>
                                <th width="20"><input type="checkbox" id="check_all_users"></th>
                                <th><?= trans("id"); ?></th>
                                <th><?= trans("username"); ?></th>
                                <th><?= trans("email"); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($members)):
                                foreach ($members as $item): ?>
                                    <tr>
                                        <td><input type="checkbox" name="email[]" value="<?= $item->email; ?>"></td>
                                        <td><?= $item->id; ?></td>
                                        <td><?= esc(getUsername($item)); ?></td>
                                        <td><?= $item->email; ?></td>
                                    </tr>
                                <?php endforeach;
                            endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" name="submit" value="users" class="btn btn-lg btn-block btn-info"><?= trans("send_email"); ?>&nbsp;&nbsp;<i class="fa fa-send"></i></button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Non Members</h3>
            </div>
            <form action="<?= base_url('AdminController/newsletterSendEmail'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="email_type" value="subscriber">
                <div class="box-body">
                    <?php if (empty($nonMembers)): ?>
                        <p class="text-muted"><?= trans("no_records_found"); ?></p>
                    <?php else: ?>
                        <div class="tableFixHead">
                            <table class="table table-subscribers">
                                <thead>
                                <tr>
                                    <th width="20"><input type="checkbox" id="check_all_subscribers"></th>
                                    <th><?= trans("id"); ?></th>
									<th><?= trans("username"); ?></th>
									<th><?= trans("email"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($nonMembers)):
                                    foreach ($nonMembers as $item): ?>
                                        <tr>
                                            <td><input type="checkbox" name="email[]" value="<?= $item->email; ?>"></td>
                                            <td><?= $item->id; ?></td>
											<td><?= esc(getUsername($item)); ?></td>
											<td><?= $item->email; ?></td>
                                        </tr>
                                    <?php endforeach;
                                endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="box-footer">
                    <button type="submit" name="submit" value="subscribers" class="btn btn-lg btn-block btn-info"><?= trans("send_email"); ?>&nbsp;&nbsp;<i class="fa fa-send"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('settings'); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/newsletterSettingsPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <label><?= trans('status'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="newsletter_status" value="1" id="newsletter_status_1" class="square-purple" <?= $generalSettings->newsletter_status == 1 ? 'checked' : ''; ?>>
                                <label for="newsletter_status_1" class="option-label"><?= trans('enable'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="newsletter_status" value="0" id="newsletter_status_2" class="square-purple" <?= $generalSettings->newsletter_status != 1 ? 'checked' : ''; ?>>
                                <label for="newsletter_status_2" class="option-label"><?= trans('disable'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <label><?= trans('newsletter_popup'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="newsletter_popup" value="1" id="newsletter_popup_1" class="square-purple" <?= $generalSettings->newsletter_popup == 1 ? 'checked' : ''; ?>>
                                <label for="newsletter_popup_1" class="option-label"><?= trans('enable'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="newsletter_popup" value="0" id="newsletter_popup_2" class="square-purple" <?= $generalSettings->newsletter_popup != 1 ? 'checked' : ''; ?>>
                                <label for="newsletter_popup_2" class="option-label"><?= trans('disable'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans("image"); ?></label>
                        <div style="margin-bottom: 10px;">
                            <img src="<?= base_url($generalSettings->newsletter_image); ?>" alt="" style="max-width: 300px; max-height: 300px;">
                        </div>
                        <div class="display-block">
                            <a class='btn btn-success btn-sm btn-file-upload'>
                                <?= trans('select_image'); ?>
                                <input type="file" name="file" size="40" accept=".png, .jpg, .jpeg" onchange="$('#upload-file-info').html($(this).val().replace(/.*[\/\\]/, ''));">
                            </a>
                            (.png, .jpg, .jpeg)
                        </div>
                        <span class='label label-info' id="upload-file-info"></span>
                    </div>
                </div>
                <div class="box-footer text-right">
                    <button type="submit" name="submit" value="general" class="btn btn-primary"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
	
	<div class="col-md-6 col-lg-6 col-sm-12">
		<div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Send Email For Both</h3>
            </div>
            <form action="<?= base_url('AdminController/newsletterSendEmailBoth'); ?>" method="post" id="bothForm">
                <?= csrf_field(); ?>
                <div class="box-body">
					<input type="hidden" name="email_type" value="registered_user">
					<input type="hidden" name="selected_emails" id="selectedEmails" value="">
					<div class="box-footer">
						<button type="submit" name="submit" onclick="onclickSubmitform()" class="btn btn-lg btn-block btn-info"><?= trans("send_email"); ?>&nbsp;&nbsp;<i class="fa fa-send"></i></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
<script>
    $("#check_all_users").click(function () {
        $('.table-users input:checkbox').not(this).prop('checked', this.checked);
    });
    $("#check_all_subscribers").click(function () {
        $('.table-subscribers input:checkbox').not(this).prop('checked', this.checked);
    });
	
	$("#check_all").click(function () {
    // Toggle the "checked" property of all checkboxes in both forms
    $('.table-users input:checkbox, .table-subscribers input:checkbox')
        .prop('checked', this.checked);
});

function onclickSubmitform()
{

    // Collect selected checkboxes from both forms
    const selectedCheckboxes = $('.table-users input:checkbox:checked, .table-subscribers input:checkbox:checked');

    // Collect email values from selected checkboxes
    const selectedEmails = [];
    selectedCheckboxes.each(function () {
        selectedEmails.push($(this).val());
    });

    // Set the selected email values in the hidden field
    $('#selectedEmails').val(selectedEmails.join(','));

    // Now, selectedEmails contains the email values of selected checkboxes
    console.log(selectedEmails);
	
	$('#bothForm').submit();
}

</script>
<style>
    .tableFixHead {
        overflow: auto;
        max-height: 600px !important;
    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
        z-index: 1;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        padding: 8px 16px;
    }

    th {
        background: #fff !important;
    }
</style>
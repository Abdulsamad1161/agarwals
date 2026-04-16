<?php $emailData = unserializeData($emailRow->email_data); ?>
<?= view('email/_header', ['title' => esc($subject)]); ?>
<table role="presentation" class="main">
    <tr>
        <td class="wrapper">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <h1 style="text-decoration: none; font-size: 24px;line-height: 28px;font-weight: bold"><?= esc($subject); ?></h1>
                        <div class="mailcontent" style="line-height: 26px;font-size: 14px;">
							<?php for ($i = 1; $i <= 20; $i++) { ?>
								<?php $key = 'content_' . $i; ?>
								<?php if (!empty($emailData[$key])) { ?>
									<p style='text-align: center'>
										<?= !empty($emailData[$key]) ? $emailData[$key] : ''; ?><br>
									</p>
								<?php } ?>	
							<?php } ?>

                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?= view('email/_footer'); ?>

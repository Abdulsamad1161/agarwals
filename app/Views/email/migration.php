<?php $emailData = unserializeData($emailRow->email_data); ?>
<?= view('email/_header', ['title' => esc($subject)]); ?>
<table role="presentation" class="main">
    <tr>
        <td class="wrapper">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <h1 style="text-decoration: none; font-size: 24px;line-height: 28px;font-weight: bold">ABC Membership Renewal</h1>
                        <div class="mailcontent" style="line-height: 26px;font-size: 14px;">
                            <p style='text-align: justify;'>
                                <?= !empty($emailData['content']) ? $emailData['content'] : ''; ?><br>
                            </p>
							<p style='text-align: center;font-weight:bold; font-size: 18px;'>
                                <?= !empty($emailData['content_1']) ? $emailData['content_1'] : ''; ?><br>
                            </p>
							<p style='text-align: center;font-weight:bold; font-size: 18px;'>
                                <?= !empty($emailData['content_2']) ? $emailData['content_2'] : ''; ?><br>
                            </p>
							<p style='text-align: center;font-weight:bold; font-size: 18px;'>
                                <?= !empty($emailData['content_3']) ? $emailData['content_3'] : ''; ?><br>
                            </p>
							<p style='text-align: center'>
                                <?= !empty($emailData['content_4']) ? $emailData['content_4'] : ''; ?><br>
                            </p>
                            <p style='text-align: center;margin-top: 30px;'>
                                <a href="<?= !empty($emailData['url']) ? esc($emailData['url']) : ''; ?>" style='font-size: 14px;text-decoration: none;padding: 14px 40px;background-color: <?= $generalSettings->site_color; ?>;color: #ffffff !important; border-radius: 3px;'>
                                    <?= !empty($emailData['buttonText']) ? esc($emailData['buttonText']) : ''; ?>
                                </a>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?= view('email/_footer'); ?>

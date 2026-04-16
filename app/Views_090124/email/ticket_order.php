<?php $emailData = unserializeData($emailRow->email_data); ?>
<?= view('email/_header', ['title' => esc($subject)]); ?>
<table role="presentation" class="main">
    <tr>
        <td class="wrapper">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <div style="background-color:#fff;padding:20px;text-align:center;border:10px double #d1274b;">
                            <h1 style="font-size:24px;line-height:28px;font-weight:bold;color:#fff;background: #d1274b;border-radius: 15px;padding: 8px;"><?= esc($subject); ?></h1>
                            <div class="mailcontent" style="line-height: 26px;font-weight:bold; font-size: 17px;">
                                
                                <div style="background-color:#1e90ff;padding:10px;margin:10px 0;border-radius:60px 0 60px 0;color: white;">
                                    <?= !empty($emailData['content']) ? $emailData['content'] : ''; ?>
                                </div>
                                
                                <div style="background-color:#1e90ff;padding:10px;margin:10px 0;border-radius:60px 0 60px 0;color: white;">
                                    <?= !empty($emailData['content_1']) ? $emailData['content_1'] : ''; ?>
                                </div>
                                
                                <div style="background-color:#1e90ff;padding:10px;margin:10px 0;border-radius:60px 0 60px 0;color: white;">
                                    <?= !empty($emailData['content_2']) ? $emailData['content_2'] : ''; ?>
                                </div>
                                
                                <div style="background-color:#1e90ff;padding:10px;margin:10px 0;border-radius:60px 0 60px 0;color: white;">
                                    <?= !empty($emailData['content_3']) ? $emailData['content_3'] : ''; ?>
                                </div>
                                
                                <div style="background-color:#1e90ff;padding:10px;margin:10px 0;border-radius:60px 0 60px 0;color: white;">
                                    <?= !empty($emailData['content_4']) ? $emailData['content_4'] : ''; ?>
                                </div>
                                
                                <div style="background-color:#1e90ff;padding:10px;margin:10px 0;border-radius:60px 0 60px 0;color: white;">
                                    <?= !empty($emailData['content_5']) ? $emailData['content_5'] : ''; ?>
                                </div>
                                
								<div style="background-color:#1e90ff;padding:10px;margin:10px 0;color: white;border-radius: 20px;">
                                    <?= !empty($emailData['content_6']) ? $emailData['content_6'] : ''; ?>
                                </div>
								
								<div style="text-align :center;padding:10px;margin:10px;background-color:white;">
                                    <img src = "<?= base_url().'/assets/media/qrcode/'.$emailData['content_8'].'.png' ?>" alt ="QR Image">
                                </div>
                                
                                <div style="background-color:#1e90ff;padding:10px;margin:10px 0;color: white;border-radius: 20px;">
                                    <?= !empty($emailData['content_9']) ? $emailData['content_9'] : ''; ?>
                                </div>
								
								<div style="background-color:#1e90ff;padding:10px;margin:10px 0;color: white;border-radius: 20px;">
                                    <?= !empty($emailData['content_7']) ? $emailData['content_7'] : ''; ?>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<?= view('email/_footer'); ?>

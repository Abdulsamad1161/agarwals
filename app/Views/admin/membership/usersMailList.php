<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= trans("users"); ?> Mail List</h3>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr role="row">
                            <th width="20"><?= trans("id"); ?></th>
                            <th><?= trans("user"); ?></th>
                            <th><?= trans("shop_description"); ?></th>
                            <th><?= trans("required_files"); ?></th>
                            <th><?= trans("membership_plan"); ?></th>
                            <th><?= trans("payment"); ?></th>
                            <th class="max-width-120"><?= trans("options"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $membershipModel = new \App\Models\MembershipModel();
                        if (!empty($users)):
                            foreach ($users as $user):
                                $membershipPlan = $membershipModel->getUserPlanByUserId($user->id, false); ?>
                                <tr>
                                    <td><?= esc($user->id); ?></td>
                                    <td>
                                        <div class="tbl-table">
                                            <div class="left">
                                                <a href="<?= generateProfileUrl($user->slug); ?>" target="_blank" class="table-link">
                                                    <img src="<?= getUserAvatar($user); ?>" alt="user" class="img-responsive">
                                                </a>
                                            </div>
                                            <div class="right">
                                                <div class="m-b-5">
                                                    <a href="<?= generateProfileUrl($user->slug); ?>" target="_blank" class="table-link"><?= esc(getUsername($user)); ?></a>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalDetails<?= $user->id; ?>"><?= trans("see_details"); ?></button>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="min-width: 300px !important;"><?= esc($user->about_me); ?></td>
                                    <td>
                                        <?php $files = unserializeData($user->vendor_documents);
                                        if (!empty($files)):?>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="ticket-attachments">
                                                        <?php foreach ($files as $file):
                                                            $fileName = '';
                                                            if (!empty($file['path'])) {
                                                                $fileName = str_replace('uploads/support/', '', $file['path']);
                                                            } ?>
                                                            <form action="<?= base_url('SupportController/downloadAttachmentPost'); ?>" method="post">
                                                                <?= csrf_field(); ?>
                                                                <input type="hidden" name="orj_name" value="<?= $file['name']; ?>">
                                                                <input type="hidden" name="name" value="<?= $fileName; ?>">
                                                                <p class="font-600 text-info">
                                                                    <button type="submit" class="button-link"><i class="fa fa-file"></i>&nbsp;&nbsp;<span><?= esc($file['name']); ?></span></button>
                                                                </p>
                                                            </form>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= !empty($membershipPlan) ? $membershipPlan->plan_title : ''; ?></td>
                                    <td><?php if (!empty($membershipPlan)):
                                            echo getPaymentMethod($membershipPlan->payment_method) . "<br>";
                                            if ($membershipPlan->payment_status == "awaiting_payment"):?>
                                                <label class="label label-danger"><?= trans("awaiting_payment"); ?></label>
                                            <?php elseif ($membershipPlan->payment_status == "payment_received"): ?>
                                                <label class="label label-success"><?= trans("payment_received"); ?></label>
                                            <?php endif;
                                        endif; ?>
                                    </td>
                                    <td>
                                        <form action="<?= base_url('MembershipController/approveShopOpeningRequest'); ?>" method="post">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="id" value="<?= $user->id; ?>">
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <li>
                                                        <button type="submit" name="submit" value="1" class="btn-list-button"><i class="fa fa-check option-icon"></i><?= trans('approve'); ?></button>
                                                    </li>
                                                    <li>
                                                        <button type="submit" name="submit" value="0" class="btn-list-button"><i class="fa fa-times option-icon"></i><?= trans('decline'); ?></button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                    <?php if (empty($users)): ?>
                        <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="pull-right">
                    <?= view('partials/_pagination'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
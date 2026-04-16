<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('list_of_rsvp_forms'); ?></h3>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped data_table" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= trans('id'); ?></th>
                                    <th><?= trans('form_title'); ?></th>
                                    <th><?= trans('name'); ?></th>
                                    <th><?= trans('email'); ?></th>
                                    <th><?= trans('phone'); ?></th>
                                    <th><?= trans('amount'); ?></th>
                                    <th><?= trans('transaction_id'); ?></th>
                                    <th><?= trans('payment_status'); ?></th>
                                    <th><?= trans('date'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($formPayments)):
									$i = 1;
                                    foreach ($formPayments as $item): ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= esc($item->form_title); ?></td>
                                            <td><?= esc($item->username); ?></td>
                                            <td><?= esc($item->email); ?></td>
                                            <td><?= esc($item->phone_number); ?></td>
                                            <td style="text-align : right;"><?= $defaultCurrency->symbol; ?><?= esc($item->payment_amount); ?></td>
                                            <td><?= esc($item->transaction_id); ?></td>
                                            <td><?= esc($item->payment_status); ?></td>
                                            <td><?= esc($item->payment_date); ?></td>
                                        </tr>
                                    <?php
									$i++;
									endforeach;
                                endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
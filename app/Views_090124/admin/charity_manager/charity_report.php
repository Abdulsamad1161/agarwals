<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('charity_report'); ?></h3>
                </div>
				
				<div class="right">
                    <a href="<?= adminUrl('charity-manager'); ?>" class="btn btn-danger btn-add-new">
                        <i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;<?= trans('back'); ?>
                    </a>
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
                                    <th><?= trans('name'); ?></th>
                                    <th><?= trans('email'); ?></th>
                                    <th><?= trans('phone'); ?></th>
                                    <th><?= trans('amount'); ?></th>
                                    <th><?= trans('note'); ?></th>
                                    <th><?= trans('date'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($charityList)):
									$i = 1;
                                    foreach ($charityList as $item): ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= esc($item->name); ?></td>
                                            <td><?= esc($item->email); ?></td>
                                            <td><?= esc($item->phone); ?></td>
                                            <td style="text-align : right;"><?= $defaultCurrency->symbol; ?><?= esc($item->amount); ?></td>
                                            <td><?= esc($item->note); ?></td>
                                            <td><?= esc($item->submited_on); ?></td>
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
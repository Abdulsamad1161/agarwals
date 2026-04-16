<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title">Pages Content</h3>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <thead>
                        <tr role="row">
                            <th width="20"><?= trans('id'); ?></th>
                            <th><?= trans('title'); ?></th>
                            <th><?= trans('location'); ?></th>
                            <th class="th-options"><?= trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($pages)):
                            foreach ($pages as $item): ?>
                                <tr>
                                    <td><?= esc($item->id); ?></td>
                                    <td><?= esc($item->title); ?></td>
                                    <td>
                                        <?= esc($item->location)?>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <li><a href="<?= adminUrl('edit-page-content/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= trans("users"); ?></h3>
        </div>
        <div class="right">
            <?php /* <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalSendEmail">
      <i class="fa fa-envelope"></i>&nbsp;Send Email
  </button>*/ ?>
            <?php /* <a href="<?= adminUrl('add-user'); ?>" class="btn btn-success btn-add-new">
      <i class="fa fa-plus"></i>&nbsp;&nbsp;<?= trans('add_user'); ?>
  </a> */ ?>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <div class="row table-filter-container">
                        <div class="col-sm-12">
                            <form action="<?= adminUrl('users'); ?>" method="get" id='filterForm'>
                                <div class="item-table-filter">
                                    <label><?= trans("email_status"); ?></label>
                                    <select name="email_status" class="form-control">
                                        <option value=""><?= trans("all"); ?></option>
                                        <option value="confirmed" <?= inputGet('email_status') == 'confirmed' ? 'selected' : ''; ?>><?= trans("confirmed"); ?></option>
                                        <option value="unconfirmed" <?= inputGet('email_status') == 'unconfirmed' ? 'selected' : ''; ?>><?= trans("unconfirmed"); ?></option>
                                    </select>
                                </div>
                                <div class="item-table-filter item-table-filter-long">
                                    <label style="display: block">&nbsp;</label>
                                    <input name="isMember" class="filter-checkbox" type="checkbox" value="1"
                                        <?= (esc(inputGet('isMember')) == 1) ? 'checked' : ''; ?>> Members
                                </div>
                                <div class="item-table-filter item-table-filter-long">
                                    <label style="display: block">&nbsp;</label>
                                    <input name="isMigration" class="filter-checkbox" type="checkbox" value="1"
                                        <?= (esc(inputGet('isMigration')) == 1) ? 'checked' : ''; ?>> Migration
                                </div>
                                <script>
                                    // JavaScript code to allow only one checkbox with the same class to be checked at a time
                                    document.querySelectorAll('.filter-checkbox').forEach(function (checkbox) {
                                        checkbox.addEventListener('change', function () {
                                            if (this.checked) {
                                                document.querySelectorAll('.filter-checkbox').forEach(function (otherCheckbox) {
                                                    if (otherCheckbox !== checkbox) {
                                                        otherCheckbox.checked = false;
                                                    }
                                                });
                                            }
                                        });
                                    });
                                </script>
                                <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                    <label style="display: block">&nbsp;</label>
                                    <button type="submit" class="btn bg-purple"><?= trans("filter"); ?> </button>
                                </div>
                            </form>
                            <form id="deleteForm" method="post"
                                action="<?= base_url('MembershipController/deleteSelectedUsers'); ?>">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="user_ids" id="user_ids">
                                <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                    <label style="display: block">&nbsp;</label>
                                    <button type="button" class="btn btn-danger" id="delete_selected">Delete</button>
                                </div>
                            </form>
                            <div class="item-table-filter md-top-10" style="width: 110px; min-width: 110px;">
                                <label style="display: block">&nbsp;</label>
                                <button type="button" class="btn btn-success" id="email_selected"><i
                                        class="fa fa-envelope"></i>&nbsp;Send Renewal Email</button>
                            </div>
                        </div>
                    </div>
                    <table class="mt-4 table table-bordered table-striped cs_datatable_lang" id="exampleDatausers"
                        role="grid" aria-describedby="example5_info">
                        <thead>
                            <tr role="row">
                                <th><input type="checkbox" id="select_all"></th>
                                <th>ABC <?= trans("id"); ?></th>
                                <th><?= trans("user"); ?></th>
                                <th><?= trans("email"); ?></th>
                                <th>Phone Number</th>
                                <th>Business <?= trans("membership_plan"); ?></th>
                                <th><?= trans("membership_plan"); ?></th>
                                <th>Plan Start Date</th>
                                <th>Plan End Date</th>
                                <th>PLan Active Status</th>
                                <th>Member Age</th>
                                <th>First Plan Start Date</th>
                                <th class="max-width-120"><?= trans("options"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $membershipModel = new \App\Models\MembershipModel();
                            if (!empty($users)):
                                foreach ($users as $user):
                                    $membershipPlan = $membershipModel->getUserPlanByUserId($user->id, true);
                                    $membershipPlanUsers = $membershipModel->getUserPlanByUserIdUsers($user->id, true);
                                    $membershipPlanUsersAge = $membershipModel->getUserPlanByUserIdUsersAge($user->id, true);
                                    $userRole = getRoleById($user->role_id);
                                    $roleColor = 'bg-gray';
                                    if (!empty($userRole)) {
                                        if ($userRole->is_super_admin) {
                                            $roleColor = 'bg-maroon';
                                        } elseif ($userRole->is_admin) {
                                            $roleColor = 'bg-info';
                                        } elseif ($userRole->is_vendor) {
                                            $roleColor = 'bg-purple';
                                        }
                                    }

                                    $rowBackgroundColor = empty($membershipPlanUsers) ? '#BDF8A3' : '';
                                    if (!empty($userRole)) {
                                        if ($userRole->is_super_admin) {
                                            $rowBackgroundColor = '';
                                        }
                                    }
                                    ?>
                                    <tr style="background-color: <?= $rowBackgroundColor; ?>">
                                        <td><input type="checkbox" class="select_user" value="<?= esc($user->id); ?>"></td>
                                        <td><?= esc($user->id); ?></td>
                                        <td>
                                            <div class="tbl-table">
                                                <div class="left">
                                                    <a href="<?= generateProfileUrl($user->slug); ?>" target="_blank"
                                                        class="table-link">
                                                        <img src="<?= getUserAvatar($user); ?>" alt="user"
                                                            class="img-responsive">
                                                    </a>
                                                </div>
                                                <div class="right">
                                                    <div class="m-b-5">
                                                        <a href="<?= generateProfileUrl($user->slug); ?>" target="_blank"
                                                            class="table-link">
                                                            <?= esc($user->first_name) . ' ' . esc($user->last_name); ?>&nbsp;<?= !empty($user->username) ? '(' . $user->username . ')' : ''; ?>
                                                        </a>
                                                    </div>
                                                    <label class="label <?= $roleColor; ?>">
                                                        <?php $roleName = @parseSerializedNameArray($userRole->role_name, selectedLangId(), true);
                                                        if (!empty($roleName)): ?>
                                                            <?= esc($roleName); ?>
                                                        <?php endif; ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?= esc($user->email);
                                            if ($user->email_status == 1): ?>
                                                <small class="text-success">(<?= trans("confirmed"); ?>)</small>
                                            <?php else: ?>
                                                <small class="text-danger">(<?= trans("unconfirmed"); ?>)</small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= esc($user->phone_number); ?>
                                        </td>
                                        <td><?= !empty($membershipPlan) ? esc($membershipPlan->plan_title) : ''; ?></td>
                                        <td><?= !empty($membershipPlanUsers) ? esc($membershipPlanUsers->plan_title) . ' ' . esc($membershipPlanUsers->number_of_days) : ''; ?>
                                        </td>
                                        <td><?= !empty($membershipPlanUsers) ? date('d-m-y', strtotime(esc($membershipPlanUsers->plan_start_date))) : ''; ?>
                                        </td>
                                        <td><?= !empty($membershipPlanUsers) ? date('d-m-y', strtotime(esc($membershipPlanUsers->plan_end_date))) : ''; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($membershipPlanUsers) && strtotime($membershipPlanUsers->plan_end_date) > strtotime(date('Y-m-d'))): ?>
                                                <label class="label label-success">Plan active</label>
                                            <?php else:
                                                if (!empty($membershipPlanUsers)) { ?>
                                                    <label class="label label-danger">Plan inactive</label>
                                                <?php }endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($membershipPlanUsersAge)):
                                                $startDate = new DateTime($membershipPlanUsersAge->plan_start_date);
                                                $today = new DateTime();

                                                $diff = $startDate->diff($today);

                                                $membershipPlanUsersAgeData =
                                                    $diff->y . ' years ' . $diff->d . ' days';
                                                ?>
                                                <label class="label label-info">
                                                    <?= esc($membershipPlanUsersAgeData); ?>
                                                </label>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= !empty($membershipPlanUsersAge) ? date('d-m-y', strtotime(esc($membershipPlanUsersAge->plan_start_date))) : ''; ?>
                                        </td>
                                        <td>
                                            <?php $showOptions = true;
                                            if ($userRole->is_super_admin) {
                                                $showOptions = false;
                                                $activeUserRole = getRoleById(user()->role_id);
                                                if (!empty($activeUserRole) && $activeUserRole->is_super_admin) {
                                                    $showOptions = true;
                                                }
                                            }
                                            if ($showOptions): ?>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button"
                                                        data-toggle="dropdown"><?= trans('select_option'); ?><span
                                                            class="caret"></span></button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li>
                                                            <button type="button" class="btn-list-button btn-change-role"
                                                                data-toggle="modal" data-target="#modalRole<?= $user->id; ?>">
                                                                <i
                                                                    class="fa fa-user option-icon"></i><?= trans('change_user_role'); ?>
                                                            </button>
                                                        </li>
                                                        <?php /*
                                                                  <?php if (!empty($membershipPlans) && $userRole->is_vendor): ?>
                                                                      <li>
                                                                          <a href="javascript:void(0)" data-toggle="modal" data-target="#modalAssign<?= $user->id; ?>"><i class="fa fa-check-circle-o option-icon"></i><?= trans('assign_membership_plan'); ?></a>
                                                                      </li>
                                                                  <?php endif; ?> */ ?>
                                                        <li>
                                                            <?php if ($user->email_status != 1): ?>
                                                                <a href="javascript:void(0)"
                                                                    onclick="confirmUserEmail(<?= $user->id; ?>);"><i
                                                                        class="fa fa-check option-icon"></i><?= trans('confirm_user_email'); ?></a>
                                                            <?php endif; ?>
                                                        </li>
                                                        <li>
                                                            <?php if ($user->banned == 0): ?>
                                                                <a href="javascript:void(0)"
                                                                    onclick="banRemoveBanUser(<?= $user->id; ?>);"><i
                                                                        class="fa fa-stop-circle option-icon"></i><?= trans('ban_user'); ?></a>
                                                            <?php else: ?>
                                                                <a href="javascript:void(0)"
                                                                    onclick="banRemoveBanUser(<?= $user->id; ?>);"><i
                                                                        class="fa fa-circle option-icon"></i><?= trans('remove_user_ban'); ?></a>
                                                            <?php endif; ?>
                                                        </li>
                                                        <li>
                                                            <a href="<?= adminUrl('edit-user/' . $user->id); ?>"><i
                                                                    class="fa fa-edit option-icon"></i><?= trans('edit_user'); ?></a>
                                                        </li>
                                                        <li>
                                                            <a href="<?= adminUrl('update-plan-details/' . $user->id); ?>"><i
                                                                    class="fa fa-tasks option-icon"></i>Add Membership Plan</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0)"
                                                                onclick="deleteItem('MembershipController/deleteUserPost','<?= $user->id; ?>','<?= trans("confirm_user", true); ?>');"><i
                                                                    class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
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
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/datatable/dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/datatable/dataTables.buttons.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/datatable/jszip.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/datatable/buttons.html5.min.js'); ?>"></script>

<script>
    $(document).ready(function () {
        var title_export = "ABC-Members_Export";
        $('#exampleDatausers').DataTable(
            {
                "iDisplayLength": 100,//per page data
                "aLengthMenu": [[5, 10, 25, 50, 100, 500, 1000, -1], [5, 10, 25, 50, 100, 500, 1000, "All"]],
                "sScrollX": 'auto',
                scrollY: '100vh',
                "dom":
                    "<'row'<'col-sm-2'l><'col-sm-6'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                buttons:
                    [
                        {
                            extend: 'excel',
                            header: true,
                            title: title_export,
                            "exportOptions": {
                                "columns": ":not(:last-child)" // Exclude the last column
                            }
                        }
                    ],
                initComplete: function () {

                    var btns = $('.dt-button');
                    btns.addClass('btn btn-success btn-sm column_cls');
                    btns.removeClass('dt-button');

                },

            });
    });
</script>
<?php if (!empty($users)):
    foreach ($users as $user): ?>
        <div id="modalAssign<?= $user->id; ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="<?= base_url('MembershipController/assignMembershipPlanPost'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="user_id" value="<?= $user->id; ?>">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><?= trans("assign_membership_plan"); ?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label><?= trans("membership_plan"); ?></label>
                                <?php if (!empty($membershipPlans)): ?>
                                    <select class="form-control" name="plan_id" required>
                                        <option value=""><?= trans("select"); ?></option>
                                        <?php foreach ($membershipPlans as $plan): ?>
                                            <option value="<?= $plan->id; ?>">
                                                <?= getMembershipPlanName($plan->title_array, selectedLangId()); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><?= trans("submit"); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="modalRole<?= $user->id; ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><?= trans('change_user_role'); ?></h4>
                    </div>
                    <form action="<?= base_url('MembershipController/changeUserRolePost'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <input type="hidden" name="user_id" value="<?= $user->id; ?>">
                                    <?php if (!empty($roles)):
                                        foreach ($roles as $item):
                                            $roleName = @parseSerializedNameArray($item->role_name, selectedLangId(), true); ?>
                                            <div class="col-sm-6 m-b-15">
                                                <input type="radio" name="role_id" value="<?= $item->id; ?>" id="role_<?= $item->id; ?>"
                                                    class="square-purple" <?= $user->role_id == $item->id ? 'checked' : ''; ?>
                                                    required>&nbsp;&nbsp;
                                                <label for="role_<?= $item->id; ?>"
                                                    class="option-label cursor-pointer"><?= esc($roleName); ?></label>
                                            </div>
                                        <?php endforeach;
                                    endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><?= trans('save_changes'); ?></button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?= trans('close'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div id="modalSendEmail" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?= trans('change_user_role'); ?></h4>
                </div>
                <form action="<?= base_url('MembershipController/SetSelectedUsers'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="checkbox1">Content</label>
                                <textarea type="text" class="form-control" name="content">Dear ABC Member, we hope this message finds you and your family well! As a valued member of our community, your support has been essential in making our events and initiatives successful. Our record shows that you have not renewed your membership for 2024, we kindly invite you to renew your membership for another year of connection, cultural celebrations, and meaningful contributions.
        By renewing your membership, you’ll continue to enjoy:
            •	Exclusive invites to free event for the members, including the AGM and Maharaja                                                                                      
                                        Agrasen Jayanti
            •	Opportunities to engage in our cultural programs and initiatives
            •	Special discounts on event tickets and family activities
            •	Regular updates on community news and initiatives

        Renewal Process:
        Simply visit membership renewal link: https://www.agarwals.ca/abcmembership
        or contact, our Membership Lead and Treasurer: Mr Siddharth Bagla Tel# 647 832 9096 to renew your membership today.
        If you have any questions or need assistance with the renewal process, please don’t hesitate to reach out to us at: info@agarwals.ca
        We are grateful for your continued support and look forward to another year of building our community together.
        </textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="unconfirmed" id="checkbox2" value="0">
                                <label class="form-check-label" for="checkbox2">Check to Send Email to Unconfirmed Members
                                    List</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Send Email</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?= trans('close'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalSendEmailMembers" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Email Content</h4>
                </div>
                <form action="<?= base_url('MembershipController/SetSelectedUsersEmail'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">Content</label>
                                <textarea id="summernote" class="form-control" name="content" rows="20">Dear ABC Member, we hope this message finds you and your family well! As a valued member of our community, your support has been essential in making our events and initiatives successful. Our record shows that you have not renewed your membership for 2024, we kindly invite you to renew your membership for another year of connection, cultural celebrations, and meaningful contributions.
        By renewing your membership, you’ll continue to enjoy:
            •	Exclusive invites to free event for the members, including the AGM and Maharaja                                                                                      
                                        Agrasen Jayanti
            •	Opportunities to engage in our cultural programs and initiatives
            •	Special discounts on event tickets and family activities
            •	Regular updates on community news and initiatives

        Renewal Process:
        Simply visit membership renewal link: https://www.agarwals.ca/abcmembership
        or contact, our Membership Lead and Treasurer: Mr Siddharth Bagla Tel# 647 832 9096 to renew your membership today.
        If you have any questions or need assistance with the renewal process, please don’t hesitate to reach out to us at: info@agarwals.ca
        We are grateful for your continued support and look forward to another year of building our community together.
        </textarea>
                            </div>
                        </div>

                        <input type="hidden" id="selected_id" name="users_id">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Send Email</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?= trans('close'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
endif; ?>

<script>
    $(document).ready(function () {
        // Select/Deselect all checkboxes
        $('#select_all').on('click', function () {
            $('.select_user').prop('checked', this.checked);
        });

        // Handle delete selected users
        $('#delete_selected').on('click', function () {
            var selected = [];
            $('.select_user:checked').each(function () {
                selected.push($(this).val());
            });

            if (selected.length > 0) {
                swal({
                    title: 'Are you sure?',
                    text: 'Want to delete it? You won\'t be able to revert this!',
                    type: 'danger',
                    showCancelButton: true,
                    confirmButtonColor: 'red',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete them!'
                }).then((willDelete) => {
                    if (willDelete) {
                        $('#user_ids').val(selected.join(',')); // Set the selected user IDs in the hidden input
                        $('#deleteForm').submit(); // Submit the form
                    }
                });
            } else {
                swal({
                    title: 'No users selected!',
                    text: 'Please select at least one user to delete.',
                    type: 'info'
                });
            }
        });


        // Handle email selected users
        $('#email_selected').on('click', function () {
            var selected = [];
            $('.select_user:checked').each(function () {
                selected.push($(this).val());
            });


            if (selected.length > 0) {
                swal({
                    title: 'Are you sure?',
                    text: 'Want to send renewal email to selected users?',
                    type: 'info',
                    showCancelButton: true,
                    confirmButtonColor: 'green',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, send email!'
                }).then((willDelete) => {
                    if (willDelete) {
                        $('#selected_id').val(selected.join(',')); // Set the selected user IDs in the hidden input
                        $('#modalSendEmailMembers').modal('show'); // Open the modal after selected ids are available
                    }
                });
            } else {
                swal({
                    title: 'No users selected!',
                    text: 'Please select at least one user to send Email.',
                    type: 'info'
                });
            }
        });
    });
</script>
<div class="row">
    <div class="col-sm-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title">Add membership Plan</h3>
                </div>
				<div class="right">
					<a href="<?= adminUrl("users"); ?>" class="btn btn-success btn-add-new">
						<i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;Back
					</a>
				</div>
            </div>
            <form action="<?= base_url('MembershipController/addMembershipPlan'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="user_id" value="<?= esc($user->id); ?>">
                <div class="box-body">
                    <?php $role = getRoleById($user->role_id);
                    if (!empty($role)):
                        $roleName = @parseSerializedNameArray($role->role_name, selectedLangId(), true);
                        if (!empty($roleName)):?>
                            <div class="form-group">
                                <label class="label label-success"><?= esc($roleName); ?></label>
                            </div>
                        <?php endif;
                    endif; ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <img src="<?= getUserAvatar($user); ?>" alt="avatar" class="thumbnail img-responsive img-update" style="max-width: 200px;">
                            </div>
                        </div>
                    </div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>ABC-ID</label>
								<input type="text" class="form-control form-input" placeholder="ABC-ID" value="ABC-<?= esc($user->id); ?>" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Name</label>
								<input type="text" class="form-control form-input" placeholder="Name" value="<?= esc($user->username); ?>" readonly>
							</div>
						</div>
                    </div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Email</label>
								<input type="email" class="form-control form-input" name="email" placeholder="Email" value="<?= esc($user->email); ?>" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Phone Number</label>
								<input type="text" class="form-control form-input" placeholder="Phone Number" value="<?= esc($user->phone_number); ?>" readonly>
							</div>
						</div>
                    </div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Select Membership Plan</label> 
								<select class="form-control form-input" name="plan_id" required>
									<option value="" selected>--SELECT--</option>
									<?php foreach ($membershipPlans as $plan): ?>
										<option value="<?php echo $plan->id; ?>">
											<?php echo $plan->title . ' - ' . $plan->number_of_days . ' - $' . getPrice($plan->price, 'input'); ?>
										</option>
									<?php endforeach; ?>
								</select>

							</div>
						</div>
                    </div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Plan Start Date</label>
								<input type="date" name="plan_start_date" class="form-control form-input" value="<?= date('Y-m-d');?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Comment</label> *(<span class="text-danger font-weight-bold">Not More than 50 words</span>)
								<input type="text" name="comment" class="form-control form-input" required>
							</div>
						</div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Add Plan</button>
                </div>
            </form>
        </div>
    </div>
</div>

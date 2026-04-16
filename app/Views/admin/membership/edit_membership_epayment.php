<?php 
if(!empty($tickets))
{	
	$item = $tickets;
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('approve_e_payment'); ?></h3>
                </div>
				
				<div class="right">
                    <a href="<?= adminUrl('transactions-membership-epayment'); ?>" class="btn btn-danger btn-add-new">
                        <i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;<?= trans('back'); ?>
                    </a>
                </div>
            </div>
			<form action="<?= base_url('MembershipController/editApproveBuisnessEpayment'); ?>" method="post">
                <?= csrf_field(); ?>
			<div class="box-body">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-12">
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" name="name" placeholder="<?= trans("form_name"); ?>" value="<?= $item->username; ?>" required readonly>
						</div>
					</div>
					
					<div class="col-lg-6 col-md-6 col-sm-12">
						<div class="form-group">
							<label>Phone Number</label>
							<input type="text" class="form-control" name="phone" placeholder="<?= trans("phone_number"); ?>" value="<?= $item->phone_number; ?>" required readonly>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-12">
						<div class="form-group">
							<label>Plan Title</label>
							<input type="text" class="form-control" name="plan_title" value="<?= $item->plan_title; ?>" required readonly>
						</div>
					</div>
					
					<div class="col-lg-6 col-md-6 col-sm-12">
						<div class="form-group">
							<label>Plan Duration</label>
							<input type="text" class="form-control" name="number_of_days" value="<?= $item->number_of_days; ?>" required readonly>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-12">
						<label>Total Price</label>
						<div class="form-group form-group-price">
							<div class="input-group" >
								<span class="input-group-addon"><?= $defaultCurrency->symbol; ?></span>
								<input type="text" name="eventTotalPrice" class="form-control form-input price-input" value="<?= getPrice($item->price, 'decimal'); ?>" required readonly>
							</div>
						</div>
					</div>
					
					<div class="col-lg-6 col-md-6 col-sm-12">
						<div class="form-group">
							<label>Date</label>
							<input type="text" class="form-control" name="totalSeats" value="<?= $item->plan_start_date; ?>" required readonly>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-12">
						<div class="form-group">
							<label>Payment Method</label>
							<input type="text" class="form-control" name="paymentMethod" value="E-Payment"required>
						</div>
					</div>
					
					<div class="col-lg-6 col-md-6 col-sm-12">
						<div class="form-group">
							<label>Payment Status</label>
							<input type="text" class="form-control" name="paymentStatus" value="COMPLETED" required>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-12">
						<div class="form-group">
							<label>Transaction ID</label>
							<input type="text" class="form-control" name="transId" placeholder="<?= trans("transaction_id"); ?>" value="" required>
						</div>
					</div>
					
					<div class="col-lg-6 col-md-6 col-sm-12">
						<div class="form-group">
							<label>Total Amount Received</label>
							<div class="form-group form-group-price">
								<div class="input-group" >
									<span class="input-group-addon"><?= $defaultCurrency->symbol; ?></span>
									<input type="text" name="totalRec" class="form-control form-input price-input" required>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<input type="hidden" name = "user_id" value="<?= $item->user_id;?>">
			<input type="hidden" name = "random_ref_no" value="<?= $item->random_ref_no;?>">
			<input type="hidden" name = "plan_id" value="<?= $item->plan_id;?>">
			<div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?= trans('approve'); ?></button>
            </div>
			</form>
		</div>
	</div>
</div>
<?php 
if(!empty($tickets))
{
	$resultArray = [];

	foreach ($tickets as $booking) 
	{
		$seatsArray = json_decode($booking->reference_seats_original);

		$key = $booking->booking_member_id . '-' . $booking->random_ref_no. '-' . $booking->eventTotalPrice . '-' . $booking->event_total_tickets . '-' . implode(',', $seatsArray);

		if (!array_key_exists($key, $resultArray)) 
		{
			$resultArray[$key] = $booking;
		}
	}

	$resultArray = array_values($resultArray);
} 
//echo "<pre>";print_r($resultArray);

$item = $resultArray[0];
?>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('approve_e_payment'); ?></h3>
                </div>
				
				<div class="right">
                    <a href="<?= adminUrl('report-tickets-ePayment/' . $item->event_id); ?>" class="btn btn-danger btn-add-new">
                        <i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;<?= trans('back'); ?>
                    </a>
                </div>
            </div>
			<form action="<?= base_url('TicketController/editApproveEpayment'); ?>" method="post">
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
						<label>Total Ticket Price</label>
						<div class="form-group form-group-price">
							<div class="input-group" >
								<span class="input-group-addon"><?= $defaultCurrency->symbol; ?></span>
								<input type="text" name="eventTotalPrice" class="form-control form-input price-input" value="<?= $item->eventTotalPrice;?>" required readonly>
							</div>
						</div>
					</div>
					
					<div class="col-lg-6 col-md-6 col-sm-12">
						<div class="form-group">
							<label>Total Seats</label>
							<input type="text" class="form-control" name="totalSeats" value="<?= $item->event_total_tickets; ?>" required readonly>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="form-group">
							<label>Table Numbers</label>
							<textarea type="text" class="form-control" name="tableNumbers" required readonly><?= $item->reference_seats; ?></textarea>
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
			
			<input type="hidden" name = "event_id" value="<?= $item->event_id;?>">
			<input type="hidden" name = "member_id" value="<?= $item->member_id;?>">
			<input type="hidden" name = "random_ref_no" value="<?= $item->random_ref_no;?>">
			<input type="hidden" name = "eventTotalwithoutDiscountPrice" value="<?= $item->eventTotalwithoutDiscountPrice;?>">
			<input type="hidden" name = "eventTotalDiscountPrice" value="<?= $item->eventTotalDiscountPrice;?>">
			<input type="hidden" name = "eventTotalDiscountPercenatge" value="<?= $item->eventTotalDiscountPercenatge;?>">
			<textarea name = "reference_seats_original" hidden><?= $item->reference_seats_original;?></textarea>
			<div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?= trans('approve'); ?></button>
            </div>
			</form>
		</div>
	</div>
</div>
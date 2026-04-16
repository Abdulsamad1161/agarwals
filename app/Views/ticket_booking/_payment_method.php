<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
				<div class="row">
					<div class="col-10">
						<div class="timer-container">
							<span class="remaining-text">Remaining Time - </span>
							<span class="timer-text" id="timer"></span>
						</div>
					</div>
					<div class="col-2" style="text-align : center;">
						<button class="btn btn-sm btn-danger" id="ticket_booking_back"><i class="fa fa-angle-double-left"></i>&nbsp;<?= trans('back'); ?></button>
					</div>
				</div>
                <div class="shopping-cart shopping-cart-shipping">
                    <div class="row">
                        <div class="col-sm-12 col-lg-8">
                            <div class="left">
                                <h1 class="cart-section-title"><?= trans("checkout"); ?></h1>
                                <?php if (!authCheck()): ?>
                                    <div class="row m-b-15">
                                        <div class="col-12 col-md-6">
                                            <p><?= trans("checking_out_as_guest"); ?></p>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <p class="text-right"><?= trans("have_account"); ?>&nbsp;<a href="javascript:void(0)" class="link-underlined" data-toggle="modal" data-target="#loginModal"><?= trans("login"); ?></a></p>
                                        </div>
                                    </div>
                                <?php endif;
                                if (!empty($cartHasPhysicalProduct) && $productSettings->marketplace_shipping == 1 && $mdsPaymentType == 'sale'): ?>
                                    <div class="tab-checkout tab-checkout-closed">
                                        <a href="<?= generateUrl('cart', 'shipping'); ?>"><h2 class="title">1.&nbsp;&nbsp;<?= trans("shipping_information"); ?></h2></a>
                                        <a href="<?= generateUrl('cart', 'shipping'); ?>" class="link-underlined edit-link"><?= trans("edit"); ?></a>
                                    </div>
                                <?php endif; ?>
                                <div class="tab-checkout tab-checkout-open">
                                    <h2 class="title">
                                        <?php if (!empty($cartHasPhysicalProduct) && $productSettings->marketplace_shipping == 1 && $mdsPaymentType == 'sale') {
                                            echo '2.';
                                        } else {
                                            echo '1.';
                                        } ?>
                                        &nbsp;<?= trans("payment_method"); ?></h2>
                                    <form action="<?= base_url('TicketBookingController/paymentMethodTicketPost'); ?>" method="post" id="validate-form" class="validate_terms">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="mds_payment_type" value="<?= $mdsPaymentType ?>">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <ul class="payment-options-list">
                                                        <?php $gateways = getActivePaymentGateways();
                                                        $i = 0;
                                                        if (!empty($gateways)): 
                                                            foreach ($gateways as $gateway):
															if ($gateway->name_key == 'epayment' && $is_epayment == 0) {
																continue; 
															}
															
															if ($gateway->name_key == 'paypal' && $is_paypal == 0) {
																continue; 
															}
															?>
                                                                <li>
                                                                    <div class="option-payment">
                                                                        <div class="list-left">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" class="custom-control-input" id="option_<?= $gateway->id; ?>" name="payment_option" value="<?= esc($gateway->name_key); ?>" required <?= $i == 0 ? 'checked' : ''; ?>>
                                                                                <label class="custom-control-label label-payment-option" for="option_<?= $gateway->id; ?>"><?= esc($gateway->name); ?></label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="list-right">
                                                                            <?php if($gateway->name_key == "epayment") {?>
                                                                            <label class="epayment" for="option_<?= $gateway->id; ?>">
                                                                                <?php echo $gateway->logos;
                                                                                 ?>
                                                                            </label>
																			<?php }
																				else
																				{	?>
																				<label for="option_<?= $gateway->id; ?>">
                                                                                <?php $logos = @explode(',', $gateway->logos);
                                                                                if (!empty($logos) && countItems($logos) > 0):
                                                                                    foreach ($logos as $logo): ?>
                                                                                        <img src="<?= base_url('assets/img/payment/' . esc(trim($logo ?? '')) . '.svg'); ?>" alt="<?= esc(trim($logo ?? '')); ?>">
                                                                                    <?php endforeach;
                                                                                endif; ?>
																				</label>
																			<?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <?php $i++;
                                                            endforeach;
                                                        endif;
                                                        if ($paymentSettings->bank_transfer_enabled): ?>
                                                            <li>
                                                                <div class="option-payment">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" id="option_bank" name="payment_option" value="bank_transfer" required <?= $i == 0 ? 'checked' : ''; ?>>
                                                                        <label class="custom-control-label label-payment-option" for="option_bank"><?= trans("bank_transfer"); ?><br><small><?= trans("bank_transfer_exp"); ?></small></label>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        <?php endif;
                                                        if (authCheck() && $paymentSettings->cash_on_delivery_enabled && empty($cartHasDigitalProduct) && $mdsPaymentType == 'sale' && $vendorCashOnDelivery == 1): ?>
                                                            <li>
                                                                <div class="option-payment">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" id="option_cash_on_delivery" name="payment_option" value="cash_on_delivery" required>
                                                                        <label class="custom-control-label label-payment-option" for="option_cash_on_delivery"><?= trans("cash_on_delivery"); ?><br><small><?= trans("cash_on_delivery_exp"); ?></small></label>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox custom-control-validate-input">
                                                        <input type="checkbox" class="custom-control-input" name="terms" id="checkbox_terms" required>
                                                        <label for="checkbox_terms" class="custom-control-label"><?= trans("terms_conditions_exp"); ?>&nbsp;
                                                            <?php $pageTerms = getPageByDefaultName('terms_conditions', selectedLangId());
                                                            if (!empty($pageTerms)): ?>
                                                                <a href="<?= generateUrl($pageTerms->page_default_name); ?>" class="link-terms" target="_blank"><strong><?= esc($pageTerms->title); ?></strong></a>
                                                            <?php endif; ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group m-t-15">
                                                    <button type="submit" name="submit" value="update" class="btn btn-lg btn-custom btn-continue-payment float-right" id="continue-payment"><?= trans("continue_to_payment") ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-checkout tab-checkout-closed-bordered">
                                    <h2 class="title">
                                        <?php if (!empty($cartHasPhysicalProduct) && $productSettings->marketplace_shipping == 1 && $mdsPaymentType == 'sale') {
                                            echo '3.';
                                        } else {
                                            echo '2.';
                                        } ?>
                                        &nbsp;<?= trans("payment"); ?>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <?php if ($mdsPaymentType == 'ticketBooking'):
                            echo view('ticket_booking/_order_summary');
                        elseif ($mdsPaymentType == 'promote'):
                            echo view('cart/_order_summary_promote');
                        else:
                            echo view('ticket_booking/_order_summary');
                        endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timer-container {
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: Arial, sans-serif;
}

.remaining-text {
    font-size: 1.5rem;
    font-weight: bold;
    color: #d1274b;
    margin-right: 10px;
}

.timer-text {
    font-size: 1.8rem;
    font-weight: bold;
    color: #333;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}

.epayment
{
	border: 2px solid #d1274b;
	padding: 10px;
}
</style>
<script>
window.onload = function() 
{
	var start_time = "<?php echo time() ?>"; 
	var left_time = "<?php echo $this->session->end_time_booking; ?>"; 
	console.log(left_time);
	leftTicketSessionTiming(start_time,left_time);
};
</script>

<script>
	var radio = document.getElementById("option_9");

	radio.addEventListener("click", function() {
		swal({
		  title: "E-payment Instructions",
		  text: "You can complete your e-payment by using the provided email address (abcpayment20@gmail.com). Your tickets purchase will be confirmed on receipt of e-transfer payment. Thank you!",
		  buttons: [
			'back',
			'ok'
		  ],
		  dangerMode: true,
		}).then(function(isConfirm) {
			if (isConfirm) 
			{
				var data = {
					'data_method': 'E-payment'
				};

				$.ajax({
					type: 'POST',
					url: MdsConfig.baseURL + '/TicketBookingController/epaymentMethodBooking',	
					data: setAjaxData(data),
					 dataType: 'json',
					 success: function (response) {
						var data = JSON.stringify(response);
						var parsedData = JSON.parse(data); 

						if (parsedData.result === 1) 
						{
							window.location.href = "<?= adminUrl('ticket-booking'); ?>"
						}
						else
						{
							swal({
							  title: "Error occured",
							  text: "Contact Admin to check your booking status",
							  buttons: [
								'cancel',
								'ok'
							  ],
							  dangerMode: true,
							}).then(function(isConfirm) {
								if (isConfirm) 
								{
									window.location.href = "<?= adminUrl('ticket-booking'); ?>"
								}
								else
								{
									window.location.href = "<?= adminUrl('ticket-booking'); ?>"
								}
							});
						}
					}
				});

				function setAjaxData(object = null) 
				{
					var data = {
						'sysLangId': MdsConfig.sysLangId,
					};
					data[MdsConfig.csrfTokenName] = $('meta[name="X-CSRF-TOKEN"]').attr('content');
					if (object != null) {
						Object.assign(data, object);
					}
					return data;
				}
		  } 
		});
	});
</script>

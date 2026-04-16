<?php  $this->session = \Config\Services::session();?>
<div class="col-sm-12 col-lg-4 order-summary-container">
    <h2 class="cart-section-title"><?= trans("payment_summary"); ?></h2>
    <div class="right">
        <?php if (!empty($charityForm)): ?>
            <div class="cart-order-details">
                <div class="item">
                    <div class="item-right">
                        <div class="list-item m-t-15">
                            <label><?= trans("charity_name"); ?>:</label>
                            <strong class="lbl-price"><?= $charityForm->charityName; ?></strong>
                        </div>
                        <div class="list-item">
                            <label><?= trans("price"); ?>:</label>
                            <strong class="lbl-price"><?= $defaultCurrency->symbol.''.$this->session->charityAmount; ?></strong>
                        </div>
                    </div>
                </div>
            </div>
			<div class="row-custom">
                <strong><?= trans("subtotal"); ?><span class="float-right"><?= $defaultCurrency->symbol.''.$this->session->charitySubAmount; ?></span></strong>
            </div>
			<div class="row-custom">
				<?php $fees = $this->session->charityPaypalAmount; ?>
                <strong>Paypal Charges<span class="float-right"><?= $defaultCurrency->symbol.''.number_format((float)$fees, 2, '.', ''); ?></span></strong>
            </div>
            <div class="row-custom">
                <p class="line-seperator"></p>
            </div>
            <div class="row-custom">
                <strong><?= trans("total"); ?><span class="float-right"><?= $defaultCurrency->symbol.''.$this->session->charityAmount; ?></span></strong>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php  $this->session = \Config\Services::session();?>
<div class="col-sm-12 col-lg-4 order-summary-container">
    <h2 class="cart-section-title"><?= trans("payment_summary"); ?></h2>
    <div class="right">
        <?php if (!empty($rsvpForm)): ?>
            <div class="cart-order-details">
                <div class="item">
                    <div class="item-right">
                        <div class="list-item m-t-15">
                            <label><?= trans("form_name"); ?>:</label>
                            <strong class="lbl-price"><?= $rsvpForm->form_name; ?></strong>
                        </div>
                        <div class="list-item">
                            <label><?= trans("price"); ?>:</label>
                            <strong class="lbl-price"><?= $defaultCurrency->symbol.''.$this->session->rsvpAmount; ?></strong>
                        </div>
                    </div>
                </div>
            </div>
			<?php if(isset($this->session->label18))
			{ ?>
				<div class="row-custom">
					<strong><?= $this->session->label18; ?><span class="float-right"><?= $this->session->quantitytext18; ?></span></strong>
				</div>
			<?php } ?>
			
			<?php if(isset($this->session->label19))
			{ ?>
				<div class="row-custom">
					<strong><?= $this->session->label19; ?><span class="float-right"><?= $this->session->quantitytext19; ?></span></strong>
				</div>
			<?php } ?>
			
			<?php if(isset($this->session->label20))
			{ ?>
				<div class="row-custom">
					<strong><?= $this->session->label20; ?><span class="float-right"><?= $this->session->quantitytext20; ?></span></strong>
				</div>
			<?php } ?>
            <div class="row-custom">
                <p class="line-seperator"></p>
            </div>
			
            <div class="row-custom">
                <strong><?= trans("total"); ?><span class="float-right"><?= $defaultCurrency->symbol.''.$this->session->rsvpAmount; ?></span></strong>
            </div>
        <?php endif; ?>
    </div>
</div>
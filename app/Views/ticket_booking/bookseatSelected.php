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
                                
								<?php //echo "<pre>";print_r($inputs);echo "</pre>";?>
                                <div class="tab-checkout tab-checkout-closed-bordered">
                                    <h2 class="title">1.&nbsp;&nbsp;<?= trans("payment_method"); ?></h2>
                                </div>
                                <div class="tab-checkout tab-checkout-closed-bordered border-top-0">
                                    <h2 class="title">2.&nbsp;&nbsp;<?= trans("payment"); ?></h2>
                                </div>
                            </div>
                        </div>
                        <?php 
                            echo view('ticket_booking/_order_summary');
                        ?>
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

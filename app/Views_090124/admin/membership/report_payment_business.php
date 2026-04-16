<?php 
if(!empty($tickets_epayment))
{
?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title"><?= trans('e-payment-report'); ?> - Business Membership</h3>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped cs_datatable_lang" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= trans('id'); ?></th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Plan Title</th>
                                    <th>Duration</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                    <th class="th-options"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
									$i= 1; 
                                    foreach ($tickets_epayment as $item): ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= esc($item->username); ?></td>
                                            <td><?= esc($item->email); ?></td>
                                            <td><?= esc($item->phone_number); ?></td>
                                            <td><?= esc($item->plan_title); ?></td>
                                            <td><?= esc($item->number_of_days); ?></td>
                                            <td><?= $defaultCurrency->symbol; ?><?= getPrice($item->price, 'decimal'); ?></td>
                                            <td><?= formatDate($item->plan_start_date); ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?><span class="caret"></span></button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li class="green-hover" style="background: #00c300 !important;"><a class="green-hover" style="color: white !important;" href="<?= adminUrl('edit-epayment-details-membership/' . $item->random_ref_no); ?>"><i class="fa fa-check-circle option-icon"></i><?= trans('approve'); ?></a></li>
														
														<li class="red-hover" style="background: red !important;margin-top: 5px !important;"><a class="red-hover" href="javascript:void(0)" style="color: white !important;" onclick="deleteItem('MembershipController/rejectEpaymentApprovalMembership','<?= $item->random_ref_no; ?>','<?= trans("confirm_reject", true); ?>');"><i class="fa fa-times-circle option-icon"></i><?= trans('reject'); ?></a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php 
									$i++;
									endforeach;
                                 ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } 
else
{
?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title"><?= trans('e-payment-report'); ?> - Business Membership</h3>
                </div>
            </div>
			<div class="row">
				<div class="col-12" style="text-align : center;">
					<h3>No Relevant Data</h3>
				</div>
			</div>
        </div>
    </div>
</div>
<?php } ?>
<style>
.red-hover:hover
{
	background : red !important;
}
.green-hover:hover
{
	background : #00c300 !important;
}
</style>

<?php 
$tickets = helperGetSession('tickets');
		
if (!empty($tickets)) 
{  
$data_payment = $tickets;
$emailData = 
[
		'email_type' => 'activation',
		'email_address' => $data_payment->email,
		'email_data' => serialize([
			'content' => 'Name : '.$data_payment->username,
			'content_1' => 'Plan Name : '.$data_payment->plan_title,
			'content_2' => 'Plan Expiry : '.formatDateShort($data_payment->plan_expiry_date),
			'content_3' => 'Payment Method : '.$data_payment->payment_method,
			'content_4' => 'Payment Status : '.$data_payment->payment_status,
			'content_5' => 'Transaction ID : '.$data_payment->payment_id,
			'content_6' => "Thank you! If you have any questions or need assistance, feel free to reach out.",
		]),
		'email_priority' => 1,
		'email_subject' => 'Business Membership Paymemt Confirmation E-payment',
		'template_path' => 'email/rsvp_payment'
];

addToEmailQueue($emailData);

helperDeleteSession('tickets');
helperDeleteSession('mds_transaction_insert_id');
}
?>
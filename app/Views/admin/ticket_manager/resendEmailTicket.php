<?php 
if(!empty($ticketsData))
{
?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title">Email Report&nbsp;-&nbsp;<?= $tickets->event_name?></h3>
                </div>
				<div class="right">
                    <a href="<?= adminUrl('ticket-manager'); ?>" class="btn btn-danger btn-add-new">
                        <i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;<?= trans('back'); ?>
                    </a>
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
                                    <th>Total Tickets</th>
                                    <th>Reference Seats</th>
                                    <th>Total</th>
                                    <th>Booking Date</th>
                                    <th>Email Status</th>
                                    <th class="th-options"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($ticketsData)):
									$i= 1; 
                                    foreach ($ticketsData as $item): ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= esc($item->username); ?></td>
                                            <td><?= esc($item->email); ?></td>
                                            <td><?= esc($item->phone_number); ?></td>
                                            <td><?= esc($item->totalSeats); ?></td>
                                            <td><?= esc($item->reference_seats); ?></td>
                                            <td><?= $defaultCurrency->symbol; ?><?= esc($item->totalTicketPrice); ?></td>
                                            <td><?= formatDate($item->booking_date); ?></td>
                                            <td></td>
                                            <td> 
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?><span class="caret"></span></button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li class="green-hover" style="background: #00c300 !important;"><a class="green-hover" style="color: white !important;" href="<?= adminUrl('confirm-resend-email/' . $item->ticket_id .'/'. $item->member_booking_id.'/'. $item->event_id); ?>"><i class="fa fa-check-circle option-icon"></i>Resend</a></li>
														<li class="green-hover" style="background: blue !important;margin-top:3px;"><a class="blue-hover" style="color: white !important;" href="<?= adminUrl('confirm-remainder-email/' . $item->ticket_id .'/'. $item->member_booking_id.'/'. $item->event_id); ?>"><i class="fa fa-check-circle option-icon"></i>Remainder</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php 
									$i++;
									endforeach;
                                endif; ?>
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
                    <h3 class="box-title">Email Report</h3>
                </div>
				
				<div class="right">
                    <a href="<?= adminUrl('ticket-manager'); ?>" class="btn btn-danger btn-add-new">
                        <i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;<?= trans('back'); ?>
                    </a>
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

.blue-hover:hover
{
	background : blue !important;
}
</style>


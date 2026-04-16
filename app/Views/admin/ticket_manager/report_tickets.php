<link href="<?= base_url('assets/vendor/datatable/dataTables.min.css'); ?>">
<link href="<?= base_url('assets/vendor/datatable/buttons.dataTables.min.css'); ?>">
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="text-center">
                    <h3 class="box-title font-design"><?= trans('report').' - '.$tickets->event_name.' ('.$tickets->event_date.')'; ?></h3>
                </div>
				
				<div class="right">
                    <a href="<?= adminUrl('ticket-manager'); ?>" class="btn btn-danger btn-add-new">
                        <i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;<?= trans('back'); ?>
                    </a>
                </div>
            </div>
			
			<div class ="row" style="padding : 15px;">
				<div class="col-lg-3 col-xs-6">
					<div class="small-box admin-small-box bg-success">
						<div class="inner">
							<h3 class="increase-count"><?= $tickets_overall_total[0]['total_seats_value']; ?></h3>
							<p><?= trans("total_seats"); ?></p>
						</div>
						<div class="icon">
							<i class="fa fa-users"></i>
						</div>
					</div>
				</div>
				
				<div class="col-lg-3 col-xs-6">
					<div class="small-box admin-small-box bg-purple">
						<div class="inner">
							<h3 class=""><?= $defaultCurrency->symbol; ?><?= $tickets_overall_total[0]['sub_total_value']; ?></h3>
							<p><?= trans("subtotal"); ?></p>
						</div>
						<div class="icon">
							<i class="fa fa-money"></i>
						</div>
					</div>
				</div>
				
				<div class="col-lg-3 col-xs-6">
					<div class="small-box admin-small-box bg-danger">
						<div class="inner">
							<h3 class=""><?= $defaultCurrency->symbol; ?><?= $tickets_overall_total[0]['discount_total_value']; ?></h3>
							<p><?= trans("discount_amount"); ?></p>
						</div>
						<div class="icon">
							<i class="fa fa-handshake-o"></i>
						</div>
					</div>
				</div>
				
				<div class="col-lg-3 col-xs-6">
					<div class="small-box admin-small-box bg-warning">
						<div class="inner">
							<h3 class=""><?= $defaultCurrency->symbol; ?><?= $tickets_overall_total[0]['total_value']; ?></h3>
							<p><?= trans("total"); ?></p>
						</div>
						<div class="icon">
							<i class="fa fa-suitcase"></i>
						</div>
					</div>
				</div>
			</div>
			
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped cs_datatable_lang" id="example" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= trans('id'); ?></th>
                                    <th><?= trans('name'); ?></th>
                                    <th><?= trans('email'); ?></th>
                                    <th><?= trans('phone'); ?></th>
                                    <th><?= trans('invoice'); ?></th>
                                    <th><?= trans('booking_date'); ?></th>
                                    <th><?= trans('transaction_number'); ?></th>
                                    <th><?= trans('total_seats'); ?></th>
                                    <th><?= trans('seat_numbers'); ?></th>
                                    <th><?= trans('subtotal'); ?></th>
                                    <th><?= trans('discount_percent'); ?></th>
                                    <th><?= trans('discount_amount'); ?></th>
                                    <th><?= trans('total'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($ticket_report)):
									$i = 1;
                                    foreach ($ticket_report as $item): 
										//echo "<pre>";print_r($item);die;?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= esc($item['username']); ?></td>
                                            <td><?= esc($item['email']); ?></td>
                                            <td><?= esc($item['phone_number']); ?></td>
                                            <td><?= esc($item['invoice_no']); ?></td>
                                            <td><?= esc($item['booking_date']); ?></td>
                                            <td><?= esc($item['transaction_id']); ?></td>
                                            <td class="text-center"><?= esc($item['totalSeats']); ?></td>
                                            <td><?= esc($item['reference_seats']); ?></td>
                                            <td class="text-right"><?= $defaultCurrency->symbol; ?><?= esc($item['subtotalTicketPrice']); ?></td>
                                            <td class="text-center"><?= esc($item['discountPercentage']); ?>%</td>
                                            <td class="text-right"><?= $defaultCurrency->symbol; ?><?= esc($item['discountPrice']); ?></td>
                                            <td class="text-right" style="width:100px;"><?= $defaultCurrency->symbol; ?><?= esc($item['totalTicketPrice']); ?></td>
                                        </tr>
                                    <?php 
									$i++;
									endforeach;
                                endif; ?>
                                </tbody>
								<tfoot>
									<tr>
										<th colspan="12" style="text-align:right">Total:</th>
										<th></th>
									</tr>
								</tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.text-center
{
	text-align : center;
}

.font-design
{
	font-size : 20px;
	font-weight : bold;
}

.text-right
{
	text-align : right;
}
</style>
<script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/datatable/dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/datatable/dataTables.buttons.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/datatable/jszip.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/datatable/buttons.html5.min.js'); ?>"></script>

<script>
$(document).ready(function() {
	 var title_export = "<?= trans('report').' - '.$tickets->event_name.' ('.$tickets->event_date.')'; ?>";
    $('#example').DataTable( 
	{
		"iDisplayLength": 100,//per page data
		"aLengthMenu": [[5,10, 25, 50, 100,500,1000,-1], [5,10, 25, 50,100,500,1000,"All"]],
		"sScrollX": 'auto',
		scrollY: '50vh',
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
			}
        ],
		 initComplete: function () {
            var btns = $('.dt-button');
            btns.addClass('btn btn-success btn-sm column_cls');
            btns.removeClass('dt-button');

        },
		
		footerCallback: function (row, data, start, end, display) {
        let api = this.api();
 
        // Remove the formatting to get integer data for summation
        let intVal = function (i) {
            return typeof i === 'string'
                ? i.replace(/[\$,]/g, '') * 1
                : typeof i === 'number'
                ? i
                : 0;
        };
 
        // Total over all pages
        total = api
            .column(12)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
 
        // Total over this page
        pageTotal = api
            .column(12, { page: 'current' })
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
 
        // Update footer
        api.column(12).footer().innerHTML =
            '$' + pageTotal + ' ( $' + total + ' total)';
    }
		
    } );
} );
</script>
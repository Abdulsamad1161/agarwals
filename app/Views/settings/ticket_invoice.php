<div id="wrapper">
    <div class="container">
		<?php /*
		
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
                    </ol>
                </nav>
            </div>
        </div>
		*/ ?>
		
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8 col-sm-12">
				<div class="title">
					<h1 class="picture_gallery_h1"><?= trans("ticket_invoice"); ?></h1>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
        <div class="row">
            <div class="col-sm-12 col-md-3">
                <div class="row-custom">
                    <?= view("settings/_tabs"); ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-9">
                <div class="row-custom">
                    <div class="profile-tab-content">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped cs_datatable_lang" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= trans('id'); ?></th>
                                    <th><?= trans('event_name'); ?></th>
                                    <th><?= trans('event_date'); ?></th>
                                    <th><?= trans('invoice'); ?></th>
                                    <th><?= trans('booking_date'); ?></th>
                                    <th><?= trans('transaction_number'); ?></th>
                                    <th><?= trans('total'); ?></th>
                                    <th><?= trans('view_invoice'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($ticket_report)):
									$i = 1;
                                    foreach ($ticket_report as $item): 
										//echo "<pre>";print_r($item);die;?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= esc($item['event_name']); ?></td>
                                            <td><?= esc($item['event_date']); ?></td>
                                            <td><?= esc($item['invoice_no']); ?></td>
                                            <td><?= esc($item['booking_date']); ?></td>
                                            <td><?= esc($item['transaction_id']); ?></td>
                                            <td class="text-success text-right"><?= $defaultCurrency->symbol; ?><?= esc($item['totalTicketPrice']); ?></td>
                                            <td class="text-center"><a href="<?= adminUrl('ticket-invoice-event/' . $item['ticket_id']); ?>"><i class="fa fa-eye eye-icon"></i></a></td>
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

<style>
.profile-tab-content
{
	border-radius: 10px !important; 
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
	border: 2px solid #d1274b !important; 
	margin: 5px !important;
	padding: 10px !important;
}

.picture_gallery_h1
{
	font-size: 25px;
	display: inline-block;
	border-bottom: 5px solid #d1274b;
	font-weight : bold;
}

.title
{
	text-align: center;
	margin-bottom : 30px;
}

.text-center
{
	text-align : center;
}

.text-right
{
	text-align : right;
	font-weight: bold;
}

.eye-icon
{
	font-size: 18px !important;
	color: #d1274b !important;
}
</style>
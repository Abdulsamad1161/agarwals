<link href="<?= base_url('assets/vendor/datatable/dataTables.min.css'); ?>">
<link href="<?= base_url('assets/vendor/datatable/buttons.dataTables.min.css'); ?>">
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= $formHeader->form_name?>&nbsp;<?= trans('report'); ?></h3>
                </div>
				
				<div class="right">
                    <a href="<?= adminUrl('rsvp-form-report'); ?>" class="btn btn-danger btn-add-new">
                        <i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;<?= trans('back'); ?>
                    </a>
                </div>
            </div>
			<div class="box-body">
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" role="grid" aria-describedby="example1_info" id="rsvp_report">
								<?php 
									$flag = false; // Initialize the flag to false

									foreach ($formFields as &$item) {
										if ($item->fieldType == 'number') {
											$flag = true;
											break; // Exit the loop as soon as you find a matching element
										}
									}
									
									$text18Flag = false;
									
									foreach ($formFields as &$item) {
										if ($item->formNameAttribute == 'text18') {
											$text18Flag = true;
											$text18Label = $item->formLabel;
											break; // Exit the loop as soon as you find a matching element
										}
									}
									
									$text19Flag = false;
									
									foreach ($formFields as &$item) {
										if ($item->formNameAttribute == 'text19') {
											$text19Flag = true;
											$text19Label = $item->formLabel;
											break; // Exit the loop as soon as you find a matching element
										}
									}
									
									$text20Flag = false;
									
									foreach ($formFields as &$item) {
										if ($item->formNameAttribute == 'text20') {
											$text20Flag = true;
											$text20Label = $item->formLabel;
											break; // Exit the loop as soon as you find a matching element
										}
									}
									
								?>
								<thead>
									<tr role="row">
										<?php
										foreach ($formFields as $field) {
											echo '<th>' . $field->formLabel . '</th>';
											
										}
										if($text18Flag)
										{
											echo '<th>Total '.$text18Label.'</th>';
										}
										if($text19Flag)
										{
											echo '<th>Total '.$text19Label.'</th>';
										}
										if($text20Flag)
										{
											echo '<th>Total '.$text20Label.'</th>';
										}
										if($flag)
										{
											echo '<th>Total Amount</th>';
											echo '<th>Payment Method</th>';
										}
										?>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($formData as $submission) {
										//echo "<pre>";echo "<pre>";print_r($submission);
										echo '<tr>';
										foreach ($formFields as $field) {
											if (isset($submission->{$field->formNameAttribute})) {
												echo '<td>' . $submission->{$field->formNameAttribute} . '</td>';
											}
										}
										if($text18Flag)
										{
											echo '<td>' . $submission->quantitytext18. '</td>';
										}
										if($text19Flag)
										{
											echo '<td>' . $submission->quantitytext19. '</td>';
										}
										if($text20Flag)
										{
											echo '<td>' . $submission->quantitytext20. '</td>';
										}
										if($flag)
										{
											echo '<td>' . $submission->total_amount. '</td>';
											echo '<td>' . $submission->payment_method. '</td>';
										}
										echo '</tr>';
									}
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

<script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/datatable/dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/datatable/dataTables.buttons.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/datatable/jszip.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/datatable/buttons.html5.min.js'); ?>"></script>

<script>
$(document).ready(function() {
	 var title_export = "<?= $formHeader->form_name?>"+' '+"<?= trans('report'); ?>";
    $('#rsvp_report').DataTable( 
	{
		"iDisplayLength": 25,//per page data
		"aLengthMenu": [[ 5, 10, 25, 50, 100, 500, 1000,-1], [ 5, 10, 25, 50, 100, 500, 1000,"All"]],
		"dom": 
		 "<'row'<'col-sm-2'l><'col-sm-6'B><'col-sm-4'f>>" +
			"<'row'<''tr>>" +
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

        }
		
    } );
} );
</script>


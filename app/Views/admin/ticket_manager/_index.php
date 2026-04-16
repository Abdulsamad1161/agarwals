<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("add_ticket"); ?></h3>
            </div>

            <form action="<?= base_url('TicketController/addTicketPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
                    
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="form-group">
								<label><?= trans("event_name"); ?></label>
								<input type="text" class="form-control" name="eventName" placeholder="<?= trans("event_name"); ?>" value="" maxlength="200" required>
							</div>
						</div>
                    
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="form-group">
								<label><?= trans("event_date"); ?></label>
								<input type="date" class="form-control" name="eventDate" placeholder="<?= trans("event_date"); ?>" value="" maxlength="200" required>
							</div>
						</div>
						
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="form-group">
								<label class="control-label"><?= trans("event_start_time"); ?></label>
								<input type="time" class="form-control" name="eventStartTime" placeholder="<?= trans("event_time"); ?>" value="" maxlength="200">
							</div>
						</div>
						
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="form-group">
								<label class="control-label"><?= trans("event_end_time"); ?></label>
								<input type="time" class="form-control" name="eventEndTime" placeholder="<?= trans("event_time"); ?>" value="" maxlength="200">
							</div>
						</div>
					</div>
					
					<div class="row">
						
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="form-group">
								<label class="control-label"><?= trans("event_location"); ?></label>
								<input type="text" class="form-control" name="eventLocation" placeholder="<?= trans("event_location"); ?>" value="" maxlength="200">
							</div>
						</div>
						
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="form-group">
								<label><?= trans("ticket_display_date"); ?></label>
								<input type="date" class="form-control" name="ticketShowDate" placeholder="<?= trans("event_date"); ?>" value="" maxlength="200" required>
							</div>
						</div>
						
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="form-group">
								<label class="control-label"><?= trans("ticket_display_time"); ?></label>
								<input type="time" class="form-control" name="ticketDisplayTime" value="" maxlength="200">
							</div>
						</div>
						
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="form-group">
								<label><?= trans("ticket_hide_date"); ?></label>
								<input type="date" class="form-control" name="ticketHideDate" placeholder="<?= trans("event_date"); ?>" value="" maxlength="200" required>
							</div>
						</div>
                    </div>
					
					<div class = "row">
						
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="form-group">
								<label class="control-label"><?= trans('event_image'); ?></label>
								<div class="display-block">
									<a class='btn btn-success btn-sm btn-file-upload'>
										<?= trans('event_image_select'); ?>
										<input type="file" name="eventImage" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info1').html($(this).val());">
									</a>
									(.png, .jpg, .jpeg)
								</div>
								<span class='label label-info' id="upload-file-info1"></span>
							</div>
						</div>
						
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="form-group">
								<label class="control-label"><?= trans('seat_layout_image'); ?></label>
								<div class="display-block">
									<a class='btn btn-info btn-sm btn-file-upload'>
										<?= trans('select_seat_layout_image'); ?>
										<input type="file" name="seatLayoutImage" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info2').html($(this).val());">
									</a>
									(.png, .jpg, .jpeg)
								</div>
								<span class='label label-info' id="upload-file-info2"></span>
							</div>
						</div>
						
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="form-group">
								<label><?= trans("time_limit_booking"); ?></label>
								<input type="number" class="form-control" name="bookinglimit" placeholder="Ex : 5" min="5" required>
							</div>
						</div>
						
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="form-group">
								<label class="control-label">Paypal Charges</label>
								<input type="number" class="form-control" name="paypalCharges" placeholder="0" value="0">
							</div>
						</div>
					</div>
					
					<div class="row">
						
						<div class="col-lg-3 col-md-3 col-sm-12">
							<label class="control-label"><?= trans('seat_configure'); ?></label>
							<div class="panel panel_green">
								<div class="panel-heading">
									<h3 class="panel-title"><?= trans('create_seats'); ?></h3>
									<span class="pull-right clickable panel-collapsed"><i class="glyphicon glyphicon-chevron-up"></i></span>
								</div>
								<div class="panel-body">
									<div id="tablesAndSeatsContainerButton">
										<label for="sections"><?= trans('enter_no_of_sections'); ?></label>
										<input type="number" id="sections" name="section" class="form-control" />
										<div class="align-right">
											<span class="btn btn-primary" onclick="createTablesAndSeats()"><?= trans('create_ts'); ?></span>
										</div>
									</div>
									<div id="tablesAndSeatsContainer"></div>
									<div id="tablesAndSeatsContainerButtonReset">
										<span class="btn btn-primary" onclick="resetsections()"><?= trans('reset'); ?></span>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-md-3">
							<label class="control-label"><?= trans('gold_ticket_price'); ?></label>
							<div class="panel panel_gold">
								<div class="panel-heading">
									<h3 class="panel-title"><?= trans('gold_ticket'); ?></h3>
									<span class="pull-right clickable panel-collapsed"><i class="glyphicon glyphicon-chevron-up"></i></span>
								</div>
								<div class="panel-body">
									<div class="form-group">
										<label class="control-label"><?= trans('member_ticket'); ?></label>
										<div class="form-group form-group-price">
												<div class="input-group" >
													<span class="input-group-addon"><?= $defaultCurrency->symbol; ?></span>
													<input type="text" name="g_mem_tp" class="form-control form-input price-input validate-price-input" placeholder="<?= $baseVars->inputInitialPrice; ?>" onpaste="return false;" maxlength="32">
												</div>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label"><?= trans('non_member_ticket'); ?></label>
										<div class="form-group form-group-price">
												<div class="input-group" >
													<span class="input-group-addon"><?= $defaultCurrency->symbol; ?></span>
													<input type="text" name="g_non_mem_tp" class="form-control form-input price-input validate-price-input" placeholder="<?= $baseVars->inputInitialPrice; ?>" onpaste="return false;" maxlength="32">
												</div>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label"><?= trans('child_ticket'); ?></label>
										<div class="form-group form-group-price">
												<div class="input-group" >
													<span class="input-group-addon"><?= $defaultCurrency->symbol; ?></span>
													<input type="text" name="g_child_tp" class="form-control form-input price-input validate-price-input" placeholder="<?= $baseVars->inputInitialPrice; ?>" onpaste="return false;" maxlength="32">
												</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-md-3">
							<label class="control-label"><?= trans('silver_ticket_price'); ?></label>
							<div class="panel panel_silver">
								<div class="panel-heading">
									<h3 class="panel-title"><?= trans('silver_ticket'); ?></h3>
									<span class="pull-right clickable panel-collapsed"><i class="glyphicon glyphicon-chevron-up"></i></span>
								</div>
								<div class="panel-body">
									<div class="form-group">
										<label class="control-label"><?= trans('member_ticket'); ?></label>
										<div class="form-group form-group-price">
												<div class="input-group" >
													<span class="input-group-addon"><?= $defaultCurrency->symbol; ?></span>
													<input type="text" name="s_mem_tp" class="form-control form-input price-input validate-price-input" placeholder="<?= $baseVars->inputInitialPrice; ?>" onpaste="return false;" maxlength="32">
												</div>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label"><?= trans('non_member_ticket'); ?></label>
										<div class="form-group form-group-price">
												<div class="input-group" >
													<span class="input-group-addon"><?= $defaultCurrency->symbol; ?></span>
													<input type="text" name="s_non_mem_tp" class="form-control form-input price-input validate-price-input" placeholder="<?= $baseVars->inputInitialPrice; ?>" onpaste="return false;" maxlength="32">
												</div>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label"><?= trans('child_ticket'); ?></label>
										<div class="form-group form-group-price">
												<div class="input-group" >
													<span class="input-group-addon"><?= $defaultCurrency->symbol; ?></span>
													<input type="text" name="s_child_tp" class="form-control form-input price-input validate-price-input" placeholder="<?= $baseVars->inputInitialPrice; ?>" onpaste="return false;" maxlength="32">
												</div>
										</div>
									</div>
								</div>
							</div>

						</div>
						
						<div class="col-md-3">
							<label class="control-label"><?= trans('discount_category'); ?></label>
							<div class="panel panel_blue">
								<div class="panel-heading">
									<h3 class="panel-title"><?= trans('discount_percent'); ?></h3>
									<span class="pull-right clickable panel-collapsed"><i class="glyphicon glyphicon-chevron-up"></i></span>
								</div>
								<div class="panel-body">
									<div class="form-group">
										<label class="control-label"><?= trans('more_than'); ?></label>
										<div class="form-group form-group-price">
												<div class="input-group" >
													<span class="input-group-addon"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
													<input type="text" name="d1_more_than" class="form-control form-input price-input validate-price-input" placeholder="0" onpaste="return false;" maxlength="32">
												</div>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label"><?= trans('discount_percent'); ?></label>
										<div class="form-group form-group-price">
												<div class="input-group" >
													<span class="input-group-addon"><i class="fa fa-percent" aria-hidden="true"></i></span>
													<input type="text" name="d1_perc" class="form-control form-input price-input validate-price-input" placeholder="0%" onpaste="return false;" maxlength="32">
												</div>
										</div>
									</div>
									
									<div class="row first_add">
										<div class="align-right-button expand1"><span class="button_span"><i class="fa fa-plus" aria-hidden="true"></i></span></div>
									</div>
									
									<div class="disc2 hidden_disc1">
									<div class="form-group">
										<label class="control-label"><?= trans('more_than'); ?></label>
										<div class="form-group form-group-price">
												<div class="input-group" >
													<span class="input-group-addon"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
													<input type="text" name="d2_more_than" class="form-control form-input price-input validate-price-input" placeholder="0" onpaste="return false;" maxlength="32">
												</div>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label"><?= trans('discount_percent'); ?></label>
										<div class="form-group form-group-price">
												<div class="input-group" >
													<span class="input-group-addon"><i class="fa fa-percent" aria-hidden="true"></i></span>
													<input type="text" name="d2_perc" class="form-control form-input price-input validate-price-input" placeholder="0%" onpaste="return false;" maxlength="32">
												</div>
										</div>
									</div>
									
									<div class="row second_add">
										<div class="align-right-button expand2"><span class="button_span"><i class="fa fa-plus" aria-hidden="true"></i></span></div>
									</div>
									</div>
									
									<div class="disc3 hidden_disc2">
									<div class="form-group">
										<label class="control-label"><?= trans('more_than'); ?></label>
										<div class="form-group form-group-price">
												<div class="input-group" >
													<span class="input-group-addon"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
													<input type="text" name="d3_more_than" class="form-control form-input price-input validate-price-input" placeholder="0" onpaste="return false;" maxlength="32">
												</div>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label"><?= trans('discount_percent'); ?></label>
										<div class="form-group form-group-price">
												<div class="input-group" >
													<span class="input-group-addon"><i class="fa fa-percent" aria-hidden="true"></i></span>
													<input type="text" name="d3_perc" class="form-control form-input price-input validate-price-input" placeholder="0%" onpaste="return false;" maxlength="32">
												</div>
										</div>
									</div>
									</div>
									
								</div>
							</div>

						</div>
						
					</div>
					
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12">
							<div class="form-group">
								<div class="row">
									<div class="col-sm-6">
										<label>Paypal</label>
									</div>
									<div class="col-sm-3 col-xs-12 col-option">
										<input type="radio" name="is_paypal" value="1"  class="square-purple" checked>
										<label for="row_width_1" class="option-label">Enable</label>
									</div>
									<div class="col-sm-3 col-xs-12 col-option">
										<input type="radio" name="is_paypal" value="0"  class="square-purple">
										<label for="row_width_2" class="option-label">Disable</label>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-lg-6 col-md-6 col-sm-12">
							<div class="form-group">
								<div class="row">
									<div class="col-sm-6">
										<label>E-payment</label>
									</div>
									<div class="col-sm-3 col-xs-12 col-option">
										<input type="radio" name="is_epayment" value="1"  class="square-purple" checked>
										<label for="row_width_3" class="option-label">Enable</label>
									</div>
									<div class="col-sm-3 col-xs-12 col-option">
										<input type="radio" name="is_epayment" value="0"  class="square-purple">
										<label for="row_width_4" class="option-label">Disable</label>
									</div>
								</div>
							</div>
						</div>
					</div>
	
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('add_ticket'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title"><?= trans('ticket_details'); ?></h3>
                </div>
				
				<div class="pull-right">
					<a href="<?= adminUrl("qr-scanner"); ?>" class="btn btn-success">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;QR Reader
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
                                    <th><?= trans('event_name'); ?></th>
                                    <th><?= trans('event_date'); ?></th>
                                    <th><?= trans('event_location'); ?></th>
                                    <th><?= trans('event_start_time'); ?></th>
                                    <th><?= trans('event_end_time'); ?></th>
                                    <th class="th-options"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($tickets)):
                                    foreach ($tickets as $item): ?>
                                        <tr>
                                            <td><?= esc($item->id); ?></td>
                                            <td><?= esc($item->event_name); ?></td>
                                            <td><?= esc($item->event_date); ?></td>
                                            <td><?= esc($item->event_location); ?></td>
                                            <td><?= esc($item->event_start_time); ?></td>
                                            <td><?= esc($item->event_end_time); ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?><span class="caret"></span></button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li><a href="<?= adminUrl('edit-ticket-details/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a></li>
														
														<li><a href="<?= adminUrl('select-vip-tickets/' . $item->id); ?>"><i class="fa fa-users li-change"></i><?= trans('hold_ticket'); ?></a></li>
														
														<li><a href="<?= adminUrl('report-tickets/' . $item->id); ?>"><i class="fa fa-file li-change"></i><?= trans('report'); ?></a></li>
														
														<li><a href="<?= adminUrl('report-tickets-checkIn/' . $item->id); ?>"><i class="fa fa-file li-change"></i>Attendees <?= trans('report'); ?></a></li> 
														
														<li><a href="<?= adminUrl('report-tickets-ePayment/' . $item->id); ?>"><i class="fa fa-file li-change"></i><?= trans('e-payment-report'); ?></a></li>
														
														<li><a href="<?= adminUrl('resend-email-ticket/' . $item->id); ?>"><i class="fa fa-file li-change"></i>Resend Email</a></li>
														
                                                        <li><a href="javascript:void(0)" onclick="deleteItem('TicketController/deleteTicketPost','<?= $item->id; ?>','<?= trans("confirm_delete", true); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;
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
.clickable{
    cursor: pointer;   
}

.panel-heading span {
	margin-top: -20px;
	font-size: 15px;
}
.panel-body {
    display: none;
}

.panel_gold
{
	background: #ffd7008a;
}

.panel_silver
{
	background: #c0c0c094;;
}

.panel_blue
{
	background: #70b4fe94;
}

.panel_green
{
	background: #50ff0059;
}

.panel_title
{
	font-weight: 501 !important;
}

.panel-body
{
	background : white !important;
}

.align-right-button
{
	text-align: right;
	padding: 0px;
	margin-right: 20px;
}

.button_span
{
	padding: 4px;
	background: #4e99ecf0;
	border-radius: 15%;
	color: white;
}

.hidden_disc1
{
	display : none;
}

.hidden_disc2
{
	display : none;
}

.hide1
{
	display : none;
}

.hide2
{
	display : none;
}

.align-right
{
	text-align: right;
	margin-top: 10px;
}

#tablesAndSeatsContainerButtonReset
{
	display : none;
	text-align: right;
}

.li-change
{
	font-size: 13px !important;
	padding-left: 9px !important;
}
</style>
<script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
<script>
$(document).on('click', '.panel-heading span.clickable', function(e){
    var $this = $(this);
	if(!$this.hasClass('panel-collapsed')) {
		$this.parents('.panel').find('.panel-body').slideUp();
		$this.addClass('panel-collapsed');
		$this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
		
	} else {
		$this.parents('.panel').find('.panel-body').slideDown();
		$this.removeClass('panel-collapsed');
		$this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
		
	}
});

$(document).on('click', '.expand1', function(e)
{
	$('.disc2').removeClass('hidden_disc1');
	$('.first_add').addClass('hide1');
	
});

$(document).on('click', '.expand2', function(e)
{
	$('.disc3').removeClass('hidden_disc2');
	$('.second_add').addClass('hide2');
	
});

function createTablesAndSeats() 
{
	var sectionsInput = document.getElementById("sections");
	var numSections = parseInt(sectionsInput.value);

	if (isNaN(numSections) || numSections <= 0) 
	{
		swal("Please enter a valid number of sections (greater than 0).");
		return;
	}
  
	var seatInputButton = document.getElementById("tablesAndSeatsContainerButtonReset");
	seatInputButton.style.display = "block";

	var sectionButton = document.getElementById("tablesAndSeatsContainerButton");
	sectionButton.style.display = "none";

	var container = document.getElementById("tablesAndSeatsContainer");
	container.innerHTML = ""; // Clear the container before adding new inputs

	for (var i = 1; i <= numSections; i++) 
	{
		var sectionDiv = document.createElement("div");
		sectionDiv.classList.add("form-group");
		
		var sectionNameLabel = document.createElement("label");
		sectionNameLabel.textContent = "<?= trans('name_for_section'); ?> " + i + ": ";
		sectionDiv.appendChild(sectionNameLabel);

		var sectionNameInput = document.createElement("input");
		sectionNameInput.type = "text";
		sectionNameInput.name = "sectionName" + i;
		sectionNameInput.classList.add("form-control");
		sectionDiv.appendChild(sectionNameInput);
		
		var tableLabel = document.createElement("label");
		tableLabel.textContent = "<?= trans('tables_for_section'); ?> " + i + ": ";
		sectionDiv.appendChild(tableLabel);

		var tableInput = document.createElement("input");
		tableInput.type = "number";
		tableInput.name = "tables" + i;
		tableInput.classList.add("form-control");
		sectionDiv.appendChild(tableInput);

		var seatLabel = document.createElement("label");
		seatLabel.textContent = "<?= trans('seats_for_section'); ?> " + i + ": ";
		sectionDiv.appendChild(seatLabel);

		var seatInput = document.createElement("input");
		seatInput.type = "number";
		seatInput.name = "seats" + i;
		seatInput.classList.add("form-control");
		sectionDiv.appendChild(seatInput);

		container.appendChild(sectionDiv);
	}	
}

function resetsections()
{
	var seatInputButton = document.getElementById("tablesAndSeatsContainerButtonReset");
	seatInputButton.style.display = "none";
  
	var sectionButton = document.getElementById("tablesAndSeatsContainerButton");
	sectionButton.style.display = "block";

	var container = document.getElementById("tablesAndSeatsContainer");
	container.innerHTML = ""; // Clear the container for resetiing sections
	
	var sections = document.getElementById("sections");
	sections.value ='';
}


$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});
</script>
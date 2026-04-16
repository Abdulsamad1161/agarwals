<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('edit_your_rsvp_form'); ?></h3>
                </div>
				
				<div class="right">
                    <a href="<?= adminUrl('rsvp-form-report'); ?>" class="btn btn-danger btn-add-new">
                        <i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;<?= trans('back'); ?>
                    </a>
                </div>
            </div>
			<form action="<?= base_url('RSVPController/editFormHeaderPost'); ?>" method="post">
                <?= csrf_field(); ?>
			<div class="box-body">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-12">
						<div class="form-group">
							<label><?= trans("form_name"); ?></label>
							<input type="text" class="form-control" name="form_name" placeholder="<?= trans("form_name"); ?>" value="<?= $formHeader->form_name;?>" required>
						</div>
					</div>
					
					<div class="col-lg-6 col-md-6 col-sm-12">
						<div class="form-group">
							<label><?= trans("form_sub_title"); ?></label>
							<input type="text" class="form-control" name="form_sub_name" placeholder="<?= trans("form_sub_title"); ?>" value="<?= $formHeader->form_sub_name;?>" required>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="form-group">
							<label><?= trans("note"); ?></label>
							<textarea type="text" class="form-control" name="form_note" placeholder="<?= trans("note"); ?>"><?= $formHeader->form_note;?></textarea>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="form-group">
							<label><?= trans("note_other"); ?></label>
							<textarea type="text" class="form-control" name="form_note_other" placeholder="<?= trans("note"); ?>"><?= $formHeader->form_note_other;?></textarea>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-6">
									<label><?= trans('visibility'); ?></label>
								</div>
								<div class="col-sm-3 col-xs-12 col-option">
									<input type="radio" name="status" value="1"  class="square-purple" <?php echo ($formHeader->status == 1) ? 'checked' : ''?>>
									<label for="row_width_1" class="option-label"><?= trans('visible'); ?></label>
								</div>
								<div class="col-sm-3 col-xs-12 col-option">
									<input type="radio" name="status" value="0"  class="square-purple" <?php echo ($formHeader->status == 0) ? 'checked' : ''?>>
									<label for="row_width_2" class="option-label"><?= trans('invisible'); ?></label>
								</div>
							</div>
						</div>
					</div>
                </div>
				
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-6">
									<label>Paypal</label>
								</div>
								<div class="col-sm-3 col-xs-12 col-option">
									<input type="radio" name="is_paypal" value="1"  class="square-purple" <?php echo ($formHeader->is_paypal == 1) ? 'checked' : ''?>>
									<label for="row_width_1" class="option-label">Enable</label>
								</div>
								<div class="col-sm-3 col-xs-12 col-option">
									<input type="radio" name="is_paypal" value="0"  class="square-purple" <?php echo ($formHeader->is_paypal == 0) ? 'checked' : ''?>>
									<label for="row_width_2" class="option-label">Disable</label>
								</div>
							</div>
						</div>
					</div>
					
					
                </div>
				
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-6">
									<label>E-payment</label>
								</div>
								<div class="col-sm-3 col-xs-12 col-option">
									<input type="radio" name="is_epayment" value="1"  class="square-purple" <?php echo ($formHeader->is_epayment == 1) ? 'checked' : ''?>>
									<label for="row_width_3" class="option-label">Enable</label>
								</div>
								<div class="col-sm-3 col-xs-12 col-option">
									<input type="radio" name="is_epayment" value="0"  class="square-purple" <?php echo ($formHeader->is_epayment == 0) ? 'checked' : ''?>>
									<label for="row_width_4" class="option-label">Disable</label>
								</div>
							</div>
						</div>
					</div>
					
					
                </div>
							
				<input type="hidden" name = "form_id" value="<?= $formHeader->form_id;?>">
			</div>
			<div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
            </div>
			</form>
		</div>
	</div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('edit_your_rsvp_form_fields'); ?></h3>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= trans('id'); ?></th>
                                    <th><?= trans('field_type'); ?></th>
                                    <th><?= trans('name_of_lable'); ?></th>
                                    <th><?= trans('required'); ?></th>
                                    <th>Add To Email</th>
                                    <th><?= trans('order'); ?></th>
                                    <th><?= trans('dropdown_options'); ?></th>
                                    <th width="20"><?= trans('amount'); ?></th>
                                    <th class="th-options"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($formFields)):
									$i= 1;
                                    foreach ($formFields as $item): ?>
                                        <tr>
										<form action="<?= base_url('RSVPController/editFormFieldsPost'); ?>" method="post">
										<?= csrf_field(); ?>
                                            <td><?= $i; ?></td>
                                            <td>
											<div class="form-group">
												<select class="form-control" name="fieldType">
													<option value="text" <?php echo ($item->fieldType === 'text') ? 'selected' : ''; ?>><?= trans('text'); ?></option>
													<option value="textarea" <?php echo ($item->fieldType === 'textarea') ? 'selected' : ''; ?>><?= trans('textarea'); ?></option>
													<option value="select" <?php echo ($item->fieldType === 'select') ? 'selected' : ''; ?>><?= trans('dropdown'); ?></option>
													<option value="date" <?php echo ($item->fieldType === 'date') ? 'selected' : ''; ?>><?= trans('date'); ?></option>
													<option value="number" <?php echo ($item->fieldType === 'number') ? 'selected' : ''; ?>><?= trans('number'); ?></option>
												</select>
											</div>
											</td>
                                            <td><input type="text" class="form-control" name = "formLabel" value="<?= $item->formLabel ;?>"></td>
                                            <td>
											<div class="form-group">
												<input type="radio" name="required_<?= $i ?>" value="1" id="isRequired_<?= $i ?>_1" <?php echo ($item->isRequired == 1) ? 'checked' : ''; ?>>
												<label for="isRequired_<?= $i ?>_1" class="option-label"><?= trans('yes'); ?></label>
												&nbsp;&nbsp;&nbsp;
												<input type="radio" name="required_<?= $i ?>" value="0" id="isRequired_<?= $i ?>_0" <?php echo ($item->isRequired == 0) ? 'checked' : ''; ?>>
												<label for="isRequired_<?= $i ?>_0" class="option-label"><?= trans('no'); ?></label>
											</div>
											</td>
											<td>
											<div class="form-group">
												<input type="radio" name="email_<?= $i ?>" value="1" id="isEmail_<?= $i ?>_1" <?php echo ($item->isEmail == 1) ? 'checked' : ''; ?>>
												<label for="isEmail_<?= $i ?>_1" class="option-label"><?= trans('yes'); ?></label>
												&nbsp;&nbsp;&nbsp;
												<input type="radio" name="email_<?= $i ?>" value="0" id="isEmail_<?= $i ?>_0" <?php echo ($item->isEmail == 0) ? 'checked' : ''; ?>>
												<label for="isEmail_<?= $i ?>_0" class="option-label"><?= trans('no'); ?></label>
											</div>
											</td>
											<td><input type="number" class="form-control" name = "fieldOrder" value="<?= $item->fieldOrder ;?>"></td>
                                            <td><input type="text" class="form-control" name = "formSelectAttribute" value="<?= $item->formSelectAttribute;?>"></td>
											<td><input type="text" class="form-control" name = "fieldAmount" value="<?= $item->fieldAmount;?>"></td>
											
											<td><button type="submit" class="btn btn-md btn-success" style="font-size : 12px;"><?= trans('save_changes'); ?></button></td>
											<input type="hidden" name="form_id" value="<?= $item->form_id;?>">
											<input type="hidden" name="id" value="<?= $item->id;?>">
										</form>
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
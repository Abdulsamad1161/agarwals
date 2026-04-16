<div class="row">
    <div class="col-sm-12 col-lg-12 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('customize_your_form'); ?></h3>
                </div>
            </div>
            <form action="<?= base_url('RSVPController/addRSVPCustomFieldPost'); ?>" method="post" onkeypress="return event.keyCode != 13;">
                <?= csrf_field(); ?>
                <div class="box-body">
					<div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
							<div class="form-group">
                                <label><?= trans('form_title'); ?></label>
                                <input type="text" class="form-control" name="form_name" placeholder="<?= trans('form_title'); ?>" required>
                            </div>
                        </div>
						
						<div class="col-sm-6 col-md-6 col-lg-6">
							<div class="form-group">
                                <label><?= trans('form_sub_title'); ?></label>
                                <input type="text" class="form-control" name="form_sub_name" placeholder="<?= trans('form_sub_title'); ?>">
                            </div>
                        </div>
                    </div>
					
					<div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
							<div class="form-group">
                                <label><?= trans('note'); ?></label>
                               <textarea class="form-control form-input" name="form_note" placeholder = "<?= trans('note'); ?>"> 
                                </textarea>
                            </div>
                        </div>
                    </div>
					
					<div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
							<div class="form-group">
                                <label><?= trans('note_other'); ?></label>
                               <textarea class="form-control form-input" name="form_note_other" placeholder = "<?= trans('note'); ?>"> 
                                </textarea>
                            </div>
                        </div>
                    </div>
					
					<div class="row">
                        <div class="col-sm-12 align_center">
							<h3 class="box-title"><?= trans('text_fields'); ?></h3>
                        </div>
                    </div>
					
                    <div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-4">
							<div class="fields">
							<div class="form-group">
                                <label><?= trans('field_type'); ?></label>
                                <select class="form-control" name="fieldType_1">
                                    <option value="text"><?= trans('text'); ?></option>
                                </select>
                            </div>
							
							<div class="form-group" style="display: none;">
                                <textarea class="form-control  form-input" name="formSelectAttribute_1" hidden> 
                                </textarea>
								<input type="hidden" name="fieldAmount_1">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('name_of_lable'); ?></label>
                                <input type="text" class="form-control" name="formLabel_1" placeholder="<?= trans('name_of_lable'); ?>">
                            </div>
							
							<div class="form-group">
                                <input type="hidden" class="form-control" name="formNameAttribute_1" value="text1">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="fieldOrder_1" placeholder="<?= trans('order'); ?>" min="1" max="99999" value="">
                            </div>
							
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('required'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isRequired_1" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('select'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="select_1" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label">Add In Email</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isEmail_1" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
						
						<div class="col-sm-12 col-md-4 col-lg-4">
							<div class="fields">
							<div class="form-group">
                                <label><?= trans('field_type'); ?></label>
                                <select class="form-control" name="fieldType_2">
                                    <option value="text"><?= trans('text'); ?></option>
                                </select>
                            </div>
							
							<div class="form-group" style="display: none;">
                                <textarea class="form-control  form-input" name="formSelectAttribute_2" hidden> 
                                </textarea>
								<input type="hidden" name="fieldAmount_2">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('name_of_lable'); ?></label>
                                <input type="text" class="form-control" name="formLabel_2" placeholder="<?= trans('name_of_lable'); ?>">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="fieldOrder_2" placeholder="<?= trans('order'); ?>" min="1" max="99999" value="">
                            </div>
							
							<div class="form-group">
                                <input type="hidden" class="form-control" name="formNameAttribute_2" value="text2">
                            </div>
						
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('required'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isRequired_2" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('select'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="select_2" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label">Add In Email</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isEmail_2" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
						
						<div class="col-sm-12 col-md-4 col-lg-4">
							<div class="fields">
							<div class="form-group">
                                <label><?= trans('field_type'); ?></label>
                                <select class="form-control" name="fieldType_3">
                                    <option value="text"><?= trans('text'); ?></option>
                                </select>
                            </div>
							
							<div class="form-group" style="display: none;">
                                <textarea class="form-control  form-input" name="formSelectAttribute_3" hidden> 
                                </textarea>
								<input type="hidden" name="fieldAmount_3">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('name_of_lable'); ?></label>
                                <input type="text" class="form-control" name="formLabel_3" placeholder="<?= trans('name_of_lable'); ?>">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="fieldOrder_3" placeholder="<?= trans('order'); ?>" min="1" max="99999" value="">
                            </div>
							
							<div class="form-group">
                                <input type="hidden" class="form-control" name="formNameAttribute_3" value="text3">
                            </div>
							
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('required'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isRequired_3" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('select'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="select_3" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label">Add In Email</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isEmail_3" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							</div>
                        </div>
                    </div>
					
					<div class="row top-margin">
                        <div class="col-sm-12 col-md-4 col-lg-4">
							<div class="fields">
							<div class="form-group">
                                <label><?= trans('field_type'); ?></label>
                                <select class="form-control" name="fieldType_4">
                                    <option value="text"><?= trans('text'); ?></option>
                                </select>
                            </div>
							
							<div class="form-group" style="display: none;">
                                <textarea class="form-control  form-input" name="formSelectAttribute_4" hidden> 
                                </textarea>
								<input type="hidden" name="fieldAmount_4">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('name_of_lable'); ?></label>
                                <input type="text" class="form-control" name="formLabel_4" placeholder="<?= trans('name_of_lable'); ?>">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="fieldOrder_4" placeholder="<?= trans('order'); ?>" min="1" max="99999" value="">
                            </div>
							
							<div class="form-group">
                                <input type="hidden" class="form-control" name="formNameAttribute_4" value="text4">
                            </div>
							
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('required'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isRequired_4" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('select'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="select_4" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label">Add In Email</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isEmail_4" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
						
						<div class="col-sm-12 col-md-4 col-lg-4">
							<div class="fields">
							<div class="form-group">
                                <label><?= trans('field_type'); ?></label>
                                <select class="form-control" name="fieldType_5">
                                    <option value="text"><?= trans('text'); ?></option>
                                </select>
                            </div>
							
							<div class="form-group" style="display: none;">
                                <textarea class="form-control  form-input" name="formSelectAttribute_5" hidden> 
                                </textarea>
								<input type="hidden" name="fieldAmount_5">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('name_of_lable'); ?></label>
                                <input type="text" class="form-control" name="formLabel_5" placeholder="<?= trans('name_of_lable'); ?>">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="fieldOrder_5" placeholder="<?= trans('order'); ?>" min="1" max="99999" value="">
                            </div>
							
							<div class="form-group">
                                <input type="hidden" class="form-control" name="formNameAttribute_5" value="text5">
                            </div>
						
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('required'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isRequired_5" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('select'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="select_5" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label">Add In Email</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isEmail_5" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
						
						<div class="col-sm-12 col-md-4 col-lg-4">
							<div class="fields">
							<div class="form-group">
                                <label><?= trans('field_type'); ?></label>
                                <select class="form-control" name="fieldType_6">
                                    <option value="text"><?= trans('text'); ?></option>
                                </select>
                            </div>
							
							<div class="form-group" style="display: none;">
                                <textarea class="form-control  form-input" name="formSelectAttribute_6" hidden> 
                                </textarea>
								<input type="hidden" name="fieldAmount_6">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('name_of_lable'); ?></label>
                                <input type="text" class="form-control" name="formLabel_6" placeholder="<?= trans('name_of_lable'); ?>">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="fieldOrder_6" placeholder="<?= trans('order'); ?>" min="1" max="99999" value="">
                            </div>
							
							<div class="form-group">
                                <input type="hidden" class="form-control" name="formNameAttribute_6" value="text6">
                            </div>
							
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('required'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isRequired_6" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('select'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="select_6" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label">Add In Email</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isEmail_6" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							</div>
                        </div>
                    </div>
					
					<div class="row top-margin">
                        <div class="col-sm-12 col-md-4 col-lg-4">
							<div class="fields">
							<div class="form-group">
                                <label><?= trans('field_type'); ?></label>
                                <select class="form-control" name="fieldType_7">
                                    <option value="text"><?= trans('text'); ?></option>
                                </select>
                            </div>
							
							<div class="form-group" style="display: none;">
                                <textarea class="form-control  form-input" name="formSelectAttribute_7" hidden> 
                                </textarea>
								<input type="hidden" name="fieldAmount_7">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('name_of_lable'); ?></label>
                                <input type="text" class="form-control" name="formLabel_7" placeholder="<?= trans('name_of_lable'); ?>">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="fieldOrder_7" placeholder="<?= trans('order'); ?>" min="1" max="99999" value="">
                            </div>
							
							<div class="form-group">
                                <input type="hidden" class="form-control" name="formNameAttribute_7" value="text7">
                            </div>
							
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('required'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isRequired_7" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('select'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="select_7" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label">Add In Email</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isEmail_7" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
						
						<div class="col-sm-12 col-md-4 col-lg-4">
							<div class="fields">
							<div class="form-group">
                                <label><?= trans('field_type'); ?></label>
                                <select class="form-control" name="fieldType_8">
                                    <option value="text"><?= trans('text'); ?></option>
                                </select>
                            </div>
							
							<div class="form-group" style="display: none;">
                                <textarea class="form-control  form-input" name="formSelectAttribute_8" hidden> 
                                </textarea>
								<input type="hidden" name="fieldAmount_8">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('name_of_lable'); ?></label>
                                <input type="text" class="form-control" name="formLabel_8" placeholder="<?= trans('name_of_lable'); ?>">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="fieldOrder_8" placeholder="<?= trans('order'); ?>" min="1" max="99999" value="">
                            </div>
							
							<div class="form-group">
                                <input type="hidden" class="form-control" name="formNameAttribute_8" value="text8">
                            </div>
						
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('required'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isRequired_8" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('select'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="select_8" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label">Add In Email</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isEmail_8" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
						
						<div class="col-sm-12 col-md-4 col-lg-4">
							<div class="fields">
							<div class="form-group">
                                <label><?= trans('field_type'); ?></label>
                                <select class="form-control" name="fieldType_9">
                                    <option value="text"><?= trans('text'); ?></option>
                                </select>
                            </div>
							
							<div class="form-group" style="display: none;">
                                <textarea class="form-control  form-input" name="formSelectAttribute_9" hidden> 
                                </textarea>
								<input type="hidden" name="fieldAmount_9">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('name_of_lable'); ?></label>
                                <input type="text" class="form-control" name="formLabel_9" placeholder="<?= trans('name_of_lable'); ?>">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="fieldOrder_9" placeholder="<?= trans('order'); ?>" min="1" max="99999" value="">
                            </div>
							
							<div class="form-group">
                                <input type="hidden" class="form-control" name="formNameAttribute_9" value="text9">
                            </div>
							
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('required'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isRequired_9" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('select'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="select_9" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label">Add In Email</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isEmail_9" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							</div>
                        </div>
                    </div>
					
					<div class="row">
                        <div class="col-sm-12 align_center">
							<h3 class="box-title"><?= trans('text_area_fields'); ?></h3>
                        </div>
                    </div>
					
					<div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-4">
							<div class="fields">
							<div class="form-group">
                                <label><?= trans('field_type'); ?></label>
                                <select class="form-control" name="fieldType_10"> 
                                    <option value="textarea"><?= trans('textarea'); ?></option>
                                </select>
                            </div>
							
							<div class="form-group" style="display: none;">
                                <textarea class="form-control  form-input" name="formSelectAttribute_10" hidden> 
                                </textarea>
								<input type="hidden" name="fieldAmount_10">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('name_of_lable'); ?></label>
                                <input type="text" class="form-control" name="formLabel_10" placeholder="<?= trans('name_of_lable'); ?>">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="fieldOrder_10" placeholder="<?= trans('order'); ?>" min="1" max="99999" value="">
                            </div>
							
							<div class="form-group">
                                <input type="hidden" class="form-control" name="formNameAttribute_10" value="text10">
                            </div>
							
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('required'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isRequired_10" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('select'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="select_10" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label">Add In Email</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isEmail_10" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
						
						<div class="col-sm-12 col-md-4 col-lg-4">
							<div class="fields">
							<div class="form-group">
                                <label><?= trans('field_type'); ?></label>
                                <select class="form-control" name="fieldType_11">
                                    <option value="textarea"><?= trans('textarea'); ?></option>
                                </select>
                            </div>
							
							<div class="form-group" style="display: none;">
                                <textarea class="form-control  form-input" name="formSelectAttribute_11" hidden> 
                                </textarea>
								<input type="hidden" name="fieldAmount_11">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('name_of_lable'); ?></label>
                                <input type="text" class="form-control" name="formLabel_11" placeholder="<?= trans('name_of_lable'); ?>">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="fieldOrder_11" placeholder="<?= trans('order'); ?>" min="1" max="99999" value="">
                            </div>
							
							<div class="form-group">
                                <input type="hidden" class="form-control" name="formNameAttribute_11" value="text11">
                            </div>
						
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('required'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isRequired_11" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('select'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="select_11" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label">Add In Email</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isEmail_11" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
						
						<div class="col-sm-12 col-md-4 col-lg-4">
							<div class="fields">
							<div class="form-group">
                                <label><?= trans('field_type'); ?></label>
                                <select class="form-control" name="fieldType_12">
                                    <option value="textarea"><?= trans('textarea'); ?></option>
                                </select>
                            </div>
							
							<div class="form-group" style="display: none;">
                                <textarea class="form-control  form-input" name="formSelectAttribute_12" hidden> 
                                </textarea>
								<input type="hidden" name="fieldAmount_12">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('name_of_lable'); ?></label>
                                <input type="text" class="form-control" name="formLabel_12" placeholder="<?= trans('name_of_lable'); ?>">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="fieldOrder_12" placeholder="<?= trans('order'); ?>" min="1" max="99999" value="">
                            </div>
							
							<div class="form-group">
                                <input type="hidden" class="form-control" name="formNameAttribute_12" value="text12">
                            </div>
							
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('required'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isRequired_12" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('select'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="select_12" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label">Add In Email</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isEmail_12" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							</div>
                        </div>
                    </div>
					
					<div class="row">
                        <div class="col-sm-12 align_center">
							<h3 class="box-title"><?= trans('dropdown_fields'); ?></h3>
                        </div>
                    </div>
					
					<div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-4">
							<div class="fields">
							<div class="form-group">
                                <label><?= trans('field_type'); ?></label>
                                <select class="form-control" name="fieldType_13"> 
                                    <option value="select"><?= trans('dropdown'); ?></option>
                                </select>
                            </div>
							
							<div class="form-group">
                                <label><?= trans('name_of_lable'); ?></label>
                                <input type="text" class="form-control" name="formLabel_13" placeholder="<?= trans('name_of_lable'); ?>">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('enter_options_with_double_amp'); ?></label>
                                <textarea class="form-control  form-input" name="formSelectAttribute_13" placeholder = "optionOne&&optionTwo"> 
                                </textarea>
                            </div>
							
							<div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="fieldOrder_13" placeholder="<?= trans('order'); ?>" min="1" max="99999" value="">
                            </div>
							
							<div class="form-group">
                                <input type="hidden" class="form-control" name="formNameAttribute_13" value="text13">
								<input type="hidden" name="fieldAmount_13">
                            </div>
							
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('required'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isRequired_13" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('select'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="select_13" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label">Add In Email</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isEmail_13" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
						
						<div class="col-sm-12 col-md-4 col-lg-4">
							<div class="fields">
							<div class="form-group">
                                <label><?= trans('field_type'); ?></label>
                                <select class="form-control" name="fieldType_14"> 
                                    <option value="select"><?= trans('dropdown'); ?></option>
                                </select>
                            </div>
							
							<div class="form-group">
                                <label><?= trans('name_of_lable'); ?></label>
                                <input type="text" class="form-control" name="formLabel_14" placeholder="<?= trans('name_of_lable'); ?>">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('enter_options_with_double_amp'); ?></label>
                                <textarea class="form-control  form-input" name="formSelectAttribute_14" placeholder = "optionOne&&optionTwo"> 
                                </textarea>
                            </div>
							
							<div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="fieldOrder_14" placeholder="<?= trans('order'); ?>" min="1" max="99999" value="">
                            </div>
							
							<div class="form-group">
                                <input type="hidden" class="form-control" name="formNameAttribute_14" value="text14">
								<input type="hidden" name="fieldAmount_14">
                            </div>
							
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('required'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isRequired_14" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('select'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="select_14" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label">Add In Email</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isEmail_14" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
						
						<div class="col-sm-12 col-md-4 col-lg-4">
							<div class="fields">
							<div class="form-group">
                                <label><?= trans('field_type'); ?></label>
                                <select class="form-control" name="fieldType_15"> 
                                    <option value="select"><?= trans('dropdown'); ?></option>
                                </select>
                            </div>
							
							<div class="form-group">
                                <label><?= trans('name_of_lable'); ?></label>
                                <input type="text" class="form-control" name="formLabel_15" placeholder="<?= trans('name_of_lable'); ?>">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('enter_options_with_double_amp'); ?></label>
                                <textarea class="form-control  form-input" name="formSelectAttribute_15" placeholder = "optionOne&&optionTwo"> 
                                </textarea>
                            </div>
							
							<div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="fieldOrder_15" placeholder="<?= trans('order'); ?>" min="1" max="99999" value="">
                            </div>
							
							<div class="form-group">
                                <input type="hidden" class="form-control" name="formNameAttribute_15" value="text15">
								<input type="hidden" name="fieldAmount_15">
                            </div>
							
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('required'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isRequired_15" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('select'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="select_15" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label">Add In Email</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isEmail_15" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
					
					<div class="row">
                        <div class="col-sm-12 align_center">
							<h3 class="box-title"><?= trans('date_fields'); ?></h3>
                        </div>
                    </div>
					
					<div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-4">
							<div class="fields">
							<div class="form-group">
                                <label><?= trans('field_type'); ?></label>
                                <select class="form-control" name="fieldType_16">
                                    <option value="date"><?= trans('date'); ?></option>
                                </select>
                            </div>
							
							<div class="form-group" style="display: none;">
                                <textarea class="form-control  form-input" name="formSelectAttribute_16" hidden> 
                                </textarea>
                            </div>
							
							<div class="form-group">
                                <label><?= trans('name_of_lable'); ?></label>
                                <input type="text" class="form-control" name="formLabel_16" placeholder="<?= trans('name_of_lable'); ?>">
                            </div>
							
							<div class="form-group">
                                <input type="hidden" class="form-control" name="formNameAttribute_16" value="text16">
								<input type="hidden" name="fieldAmount_16">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="fieldOrder_16" placeholder="<?= trans('order'); ?>" min="1" max="99999" value="">
                            </div>
							
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('required'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isRequired_16" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('select'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="select_16" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label">Add In Email</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isEmail_16" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
						
						<div class="col-sm-12 col-md-4 col-lg-4">
							<div class="fields">
							<div class="form-group">
                                <label><?= trans('field_type'); ?></label>
                                <select class="form-control" name="fieldType_17">
                                    <option value="date"><?= trans('date'); ?></option>
                                </select>
                            </div>
							
							<div class="form-group" style="display: none;">
                                <textarea class="form-control  form-input" name="formSelectAttribute_17" hidden> 
                                </textarea>
                            </div>
							
							<div class="form-group">
                                <label><?= trans('name_of_lable'); ?></label>
                                <input type="text" class="form-control" name="formLabel_17" placeholder="<?= trans('name_of_lable'); ?>">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="fieldOrder_17" placeholder="<?= trans('order'); ?>" min="1" max="99999" value="">
                            </div>
							
							<div class="form-group">
                                <input type="hidden" class="form-control" name="formNameAttribute_17" value="text17">
								<input type="hidden" name="fieldAmount_17">
                            </div>
						
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('required'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isRequired_17" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('select'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="select_17" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label">Add In Email</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isEmail_17" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
					
					<div class="row">
                        <div class="col-sm-12 align_center">
							<h3 class="box-title"><?= trans('payment_field'); ?></h3>
                        </div>
                    </div>
					
					<div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-4">
							<div class="fields">
							<div class="form-group">
                                <label><?= trans('field_type'); ?></label>
                                <select class="form-control" name="fieldType_18">
                                    <option value="number"><?= trans('number'); ?></option>
                                </select>
                            </div>
							
							<div class="form-group" style="display: none;">
                                <textarea class="form-control  form-input" name="formSelectAttribute_18" hidden> 
                                </textarea>
                            </div>
							
							<div class="form-group">
                                <label><?= trans('name_of_lable'); ?></label>
                                <input type="text" class="form-control" name="formLabel_18" placeholder="<?= trans('name_of_lable'); ?>">
                            </div>
							
							<div class="form-group">
                                <input type="hidden" class="form-control" name="formNameAttribute_18" value="text18">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('amount'); ?></label>
								<div class="form-group form-group-price">
									<div class="input-group" >
										<span class="input-group-addon"><?= $defaultCurrency->symbol; ?></span>
										<input type="text" name="fieldAmount_18" class="form-control form-input price-input validate-price-input" placeholder="<?= $baseVars->inputInitialPrice; ?>" onpaste="return false;" maxlength="32">
									</div>
								</div>
                            </div>
							
							<div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="fieldOrder_18" placeholder="<?= trans('order'); ?>" min="1" max="99999" value="">
                            </div>
							
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('required'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isRequired_18" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('select'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="select_18" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label">Add In Email</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isEmail_18" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
						
                        <div class="col-sm-12 col-md-4 col-lg-4">
							<div class="fields">
							<div class="form-group">
                                <label><?= trans('field_type'); ?></label>
                                <select class="form-control" name="fieldType_19">
                                    <option value="number"><?= trans('number'); ?></option>
                                </select>
                            </div>
							
							<div class="form-group" style="display: none;">
                                <textarea class="form-control  form-input" name="formSelectAttribute_19" hidden> 
                                </textarea>
                            </div>
							
							<div class="form-group">
                                <label><?= trans('name_of_lable'); ?></label>
                                <input type="text" class="form-control" name="formLabel_19" placeholder="<?= trans('name_of_lable'); ?>">
                            </div>
							
							<div class="form-group">
                                <input type="hidden" class="form-control" name="formNameAttribute_19" value="text19">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('amount'); ?></label>
								<div class="form-group form-group-price">
									<div class="input-group" >
										<span class="input-group-addon"><?= $defaultCurrency->symbol; ?></span>
										<input type="text" name="fieldAmount_19" class="form-control form-input price-input validate-price-input" placeholder="<?= $baseVars->inputInitialPrice; ?>" onpaste="return false;" maxlength="32">
									</div>
								</div>
                            </div>
							
							<div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="fieldOrder_19" placeholder="<?= trans('order'); ?>" min="1" max="99999" value="">
                            </div>
							
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('required'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isRequired_19" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('select'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="select_19" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label">Add In Email</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isEmail_19" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
						
                        <div class="col-sm-12 col-md-4 col-lg-4">
							<div class="fields">
							<div class="form-group">
                                <label><?= trans('field_type'); ?></label>
                                <select class="form-control" name="fieldType_20">
                                    <option value="number"><?= trans('number'); ?></option>
                                </select>
                            </div>
							
							<div class="form-group" style="display: none;">
                                <textarea class="form-control  form-input" name="formSelectAttribute_20" hidden> 
                                </textarea>
                            </div>
							
							<div class="form-group">
                                <label><?= trans('name_of_lable'); ?></label>
                                <input type="text" class="form-control" name="formLabel_20" placeholder="<?= trans('name_of_lable'); ?>">
                            </div>
							
							<div class="form-group">
                                <input type="hidden" class="form-control" name="formNameAttribute_20" value="text20">
                            </div>
							
							<div class="form-group">
                                <label><?= trans('amount'); ?></label>
								<div class="form-group form-group-price">
									<div class="input-group" >
										<span class="input-group-addon"><?= $defaultCurrency->symbol; ?></span>
										<input type="text" name="fieldAmount_20" class="form-control form-input price-input validate-price-input" placeholder="<?= $baseVars->inputInitialPrice; ?>" onpaste="return false;" maxlength="32">
									</div>
								</div>
                            </div>
							
							<div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="fieldOrder_20" placeholder="<?= trans('order'); ?>" min="1" max="99999" value="">
                            </div>
							
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('required'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isRequired_20" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label"><?= trans('select'); ?></label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="select_20" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label">Add In Email</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="checkbox" name="isEmail_20" value="1" class="square-purple">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
					</div>
					
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_and_continue'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.fields
{
	border-radius: 10px;
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
	overflow: hidden;
	border: 2px solid #d1274b;
	padding: 15px;
}

.top-margin
{
	margin-top : 15px;
}

.align_center
{
	text-align :center;
}
</style>

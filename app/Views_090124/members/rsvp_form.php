<div class="header_spons">
	<div class="overlay">
		<h1 class="header_spons_h1">RSVP Event Forms</h1>
	</div>
</div>


<div class="container">
	<div class="row">
		<?= view('partials/_messages'); ?>
	</div>
</div>

<?php

if(!empty($form_data))
{
	
function hasNumberField($form) 
{
	foreach ($form->forms as $field) {
		if ($field->fieldType === 'number') {
			return true;
		}
	}
	return false;
}

foreach ($form_data as $form) {
$hasNumberField = hasNumberField($form);


if($hasNumberField)
{?>
<div class="container">
    <div class="over_container">
        <div class="col-md-12 mb-3 col-sm-12" style="text-align:center;">
            <div class="title">
                <h1 class="picture_gallery_h1"><?= $form->form_name; ?></h1>
            </div>
			
			<?php if(!empty($form->form_sub_name)){?>
				<div class="sub_title">
					<h4 class="">(<?= $form->form_sub_name; ?>)</h4>
				</div>
			<?php }?>
        </div>
		
		<?php if(!empty($form->form_note)){?>
			<div class="row mb-3">
				<div class="col-md-12 col-sm-12">
					<h6 class=""><span class="bold">NOTE </span>: <?= $form->form_note; ?></h6>
				</div>
			</div>
		<?php }?>
		
        <form action="<?= base_url('ProfileController/rsvpEventFormPaymentPost'); ?>" method="post" id="rspForm<?php echo $form->form_id; ?>">
            <?= csrf_field(); ?>

            <?php
            $fieldsCount = count($form->forms);
            for ($i = 0; $i < $fieldsCount; $i += 2) {
                ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <label class="control-label"><?php echo $form->forms[$i]->formLabel; ?></label>
                            <?php if ($form->forms[$i]->fieldType === 'text'): ?>
                                <input type="text" name="<?php echo $form->forms[$i]->formNameAttribute; ?>" placeholder="<?php echo $form->forms[$i]->formLabel; ?>"
                                       <?php echo ($form->forms[$i]->isRequired ? 'required' : ''); ?> class="form-control form-input">
							<?php elseif ($form->forms[$i]->fieldType === 'number'): ?>
								<div class ="row">
								<div class ="col-sm-6 col-md-6">
									<input type="text" placeholder="<?php echo $form->forms[$i]->formLabel; ?>"
                                       <?php echo ($form->forms[$i]->isRequired ? 'required' : ''); ?> class="form-control form-input" value="<?php echo $defaultCurrency->symbol.''.$form->forms[$i]->fieldAmount; ?>" readonly>
								</div>
								<div class ="col-sm-6 col-md-6">
									<div class='item-container'>
										<input type="text" class="form-control form-input number-field<?php echo $form->form_id; ?><?php echo $form->forms[$i]->formNameAttribute; ?>" name="<?php echo $form->forms[$i]->formNameAttribute; ?>" value="<?php echo $form->forms[$i]->fieldAmount; ?>" readonly hidden>
										
										<input type="hidden" value="" id="total<?php echo $form->form_id; ?><?php echo $form->forms[$i]->formNameAttribute; ?>">
										
										<input type="hidden" name ="label<?php echo $form->forms[$i]->formNameAttribute; ?>" value="<?php echo $form->forms[$i]->formLabel; ?>">
										
										 <div class="quantity">
											<a href="#" class="myminus minus<?php echo $form->form_id; ?><?php echo $form->forms[$i]->formNameAttribute; ?>"><span>-</span></a>
											<input name="quantity<?php echo $form->forms[$i]->formNameAttribute; ?>" type="text" class="myqty totalQty<?php echo $form->form_id; ?><?php echo $form->forms[$i]->formNameAttribute; ?>" value="0">
											<a href="#" class="myplus plus<?php echo $form->form_id; ?><?php echo $form->forms[$i]->formNameAttribute; ?>"><span>+</span></a>
										</div>
									</div>
								</div>
								</div>
										
										
							<?php elseif ($form->forms[$i]->fieldType === 'date'): ?>
                                <input type="date" name="<?php echo $form->forms[$i]->formNameAttribute; ?>"
                                       <?php echo ($form->forms[$i]->isRequired ? 'required' : ''); ?> class="form-control form-input">
                            <?php elseif ($form->forms[$i]->fieldType === 'textarea'): ?>
                                <textarea name="<?php echo $form->forms[$i]->formNameAttribute; ?>" placeholder="<?php echo $form->forms[$i]->formLabel; ?>"
                                          <?php echo ($form->forms[$i]->isRequired ? 'required' : ''); ?> class="form-control form-input"></textarea>
                            <?php elseif ($form->forms[$i]->fieldType === 'select'): ?>
                                <select name="<?php echo $form->forms[$i]->formNameAttribute; ?>"
                                        <?php echo ($form->forms[$i]->isRequired ? 'required' : ''); ?> class="form-control form-input">
										<option value="">-SELECT-</option>
                                    <?php foreach ($form->forms[$i]->formSelectAttribute as $option): ?>
                                        <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                        </div>

                        <?php if ($i + 1 < $fieldsCount): ?>
                            <div class="col-md-6 col-sm-12">
                                <label class="control-label"><?php echo $form->forms[$i + 1]->formLabel; ?></label>
                                <?php if ($form->forms[$i + 1]->fieldType === 'text'): ?>
                                    <input type="text" name="<?php echo $form->forms[$i + 1]->formNameAttribute; ?>" placeholder="<?php echo $form->forms[$i + 1]->formLabel; ?>"
                                           <?php echo ($form->forms[$i + 1]->isRequired ? 'required' : ''); ?> class="form-control form-input">
								<?php elseif ($form->forms[$i + 1]->fieldType === 'number'): ?>
									<div class ="row">
									<div class ="col-sm-6 col-md-6">
										<input type="text" placeholder="<?php echo $form->forms[$i + 1]->formLabel; ?>"
                                           <?php echo ($form->forms[$i + 1]->isRequired ? 'required' : ''); ?> class="form-control form-input" value="<?php echo $defaultCurrency->symbol.''.$form->forms[$i + 1]->fieldAmount; ?>" readonly>
									</div>	
									<div class ="col-sm-6 col-md-6">
										<div class="item-container">
											<input type="text" class="form-control form-input number-field<?php echo $form->form_id; ?><?php echo $form->forms[$i + 1]->formNameAttribute; ?>" name="<?php echo $form->forms[$i + 1]->formNameAttribute; ?>" value="<?php echo $form->forms[$i + 1]->fieldAmount; ?>" readonly hidden>
											
											<input type="hidden" value="" id="total<?php echo $form->form_id; ?><?php echo $form->forms[$i + 1]->formNameAttribute; ?>">
											
											<input type="hidden" name ="label<?php echo $form->forms[$i + 1]->formNameAttribute; ?>" value="<?php echo $form->forms[$i + 1]->formLabel; ?>">
											
											
											<div class="quantity">
												<a href="#" class="my2minus minus<?php echo $form->form_id; ?><?php echo $form->forms[$i + 1]->formNameAttribute; ?>"><span>-</span></a>
												<input name="quantity<?php echo $form->forms[$i + 1]->formNameAttribute; ?>" type="text" class="my2qty totalQty<?php echo $form->form_id; ?><?php echo $form->forms[$i + 1]->formNameAttribute; ?>" value="0">
												<a href="#" class="my2plus plus<?php echo $form->form_id; ?><?php echo $form->forms[$i + 1]->formNameAttribute; ?>"><span>+</span></a>
											</div>
										</div>
									</div>
									</div>
								<?php elseif ($form->forms[$i + 1]->fieldType === 'date'): ?>
                                <input type="date" name="<?php echo $form->forms[$i + 1]->formNameAttribute; ?>"
                                       <?php echo ($form->forms[$i + 1]->isRequired ? 'required' : ''); ?> class="form-control form-input">
                                <?php elseif ($form->forms[$i + 1]->fieldType === 'textarea'): ?>
                                    <textarea name="<?php echo $form->forms[$i + 1]->formNameAttribute; ?>" placeholder="<?php echo $form->forms[$i + 1]->formLabel; ?>"
                                              <?php echo ($form->forms[$i + 1]->isRequired ? 'required' : ''); ?> class="form-control form-input"></textarea>
                                <?php elseif ($form->forms[$i + 1]->fieldType === 'select'): ?>
                                    <select name="<?php echo $form->forms[$i + 1]->formNameAttribute; ?>"
                                            <?php echo ($form->forms[$i + 1]->isRequired ? 'required' : ''); ?> class="form-control form-input">
											<option value="">-SELECT-</option>
                                        <?php foreach ($form->forms[$i + 1]->formSelectAttribute as $option): ?>
                                            <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>


                <?php
            }
            ?>
			<?php if(!empty($form->form_note_other)){?>
			<div class="row mb-3">
				<div class="col-md-12 col-sm-12">
					<h6 class=""><span class="bold">NOTE </span>: <?= $form->form_note_other; ?></h6>
				</div>
			</div>
		<?php }?>
            <input type="hidden" name="form_id" value="<?php echo $form->form_id; ?>">
            <input type="hidden" name="is_paypal" value="<?php echo $form->is_paypal; ?>">
            <input type="hidden" name="is_epayment" value="<?php echo $form->is_epayment; ?>">
            <div class="row">
                <div class="col-12 text-right mt-4">
					If payment is not compulsory, please check this checkbox &nbsp;&nbsp;<input type = "checkbox" value="1" name ="payNow">&nbsp;&nbsp;
					Total : <input type="text" class="form-input" id="totalAmount<?php echo $form->form_id; ?>" name ="total_amount" readonly>
                    <button type="submit" class="btn btn-md btn-danger"><?= trans("submit").' & '.trans('pay_now') ?></button>
                </div>
            </div>
        </form> <!-- Closing form tag -->
    </div>
</div>
<script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
<script>
$(document).ready(function() {
    // Initialize the totalAmount to 0
    var totalAmount = 0;
    var total1 = 0;
    var total2 = 0;

    <?php
    $fieldsCount = count($form->forms);
    for ($i = 0; $i < $fieldsCount; $i += 2) {
    ?>
    // First Input Field
    $('.minus<?php echo $form->form_id; ?><?php echo $form->forms[$i]->formNameAttribute; ?>').on('click', function(e) {
        e.preventDefault();
        var value = parseInt($('.totalQty<?php echo $form->form_id; ?><?php echo $form->forms[$i]->formNameAttribute; ?>').val());
        if (value > 0) {
            value--;
        }
        $('.totalQty<?php echo $form->form_id; ?><?php echo $form->forms[$i]->formNameAttribute; ?>').val(value);

        // Calculate and update the totalAmount
        var quantity = value;
        var price = parseFloat($('.number-field<?php echo $form->form_id; ?><?php echo $form->forms[$i]->formNameAttribute; ?>').val());
        var subtotal = quantity * price;
        total1 = subtotal;

        // Update the totalAmount by adding total1 and total2
        totalAmount = total1 + total2;

        // Update the totalAmount field
        $('#totalAmount<?php echo $form->form_id; ?>').val(totalAmount.toFixed(2)); // Format to 2 decimal places
    });

    $('.plus<?php echo $form->form_id; ?><?php echo $form->forms[$i]->formNameAttribute; ?>').on('click', function(e) {
        e.preventDefault();
        var value = parseInt($('.totalQty<?php echo $form->form_id; ?><?php echo $form->forms[$i]->formNameAttribute; ?>').val());
        value++;
        $('.totalQty<?php echo $form->form_id; ?><?php echo $form->forms[$i]->formNameAttribute; ?>').val(value);

        // Calculate and update the totalAmount
        var quantity = value;
        var price = parseFloat($('.number-field<?php echo $form->form_id; ?><?php echo $form->forms[$i]->formNameAttribute; ?>').val());
        var subtotal = quantity * price;
        total1 = subtotal;

        // Update the totalAmount by adding total1 and total2
        totalAmount = total1 + total2;

        // Update the totalAmount field
        $('#totalAmount<?php echo $form->form_id; ?>').val(totalAmount.toFixed(2)); // Format to 2 decimal places
    });

    <?php if ($i + 1 < $fieldsCount): ?>
    // Second Input Field
    $('.minus<?php echo $form->form_id; ?><?php echo $form->forms[$i + 1]->formNameAttribute; ?>').on('click', function(e) {
        e.preventDefault();
        var value = parseInt($('.totalQty<?php echo $form->form_id; ?><?php echo $form->forms[$i + 1]->formNameAttribute; ?>').val());
        if (value > 0) {
            value--;
        }
        $('.totalQty<?php echo $form->form_id; ?><?php echo $form->forms[$i + 1]->formNameAttribute; ?>').val(value);

        // Calculate and update the totalAmount
        var quantity = value;
        var price = parseFloat($('.number-field<?php echo $form->form_id; ?><?php echo $form->forms[$i + 1]->formNameAttribute; ?>').val());
        var subtotal = quantity * price;
        total2 = subtotal;

        // Update the totalAmount by adding total1 and total2
        totalAmount = total1 + total2;

        // Update the totalAmount field
        $('#totalAmount<?php echo $form->form_id; ?>').val(totalAmount.toFixed(2)); // Format to 2 decimal places
    });

    $('.plus<?php echo $form->form_id; ?><?php echo $form->forms[$i + 1]->formNameAttribute; ?>').on('click', function(e) {
        e.preventDefault();
        var value = parseInt($('.totalQty<?php echo $form->form_id; ?><?php echo $form->forms[$i + 1]->formNameAttribute; ?>').val());
        value++;
        $('.totalQty<?php echo $form->form_id; ?><?php echo $form->forms[$i + 1]->formNameAttribute; ?>').val(value);

        // Calculate and update the totalAmount
        var quantity = value;
        var price = parseFloat($('.number-field<?php echo $form->form_id; ?><?php echo $form->forms[$i + 1]->formNameAttribute; ?>').val());
        var subtotal = quantity * price;
        total2 = subtotal;

        // Update the totalAmount by adding total1 and total2
        totalAmount = total1 + total2;

        // Update the totalAmount field
        $('#totalAmount<?php echo $form->form_id; ?>').val(totalAmount.toFixed(2)); // Format to 2 decimal places
    });
    <?php endif; ?>
    <?php
    }
    ?>
});

/*
document.addEventListener("DOMContentLoaded", function() {
    var checkboxes = document.querySelectorAll('input[name="selectedFields<?php echo $form->form_id; ?>[]"]');
    var totalAmountField = document.getElementById("totalAmount<?php echo $form->form_id; ?>");
    var numberFields = document.querySelectorAll('.number-field<?php echo $form->form_id; ?>'); 
	var quantityInputs = document.querySelectorAll('.total<?php echo $form->form_id; ?>');

    checkboxes.forEach(function(checkbox, index) {
        checkbox.addEventListener("change", function() {
            calculateTotal();
        });
    });

    function calculateTotal() {
        var total = 0;
        checkboxes.forEach(function(checkbox, index) {
            if (checkbox.checked) {
                // Get the value of the corresponding number field by index
                var fieldValue = parseFloat(numberFields[index].value);
				console.log(fieldValue);
                if (!isNaN(fieldValue)) {
                    total += fieldValue;
                }
            }
        });
        totalAmountField.value = total.toFixed(2);
    }

    // Calculate the initial total
    calculateTotal();
});

document.getElementById('rspForm<?php echo $form->form_id; ?>').addEventListener('submit', function (e) {
	var checkboxes = document.querySelectorAll('input[type="checkbox"]');
	var isChecked = Array.from(checkboxes).some(function (checkbox) {
		return checkbox.checked;
	});

	if (!isChecked) {
		swal('Info','Please select at least one option.');
		e.preventDefault(); // Prevent form submission
	}
});
*/
</script>
<?php 
}
else
{
?>

<div class="container">
    <div class="over_container">
        <div class="col-md-12 mb-3 col-sm-12" style="text-align:center;">
            <div class="title">
                <h1 class="picture_gallery_h1"><?= $form->form_name; ?></h1>
            </div>
			
			<?php if(!empty($form->form_sub_name)){?>
				<div class="sub_title">
					<h4 class="">(<?= $form->form_sub_name; ?>)</h4>
				</div>
			<?php }?>
        </div>
		
		<?php if(!empty($form->form_note)){?>
			<div class="row mb-3">
				<div class="col-md-12 col-sm-12">
					<h6 class=""><span class="bold">NOTE </span>: <?= $form->form_note; ?></h6>
				</div>
			</div>
		<?php }?>
		
        <form action="<?= base_url('ProfileController/rsvpEventFormPost'); ?>" method="post" id="rspForm<?php echo $form->form_id; ?>">
            <?= csrf_field(); ?>

            <?php
            $fieldsCount = count($form->forms);
            for ($i = 0; $i < $fieldsCount; $i += 2) {
                ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <label class="control-label"><?php echo $form->forms[$i]->formLabel; ?></label>
                            <?php if ($form->forms[$i]->fieldType === 'text'): ?>
                                <input type="text" name="<?php echo $form->forms[$i]->formNameAttribute; ?>" placeholder="<?php echo $form->forms[$i]->formLabel; ?>"
                                       <?php echo ($form->forms[$i]->isRequired ? 'required' : ''); ?> class="form-control form-input">
							<?php elseif ($form->forms[$i]->fieldType === 'date'): ?>
                                <input type="date" name="<?php echo $form->forms[$i]->formNameAttribute; ?>"
                                       <?php echo ($form->forms[$i]->isRequired ? 'required' : ''); ?> class="form-control form-input">
                            <?php elseif ($form->forms[$i]->fieldType === 'textarea'): ?>
                                <textarea name="<?php echo $form->forms[$i]->formNameAttribute; ?>" placeholder="<?php echo $form->forms[$i]->formLabel; ?>"
                                          <?php echo ($form->forms[$i]->isRequired ? 'required' : ''); ?> class="form-control form-input"></textarea>
                            <?php elseif ($form->forms[$i]->fieldType === 'select'): ?>
                                <select name="<?php echo $form->forms[$i]->formNameAttribute; ?>"
                                        <?php echo ($form->forms[$i]->isRequired ? 'required' : ''); ?> class="form-control form-input">
										<option value="">-SELECT-</option>
                                    <?php foreach ($form->forms[$i]->formSelectAttribute as $option): ?>
                                        <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                        </div>

                        <?php if ($i + 1 < $fieldsCount): ?>
                            <div class="col-md-6 col-sm-12">
                                <label class="control-label"><?php echo $form->forms[$i + 1]->formLabel; ?></label>
                                <?php if ($form->forms[$i + 1]->fieldType === 'text'): ?>
                                    <input type="text" name="<?php echo $form->forms[$i + 1]->formNameAttribute; ?>" placeholder="<?php echo $form->forms[$i + 1]->formLabel; ?>"
                                           <?php echo ($form->forms[$i + 1]->isRequired ? 'required' : ''); ?> class="form-control form-input">
								<?php elseif ($form->forms[$i + 1]->fieldType === 'date'): ?>
                                <input type="date" name="<?php echo $form->forms[$i + 1]->formNameAttribute; ?>"
                                       <?php echo ($form->forms[$i + 1]->isRequired ? 'required' : ''); ?> class="form-control form-input">
                                <?php elseif ($form->forms[$i + 1]->fieldType === 'textarea'): ?>
                                    <textarea name="<?php echo $form->forms[$i + 1]->formNameAttribute; ?>" placeholder="<?php echo $form->forms[$i + 1]->formLabel; ?>"
                                              <?php echo ($form->forms[$i + 1]->isRequired ? 'required' : ''); ?> class="form-control form-input"></textarea>
                                <?php elseif ($form->forms[$i + 1]->fieldType === 'select'): ?>
                                    <select name="<?php echo $form->forms[$i + 1]->formNameAttribute; ?>"
                                            <?php echo ($form->forms[$i + 1]->isRequired ? 'required' : ''); ?> class="form-control form-input">
											<option value="">-SELECT-</option>
                                        <?php foreach ($form->forms[$i + 1]->formSelectAttribute as $option): ?>
                                            <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
                <?php
            }
            ?>
			<?php if(!empty($form->form_note_other)){?>
			<div class="row mb-3">
				<div class="col-md-12 col-sm-12">
					<h6 class=""><span class="bold">NOTE </span>: <?= $form->form_note_other; ?></h6>
				</div>
			</div>
		<?php }?>
            <input type="hidden" name="form_id" value="<?php echo $form->form_id; ?>">
            <div class="row">
                <div class="col-12 text-right">
                    <button type="submit" class="btn btn-md btn-danger"><?= trans("submit") ?></button>
                </div>
            </div>
        </form> <!-- Closing form tag -->
    </div>
</div>
<?php }?>
<script>
document.getElementById("rspForm<?php echo $form->form_id; ?>").addEventListener("keypress", function (event) {
  if (event.keyCode === 13) {
    event.preventDefault();
  }
});
</script>
<?php
}

}
else
{
?>
<div class="container">
    <div class="col-md-12 mb-3 col-sm-12" style="text-align:center;">
		<div class="over_container-data">
			<span style="font-size: 35px;color: #219721;font-weight: bold;">RSVP<br>is now closed</span>
		</div>
	</div>
</div>
<?php }?>
<style>
.item-container {
  display: flex;
  align-items: center;
  justify-content: center;
}

.quantity {
  display: flex;
  align-items: center;
  padding: 10px;
}

.myminus,
 .myplus,
 .myqty,
 .my2minus,
 .my2plus,
 .my2qty
 {
  display: inline-block;
  width: 22px;
  height: 25px;
  margin: 0;
  background: #dee0ee;
  text-decoration: none;
  text-align: center;
  line-height: 23px;
  background: #575b71;
  color: #fff;
  border: 1px solid #dee0ee;
  border-radius: 3px;
}
 
.myminus, .my2minus {
  border-radius: 3px 0 0 3px;
}
.myplus, .my2plus {
  border-radius: 0 3px 3px 0;
}
.my2qty, .myqty {
  width: 32px;
  height: 25px;
  margin: 0;
  padding: 0;
  text-align: center;
  border-top: 2px solid #dee0ee;
  border-bottom: 2px solid #dee0ee;
  border-left: 1px solid #dee0ee;
  border-right: 2px solid #dee0ee;
  background: #fff;
  color: #8184a1;
}
.myminus:link,
.myplus:link {
  color: #8184a1;
}

 .my2minus:link,
.my2plus:link {
  color: #8184a1;
} 
.my2minus:visited,
.my2plus:visited {
  color: #fff;
}

.myminus:visited,
.myplus:visited {
  color: #fff;
}

.header_spons 
{
	text-align: center;
	width: 100%;
	height: auto;
	background-size: cover;
	background-attachment: fixed;
	position: relative;
	overflow: hidden;
	border-radius: 0 0 55% 55% / 50%;
}

.header_spons .overlay
{
	width: 100%;
	height: 100%;
	padding: 5px;
	color: #FFF;
	text-shadow: 2px 1px 2px #a6a6a6;
	background: #d1274b;
	
}

header_spons_h1 
{
	font-size: 35px;
	margin-bottom: 30px;
}

.over_container
{
	border-radius: 10px;
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
	overflow: hidden;
	margin: 20px;
	border: 2px solid #d1274b;
	padding : 25px !important;
}

.over_container-data
{
	border-radius: 50px;
	box-shadow: rgba(0, 0, 0, 0.15) 0px 15px 25px, rgba(0, 0, 0, 0.05) 0px 5px 10px;
	overflow: hidden;
	margin: 20px;
	border: 2px solid #d1274b;
	padding : 25px !important;
}

.picture_gallery_h1
{
	font-size: 40px;
	display: inline-block;
	border-bottom: 5px solid #d1274b;
}

.title
{
	text-align: center;
}

.sub_title
{
	color : #5e5b5b;
}

.bold
{
	font-weight : bold;
}
</style>
<?php 
helperDeleteSession('modesy_rsvp_form_id');
helperDeleteSession('mds_membership_bank_transaction_number');
helperDeleteSession('mds_membership_transaction_insert_id'); 
helperDeleteSession('formID'); 
helperDeleteSession('rsvpAmount'); 
helperDeleteSession('label18'); 
helperDeleteSession('label19'); 
helperDeleteSession('label20'); 
helperDeleteSession('quantitytext18'); 
helperDeleteSession('quantitytext19'); 
helperDeleteSession('quantitytext20'); 
helperDeleteSession('rsvpSubmitId'); 
helperDeleteSession('is_paypal'); 
helperDeleteSession('is_epayment');
?>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title">Member Migration</h3>
        </div>
		<?php if(!empty($uploaded_data)){ ?>
		<div class="right">
			<a href="<?= adminUrl('users-migration'); ?>" class="btn btn-success">
				<i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;<?= trans('back'); ?>
			</a>
		</div>
		<?php } ?>
    </div>
    <div class="box-body">
        <div class="row">
			<?php if(empty($uploaded_data)){ ?>
				<div class="col-xs-12 col-lg-4 col-sm-12 col-md-4">
                <div class="box-data">
					<form action="<?= base_url('MembershipController/do_excel_import_members'); ?>" method="post" enctype="multipart/form-data">
					<?= csrf_field(); ?>
						<h3 class="heading-data">Members Import</h3>
						<ul id="error_message_box"></ul>
						<span style="font-size: 14px;font-weight: bold;">Click Here : <i class="fa fa-hand-o-right" style="font-size:15px"></i></span>
						<b><a href="<?= base_url('MembershipController/excel_member_template'); ?>">Download Import Template(CSV)</a></b>
						<br>
						<br>
						<div class="form-group">
							<label class="control-label"><?= trans('upload_file'); ?></label> 
							<div class="display-block">
								<a class='btn btn-success btn-md btn-file-upload'>
									<?= trans('browse_file'); ?>
									<input type="file" name="file_path" accept=".csv" onchange="$('#upload-file-info2').html($(this).val());" required>
								</a>
								(.csv)
							</div>
							<span class='label label-info' id="upload-file-info2"></span>
						</div>
						<div class = "row">
							<div class = "col-md-12 align-right">
								<button type="submit" class="btn btn-primary pull-right">Submit</button>
							</div>
						</div>
					</form>
				</div>  
				</div>  
				<div class="col-xs-12 col-lg-12 col-sm-12 col-md-12">
				<?php }
						else
						{						
						?>
						<form action="<?= base_url('MembershipController/do_excel_import_from_screen_members'); ?>" method="post">
						<?= csrf_field(); ?>
							<h3 class="heading-data"> Kindly check and submit your imported data</h3>
							<div class="table-responsive">
							<table width="100%" class="table table-bordered">
							<thead class="bg-primary text-white">
							<tr>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Email</th>
								<th>Membership Type</th>
								<th>Membership Validity</th>
								<th>Membership Duration</th>
							</tr>
							</thead>
							<tbody>
							<?php 
								foreach($uploaded_data as $data) { 
								?>
									<tr>
										<td><input type="text" class="form-control" name="First_Name[]" value="<?php echo $data['First_Name']; ?>"></td>
										<td><input type="text" class="form-control" name="Last_Name[]" value="<?php echo $data['Last_Name']; ?>"></td>
										<td><input type="text" class="form-control" name="Email[]" value="<?php echo $data['Email']; ?>"></td>
										<td><input type="text" class="form-control" name="Membership_type[]" value="<?php echo $data['Membership_type']; ?>"></td>
										<td><input type="text" class="form-control" name="Membership_Validity[]" value="<?php echo $data['Membership_Validity']; ?>"></td>
										<td><input type="text" class="form-control" name="Duration[]" value="<?php echo $data['Duration']; ?>"></td>
									</tr>
							<?php } ?>
							</tbody>
							</table>
							</div>
							<br>
							<div class = "row">
								<div class = "col-md-12 align-right">
									<button type="submit" class="btn btn-primary pull-right">Submit</button>
								</div>
							</div>
						</form>
            </div>
						<?php }?>
        </div>
    </div>
</div>

<style>
.box-data
{
	padding: 15px !important;
	border: 2px solid #d1274b;
	margin: 10px;
	border-radius: 10px;
	box-shadow: 10px 10px 10px 10px #adadad6e;
}

.heading-data
{
	text-align: center;
  font-weight: bold;
  margin-top: 0px !important;
  margin-bottom: 25px !important;
}
</style>

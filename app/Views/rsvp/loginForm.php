<style>
.header_spons {
	text-align: center;
	width: 100%;
	height: auto;
	background-size: cover;
	background-attachment: fixed;
	position: relative;
	overflow: hidden;
	border-radius: 0 0 55% 55% / 50%;
}
.header_spons .overlay{
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

.row_padding
{
	padding: 30px !important;
  border: 2px solid #d1274b;
  margin: 10px;
  border-radius: 10px;
  box-shadow: 10px 10px 10px 10px #adadad6e;
}
.red 
{
	color : red;
	float : right;
}
</style>
	
<div class="header_spons">
	<div class="overlay">
		<h1 class="header_spons_h1">Login Form</h1>
	</div>
</div>

<div class="container">
	<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4 row_padding">
				<span class="red">Kindly fill the form</span>
				<form id="form_register_2" novalidate="novalidate" method ="post">
					<div class="form-group">
						<label>First Name :</label>
						<input type="text" name="fname" class="form-control auth-form-input" placeholder="First Name" maxlength="255" required>
					</div>
					
					<div class="form-group">
						<label>Last Name :</label>
						<input type="text" name="lname" class="form-control auth-form-input" placeholder="Last Name" maxlength="255">
					</div>
					 
					<div class="form-group">
						<label>Primary Phone Number :</label>
						<input type="text" name="phone" class="form-control" placeholder="Phone Number" maxlength="255" required>
					</div>
					
					<div class="form-group">
						<label>Primary Email :</label>
						<input type="email" name="email" class="form-control auth-form-input" placeholder="<?= trans("email_address"); ?>" maxlength="255" required>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-md btn-danger btn-block">Submit</button>
					</div>
				</form>
			</div>
			<div class="col-md-4"></div>
	</div>
</div>
<div class="banner">
    <div class="dark-overlay"></div>
	<img src="<?= base_url().'/'.esc($generalSettings->library_image); ?>" alt="Background Image" class="background-image">
    <div class="content">
			<!-- Centered text 
    <div class="centered-text">
        <h1 id="typing-animation">ABC Library</h1>
    </div>-->
    </div>
</div>

<style>
#typing-animation
{
	font-size : 80px;
}
.centered-text 
{
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	text-align: center;
	color: white;
	font-size: 36px;
	font-weight: bold;
	filter: drop-shadow(2px 4px 6px black);
    background-color: rgba(152, 151, 151, 0.2); 
    box-shadow: inset 0 0 0 200px rgb(255, 255, 255, 0.08);
}
  .banner 
  {
  position: relative;
  height: 35vh; /* Adjust the height as needed */
  overflow: hidden;
}

.dark-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-position: center bottom;
}

.background-image {
  //position: relative;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: top;
}

.content {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  margin-top : 3vh;
}

/* Add media queries for responsive adjustments */
@media (max-width: 768px) {
  .content {
    flex-direction: column;
  }
}


</style>


<div class="event-schedule-area-two bg-color pad100 mt-3 mb-3">
    <div class="container">
        <div class="row">
			<?php if(!empty($books))
			{ ?>
            <div class="col-lg-12">
				<div class="tab-content" id="myTabContent">
					<div class="col-lg-12" style="text-align : center;">
						<div class="title">
							<h1 class="picture_gallery_h1">Search Books by Category</h1>
						</div>
					</div>
					<div class="col-lg-12">
						<form id="filterForm">
							<div class="form-row">
								<div class="col-md-4 mb-3">
									<label><?= trans('parent_category'); ?></label>
									<select class="form-control" name="category_id" required id="parent_category">
										<option value="" selected>--SELECT--</option>
										<?php if (!empty($categories)):
											foreach ($categories as $parentCategory):
											?>
												<option value="<?= $parentCategory->id; ?>"><?= $parentCategory->catgeoryName; ?></option>
											<?php endforeach;
										endif; ?>
									</select>
								</div>
								<div class="col-md-4 mb-3">
									<div class="form-group" id="sub_category_container" style="display: none;">
										<label>Sub Category</label>
										<select class="form-control" name="sub_category" id="sub_category" required>
										</select>
									</div>
								</div>
								<div class="col-md-4 mb-3">
									<label>&nbsp;</label>
									<button class="btn btn-sm btn-danger" style="font-size: 14px;padding: 11px;margin-top: 20px;" type="submit">Filter</button>
								</div>
							</div>
						</form>
					</div>
                <div class="tab-pane fade active show" id="home" role="tabpanel">
				<div class="table-responsive" style="max-height : 80vh;">
					<table class="table" id="bookTable">
						<thead>
							<tr>
								<th class="text-center" scope="col">S.No</th>
								<th scope="col">Cover Image</th>
								<th scope="col">Title</th>
								<th class="text-center" scope="col">Details</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i= 1;
							foreach ($books as $book): ?>
								<tr class="inner-box">
									<th scope="row">
										<p><?= $i; ?></p>
									</th>
									<td>
										<div class="event-img">
											<?php if(!empty($book->coverImage))
											{ ?>
												<img src="<?= base_url().'/'.$book->coverImage; ?>" alt="Cover Image" />
											<?php } 
											else
											{ ?>
												<img src="<?= getLogo(); ?>" alt="ABC Logo" />
											<?php } ?>
											
										</div>
									</td>
									<td>
										<div class="event-wrap">
											<h3><?= htmlspecialchars($book->name); ?></h3>
										</div>
									</td>
									<td>
										<div class="primary-btn">	
											<a target= "_blank" class="btn btn-sm btn-danger" style="font-size: 14px;padding: 11px;border-radius: 50px;" href="<?= base_url().'/'.esc($book->file_path); ?>">Read More</a>
										</div>
									</td>
								</tr>
							<?php 
							$i++;
							endforeach; ?>
						</tbody>
					</table>
				</div>
				</div>
				</div>
            </div>
			<?php }
			else
			{ ?>
				<div class="col-md-3 mb-3"></div>
				<div class="col-md-6 mb-3 mt-4 col-sm-12">
					<div class="title">
						<h1 class="picture_gallery_h1">Libray is Empty</h1>
					</div>
				</div>
				<div class="col-md-3 mb-3"></div>
				<div class="col-md-12 text_center">
					 <img src="<?= base_url('assets/images_agarwal/stay_tuned.png'); ?>" class="img-fluid" alt="Stay Tuned">
				</div>
			<?php } ?>
            <!-- /col end-->
        </div>
        <!-- /row end-->
    </div>
</div>

<script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
<script>
function setAjaxData(object = null) {
    var data = {
        'sysLangId': MdsConfig.sysLangId,
    };
    data[MdsConfig.csrfTokenName] = $('meta[name="X-CSRF-TOKEN"]').attr('content');
    if (object != null) {
        Object.assign(data, object);
    }
    return data;
}

$(document).ready(function () {
	$('#parent_category').val('');
	document.getElementById('parent_category').addEventListener('change', function () {
	 
		var parentCategoryId = this.value;
		
		if(parentCategoryId == '')
		{
			 var subCategoryContainer = document.getElementById('sub_category_container');
			subCategoryContainer.style.display = 'none';
			$('#sub_category').empty();
			return false;
		}
		// Get the sub-category container
		var subCategoryContainer = document.getElementById('sub_category_container');

		if (parentCategoryId === '0') {
			// If the parent category is set to "None," hide the sub-category container
			subCategoryContainer.style.display = 'none';
		} else {
			// If a parent category is selected, show the sub-category container
			subCategoryContainer.style.display = 'block'; // You can also use 'inline' or 'inline-block' if needed
		}
		
		var subCategoryDropdown = document.getElementById('sub_category');
		
		var data = {
			'parent_id': parentCategoryId
		};
		$.ajax({
			url: MdsConfig.baseURL + '/SponsorshipController/getSubcategoryLibararyData',	
			data: setAjaxData(data),
			type: 'POST',
			dataType: 'json',
			success: function (data) {
				
				$('#sub_category').empty();
				
				if (data.length === 0) {
					subCategoryContainer.style.display = 'none';
					subCategoryDropdown.removeAttribute('required');
					subCategoryDropdown.removeAttribute('name');
					swal('Information','It is general category you can search the data using filter button','info');
					
				} else {
					$.each(data, function (key, value) {
						$('#sub_category').append($('<option>', {
							value: value.id,
							text: value.catgeoryName
						}));
					});
				}
			},
			error: function () {
				swal('Warning','No Related Data Found','info');
			}
		});
	});
});

$('#filterForm').submit(function (e) {
    e.preventDefault(); 
    
    var selectedParentCategory = $('#parent_category').val();
    var selectedSubCategory = $('#sub_category').val();
    
    var data = {
			'parent_id': selectedParentCategory,
			'sub_category_id': selectedSubCategory,
		};
		$.ajax({
			url: MdsConfig.baseURL + '/SponsorshipController/getSlectedLibararyData',	
			data: setAjaxData(data),
			type: 'POST',
			dataType: 'json',
			success: function (filteredData) {
				
				$('#bookTable tbody').empty();
				var rowNum = 1;
				$.each(filteredData, function (key, book) {
					var row = '<tr class="inner-box">' +
						'<th scope="row">' + rowNum + '</th>' +
						'<td><div class="event-img"><img src="' + book.coverImage + '" alt="Cover Image" /></div></td>' +
						'<td><div class="event-wrap"><h3>' + book.name + '</h3></div></td>' +
						'<td><div class="r-no">' + book.description + '</div></td>' +
						'<td><div class="primary-btn"><a target="_blank" class="btn btn-sm btn-danger" style="font-size: 14px;padding: 11px;border-radius: 50px;" href="' + book.file_path + '">Read More</a></div></td>' +
						'</tr>';

					$('#bookTable tbody').append(row);
					rowNum++;
				});
			},
			error: function () {
				swal('Warning','No Related Data Found','info');
			}
		});
});

</script>
<style>

#home
{
	box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
	margin-top: 15px;
}

.tab-content
{
	padding: 30px !important;
  border: 2px solid #d1274b;
  margin: 10px;
  border-radius: 10px;
  box-shadow: 10px 10px 10px 10px #adadad6e;
}
.picture_gallery_h1
 {
  font-size: 28px;
  display: inline-block;
  border-bottom: 5px solid #d1274b;
}
.title
{
	text-align: center;
}

.text_center
{
	text-align : center;
}

.btn_width
{
	width : 65%;
}


.form-control-label{margin-bottom: 0}
.input, textarea {padding: 8px 15px;border-radius: 5px !important;margin: 5px 0px;box-sizing: border-box;border: 1px solid #ccc;font-size: 18px !important;font-weight: 300}
.input:focus, textarea:focus{-moz-box-shadow: none !important;-webkit-box-shadow: none !important;box-shadow: none !important;outline-width: 0;font-weight: 400}

.align_right
{
	text-align : right;
}
.form_container 
{
	 background: url("<?= base_url('assets/images_agarwal/sponsorship_enquiry.jpg') ?>");   
    background-size: cover;
}


.btn-radius 
	{
		border-radius: 100px !important;
	}
	.btn 
	{
		color:white;
		font-size: 13px;
		font-weight: bold;
		letter-spacing: 1px;
		border-radius: 2px;
		padding: 13px 28px;
		text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.14);
		text-transform: uppercase;
		box-shadow: 0 4px 9px 0 rgba(0, 0, 0, 0.2);
	}

	.btn-lg 
	{
		padding: 18px 49px;
	}
	.btn-danger{
    background: #e81216;
    background: -moz-linear-gradient(-45deg, #e81216 0%, #f45355 50%, #f6290c 51%, #ed0e11 71%, #fc1b21 100%);
    background: -webkit-linear-gradient(-45deg, #e81216 0%,#f45355 50%,#f6290c 51%,#ed0e11 71%,#fc1b21 100%);
    background: linear-gradient(135deg, #e81216 0%,#f45355 50%,#f6290c 51%,#ed0e11 71%,#fc1b21 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e81216', endColorstr='#fc1b21',GradientType=1 );
    background-size: 400% 400%;
    -webkit-animation: AnimationName 3s ease infinite;
    -moz-animation: AnimationName 3s ease infinite;
    animation: AnimationName 3s ease infinite;
    -webkit-animation: AnimationName 3s ease infinite;
    -moz-animation: AnimationName 3s ease infinite;
    animation: AnimationName 3s ease infinite;
    border: medium none;
}
@-webkit-keyframes AnimationName 
	{
		0%{
			background-position:0% 31%
		}
		50%{
			background-position:100% 70%
		}
		100%{
			background-position:0% 31%
		}
	}
	@-moz-keyframes AnimationName 
	{
		0%{
			background-position:0% 31%
		}
		50%{
			background-position:100% 70%
		}
		100%{
			background-position:0% 31%
		}
	}
	@keyframes AnimationName 
	{
		0%{
			background-position:0% 31%
		}
		50%{
			background-position:100% 70%
		}
		100%{
			background-position:0% 31%
		}
	}
	.event-schedule-area .tab-area .nav-tabs {
    border-bottom: inherit;
}

.event-schedule-area .tab-area .nav {
    border-bottom: inherit;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    margin-top: 80px;
}

.event-schedule-area .tab-area .nav-item {
    margin-bottom: 75px;
}
.event-schedule-area .tab-area .nav-item .nav-link {
    text-align: center;
    font-size: 22px;
    color: #333;
    font-weight: 600;
    border-radius: inherit;
    border: inherit;
    padding: 0px;
    text-transform: capitalize !important;
}
.event-schedule-area .tab-area .nav-item .nav-link.active {
    color: #4125dd;
    background-color: transparent;
}

.event-schedule-area .tab-area .tab-content .table {
    margin-bottom: 0;
    width: 80%;
}
.event-schedule-area .tab-area .tab-content .table thead td,
.event-schedule-area .tab-area .tab-content .table thead th {
    border-bottom-width: 1px;
    font-size: 20px;
    font-weight: 600;
    color: #252525;
}
.event-schedule-area .tab-area .tab-content .table td,
.event-schedule-area .tab-area .tab-content .table th {
    border: 1px solid #b7b7b7;
    padding-left: 30px;
}
.event-schedule-area .tab-area .tab-content .table tbody th .heading,
.event-schedule-area .tab-area .tab-content .table tbody td .heading {
    font-size: 16px;
    text-transform: capitalize;
    margin-bottom: 16px;
    font-weight: 500;
    color: #252525;
    margin-bottom: 6px;
}
.event-schedule-area .tab-area .tab-content .table tbody th span,
.event-schedule-area .tab-area .tab-content .table tbody td span {
    color: #4125dd;
    font-size: 18px;
    text-transform: uppercase;
    margin-bottom: 6px;
    display: block;
}
.event-schedule-area .tab-area .tab-content .table tbody th span.date,
.event-schedule-area .tab-area .tab-content .table tbody td span.date {
    color: #656565;
    font-size: 14px;
    font-weight: 500;
    margin-top: 15px;
}
.event-schedule-area .tab-area .tab-content .table tbody th p {
    font-size: 14px;
    margin: 0;
    font-weight: normal;
}

.event-schedule-area-two .section-title .title-text h2 {
    margin: 0px 0 15px;
}

.event-schedule-area-two ul.custom-tab {
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    border-bottom: 1px solid #dee2e6;
    margin-bottom: 30px;
}
.event-schedule-area-two ul.custom-tab li {
    margin-right: 70px;
    position: relative;
}
.event-schedule-area-two ul.custom-tab li a {
    color: #252525;
    font-size: 25px;
    line-height: 25px;
    font-weight: 600;
    text-transform: capitalize;
    padding: 35px 0;
    position: relative;
}
.event-schedule-area-two ul.custom-tab li a:hover:before {
    width: 100%;
}
.event-schedule-area-two ul.custom-tab li a:before {
    position: absolute;
    left: 0;
    bottom: 0;
    content: "";
    background: #4125dd;
    width: 0;
    height: 2px;
    -webkit-transition: all 0.4s;
    -o-transition: all 0.4s;
    transition: all 0.4s;
}
.event-schedule-area-two ul.custom-tab li a.active {
    color: #4125dd;
}

.event-schedule-area-two .primary-btn {
    margin-top: 40px;
}

.event-schedule-area-two .tab-content .table {
    -webkit-box-shadow: 0 1px 30px rgba(0, 0, 0, 0.1);
    box-shadow: 0 1px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: 0;
}
.event-schedule-area-two .tab-content .table thead {
    background-image: linear-gradient(to top, #4481eb 0%, #04befe 100%);
    color: #fff;
    font-size: 20px;
}
.event-schedule-area-two .tab-content .table thead tr th {
    padding: 20px;
    border: 0;
}
.event-schedule-area-two .tab-content .table tbody {
    background: #fff;
}
.event-schedule-area-two .tab-content .table tbody tr.inner-box {
    border-bottom: 2px solid #dee2e6;
}
.event-schedule-area-two .tab-content .table tbody tr th {
    border: 0;
    padding: 30px 20px;
    vertical-align: middle;
}
.event-schedule-area-two .tab-content .table tbody tr th .event-date {
    color: #252525;
    text-align: center;
}
.event-schedule-area-two .tab-content .table tbody tr th .event-date span {
    font-size: 50px;
    line-height: 50px;
    font-weight: normal;
}
.event-schedule-area-two .tab-content .table tbody tr td {
    padding: 30px 20px;
    vertical-align: middle;
}
.event-schedule-area-two .tab-content .table tbody tr td .r-no span {
    color: #252525;
}
.event-schedule-area-two .tab-content .table tbody tr td .event-wrap h3 a {
    font-size: 20px;
    line-height: 20px;
    color: #cf057c;
    -webkit-transition: all 0.4s;
    -o-transition: all 0.4s;
    transition: all 0.4s;
}
.event-schedule-area-two .tab-content .table tbody tr td .event-wrap h3 a:hover {
    color: #4125dd;
}
.event-schedule-area-two .tab-content .table tbody tr td .event-wrap .categories {
    display: -webkit-inline-box;
    display: -ms-inline-flexbox;
    display: inline-flex;
    margin: 10px 0;
}
.event-schedule-area-two .tab-content .table tbody tr td .event-wrap .categories a {
    color: #252525;
    font-size: 16px;
    margin-left: 10px;
    -webkit-transition: all 0.4s;
    -o-transition: all 0.4s;
    transition: all 0.4s;
}
.event-schedule-area-two .tab-content .table tbody tr td .event-wrap .categories a:before {
    content: "\f07b";
    font-family: fontawesome;
    padding-right: 5px;
}
.event-schedule-area-two .tab-content .table tbody tr td .event-wrap .time span {
    color: #252525;
}
.event-schedule-area-two .tab-content .table tbody tr td .event-wrap .organizers {
    display: -webkit-inline-box;
    display: -ms-inline-flexbox;
    display: inline-flex;
    margin: 10px 0;
}
.event-schedule-area-two .tab-content .table tbody tr td .event-wrap .organizers a {
    color: #4125dd;
    font-size: 16px;
    -webkit-transition: all 0.4s;
    -o-transition: all 0.4s;
    transition: all 0.4s;
}
.event-schedule-area-two .tab-content .table tbody tr td .event-wrap .organizers a:hover {
    color: #4125dd;
}
.event-schedule-area-two .tab-content .table tbody tr td .event-wrap .organizers a:before {
    content: "\f007";
    font-family: fontawesome;
    padding-right: 5px;
}
.event-schedule-area-two .tab-content .table tbody tr td .primary-btn {
    margin-top: 0;
    text-align: center;
}
.event-schedule-area-two .tab-content .table tbody tr td .event-img img {
    width: 100px;
    height: 100px;
}
</style>

<script>
	/*This code is for animation of typing animation 
		----Start---
	*/
    /* document.addEventListener('DOMContentLoaded', function() 
	{
		const text = 'ABC Library';
		const typingAnimationElement = document.getElementById('typing-animation');
		let index = 0;

		function type() 
		{
			if (index < text.length) 
			{
				typingAnimationElement.textContent += text.charAt(index);
				index++;
				setTimeout(type, 100);
			} 
			else 
			{
				setTimeout(function() 
				{
					typingAnimationElement.textContent = '';
					index = 0;
					type();
				}, 2000); // Pause for 2 seconds before repeating
			}
		}

		type();
    }); */
	/*
		----End---
	*/
	

</script>
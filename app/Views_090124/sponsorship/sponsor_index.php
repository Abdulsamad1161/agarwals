 <style>

        .container_spons {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }

        .content_spons {
            flex-basis: calc(60% - 20px);
            padding: 20px;
        }

        .content_spons h2 {
            margin-top: 0;
        }

        .content_spons p {
            line-height: 1.6;
        }

        .image_spons {
            flex-basis: calc(40% - 20px);
            overflow: hidden;
            position: relative;
			  animation: slideInFromBottom 2s forwards; /* Animation applied */
        }

        .image_spons img {
            width: 100%;
            height: auto;
            display: block;
           // opacity : 0;
        }
		
		@keyframes slideInFromBottom {
           0% {
                transform: translateY(100%);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

       
        @media (max-width: 768px) {
            .container_spons {
                flex-direction: column;
            }

            .content_spons,
            .image_spons {
                flex-basis: 100%;
            }
        }
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

header_spons_h5 
{
	margin-bottom: 10px;
}
.content_spons p
{
	font-size : 18px;
}

.red
{
	color :	#d1274b !important;
	animation: slideInFromLeft 4s forwards;
}

@keyframes slideInFromLeft {
            0% {
                transform: translateX(-100%);
                opacity: 0;
            }
            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
	
<div class="header_spons">
	<div class="overlay">
		<h1 class="header_spons_h1"><?= trans("sponsorship");?></h1>
	</div>
</div>

<div class="container_spons">
	<div class="content_spons">
		<h3>Sponsorship Opportunities : </h3>
		<p>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Agarwals Based in Canada (ABC) is a registered Not-For-Profit entity founded in 1997 with the goals of promoting social, cultural, spiritual and economic growth of Agarwals in Canada, so as to build a
			prosperous and successful community. Members of the organization are known for reaching high levels of achievement in academic, artistic, business and government enterprises.
		</p>
		
		<h5 class="header_spons_h4">ABC continues to extend its values in Canada by:</h5>
		<p>
			&emsp;&emsp;<i class="fa fa-angle-right red" aria-hidden="true"></i>&emsp;&emsp;Giving back to community: Heart and Stroke foundation, Terry Fox Run and Food Bank<br>

			&emsp;&emsp;<i class="fa fa-angle-right red" aria-hidden="true"></i>&emsp;&emsp;Promoting Art and cultural heritage by organizing social events<br>

			&emsp;&emsp;<i class="fa fa-angle-right red" aria-hidden="true"></i>&emsp;&emsp;Providing networking and relationship building opportunities to newcomers to Canada<br>

			&emsp;&emsp;<i class="fa fa-angle-right red" aria-hidden="true"></i>&emsp;&emsp;Growing culturally and economically<br>

			&emsp;&emsp;<i class="fa fa-angle-right red" aria-hidden="true"></i>&emsp;&emsp;Organizing community events for youth and seniors<br>
		</p>
		
		<p>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ABC has a strong base of more than 500 members across Canada and continues to grow every year. There are over 1200 Agarwal families living in and around Greater Toronto Area that attend various events organized by ABC during the year. Our typical events are:
		</p>
		
		<p>
			&emsp;&emsp;<i class="fa fa-angle-right red" aria-hidden="true"></i>&emsp;&emsp;Members’ Appreciation Day<br>
			&emsp;&emsp;<i class="fa fa-angle-right red" aria-hidden="true"></i>&emsp;&emsp;Holi Celebrations<br>
			&emsp;&emsp;<i class="fa fa-angle-right red" aria-hidden="true"></i>&emsp;&emsp;Eco-Cleaning of Temple<br>
			&emsp;&emsp;<i class="fa fa-angle-right red" aria-hidden="true"></i>&emsp;&emsp;India day festival and grand parade<br>
			&emsp;&emsp;<i class="fa fa-angle-right red" aria-hidden="true"></i>&emsp;&emsp;Summer Picnic<br>
			&emsp;&emsp;<i class="fa fa-angle-right red" aria-hidden="true"></i>&emsp;&emsp;Youth and senior Activities<br>
			&emsp;&emsp;<i class="fa fa-angle-right red" aria-hidden="true"></i>&emsp;&emsp;Terry Fox Run<br>
			&emsp;&emsp;<i class="fa fa-angle-right red" aria-hidden="true"></i>&emsp;&emsp;Annual Gala<br>
		</p>
		
	</div>
        <div class="image_spons">
            <img src="<?= base_url().'/'.$sponsorship->image_path; ?>" alt="image_spons 1">
        </div>
    </div>
	
	<div class="container_spons">
	<div class="content_spons">
		<p>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The document on right offers description of various sponsorship packages and the benefits your organization can draw by becoming an Annual Gala sponsor. Please contact any one of the undersigned if you have any questions or require additional details about ABC or the event. Alternatively you may also fill out Sponsorship Enquiry form and we will get back to you.
		</p>
		
	</div>
        <div class="image_spons">
			<div class="col-12 text_center">
			
				<h3><?= $sponsorship->btn_name; ?></h3>
				<p>
					<a class="btn btn-danger btn-lg btn-radius btn_width" target="_blank" href="<?= base_url().'/'.esc($sponsorship->file_path); ?>"><?= $sponsorship->btn_name; ?></a>
				</p>
				<p>
					<button type="submit" class="btn btn-danger btn-lg btn-radius btn_width" onclick ="redirectToOurSponsor()">Meet Our Current Sponsors</button>
				</p>
			</div>
        </div>
    </div>


	
<div class="container-fluid px-1 py-5 mx-auto form_container">
	
    <div class="row d-flex justify-content-center">
        <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
            <div class="card">
                <h3 class="text-center mb-4">Sponsorship Enquiry</h3>
                <form action="<?= base_url('SponsorshipController/sendSponsorshipEnquiryPost'); ?>" method="post" id="sponsorshipEnquiryForm" class="form-card">
					<?= csrf_field(); ?>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">First name<span class="text-danger"> *</span></label> <input class="input" type="text" id="fname" name="first_name" placeholder="Enter your first name" required> </div>
                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Last name</label> <input class="input" type="text" id="lname" name="last_name" placeholder="Enter your last name" > </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Business email<span class="text-danger"> *</span></label> <input class="input" type="text" id="email" name="email" placeholder="Enter your Email" required> </div>
                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Phone number<span class="text-danger"> *</span></label> <input class="input" type="text" id="mob" name="phone_number" placeholder="Enter your phone number" required> </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-12 flex-column d-flex"> <label class="form-control-label px-3">Company<span class="text-danger"> *</span></label> <input class="input" type="text" id="company" name="company" placeholder="Enter your company name" required> </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 flex-column d-flex"> <label class="form-control-label px-3">Message<span class="text-danger"> *</span></label> <textarea class="form-control form-input" id="message" name="message" rows="4" placeholder = "<?= trans('message');?>" required></textarea> </div>
                    </div>
                    <div class="row justify-content-end">
						<input type="text" id="email_address" name="email_address" style="display: none;">
                        <div class="form-group col-sm-6 align_right"> <button type="submit" class="btn btn-danger btn-lg btn-radius">Submit</button> </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>

<script>
$(document).ready(function() {
    $('#sponsorshipEnquiryForm').submit(function(event) {
		event.preventDefault(); // Preventing default form submission

		$.ajax({
			type: 'POST',
			url: $(this).attr('action'), 
			data: $(this).serialize(),
			dataType: 'json',
			success: function(response) {
				if (response == 'updated'){
					swal({
					title: 'Submitted Successfully!',
					text: 'Thank you for showing interest, Our Team Will connect you shortly.'
					}).then(function() {
						 window.location.reload();
					});
				} 
				else if(response == 'spam')
				{
					swal({
					title: 'Sorry!',
					text: 'You are not allowed to submit the form!'
					}).then(function() {
						window.location.reload();
					});
				}
				else {
					swal({
						title: 'Submission Failed!',
						text: 'Server reported a failure.',
					});
				}
			},
			error: function(xhr, status, error) {
				swal({
					title: 'Submission Failed!',
					text: 'Kindly check the filled data!',
				});
			}
		});

	});
});

function redirectToOurSponsor()
{
	window.location.href = "<?= base_url('SponsorshipController/ourSponsors'); ?>";
}
</script>

<style>
.text_center
{
	text-align : center;
}

.btn_width
{
	width : 65%;
}

.card{padding: 30px 40px;margin-top: 60px;margin-bottom: 60px;border: none !important;box-shadow: 0 6px 12px 0 rgba(0,0,0,0.2)}

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
</style>
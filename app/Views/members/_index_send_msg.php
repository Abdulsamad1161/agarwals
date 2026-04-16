<div class="modal fade" id="messageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-send-message" role="document">
        <div class="modal-content">
            <form id="form_send_message" novalidate="novalidate" class="form_message">
                <input type="hidden" name="receiver_id" id="message_receiver_id" value="<?= $user->id; ?>">
                <input type="hidden" id="message_send_em" value="<?= $user->send_email_new_message; ?>">
                <?php if (!empty($productId)): ?>
                    <input type="hidden" name="product_id" value="<?= $productId; ?>">
                <?php endif; ?>
                <div class="modal-header">
					<div class="title">
						<h1 class="picture_gallery_h1"><?= trans("send_message"); ?></h1>
					</div>
                    <button type="button" class="close" data-dismiss="modal" id="redirectToMembers"><i class="icon-close"></i></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div id="send-message-result"></div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="user-contact-modal">
                                            <div class="left">
                                                <a href="<?= generateProfileUrl($user->slug); ?>"><img src="<?= getUserAvatar($user); ?>" alt="<?= esc(getUsername($user)); ?>"></a>
                                            </div>
                                            <div class="right">
                                                <strong><a href="<?= generateProfileUrl($user->slug); ?>"><?= esc(getUsername($user)); ?></a></strong>
                                                <?php if ($generalSettings->hide_vendor_contact_information != 1):
                                                    if (!empty($user->phone_number) && $user->show_phone == 1): ?>
                                                        <p class="info">
                                                            <i class="icon-phone red"></i><a href="javascript:void(0)" id="show_phone_number"><?= trans("show"); ?></a>
                                                            <a href="tel:<?= esc($user->phone_number); ?>" id="phone_number" class="display-none"><?= esc($user->phone_number); ?></a>
                                                        </p>
                                                    <?php endif;
                                                    if (!empty($user->email) && $user->show_email == 1): ?>
                                                    <p class="info"><i class="icon-envelope red"></i><?= esc($user->email); ?></p>
                                                <?php endif;
                                                endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?= trans("subject"); ?></label>
                                <input type="text" name="subject" id="message_subject" value="<?= !empty($subject) ? esc($subject) : ''; ?>" class="form-control form-input" placeholder="<?= trans("subject"); ?>" required>
                            </div>
                            <div class="form-group m-b-sm-0">
                                <label class="control-label"><?= trans("message"); ?></label>
                                <textarea name="message" id="message_text" class="form-control form-textarea" placeholder="<?= trans("write_a_message"); ?>" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-danger redirectToMembersmsg"><i class="icon-send"></i>&nbsp;<?= trans("send"); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
<script>
$(document).ready(function () 
{
	function openSelectionModal() 
	{
		$(function() {
			$('#messageModal').modal({
				backdrop: 'static',
				keyboard: false
			}).modal('show');
		});
	}

	$(".redirectToMembersmsg").click(function () 
	{
		$("#messageModal").modal("hide");
		
		swal({
			  title: "Message Sent Succesfully",
			  text: "You can continue texting in Message module",
			  icon: "info",
			  buttons:  ['Back',"Continue"],
			})
			.then((willDelete) => {
			  if (willDelete) 
				{
					window.location.href = "<?= base_url('messages'); ?>";
			 	}
				else 
				{
					window.location.href = "<?= base_url('admin/members'); ?>";
			 	}
			});
	});
	
	openSelectionModal();
	
});

$('#redirectToMembers').click(function()
{
	window.location.href = "<?= base_url('admin/members'); ?>";
});


</script>

<style>
.form_message
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

.btn-danger
{
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

.btn-radius 
{
	border-radius: 100px !important;
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

button.close
{
	background: red !important;
	padding: 2px 1px 2px 1px !important;
	opacity: 1 !important;
	color: #fff !important;
	top: 40px !important;
	right: 40px !important;
	border-radius: 5px !important;
}

.red
{
	color : red !important;
}

.modal-content
{
	border-radius: 10px !important;
}
</style>
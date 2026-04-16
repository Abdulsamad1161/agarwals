<div id="wrapper">
    <div class="container">
		<?php /*
			<div class="row">
				<div class="col-12">
					<nav class="nav-breadcrumb" aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
							<li class="breadcrumb-item active" aria-current="page"><?= trans("messages"); ?></li>
						</ol>
					</nav>
					<h1 class="page-title"><?= trans("messages"); ?></h1>
				</div>
			</div>
		*/ ?>
		
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8 col-sm-12">
				<div class="title">
					<h1 class="picture_gallery_h1"><?= trans("messages"); ?></h1>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
		
        <div class="row row-col-messages">
            <?php if (empty($unreadConversations) && empty($readConversations)): ?>
                <div class="col-12">
                    <p class="text-center"><?= trans("no_messages_found"); ?></p>
                </div>
            <?php else: ?>
                <div class="col-sm-12 col-md-12 col-lg-3 col-message-sidebar">
                    <div class="message-sidebar-custom-scrollbar">
                        <div class="row-custom messages-sidebar">
                            <?php if (!empty($unreadConversations)):
                                foreach ($unreadConversations as $item):
                                    $userId = 0;
                                    if ($item->receiver_id != user()->id) {
                                        $userId = $item->receiver_id;
                                    } else {
                                        $userId = $item->sender_id;
                                    }
                                    $user = getUser($userId);
                                    if (!empty($user)):?>
                                        <div class="conversation-item <?= $item->id == $conversation->id ? 'active-conversation-item' : ''; ?>">
                                            <a href="<?= generateUrl('messages'); ?>?conv=<?= $item->id; ?>" class="conversation-item-link">
                                                <div class="middle">
                                                    <img src="<?= getUserAvatar($user); ?>" alt="<?= esc(getUsername($user)); ?>">
                                                </div>
                                                <div class="right">
                                                    <div class="row-custom">
                                                        <strong class="username"><?= esc(getUsername($user)); ?></strong>
                                                        <label class="badge badge-success badge-new"><?= trans("new_message"); ?></label>
                                                    </div>
                                                    <div class="row-custom m-b-0">
                                                        <p class="subject"><?= esc(characterLimiter($item->subject, 28, '...')); ?></p>
                                                    </div>
                                                </div>
                                            </a>
											<?php /*
                                            <a href="javascript:void(0)" class="delete-conversation-link" onclick='deleteConversation(<?= $item->id; ?>,"<?= trans("confirm_message", true); ?>");'><i class="icon-trash"></i></a> */ ?>
                                        </div>
                                    <?php endif;
                                endforeach;
                            endif;
                            if (!empty($readConversations)):
                                foreach ($readConversations as $item):
                                    $userId = 0;
                                    if ($item->receiver_id != user()->id) {
                                        $userId = $item->receiver_id;
                                    } else {
                                        $userId = $item->sender_id;
                                    }
                                    $user = getUser($userId);
                                    if (!empty($user)):?>
                                        <div class="conversation-item <?= $item->id == $conversation->id ? 'active-conversation-item' : ''; ?>">
                                            <a href="<?= generateUrl('messages'); ?>?conv=<?= $item->id; ?>" class="conversation-item-link">
                                                <div class="middle">
                                                    <img src="<?= getUserAvatar($user); ?>" alt="<?= esc(getUsername($user)); ?>">
                                                </div>
                                                <div class="right">
                                                    <div class="row-custom">
                                                        <strong class="username"><?= esc(getUsername($user)); ?></strong>
                                                    </div>
                                                    <div class="row-custom m-b-0">
                                                        <p class="subject"><?= esc(characterLimiter($item->subject, 28, '...')); ?></p>
                                                    </div>
                                                </div>
                                            </a>
											<?php /*
                                            <a href="javascript:void(0)" class="delete-conversation-link" onclick='deleteConversation(<?= $item->id; ?>,"<?= trans("confirm_message", true); ?>");'><i class="icon-trash"></i></a> */?>
                                        </div>
                                    <?php endif;
                                endforeach;
                            endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-9 col-message-content">
                    <?php
                    $profileId = $conversation->sender_id;
                    if (user()->id == $conversation->sender_id) {
                        $profileId = $conversation->receiver_id;
                    }
                    $profile = getUser($profileId);
                    if (!empty($profile)):?>
                        <div class="row-custom messages-head">
                            <div class="sender-head">
                                <div class="left">
                                    <img src="<?= getUserAvatar($profile); ?>" alt="<?= esc(getUsername($profile)); ?>" class="img-profile">
                                </div>
                                <div class="right">
                                    <strong class="username"><?= esc(getUsername($profile)); ?></strong>
                                    <p class="p-last-seen">
                                        <span class="last-seen <?= isUserOnline($profile->last_seen) ? 'last-seen-online' : ''; ?>"> <i class="icon-circle"></i> <?= trans("last_seen"); ?>&nbsp;<?= timeAgo($profile->last_seen); ?></span>
                                    </p>
                                    <?php if (!empty($conversation->product_id)):
                                        $product = getProduct($conversation->product_id);
                                        if (!empty($product)):?>
                                            <p class="subject m-0 font-600"><a href="<?= generateProductUrl($product); ?>" class="link-black link-underlined" target="_blank"><?= esc($conversation->subject); ?></a></p>
                                        <?php endif;
                                    else: ?>
                                        <p class="subject m-0 font-600"><?= esc($conversation->subject); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row-custom messages-content">
                        <div id="message-custom-scrollbar" class="messages-list">
                            <?php if (!empty($messages)):
                                foreach ($messages as $item):
                                    if ($item->deleted_user_id != user()->id): ?>
                                        <?php if (user()->id == $item->receiver_id): ?>
                                            <div class="message-list-item">
                                                <div class="message-list-item-row-received">
                                                    <div class="user-avatar">
                                                        <div class="message-user">
                                                            <img src="<?= getUserAvatarById($item->sender_id); ?>" alt="" class="img-profile">
                                                        </div>
                                                    </div>
                                                    <div class="user-message">
                                                        <div class="message-text">
                                                            <?= esc($item->message); ?>
                                                        </div>
                                                        <span class="time"><?= timeAgo($item->created_at); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="message-list-item">
                                                <div class="message-list-item-row-sent">
                                                    <div class="user-message">
                                                        <div class="message-text">
                                                            <?= esc($item->message); ?>
                                                        </div>
                                                        <span class="time"><?= timeAgo($item->created_at); ?></span>
                                                    </div>
                                                    <div class="user-avatar">
                                                        <div class="message-user">
                                                            <img src="<?= getUserAvatarById($item->sender_id); ?>" alt="" class="img-profile">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif;
                                    endif;
                                endforeach;
                            endif; ?>
                        </div>
                        <div class="message-reply">
                            <form action="<?= base_url('send-message-post'); ?>" method="post" id="form_validate">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="conversation_id" value="<?= $conversation->id; ?>">
                                <input type="hidden" name="back_url" value="<?= getCurrentUrl(); ?>">
                                <?php if (user()->id == $conversation->sender_id): ?>
                                    <input type="hidden" name="receiver_id" value="<?= $conversation->receiver_id; ?>">
                                <?php else: ?>
                                    <input type="hidden" name="receiver_id" value="<?= $conversation->sender_id; ?>">
                                <?php endif; ?>
                                <div class="form-group m-b-10">
                                    <textarea class="form-control form-textarea" name="message" placeholder="<?= trans('write_a_message'); ?>" required></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-danger float-right"><i class="icon-send"></i> <?= trans("send"); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.messages-head
{
	border-radius: 10px !important; 
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
	border: 2px solid #d1274b !important; 
	margin: 5px !important;
	padding: 10px !important;
}

.os-host
{
	border-radius: 10px !important; 
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
	border: 2px solid #d1274b !important; 
	margin: 5px !important;
	padding: 10px !important;
	max-height : 500px !important;
}

.picture_gallery_h1
{
	font-size: 30px;
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

.message-reply
{
	border-radius: 10px !important;
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
	border: 2px solid #d1274b !important;
	margin: 5px !important;
	padding: 10px !important;
}
</style>
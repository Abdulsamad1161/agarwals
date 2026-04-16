<div class="container">
	<div class="row">
		<div class="col-md-4 mb-3"></div>
		<div class="col-md-4 mb-3 mt-4 col-sm-12">
			<div class="title">
				<h1 class="picture_gallery_h1">MEMBERS</h1>
			</div>
		</div>
		<div class="col-md-4 mb-3"></div>
	</div>
</div>
<div class="container">
    <div class="row padding_row">
	<?php
		if(!empty($users))
		{ 
		foreach ($users as $item): 
		//echo "<pre>";print_r($item);die;
		if($item['show_profile'] == 1 && $item['id'] !== user()->id)
		{
		?>
			<div class="col-md-3 col-sm-6">
				<?php 
					if($item['avatar'] != '' && $item['avatar'] != NULL)
					{
						$img_url = base_url().'/'.$item['avatar'];
					}
					else
					{
						$img_url = base_url('assets/images_agarwal/no_image.png');
					}
				?>
				<div class="box1"> <img src="<?= $img_url ?>" alt="">
					<h3 class="title">
						<?php 
							if($item['show_email'] == 1)
							{
								echo $item['email'];
							}
						?>
					</h3>
					<ul class="icon">
						<li><a href="<?= $item['facebook_url']; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
						<li><a href="<?= $item['instagram_url']; ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
						<li><a href="<?= adminUrl('send-msg/' . $item['id']); ?>"<i class="fa fa-envelope"></i></a></li>
					</ul>
				</div>
				<div class="row">
					<div class="user-name"><?= $item['first_name'].' '.$item['last_name']; ?></div>
				</div>
			</div>
        <?php 
		}
		endforeach; 
		}
		else 
		{ ?>
			<div class="col-md-12" style="text-align:center">
					 <img src="<?= base_url('assets/images_agarwal/stay_tuned.png'); ?>" alt="Stay Tuned">
				</div>
		<?php } ?>
    </div>
</div>
<style>

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

.box1 img,.box1:after,.box1:before
{
	width:100%;transition:all .3s ease 0s
}

.box1 .icon,.box2,.box3,.box4,.box5 .icon li a
{
	text-align:center
}

.box10:after,.box10:before,.box1:after,.box1:before,.box2
.inner-content:after,.box3:after,.box3:before,.box4:before,.box5:after,.box5:before,.box6:after,.box7:after,.box7:before
{
	content:""
}

.box1,.box11,.box12,.box13,.box14,.box16,.box17,.box18,.box2,.box20,.box21,.box3,.box4,.box5,.box5 .icon li a,.box6,.box7,.box8
{
	overflow:hidden
}

.box1 .title,.box10 .title,.box4 .title,.box7 .title
{
	letter-spacing:1px
}

.box3 .post,.box4 .post,.box5 .post,.box7 .post
{
	font-style:italic
}

.mt-30
{
	margin-top:30px
}

.mt-40
{
	margin-top:40px
}

.mb-30
{
	margin-bottom:30px
}

.box1 .icon,.box1 .title
{
	margin:0;position:absolute
}

.box1
{
	box-shadow:0 0 3px rgba(0,0,0,.3);position:relative
}

.box1:after,.box1:before
{
	height:50%;background:rgba(0,0,0,.5);position:absolute;top:0;left:0;z-index:1;transform-origin:100% 0;transform:rotateZ(90deg)
}

.box1:after
{
	top:auto;bottom:0;transform-origin:0 100%
}

.box1:hover:after,.box1:hover:before
{
	transform:rotateZ(0)
}

.box1 img
{
	height:auto;transform:scale(1) rotate(0)
}

.box1:hover img
{
	filter:sepia(80%);transform:scale(1.3) rotate(10deg)
}

.box1 .title
{
	font-size:12px;font-weight:400;color:#fff;bottom:10px;left:10px;opacity:0;z-index:2;transform:scale(0);transition:all .5s ease .2s
}

.box1:hover .title
{
	opacity:1;transform:scale(1)
}

.box1 .icon
{
	padding:7px 5px;list-style:none;background:#004cbf;border-radius:0 0 0 10px;top:-100%;right:0;z-index:2;transition:all .3s ease .2s
}

.box1:hover .icon
{
	top:0
}

.box1 .icon li
{
	display:block;margin:10px 0
}

.box1 .icon li a
{
	display:block;width:35px;height:35px;line-height:35px;border-radius:10px;font-size:18px;color:#fff;transition:all .3s ease 0s
}

.box1 .icon li span
{
	display:block;width:35px;height:35px;line-height:35px;border-radius:10px;font-size:18px;color:#fff;transition:all .3s ease 0s
}

.box2 .icon li a,.box3 .icon a:hover,.box4 .icon li a:hover,.box5 .icon li a,.box6 .icon li a
{
	border-radius:50%
}

.box1 .icon li a:hover
{
	color:#fff;box-shadow:0 0 10px #000 inset,0 0 0 3px #fff
}

.box1 .icon li span:hover
{
	color:#fff;box-shadow:0 0 10px #000 inset,0 0 0 3px #fff;cursor:pointer;
}

@media only screen and (max-width:990px)
{
	.box1
	{
	margin-bottom:30px
	}
}

.padding_row
{
	padding: 30px !important;
	border: 2px solid #d1274b;
	margin: 10px;
	border-radius: 10px;
	box-shadow: 10px 10px 10px 10px #adadad6e;
}

.user-name
{
	padding: 5px !important;
	border: 1px solid #f7c01b;
	margin: 10px;
	border-radius: 10px;
	box-shadow: 2px 2px 2px 2px #adadad6e;
	width: 100%;
	text-align: center;
	text-transform:uppercase;
}
</style>

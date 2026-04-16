<div class="container">
	<div class="row">
		<div class="col-md-2 mb-3"></div>
		<div class="col-md-8 mb-3 mt-4 col-sm-12">
			<div class="title">
				<h1 class="picture_gallery_h1">Board Of Directors</h1>
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
		?>
			<div class="col-md-3 col-sm-6 mt-3">
				<?php 
					if($item->image != '' && $item->image != NULL)
					{
						$img_url = base_url().'/'.$item->image;
					}
					else
					{
						$img_url = base_url('assets/images_agarwal/no_image.png');
					}
				?>
				<div class="card profile-card-5 top-height">
    		        <div class="card-img-block" style="height: 35vh;margin-top: 15px;margin-bottom: 15px;">
    		            <img class="card-img-top" src="<?= $img_url;?>" alt="Board Member Image" height = "100%">
    		        </div>
                    <div class="card-body pt-0">
						<h5 class="card-title"><?= $item->name; ?></h5>
						<p class="card-text"><?= $item->description; ?></p>
						<?php /* <div class="btn-wrap">
							<?php if (authCheck()){ 
								if(isAdmin()){ ?>
								<a href="<?= generateProfileUrl($item->slug); ?>" class="btn btn-info">Profile</a>
								<a href="<?= adminUrl('send-msg/' . $item->member_id); ?>" class="btn btn-success">Chat</a>
							<?php }
							else
							{ ?>
								<a href="javascript:void(0)" data-toggle="modal" class="btn btn-info" data-target="#siteModal">Profile</a>
								<a href="javascript:void(0)" data-toggle="modal" class="btn btn-success" data-target="#siteModal">Chat</a>
							<?php 
							}
							}
							else { ?>
							<a href="javascript:void(0)" data-toggle="modal" class="btn btn-info" data-target="#siteModal">Profile</a>
							<a href="javascript:void(0)" data-toggle="modal" class="btn btn-success" data-target="#siteModal">Chat</a>
							<?php }?>
						</div> */ ?>
                  </div>
                </div>
			</div>
        <?php 
		endforeach;
		}
		else 
		{ ?>
			<div class="col-md-12" style="text-align:center">
					 <img class='img-fluid' src="<?= base_url('assets/images_agarwal/stay_tuned.png'); ?>" alt="Stay Tuned">
				</div>
		<?php } ?>
    </div>
</div>
<style>
.card-body{
text-align:center;
}
.card-body .btn-wrap{
  display:flex;
  justify-content:space-around;
}

.card-body{
  width:100%;
}

.card-body .btn{
  width:calc(50% - 10px);
}

.btn{
padding:10px;
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

.padding_row
{
	padding: 30px !important;
	border: 2px solid #d1274b;
	margin: 10px;
	border-radius: 10px;
	box-shadow: 10px 10px 10px 10px #adadad6e;
}

.profile-card-5{
    margin-top:20px;
	border: 2px solid #b5a526;
	border-radius: 10px;
	box-shadow: 1px 1px 0px 4px #adadad6e;
}
.profile-card-5 .btn{
    border-radius:2px;
    text-transform:uppercase;
    font-size:12px;
}

.btn:hover{
	background-color : white;
    font-size:12px;
    padding:7px 20px;
	color : blue;
}

.profile-card-5 .card-img-block {
    width: 91%;
    margin: 0 auto;
    position: relative;
    
}
.profile-card-5 .card-img-block img{
    border-radius:5px;
    box-shadow:0 0 10px rgba(0,0,0,0.63);
}
.profile-card-5 h5{
    color:#4E5E30;
    font-weight:600;
}
.profile-card-5 p{
    font-size:14px;
    font-weight:300;
}
.profile-card-5 .btn-primary{
    background-color:#4E5E30;
    border-color:#4E5E30;
}
</style>

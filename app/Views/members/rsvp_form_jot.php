<div class="header_spons">
	<div class="overlay">
		<h1 class="header_spons_h1">Registration Form</h1>
	</div>
</div>


<div class="container">
	<div class="row">
		<?= view('partials/_messages'); ?>
	</div>
</div> 

<div class="container">
    <?php
    $today = date('Y-m-d');
    $form_shown = false; // Flag to track if any form is shown

    foreach ($form_data as $form) {
        if ($form->start_date <= $today && $form->end_date >= $today) {
            $form_shown = true;
            echo '
            <div class="row mb-4">
                <div class="col-md-12 text-center">
                    <div class="over_container-data">
                        <iframe
                            src="' . htmlspecialchars($form->jot_form_url) . '"
                            frameborder="0"
                            style="width:100%; height:600px;"
                            allowfullscreen
                        ></iframe>
                    </div>
                </div>
            </div>';
        }
    }

    // If no form matched the date criteria, show "RSVP is now closed"
    if (!$form_shown) {
        echo '
        <div class="col-md-12 mb-3 col-sm-12 text-center">
            <div class="over_container-data">
                <span style="font-size: 35px; color: #219721; font-weight: bold;">
                    No Forms Found
                </span>
            </div>
        </div>';
    }
    ?>
</div>


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

/* .over_container
{
	border-radius: 10px;
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
	overflow: hidden;
	margin: 20px;
	border: 2px solid #d1274b;
	padding : 25px !important;
} */

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
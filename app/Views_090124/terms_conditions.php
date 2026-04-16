<div id="wrapper" style="background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);">
    <div class="container">
		<div class="seven">
		  <h1>Terms & Conditions</h1>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 below-container">
				<?php echo $page->page_content;?>
			</div>
		</div>
	</div>
</div>

<style>
.seven h1 {
	text-align: center;
    font-size:30px; 
	font-weight:bold; 
	color:#d1274b; 
	letter-spacing:1px;
    text-transform: uppercase;

    display: grid;
    grid-template-columns: 1fr max-content 1fr;
    grid-template-rows: 27px 0;
    grid-gap: 20px;
    align-items: center;
}

.seven h1:after,.seven h1:before {
    content: " ";
    display: block;
    border-bottom: 1px solid black;
    border-top: 1px solid black;
    height: 5px;
	background-color:#f8f8f8;
}
.picture_gallery_h1
{
	font-size: 30px;
	display: inline-block;
	border-bottom: 5px solid #d1274b;
}

.picture_gallery_h4
{
	font-size: 1.5rem;
	display: inline-block;
	border-bottom: 3px solid #d1274b;
}

.title
{
	text-align: center;
}

.seperator
{
	border: 1px solid #ccc;
}

.text-center-heading
{
	text-align: center;
	font-size: 1.5rem !important;
	padding: 10px;
}

.text-bold
{
	font-weight :bold;
}

.red
{
	color : #d1274b;
}

.text-email
{
	color : blue;
	text-decoration : underline;
}

.below-container
{
	padding: 30px !important;
	border: 2px solid #d1274b;
	margin: 10px;
	border-radius: 10px;
	box-shadow: 10px 10px 10px 10px #adadad6e;
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

.btn-radius 
{
	border-radius: 100px !important;
}

@media (max-width: 576px) {

  .box-image 
	{
      max-width: 335px;
    }

}
@media (max-width: 576px) {

  .box-image 
	{
      display : none;
    }

}
</style>
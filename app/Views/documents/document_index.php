<div id="wrapper">
    <div class="container">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8 col-sm-12">
				<div class="title">
					<h1 class="picture_gallery_h1">Important Documents</h1>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
        <div class="row">
		<?php if(!empty($documentList)){?>
      <div class="col-sm-12 col-md-3">
        <div class="row-custom">
          <div class="profile-tabs">
            <ul class="nav">
              <li class="nav-item">
                <!-- PDF links will be dynamically added here -->
                <div class="list-group pdf-list" id="pdfList">
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-9">
        <div class="row-custom">
          <div class="profile-tab-content">
            <!-- PDF pages will be dynamically added here -->
            <div id="pdfCanvasContainer">
            </div>
          </div>
        </div>
      </div>
		<?php } else { ?>
			<div class="container">
				<div class="col-md-12 mb-3 col-sm-12" style="text-align:center;">
					<div class="over_container-data">
						<span style="font-size: 35px;color: #219721;font-weight: bold;">Uploading Documents....</span>
					</div>
				</div>
			</div>
		<?php 
		} ?>
    </div>
    </div>
	
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
<script>
    var pdfArray = <?php echo json_encode($documentList); ?>;

    // Load PDF viewer with the first PDF in the array by default
    loadPDF(pdfArray[0].document);

    // Function to load PDF file and render it in the viewer
    function loadPDF(pdfUrl) {
      // Clear previously rendered PDF pages
      document.getElementById('pdfCanvasContainer').innerHTML = '';

      // Load and render the PDF file
      var loadingTask = pdfjsLib.getDocument(pdfUrl);
      loadingTask.promise.then(function(pdf) {
        // Fetch all pages
        var pagesPromises = [];
        for (var i = 0; i < pdf.numPages; i++) {
          pagesPromises.push(pdf.getPage(i + 1));
        }

        // Render each page
        Promise.all(pagesPromises).then(function(pages) {
          var container = document.getElementById('pdfCanvasContainer');
          pages.forEach(function(page) {
            var scale = 1.5;
            var viewport = page.getViewport({ scale: scale });
            var canvas = document.createElement('canvas');
            var context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            container.appendChild(canvas);

            // Render PDF page into canvas context
            var renderContext = {
              canvasContext: context,
              viewport: viewport
            };
            page.render(renderContext);
          });
        });
      }).catch(function(error) {
        console.error('Error loading PDF: ', error);
      });
    }
	
	// Function to handle click on PDF list items
    document.getElementById('pdfList').addEventListener('click', function(event) {
      var pdfUrl = event.target.dataset.pdfUrl;
      if (pdfUrl) {
        // Load and render the selected PDF file
        loadPDF(pdfUrl);
      }
    });

    // Function to dynamically create PDF list
    function createPDFList() {
      var pdfListContainer = document.getElementById('pdfList');
      pdfArray.forEach(function(pdf) {
        var pdfLink = document.createElement('a');
        pdfLink.href = '#';
        pdfLink.classList.add('list-group-item', 'list-group-item-action');
        pdfLink.textContent = pdf.documentName; // Display the document name
        pdfLink.dataset.pdfUrl = pdf.document;
        pdfListContainer.appendChild(pdfLink);
      });
    }

    // Create PDF list on page load
    createPDFList();
  </script>

<style>
.over_container-data
{
	border-radius: 50px;
	box-shadow: rgba(0, 0, 0, 0.15) 0px 15px 25px, rgba(0, 0, 0, 0.05) 0px 5px 10px;
	overflow: hidden;
	margin: 20px;
	border: 2px solid #d1274b;
	padding : 25px !important;
}
#pdfCanvasContainer {
  display: block;
  margin: 20px auto;
  max-height: 80vh; /* Set maximum height to 80% of viewport height */
  overflow-y: auto; /* Add vertical scrollbar if content exceeds height */
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.profile-tabs
{
	border-radius: 10px !important; 
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
	margin: 5px !important; 
	border: 2px solid #d1274b !important; 
	padding: 10px !important;
}
.profile-tab-content
{
	border-radius: 10px !important; 
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
	margin: 5px !important; 
	border: 2px solid #d1274b !important; 
	padding: 10px !important;
}

.seperator
{
	border: 1px solid #ccc !important;
	margin: 15px 0px !important;
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

.heading-col
{
	text-align: center;
	font-size: 20px;
	color: #d1274b;
	font-weight: bold;
	margin: 10px 0px 25px;
}

.text-bold
{
	font-weight : bold;
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

.text-right
{
	text-align : right;
}

.data-pass
{
	color : red !important;
	font-weight : bold !important;
}
</style>
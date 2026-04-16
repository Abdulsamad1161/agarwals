<?php
$videoUrl = base_url() . '/uploads/video/' . $video->uploaldFileName;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $video->videoName;?></title>
    <!-- Include Plyr CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/plyr/plyr.css'); ?>">
</head>
<body>
    <div class="video-container">
        <!-- Create a video element with Plyr attributes -->
        <video id="player" controls data-plyr-config='{"title": "ABC DIWALI GALA 2022"}'>
            <source src="<?php echo $videoUrl; ?>" type="video/mp4">
        </video>
    </div>
	
	<div class="download-div" style="display:flex;justify-content:center;margin-top:15px;">
       
    </div>

    <!-- Include Plyr JavaScript -->
    <script src="<?= base_url('assets/vendor/plyr/plyr.min.js'); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Plyr for video playback
            const player = new Plyr('#player', {
                // Optional: Add Plyr configurations here
            });

            // Optional: Add event listener for when Plyr is ready
            player.on('ready', function (event) {
                // Optional: You can customize Plyr's behavior here
            });

            // Conditionally create the download link if download option is enabled
            if (<?php echo $video->downloadVideo; ?> == 1) {
                const downloadLink = document.createElement('a');
                downloadLink.id = 'downloadLink';
                downloadLink.href = '<?php echo $videoUrl; ?>';
                downloadLink.download = 'video.mp4';
                downloadLink.textContent = 'Download Video';
				downloadLink.classList.add('download-a');
                const downloadDiv = document.querySelector('.download-div');
				downloadDiv.appendChild(downloadLink);
            }
        });
    </script>
</body>
<style>
#player {
        width: 100%;
        height: 90vh;
    }
	
.download-a
{
	background-color: #008CBA;
	border: none;
	color: white;
	padding: 15px 32px;
	text-align: center;
	text-decoration: none;
	display: inline-block;
	font-size: 20px;
}
</style>
</html>



<link rel="stylesheet" href="<?= base_url('assets/vendor/plyr/plyr.css'); ?>">
<script src="<?= base_url('assets/vendor/plyr/plyr.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/plyr/plyr.polyfilled.min.js'); ?>"></script>
<div class="banner">
    <div class="dark-overlay"></div>
    <img src="<?= base_url() . '/' . esc($generalSettings->gallery_image); ?>" alt="Background Image"
        class="background-image">
    <div class="content">
        <!-- Centered text 
    <div class="centered-text">
        <h1 id="typing-animation">ABC Gallery</h1>
    </div>-->
    </div>
</div>

<style>
    #typing-animation {
        font-size: 80px;
    }

    .centered-text {
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

    .banner {
        position: relative;
        height: 35vh;
        /* Adjust the height as needed */
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
        margin-top: 3vh;
    }

    /* Add media queries for responsive adjustments */
    @media (max-width: 768px) {
        .content {
            flex-direction: column;
        }
    }

    .left-content-inner h3 {
        font-size: 4vw;
        font-family: Arial, Helvetica, sans-serif;
        background: white;
        -webkit-text-fill-color: transparent;
        -webkit-background-clip: text;
    }

    .left-content-inner p {
        font-size: 2vw;
        font-family: Arial, Helvetica, sans-serif;
        background: white;
        -webkit-text-fill-color: transparent;
        -webkit-background-clip: text;
    }
</style>

<style>
    /* Custom CSS to set a fixed height for the card and make the image fit */
    .card {
        position: relative;
        height: 200px;
        /* Set your desired fixed height */
        overflow: hidden;
        transition: transform 0.5s ease;
        /* Add transition property for smooth movement */
    }

    .card img {
        object-fit: cover;
        height: 100%;
        /* Make the image fill the entire card while preserving aspect ratio */
        width: 100%;
    }

    .gallery_card {
        box-shadow: 10px 10px 10px 10px #adadad6e;
    }

    .gallery_card:hover {
        transform: translateY(-20px);
        /* Move the card up by 20px on hover */
    }
</style>

<?php if (!empty($galleryVideos_data)):
    // echo "<pre>";print_r($galleryVideos_data);die;
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3"></div>
            <div class="col-md-4 mb-3 mt-4 col-sm-12">
                <div class="title">
                    <h1 class="picture_gallery_h1">Video Gallery</h1>
                </div>
            </div>
            <div class="col-md-4 mb-3"></div>
        </div>
    </div>

    <!-- Container for Video Thumbnails -->
    <div class="container">
        <div class="row pb-row">
            <?php foreach ($galleryVideos_data as $index => $video) {
                // Extract the video ID from the YouTube embed URL

                $youtubeID = '';

                // Try to match embed format first
                if (preg_match('/embed\/([^?&"]+)/', $video->uploaldFileName, $matches)) {
                    $youtubeID = $matches[1];
                }
                // If not found, try short format (youtu.be)
                elseif (preg_match('/youtu\.be\/([^?&"]+)/', $video->uploaldFileName, $matches)) {
                    $youtubeID = $matches[1];
                }
                
                // Default thumbnail if something goes wrong
                $thumbnail = $youtubeID ? "https://img.youtube.com/vi/{$youtubeID}/hqdefault.jpg" : 'default.jpg';
                $embedUrl = $youtubeID ? "https://www.youtube.com/embed/{$youtubeID}" : '';

                echo '
                <div class="col-md-4 col-sm-12 mb-3">
                    <div class="post-slide top-height mb-4">
                        <div class="post-img video-thumbnail" style="position: relative; cursor: pointer;" 
                             onclick="openFullView(\'' . htmlspecialchars($embedUrl) . '\')">
                            <img src="' . $thumbnail . '" alt="' . htmlspecialchars($video->videoName) . '" 
                                 style="width: 100%; height: 250px; object-fit: cover;">
                            <img src="https://img.icons8.com/ios-filled/100/ffffff/play--v1.png" alt="Play"
                                 style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 60px;">
                        </div>
                    </div>
                    <div class="text-center">
                        <h4 class="text-design"><span>' . htmlspecialchars($video->videoName) . '</span></h4>
                    </div>
                </div>';
            } ?>
        </div>
    </div>

    <!-- Full View Video Section -->
    <div id="fullView"
        style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 9999; justify-content: center; align-items: center; display: none;">
        <div style="position: relative; width: 100%; height: 100%;">
            <!-- Close Button -->
            <button onclick="closeFullView()"
                style="position: absolute; top: 70px; right: 20px; background: red; color: white; padding: 5px; border: none; font-size: 13px;border-radius: 5px;"><i
                    class="fa fa-close"></i>&nbsp;Close</button>
            <!-- Embedded Video Player -->
            <iframe id="videoFrame" width="100%" height="100%" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
        </div>
    </div>

    <script>
        function openFullView(videoUrl) {
            // Set the video URL to the iframe's src
            document.getElementById('videoFrame').src = videoUrl + "?autoplay=1"; // Autoplay when opening
            document.getElementById('fullView').style.display = "flex"; // Show the full view
        }

        function closeFullView() {
            // Clear the iframe src to stop the video
            document.getElementById('videoFrame').src = "";
            document.getElementById('fullView').style.display = "none"; // Hide the full view
        }
    </script>


<?php endif; ?>

<style>
    .text-design {
        color: white;
        font-weight: bold;
        padding: 6px;
        border-radius: 11px;
        background-image: linear-gradient(to top, #30cfd0 0%, #330867 100%);
    }

    .post-slide {
        background: #fff;
        border-radius: 7px;
        box-shadow: 10px 10px 10px 10px #adadad6e;
    }

    .post-slide .post-img {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        height: 200px;
        object-fit: cover;
    }

    .post-slide .post-img img {
        width: 100%;
        height: auto;
        transform: scale(1, 1);
        transition: transform 0.2s linear;
    }

    .post-slide:hover .post-img img {
        transform: scale(1.1, 1.1);
    }

    .post-slide .over-layer {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        background: linear-gradient(-45deg, rgba(6, 190, 244, 0.75) 0%, rgba(45, 112, 253, 0.6) 100%);
        transition: all 0.50s linear;
    }

    .post-slide:hover .over-layer {
        opacity: 1;
        text-decoration: none;
    }

    .post-slide .over-layer i {
        position: relative;
        top: 45%;
        text-align: center;
        display: block;
        color: #fff;
        font-size: 50px;
    }

    .post-slide .post-title a {
        font-size: 15px;
        font-weight: bold;
        color: #333;
        display: inline-block;
        text-transform: uppercase;
        transition: all 0.3s ease 0s;
    }

    .post-slide .post-title a:hover {
        text-decoration: none;
        color: #3498db;
    }

    .post-slide .post-description {
        line-height: 24px;
        color: #808080;
        margin-bottom: 25px;
    }

    .post-slide .read-more {
        padding: 7px 20px;
        float: right;
        font-size: 12px;
        background: #2196F3;
        color: #ffffff;
        box-shadow: 0px 10px 20px -10px #1376c5;
        border-radius: 25px;
        text-transform: uppercase;
    }

    .post-slide .read-more:hover {
        background: #3498db;
        text-decoration: none;
        color: #fff;
    }

    .pb-video-container {
        padding-top: 20px;
    }

    .pb-video {
        padding: 5px;
        box-shadow: 10px 10px 10px 10px #adadad6e;
    }

    .pb-row {
        margin-bottom: 10px;
    }
</style>


<style>
    .picture_gallery_h1 {
        font-size: 40px;
        display: inline-block;
        border-bottom: 5px solid #d1274b;
    }

    .title {
        text-align: center;
    }

    .overlay {
        display: flex;
        align-items: center;
        justify-content: center;
        background: RGBA(0, 0, 0, .5);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10000;
    }

    .img-enlargable {
        cursor: pointer;
    }

    .overlay img {
        max-width: 80%;
        max-height: 80%;
        cursor: zoom-out;
    }

    .overlay button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: white;
        background: black;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
        z-index: 10001;
    }

    .overlay .prev-button {
        left: 60px;
    }

    .overlay .next-button {
        right: 60px;
    }

    .overlay .close-button {
        top: 30px;
        right: 60px;
        font-size: 24px;
        background: transparent;
    }
</style>

<script>
    /*This code is for animation of typing animation 
        ----Start---
    */
    /* document.addEventListener('DOMContentLoaded', function() 
    {
        const text = 'ABC Gallery';
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

    document.addEventListener('DOMContentLoaded', function () {
        const players = [];
        const videos = document.querySelectorAll('.plyr');

        videos.forEach(function (video, index) {
            players.push(new Plyr(video, {
                controls: ['play', 'progress', 'mute', 'volume', 'fullscreen']
            }));

            video.addEventListener('play', function () {
                // Pause all other videos when one is played
                players.forEach(function (player, playerIndex) {
                    if (index !== playerIndex) {
                        player.pause();
                    }
                });
            });
        });
    });
</script>
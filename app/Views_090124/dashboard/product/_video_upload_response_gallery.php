<div class="row">
    <div class="col-12">
        <?php if (!empty($productVideo)): ?>
            <div class="dm-uploader-container">
                <div id="drag-and-drop-zone-video" class="dm-uploader dm-uploader-media text-center">
                    <ul class="dm-uploaded-files dm-uploaded-media-file">
                        <li class="media li-dm-media-preview">
                            <video id="player" playsinline controls>
                                <source src="<?= getProductVideoUrl($productVideo); ?>" type="video/mp4">
                            </video>
                        </li>
                    </ul>
                </div>
            </div>
        <?php else: ?>
            <div class="dm-uploader-container">
                <div id="drag-and-drop-zone-video" class="dm-uploader dm-uploader-media text-center">
                    <div class="dm-upload-icon">
                        <i class="fa fa-upload"></i>
                    </div>
                    <p class="dm-upload-text">
                        <?= trans("drag_drop_file_here"); ?>&nbsp;<span style="text-decoration: underline"><?= trans('browse_files'); ?></span>
                    </p>
                    <label for="file-input" class="btn btn-md dm-btn-select-files">
                        <input type="file" id="file-input" name="file" style="display: none;">
                    </label>
                    <ul class="dm-uploaded-files dm-uploaded-media-file" id="files-video"></ul>
                    <div class="error-message-file-upload">
                        <p class="m-0 text-center"></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>



<style>
.dm-uploader-container {
  position: relative;
  float: left;
  display: block;
  width: 100%;
  margin-bottom: 10px;
}

.dm-uploader {
  background: #f8f9fb !important;
  border: 2px dashed #eeeff1;
}

.dm-uploader-media {
  padding: 15px !important;
}

.dm-uploader {
  position: relative;
  float: left;
  width: 100%;
  height: auto;
  text-align: center;
  background: #f8f9fb;
  border: 2px dashed #eeeff1;
  border-radius: 4px;
  padding: 15px;
}

.dm-uploader {
  cursor: default;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

	.dm-upload-icon {
  font-size: 38px;
  line-height: 38px;
  color: #9fafc0;
  margin-bottom: 5px;
  margin-top: 20px;
}

.dm-uploader {
  text-align: center;
}

.dm-uploader {
  cursor: default;
}

.dm-upload-text {
  font-size: 14px;
  color: #9fafc0;
  margin-bottom: 35px;
}

.dm-btn-select-files {
  position: absolute !important;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
}

.dm-uploaded-files {
  width: 100%;
  display: block;
  position: relative;
  float: left;
  padding: 0;
  margin: 0;
}

.dm-uploaded-media-file {
  width: 100% !important;
}

.error-message-file-upload {
  position: absolute;
  bottom: 25px;
  left: 0;
  right: 0;
  text-align: center;
  color: #d43f3a;
  font-size: 13px;
}
</style>
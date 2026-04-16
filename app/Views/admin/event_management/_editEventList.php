<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("edit_event_lits"); ?></h3><a href="<?= adminUrl('event-settings'); ?>" class="btn btn-danger pull-right"><i class="fa fa-left"></i><?= trans('back'); ?></a>
            </div>
            <form action="<?= base_url('AdminController/editEventSettingsPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("event_name"); ?></label>
                        <input type="text" class="form-control" name="eventname" placeholder="<?= trans("event_name"); ?>" value="<?php if(isset($eventList->event_name)){ echo $eventList->event_name;}?>" maxlength="200" required>
                    </div>
					
					<div class="form-group">
                        <label><?= trans("event_date"); ?></label>
                        <input type="date" class="form-control" name="eventdate" placeholder="<?= trans("event_date"); ?>" value="<?php if(isset($eventList->event_date)){ echo $eventList->event_date;}?>" maxlength="200" required>
                    </div>
					
					<div class="form-group">
                        <label><?= trans("event_start_time"); ?></label>
						<input type="time" class="form-control" name="startTime" value="<?php if(isset($eventList->event_name)){ echo $eventList->event_start_time;}?>">
                    </div>

					<div class="form-group">
                        <label><?= trans("event_end_time"); ?></label>
						<input type="time" class="form-control" name="endTime" value="<?php if(isset($eventList->event_name)){ echo $eventList->event_end_time;}?>">
                    </div>  
					
					<div class="form-group">
                        <label><?= trans("event_location"); ?></label>
                        <input type="text" class="form-control" name="eventLocation" placeholder="<?= trans("event_location"); ?>" value="<?php if(isset($eventList->event_location)){ echo $eventList->event_location;}?>" maxlength="200" required>
                    </div>
					
					<div class="form-group">
                        <label>City & Country (Short Location)</label>
                        <input type="text" class="form-control" name="shortLocation" placeholder="<?= trans("event_location"); ?>" value="<?php if(isset($eventList->event_shortLocation)){ echo $eventList->event_shortLocation;}?>" maxlength="200" required>
                    </div>
					
					<div class="form-group">
                        <label><?= trans("button_name"); ?></label>
                        <input type="text" class="form-control" name="btnName" placeholder="Ex :<?= trans("buy_now"); ?>" value="<?php if(isset($eventList->btnName)){ echo $eventList->btnName;}?>" maxlength="200">
                    </div>
					
					<div class="form-group">
                        <label><?= trans("link"); ?> (you can directly copy and paste the url) </label>
                        <input type="text" class="form-control" name="linkToRedirect" placeholder="<?= trans("link"); ?>" value="<?php if(isset($eventList->eventLink)){ echo $eventList->eventLink;}?>">
                    </div>
					
					<div class="form-group">
                        <label><?= trans("about_the_event"); ?></label>
                        <textarea type="text" class="form-control" name="eventDescription" placeholder="<?= trans("about_the_event"); ?>" ><?php if(isset($eventList->eventDescription)){ echo $eventList->eventDescription;}?></textarea>
                    </div>
					
					<div class="form-group">
                        <label><?= trans("description"); ?></label>
                        <textarea type="text" class="form-control" name="description" placeholder="<?= trans("description"); ?>" ><?php if(isset($eventList->description)){ echo $eventList->description;}?></textarea>
                    </div>
					
					<div class="form-group">
                        <label><?= trans("note"); ?> (important note others if required)</label>
                        <textarea type="text" class="form-control" name="note" placeholder="<?= trans("description"); ?>" ><?php if(isset($eventList->note)){ echo $eventList->note;}?></textarea>
                    </div>

					<div class="form-group">
						<label class="control-label"><?= trans('event_poster'); ?></label>
						<div class="display-block">
							<a class='btn btn-success btn-sm btn-file-upload'>
								<?= trans('event_poster_select'); ?>
								<input type="file" name="eventImage" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info7').html($(this).val());">
							</a>
							(.png, .jpg, .jpeg, .gif, .svg)
						</div>
						<span class='label label-info' id="upload-file-info7"></span>
					</div>
					
					<div class="form-group">
						<label class="control-label"><?= trans('oragnizerImage'); ?></label>
						<div class="display-block">
							<a class='btn btn-success btn-sm btn-file-upload'>
								<?= trans('oragnizer_image_select'); ?>
								<input type="file" name="oragnizerImage" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info8').html($(this).val());">
							</a>
							(.png, .jpg, .jpeg, .gif, .svg)
						</div>
						<span class='label label-info' id="upload-file-info8"></span>
					</div>

					<input type="hidden" name="id" value="<?php if(isset($eventList->id)){ echo $eventList->id;}?>" >					
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('edit_event'); ?></button>
                </div>
            </form>
        </div>
    </div>
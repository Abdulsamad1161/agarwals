<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title">Select Home Page Images</h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl("event-settings"); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= trans('back'); ?>
                    </a>
                </div>
            </div>
			<div class="box-body">
				<form method="post" action="<?= base_url('AdminController/edithomePageGalleryPost'); ?>">
					<?= csrf_field(); ?>
					<div class="row">
						<?php foreach ($galleryImages as $item) { ?>
							<div class="col-md-3 col-lg-3 col-sm-6" style="text-align : center;">
								<div class="image-card">
									<!-- Add a checkbox for each image -->
									<input type="checkbox"  class="image-checkbox"  name="selected_images[]" value="<?= $item->id; ?>" <?php if($item->homePage ==1){ echo 'checked';} ?>>
									<img src="<?= base_url() . '/' . $item->image_path; ?>" alt="Image" class="card-image" style="height: 40vh; max-width: 100%;">
								</div>
							</div>
						<?php } ?>
					</div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn btn-success pull-right">Submit Selected Images</button>
			</div>
				</form>
		</div>
	</div>
</div>
<script>
    // Select all checkboxes with the class "image-checkbox"
    const checkboxes = document.querySelectorAll('.image-checkbox');
    let selectedCount = 0;

    checkboxes.forEach((checkbox) => {
        // If a checkbox is already checked on page load, increment the count
        if (checkbox.checked) {
            selectedCount++;
        }

        checkbox.addEventListener('change', (event) => {
            if (event.target.checked) {
                // Increment the count when a checkbox is checked
                selectedCount++;
            } else {
                // Decrement the count when a checkbox is unchecked
                selectedCount--;
            }

            // Disable remaining checkboxes when the limit is reached
            checkboxes.forEach((cb) => {
                // Only disable unchecked checkboxes
                if (!cb.checked) {
                    cb.disabled = selectedCount >= 6;
                }
            });
        });
    });
</script>

<style>
.image-card
{
	border-radius: 10px;
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
	overflow: hidden;
	margin: 6px;
	border: 2px solid #d1274b;
	padding: 6px;
}

</style>
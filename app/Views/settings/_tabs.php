<div class="profile-tabs">
    <ul class="nav">
        <li class="nav-item <?= $activeTab == 'edit_profile' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateUrl("settings"); ?>">
                <span><?= trans("update_profile"); ?></span>
            </a>
        </li>
		<li class="nav-item <?= $activeTab == 'membership_plans' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateUrl("settings", "membership_plans"); ?>">
                <span><?= trans("membership_plan_details"); ?></span>
            </a>
        </li>
		
		<?php if (isVendor()): ?>
			<li class="nav-item <?= $activeTab == 'membership_plans_vendors' ? 'active' : ''; ?>">
				<a class="nav-link" href="<?= generateUrl("settings", "membership_plans_vendors"); ?>">
					<span><?= trans("vendor_membership_plan_details"); ?></span>
				</a>
			</li>
		<?php endif; ?>
		
        <?php if (isSaleActive()): ?>
            <li class="nav-item <?= $activeTab == 'shipping_address' ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= generateUrl("settings", "shipping_address"); ?>">
                    <span><?= trans("shipping_address"); ?></span>
                </a>
            </li>
        <?php endif; ?>
        <li class="nav-item <?= $activeTab == 'social_media' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateUrl("settings", "social_media"); ?>">
                <span><?= trans("social_media"); ?></span>
            </a>
        </li>
		<li class="nav-item <?= $activeTab == 'volunteer' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateUrl("settings", "volunteer"); ?>">
                <span><?= trans("volunteer"); ?></span>
            </a>
        </li>
        <li class="nav-item <?= $activeTab == 'change_password' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateUrl("settings", "change_password"); ?>">
                <span><?= trans("change_password"); ?></span>
            </a>
        </li>
		<li class="nav-item <?= $activeTab == 'ticket_invoice' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateUrl("settings", "ticket_invoice"); ?>">
                <span><?= trans("ticket_invoice"); ?></span>
            </a>
        </li>
		
		<li class="nav-item <?= $activeTab == 'membership_invoice' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateUrl("settings", "membership_invoice"); ?>">
                <span><?= trans("membership_invoice"); ?></span>
            </a>
        </li>
    </ul>
</div>
<style>

.profile-tabs
{
	border-radius: 10px !important; 
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
	margin: 5px !important; 
	border: 2px solid #d1274b !important; 
	padding: 10px !important;
}
</style>

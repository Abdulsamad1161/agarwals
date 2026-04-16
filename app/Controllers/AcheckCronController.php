<?php
namespace App\Controllers;

use App\Models\MembershipModel;
use App\Models\EmailModel;

class AcheckCronController extends BaseController
{
    public $membershipModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
		
		$this->membershipModel = new MembershipModel();
    }
	
	public function testjob()
	{
		$Person = "Mail Sent Successfully to samad";
		$time = date('d-m-Y h:i:s a');
		$time = "Mail Sent Time: $time \r\n";
		$new_line = '';

		$logDirectory = "CronLog/BusinessMemberData";
		$logFileName = "log" . date("dM") . ".txt";
		$logFilePath = $logDirectory . '/' . $logFileName;

		// Check if the directory exists, if not, create it
		if (!is_dir($logDirectory)) {
			mkdir($logDirectory, 0755, true);
		}

		$cronLog_data = fopen($logFilePath, "a");

		fwrite($cronLog_data, $new_line . "\n");
		fwrite($cronLog_data, $Person . "\n");
		fwrite($cronLog_data, $time . "\n");
		fclose($cronLog_data);
	}
	
	public function cronJobBuisnessMember()
	{
		$users = $this->membershipModel->getAllUsersMembers();
		
		if(!empty($users))
		{
			foreach($users as $user)
			{
				$userPlan = $this->membershipModel->getUserPlanByUserId($user['id']);
		
				if(!empty($userPlan) && $userPlan->is_free != 1)
				{
					$daysLeft = $this->membershipModel->getUserPlanRemainingDaysCount($userPlan);

					// Check for alerts based on different intervals
					if ($daysLeft === 30) 
					{
						// Send an alert 30 days before expiration
						$this->sendExpirationAlertbm($userPlan, 30, $user);
					}
					elseif ($daysLeft === 20) 
					{
						// Send an alert 20 days before expiration
						$this->sendExpirationAlertbm($userPlan, 20, $user);
					}
					elseif ($daysLeft === 10) 
					{
						// Send an alert 10 days before expiration
						$this->sendExpirationAlertbm($userPlan, 10, $user);
					}					
					elseif ($daysLeft === 1 || $daysLeft === 0)
					{
						// Send alerts on the last day and the day of expiration
						$this->sendExpirationAlertbm($userPlan, 1, $user);
						$this->sendExpirationAlertbm($userPlan, 0, $user);
					}
					elseif($daysLeft < 0)
					{
						$this->sendExpirationAlertPostBM($userPlan, $user);
					}
				}
				elseif(!empty($userPlan) && $userPlan->is_free != 0)
				{
					$daysLeft = $this->membershipModel->getUserPlanRemainingDaysCount($userPlan);
					
					if ($daysLeft === 5) 
					{
						// Send an alert 5 days before expiration
						$this->sendExpirationAlertFreeTrailbm($userPlan, 5, $user);
					}					
					elseif ($daysLeft === 1 || $daysLeft === 0)
					{
						// Send alerts on the last day and the day of expiration
						$this->sendExpirationAlertFreeTrailbm($userPlan, 1, $user);
						$this->sendExpirationAlertFreeTrailbm($userPlan, 0, $user);
					}
				}
			}
			
			$emailModel = new EmailModel();
			$emailModel->runEmailQueue();
		}
	}
	
	private function sendExpirationAlertbm($userPlan, $daysBeforeExpiration, $user)
	{
		$messageShownToday = $this->checkIfMessageShownTodayForPlanbm($userPlan->id, $user);
		if (!$messageShownToday) {
			$emailData = [
				'email_type' => 'activation',
				'email_address' => $user['email'],
				'email_data' => serialize([
					'content' => 'Name : ' . $user['username'],
					'content_1' => 'Phone : ' . $user['phone_number'],
					'content_2' => 'Membership Name : ' . $userPlan->plan_title,
					'content_3' => 'Membership Expiry Date: ' . $userPlan->plan_end_date,
					'content_4' => "Business Membership is expiring in $daysBeforeExpiration day" . ($daysBeforeExpiration > 1 ? 's' : '') . ". Renew Your Business Membership! If you have any questions or need assistance, feel free to reach out.",
				]),
				'email_priority' => 1,
				'email_subject' => 'Plan Expiry Alert Business Membership',
				'template_path' => 'email/rsvp_payment'
			];

			addToEmailQueue($emailData);
			// Set the flag indicating that the message has been shown today
			$this->markMessageAsShownTodayForPlanbm($userPlan->id,$user);
		}
	}
	
	private function sendExpirationAlertFreeTrailbm($userPlan, $daysBeforeExpiration, $user)
	{
		$messageShownToday = $this->checkIfMessageShownTodayForPlanbm($userPlan->id, $user);
		if (!$messageShownToday) {
			$emailData = [
				'email_type' => 'activation',
				'email_address' => $user['email'],
				'email_data' => serialize([
					'content' => 'Name : ' . $user['username'],
					'content_1' => 'Phone : ' . $user['phone_number'],
					'content_2' => 'Membership Name : ' . $userPlan->plan_title,
					'content_3' => 'Membership Expiry Date: ' . $userPlan->plan_end_date,
					'content_4' => "Your Free Business Membership Trail Plan is expiring in $daysBeforeExpiration day" . ($daysBeforeExpiration > 1 ? 's' : '') . ". Purchase New Business Membership Plan Now! If you have any questions or need assistance, please feel free to reach out.",
				]),
				'email_priority' => 1,
				'email_subject' => 'Free Business Membership Trail Plan Expiry Alert',
				'template_path' => 'email/rsvp_payment'
			];

			addToEmailQueue($emailData);
			// Set the flag indicating that the message has been shown today
			$this->markMessageAsShownTodayForPlanbm($userPlan->id,$user);
		}
	}
	
	private function sendExpirationAlertPostBM($userPlan, $daysBeforeExpiration, $user)
	{
		$messageShownToday = $this->checkIfMessageShownTodayForPlanbm($userPlan->id, $user);
		if (!$messageShownToday) {
			$emailData = [
				'email_type' => 'activation',
				'email_address' => $user['email'],
				'email_data' => serialize([
					'content' => 'Name : ' . $user['username'],
					'content_1' => 'Phone : ' . $user['phone_number'],
					'content_2' => 'Membership Name : ' . $userPlan->plan_title,
					'content_3' => 'Membership Expiry Date: ' . $userPlan->plan_end_date,
					'content_4' => "Your Business Membership Has expired. Renew Your Business Membership Now! If you have any questions or need assistance, please feel free to reach out.",
				]),
				'email_priority' => 1,
				'email_subject' => 'Plan Expired Alert - Business Membership',
				'template_path' => 'email/rsvp_payment'
			];

			addToEmailQueue($emailData);
			// Set the flag indicating that the message has been shown today
			$this->markMessageAsShownTodayForPlanbm($userPlan->id,$user);
		}
	}
	
	private function sendExpirationAlertPostFreeTrailBM($userPlan, $daysBeforeExpiration, $user)
	{
		$messageShownToday = $this->checkIfMessageShownTodayForPlanbm($userPlan->id, $user);
		if (!$messageShownToday) {
			$emailData = [
				'email_type' => 'activation',
				'email_address' => $user['email'],
				'email_data' => serialize([
					'content' => 'Name : ' . $user['username'],
					'content_1' => 'Phone : ' . $user['phone_number'],
					'content_2' => 'Membership Name : ' . $userPlan->plan_title,
					'content_3' => 'Membership Expiry Date: ' . $userPlan->plan_end_date,
					'content_4' => "Your Free Business Membership  Trail Plan Has expired. Purchase New Business Membership Plan Now! If you have any questions or need assistance, please feel free to reach out.",
				]),
				'email_priority' => 1,
				'email_subject' => 'Free Business Membership Trail Plan Expired Alert',
				'template_path' => 'email/rsvp_payment'
			];

			addToEmailQueue($emailData);
			// Set the flag indicating that the message has been shown today
			$this->markMessageAsShownTodayForPlanbm($userPlan->id,$user);
		}
	}
	
	function checkIfMessageShownTodayForPlanbm($id, $user) 
	{
		$data = $this->membershipModel->msgUserSentExpirybm($id, $user['id']);
		if ($data) {
			// Get the date when the message was last sent
			$msgSentDate = formatDate($data->msgSentDate);

			// Get the current date
			$currentDate = formatDate(date('Y-m-d'));

			// Compare the dates to check if the message was sent today
			if ($msgSentDate === $currentDate) {
				// Message has already been sent today; no need to send it again.
				return true;
			}
		}

		// Message has not been sent today.
		return false;
	}

	// Function to mark the message as shown today for a specific plan
	function markMessageAsShownTodayForPlanbm($id, $user) {
		$Person = "Mail Sent Successfully to " . $user['first_name'] . " " . $user['last_name'];
		$time = date('d-m-Y h:i:s a');
		$time = "Mail Sent Time: $time \r\n";
		$new_line = '';

		$logDirectory = "CronLog/BusinessMemberData";
		$logFileName = "log" . date("dM") . ".txt";
		$logFilePath = $logDirectory . '/' . $logFileName;

		// Check if the directory exists, if not, create it
		if (!is_dir($logDirectory)) {
			mkdir($logDirectory, 0755, true);
		}

		$cronLog_data = fopen($logFilePath, "a");

		fwrite($cronLog_data, $new_line . "\n");
		fwrite($cronLog_data, $Person . "\n");
		fwrite($cronLog_data, $time . "\n");
		fclose($cronLog_data);
		return $this->membershipModel->msgUserSentExpiryTodaybm($id, $user['id']);
	}
	
	public function resendemail()
	{
		$users = $this->membershipModel->getAllUsersMembers();
		
		if(!empty($users))
		{
			foreach($users as $user)
			{
				$userPlan = $this->membershipModel->getUserPlanByUserIdUsers($user['id']);
				
				if(!empty($userPlan))
				{
					$daysLeft = $this->membershipModel->getUserPlanRemainingDaysCountUsers($userPlan);
					
					if ($daysLeft > 0) 
					{
						$this->sendEmailAlert($userPlan, $user);
					}
				}
			}
			
		}
	}
	
	public function cronJob()
	{
		$users = $this->membershipModel->getAllUsersMembers();
		
		if(!empty($users))
		{
			foreach($users as $user)
			{
				$userPlan = $this->membershipModel->getUserPlanByUserIdUsers($user['id']);
			
				if(!empty($userPlan))
				{
					$daysLeft = $this->membershipModel->getUserPlanRemainingDaysCountUsers($userPlan);
					
					// Check for alerts based on different intervals
					if ($daysLeft === 30) 
					{
						// Send an alert 30 days before expiration
						$this->sendExpirationAlert($userPlan, 30, $user);
					} 
					elseif ($daysLeft === 20) 
					{
						// Send an alert 20 days before expiration
						$this->sendExpirationAlert($userPlan, 20, $user);
					}
					elseif ($daysLeft === 10) 
					{
						// Send an alert 10 days before expiration
						$this->sendExpirationAlert($userPlan, 10, $user);
					}
					elseif ($daysLeft === 1 || $daysLeft === 0) 
					{
						// Send alerts on the last day and the day of expiration
						$this->sendExpirationAlert($userPlan, 1, $user);
						$this->sendExpirationAlert($userPlan, 0, $user);
					}
					elseif($daysLeft < 0)
					{
						$this->sendExpirationAlertPost($userPlan, $user);
						$this->updatePlanStatus($userPlan->id,$userPlan->plan_id);
					}
				}
				
				$userPlanPost = $this->membershipModel->getUserPlanByUserIdUsersPost($user['id']);

				if (!empty($userPlanPost)) {
					$daysLeftPost = $this->membershipModel->getUserPlanRemainingDaysCountUsers($userPlanPost);
					$data = $this->membershipModel->msgUserSentExpiryPost($userPlanPost->id, $user['id']);

					if ($daysLeftPost < 0 && $data) 
					{
						if ($data->msgSentDate !== null) {
							$msgSentDate = strtotime($data->msgSentDate);
							$currentDate = strtotime(date('Y-m-d'));

							$daysSinceLastEmail = ($currentDate - $msgSentDate) / (60 * 60 * 24);

							if ($daysSinceLastEmail >= 7) {
								$this->sendExpirationAlertPost($userPlanPost, $user);
							}
						} else {
							$this->sendExpirationAlertPost($userPlanPost, $user);
						}
					}
				}
			}
			
			$emailModel = new EmailModel();
			$emailModel->runEmailQueue();
		}
	}
	
	private function updatePlanStatus($userId,$plan_id)
	{
		$this->membershipModel->updatePlansDetailsDeleted($userId,$plan_id);
	}

	// Function to send an expiration alert
	private function sendExpirationAlert($userPlan, $daysBeforeExpiration, $user)
	{
		$messageShownToday = $this->checkIfMessageShownTodayForPlan($userPlan->id, $user['id']);

		if (!$messageShownToday) {
			$emailData = [
				'email_type' => 'activation',
				'email_address' => $user['email'],
				'email_data' => serialize([
					'content' => 'Name : ' . $user['username'],
					'content_1' => 'Phone : ' . $user['phone_number'],
					'content_2' => 'Membership Name : ' . $userPlan->plan_title,
					'content_3' => 'Membership Expiry Date: ' . $userPlan->plan_end_date,
					'content_4' => "Membership is expiring in $daysBeforeExpiration day" . ($daysBeforeExpiration > 1 ? 's' : '') . ". Renew Your Membership! If you have any questions or need assistance, feel free to reach out.",
				]),
				'email_priority' => 1,
				'email_subject' => 'Plan Expiry Alert',
				'template_path' => 'email/rsvp_payment'
			];

			addToEmailQueue($emailData);
			// Set the flag indicating that the message has been shown today
			$this->markMessageAsShownTodayForPlan($userPlan->id, $user);
		}
	}
	
	private function sendEmailAlert($userPlan, $user)
	{
		$emailData = [
			'email_type' => 'activation',
			'email_address' => $user['email'],
			'email_data' => serialize([
				'content' => 'Name : ' . $user['username'],
				'content_1' => 'Phone : ' . $user['phone_number'],
				'content_2' => 'Membership Name : ' . $userPlan->plan_title,
				'content_3' => 'Membership Expiry Date: ' . $userPlan->plan_end_date,
				'content_4' => "Membership is expiring on Expiry Date! If you have any questions or need assistance, feel free to reach out.",
			]),
			'email_priority' => 1,
			'email_subject' => 'Plan Expiry Info',
			'template_path' => 'email/rsvp_payment'
		];

		addToEmailQueue($emailData);
		// Set the flag indicating that the message has been shown today
		$this->markMessageAsShownTodayForPlanPost($userPlan->id, $user);
	}
	
	// Function to send an expiration alert post
	private function sendExpirationAlertPost($userPlan, $user)
	{
		$messageShownToday = $this->checkIfMessageShownTodayForPlan($userPlan->id, $user['id']);

		if (!$messageShownToday) {
			$emailData = [
				'email_type' => 'activation',
				'email_address' => $user['email'],
				'email_data' => serialize([
					'content' => 'Name : ' . $user['username'],
					'content_1' => 'Phone : ' . $user['phone_number'],
					'content_2' => 'Membership Name : ' . $userPlan->plan_title,
					'content_3' => 'Membership Expiry Date: ' . $userPlan->plan_end_date,
					'content_4' => "Your Membership has expired. Renew Your Membership Soon! If you have any questions or need assistance, please feel free to reach out.",
				]),
				'email_priority' => 1,
				'email_subject' => 'Plan Expired Alert!',
				'template_path' => 'email/rsvp_payment'
			];

			addToEmailQueue($emailData);
			// Set the flag indicating that the message has been shown today
			$this->markMessageAsShownTodayForPlan($userPlan->id, $user);
		}
	}

	
	function checkIfMessageShownTodayForPlan($id, $user_id) 
	{
		$data = $this->membershipModel->msgUserSentExpiry($id, $user_id);
		if ($data) {
			// Get the date when the message was last sent
			$msgSentDate = formatDate($data->msgSentDate);

			// Get the current date
			$currentDate = formatDate(date('Y-m-d'));

			// Compare the dates to check if the message was sent today
			if ($msgSentDate === $currentDate) {
				// Message has already been sent today; no need to send it again.
				return true;
			}
		}

		// Message has not been sent today.
		return false;
	}

	// Function to mark the message as shown today for a specific plan
	function markMessageAsShownTodayForPlan($id, $user) {

		$Person = "Mail Sent Successfully to " . $user['first_name'] . " " . $user['last_name'];
		$time = date('d-m-Y h:i:s a');
		$time = "Mail Sent Time: $time \r\n";
		$new_line = '';

		$logDirectory = "CronLog/MemberData";
		$logFileName = "log" . date("dM") . ".txt";
		$logFilePath = $logDirectory . '/' . $logFileName;

		// Check if the directory exists, if not, create it
		if (!is_dir($logDirectory)) {
			mkdir($logDirectory, 0755, true);
		}

		$cronLog_data = fopen($logFilePath, "a");

		fwrite($cronLog_data, $new_line . "\n");
		fwrite($cronLog_data, $Person . "\n");
		fwrite($cronLog_data, $time . "\n");
		fclose($cronLog_data);

		return $this->membershipModel->msgUserSentExpiryToday($id, $user['id']);
	}
	
	function markMessageAsShownTodayForPlanPost($id, $user) {

		$Person = "Mail Sent Successfully to " . $user['first_name'] . " " . $user['last_name'];
		$time = date('d-m-Y h:i:s a');
		$time = "Mail Sent Time: $time \r\n";
		$new_line = '';

		$logDirectory = "CronLog/ResendData";
		$logFileName = "log" . date("dM") . ".txt";
		$logFilePath = $logDirectory . '/' . $logFileName;

		// Check if the directory exists, if not, create it
		if (!is_dir($logDirectory)) {
			mkdir($logDirectory, 0755, true);
		}

		$cronLog_data = fopen($logFilePath, "a");

		fwrite($cronLog_data, $new_line . "\n");
		fwrite($cronLog_data, $Person . "\n");
		fwrite($cronLog_data, $time . "\n");
		fclose($cronLog_data);

		return true;
	}
	
}
?>
<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\EmailModel;
use PHPMailer\PHPMailer\Exception;

class AuthController extends BaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    /**
     * Login Post
     */
    public function loginPost()
    {
        //check auth
        if (authCheck()) {
            echo json_encode(['result' => 1]);
            exit();
        }
        $val = \Config\Services::validation();
        $val->setRule('email', trans("email_address"), 'required|max_length[255]');
        $val->setRule('password', trans("password"), 'required|max_length[255]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            echo view('partials/_messages');
        } else {
			$check_otp_enabled = $this->authModel->login();
            if ($check_otp_enabled) {
				if($check_otp_enabled === 1)
				{
					echo json_encode(['result' => 1,'otp' => 1]);
				}
				else
				{
					echo json_encode(['result' => 1]);	
				}
            } else {
                $data = [
                    'result' => 0,
                    'errorMessage' => view('partials/_messages')
                ];
                echo json_encode($data);
            }
            resetFlashData();
        }
    }
	
	/**
     * Login OTP Verification 
     */
	
	public function generateOTP() 
	{
		$otp = rand(100000, 999999);
		return $otp;
	} 

	public  function otpVerification()
	{
		if($this->session->remove('otp_number') != NULL)
		{
			$this->session->remove('otp_number');
		}
		
		if($this->session->remove('otp_time') != NULL)
		{
			$this->session->remove('otp_time');
		}
		
		if($this->session->remove('expiration_time') != NULL)
		{
			$this->session->remove('expiration_time');
		}
		
		$user_id = $this->session->get_user_id_otp;
		$emailUser = $this->session->emailUser;
		
		$data_user = $this->authModel->getUser($user_id);
		
		$randomOTP = $this->generateOTP();
		
		$emailData = 
		[
				'email_type' => 'activation',
				'email_address' => $emailUser,
				'email_data' => serialize([
					'content' => 'Your OTP Confirmation Code for Login',
					'content_1' => 'OTP CODE - ' .$randomOTP,
					'content_2' => 'Your OTP is valid for 15 minutes only',
				]),
				'email_priority' => 1,
				'email_subject' => 'Confirmation For your Account',
				'template_path' => 'email/otp_verification'
		];
		
		addToEmailQueue($emailData);
		
		$otp_data = [
                'otp_number' => $randomOTP,
                'otp_time' => time(),
				'expiration_time' => time() + (15 * 60)
            ];
        $this->session->set($otp_data);
        $data['title'] = trans("otp_verification");
        $data['description'] = trans("otp_verification") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("otp_verification") . ',' . $this->baseVars->appName;
        $data['userSession'] = getUserSession();
        echo view('partials/_header', $data);
        echo view('auth/otp_verfication');
        echo view('partials/_footer');
	}
	
	public function otpVerificationPost()
	{
		$otp_value = $this->session->otp_number;
		$entered_otp = inputPost('otp');
		if($otp_value == $entered_otp)
		{
			$current_time = time();
			$otp_expiry = $this->session->expiration_time;
			if($otp_expiry > $current_time)
			{
				$this->session->remove('otp_number');
				$this->session->remove('otp_time');
				$this->session->remove('expiration_time');
				echo json_encode(['result' => 1]);
			}
			else
			{
				setErrorMessage(trans("msg_otp_expired") . "&nbsp;<a href='javascript:void(0)' class='color-link link-underlined link-mobile-alert' onclick=\"sendotpAgain();\">" . trans("resend_otp") . "</a>");
				$data = [
				'result' => -1,
				'errorMessage' => view('partials/_messages')
				];
				$this->session->remove('otp_number');
				$this->session->remove('otp_time');
				$this->session->remove('expiration_time');
				echo json_encode($data);
			}
		}
		else
		{
			setErrorMessage(trans("error_otp"));
			$data = [
				'result' => 0,
				'errorMessage' => view('partials/_messages')
			];
			echo json_encode($data);
		}
	}
	
	public function redirecthome()
	{
		$this->session->remove('otp_number');
		$this->session->remove('otp_time');
		$this->session->remove('expiration_time');
		$this->session->remove('get_user_id_otp');
		return redirect()->to(langBaseUrl());
	}

	public function redirectSuccessfulOTP()
	{
		$data_user_id = $this->session->get_user_id_otp;
		$data = $this->authModel->createUserSessionAfterOTP($data_user_id);
		if($data)
		{
			return redirect()->to(langBaseUrl());
		}
	}
    /**
     * Connect with Facebook
     */
    public function connectWithFacebook()
    {
        $state = generateToken();
        $fbUrl = "https://www.facebook.com/v2.10/dialog/oauth?client_id=" . $this->generalSettings->facebook_app_id . "&redirect_uri=" . langBaseUrl() . "/facebook-callback&scope=email&state=" . $state;
        $this->session->set('oauth2state', $state);
        $this->session->set('fbLoginReferrer', previous_url());
        return redirect()->to($fbUrl);
    }

    /**
     * Facebook Callback
     */
    public function facebookCallback()
    {
        require_once APPPATH . "ThirdParty/facebook/vendor/autoload.php";
        $provider = new \League\OAuth2\Client\Provider\Facebook([
            'clientId' => $this->generalSettings->facebook_app_id,
            'clientSecret' => $this->generalSettings->facebook_app_secret,
            'redirectUri' => langBaseUrl() . '/facebook-callback',
            'graphApiVersion' => 'v2.10',
        ]);
        if (!isset($_GET['code'])) {
            echo 'Error: Invalid Login';
            exit();
            // Check given state against previously stored one to mitigate CSRF attack
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $this->session->get('oauth2state'))) {
            $this->session->remove('oauth2state');
            echo 'Error: Invalid State';
            exit();
        }
        $token = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);
        try {
            $user = $provider->getResourceOwner($token);
            $fbUser = new \stdClass();
            $fbUser->id = $user->getId();
            $fbUser->email = $user->getEmail();
            $fbUser->name = $user->getName();
            $fbUser->firstName = $user->getFirstName();
            $fbUser->lastName = $user->getLastName();
            $fbUser->pictureURL = $user->getPictureUrl();
            $model = new AuthModel();
            $model->loginWithFacebook($fbUser);
            if (!empty($this->session->get('fbLoginReferrer'))) {
                return redirect()->to($this->session->get('fbLoginReferrer'));
            } else {
                return redirect()->to(langBaseUrl());
            }
        } catch (\Exception $e) {
            echo 'Error: Invalid User';
            exit();
        }
    }

    /**
     * Connect with Google
     */
    public function connectWithGoogle()
    {
        require_once APPPATH . 'ThirdParty/google/vendor/autoload.php';
        $provider = new \League\OAuth2\Client\Provider\Google([
            'clientId' => $this->generalSettings->google_client_id,
            'clientSecret' => $this->generalSettings->google_client_secret,
            'redirectUri' => base_url('connect-with-google'),
        ]);

        if (!empty($_GET['error'])) {
            exit('Got error: ' . esc($_GET['error'], ENT_QUOTES, 'UTF-8'));
        } elseif (empty($_GET['code'])) {
            $authUrl = $provider->getAuthorizationUrl();
            $_SESSION['oauth2state'] = $provider->getState();
            $this->session->set('gLoginReferrer', previous_url());
            return redirect()->to($authUrl);
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        } else {
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);
            try {
                $user = $provider->getResourceOwner($token);
                $gUser = new \stdClass();
                $gUser->id = $user->getId();
                $gUser->email = $user->getEmail();
                $gUser->name = $user->getName();
                $gUser->firstName = $user->getFirstName();
                $gUser->lastName = $user->getLastName();
                $gUser->avatar = $user->getAvatar();

                $model = new AuthModel();
                $model->loginWithGoogle($gUser);
                if (!empty($this->session->get('gLoginReferrer'))) {
                    return redirect()->to($this->session->get('gLoginReferrer'));
                } else {
                    return redirect()->to(langBaseUrl());
                }
            } catch (Exception $e) {
                exit('Something went wrong: ' . $e->getMessage());
            }
        }
    }

    /**
     * Connect with VK
     */
    public function connectWithVK()
    {
        require_once APPPATH . "ThirdParty/vkontakte/vendor/autoload.php";
        $provider = new \J4k\OAuth2\Client\Provider\Vkontakte([
            'clientId' => $this->generalSettings->vk_app_id,
            'clientSecret' => $this->generalSettings->vk_secure_key,
            'redirectUri' => base_url('connect-with-vk'),
            'scopes' => ['email'],
        ]);
        // Authorize if needed
        if (PHP_SESSION_NONE === session_status()) session_start();
        $isSessionActive = PHP_SESSION_ACTIVE === session_status();
        $code = !empty($_GET['code']) ? $_GET['code'] : null;
        $state = !empty($_GET['state']) ? $_GET['state'] : null;
        $sessionState = 'oauth2state';
        // No code – get some
        if (!$code) {
            $authUrl = $provider->getAuthorizationUrl();
            if ($isSessionActive) $_SESSION[$sessionState] = $provider->getState();
            $this->session->set('vkLoginReferrer', previous_url());
            return redirect()->to($authUrl);
        } // Anti-CSRF
        elseif ($isSessionActive && (empty($state) || ($state !== $_SESSION[$sessionState]))) {
            unset($_SESSION[$sessionState]);
            throw new \RuntimeException('Invalid state');
        } else {
            try {
                $providerAccessToken = $provider->getAccessToken('authorization_code', ['code' => $code]);
                $user = $providerAccessToken->getValues();
                //get user details with cURL
                $url = 'http://api.vk.com/method/users.get?uids=' . $providerAccessToken->getValues()['user_id'] . '&access_token=' . $providerAccessToken->getToken() . '&v=5.95&fields=photo_200,status';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                $response = curl_exec($ch);
                curl_close($ch);

                $userDetails = json_decode($response);
                $vkUser = new \stdClass();
                $vkUser->id = $providerAccessToken->getValues()['user_id'];
                $vkUser->email = $providerAccessToken->getValues()['email'];
                $vkUser->name = @$userDetails->response['0']->first_name . " " . @$userDetails->response['0']->last_name;
                $vkUser->firstName = @$userDetails->response['0']->first_name;
                $vkUser->lastName = @$userDetails->response['0']->last_name;
                $vkUser->avatar = @$userDetails->response['0']->photo_200;

                $model = new AuthModel();
                $model->loginWithVK($vkUser);
                if (!empty($this->session->get('vkLoginReferrer'))) {
                    return redirect()->to($this->session->get('vkLoginReferrer'));
                } else {
                    return redirect()->to(langBaseUrl());
                }
            } catch (IdentityProviderException $e) {
                error_log($e->getMessage());
            }
        }
    }
   public function generateCaptcha() {
        $captcha_code = '';
        $captcha_image_height = 50;
        $captcha_image_width = 130;
        $total_characters_on_image = 6;

        // Allowed characters for CAPTCHA (avoiding confusing ones)
        $possible_captcha_letters = 'bcdfghjkmnpqrstvwxyz23456789';
        $captcha_font = FCPATH . 'uploads/monofont.ttf';

        $random_captcha_dots = 50;
        $random_captcha_lines = 25;
        $captcha_text_color = "0x142864";
        $captcha_noise_color = "0x142864";

        // Generate random CAPTCHA string
        for ($i = 0; $i < $total_characters_on_image; $i++) {
            $captcha_code .= $possible_captcha_letters[mt_rand(0, strlen($possible_captcha_letters) - 1)];
        }

        $captcha_font_size = $captcha_image_height * 0.65;
        $captcha_image = imagecreate($captcha_image_width, $captcha_image_height);

        // Set background color
        $background_color = imagecolorallocate($captcha_image, 255, 255, 255);

        // Convert hex color to RGB
        $array_text_color = $this->hextorgb($captcha_text_color);
        $captcha_text_color = imagecolorallocate($captcha_image, $array_text_color['red'], $array_text_color['green'], $array_text_color['blue']);

        $array_noise_color = $this->hextorgb($captcha_noise_color);
        $image_noise_color = imagecolorallocate($captcha_image, $array_noise_color['red'], $array_noise_color['green'], $array_noise_color['blue']);

        // Generate random dots
        for ($i = 0; $i < $random_captcha_dots; $i++) {
            imagefilledellipse($captcha_image, mt_rand(0, $captcha_image_width), mt_rand(0, $captcha_image_height), 2, 3, $image_noise_color);
        }

        // Generate random lines
        for ($i = 0; $i < $random_captcha_lines; $i++) {
            imageline($captcha_image, mt_rand(0, $captcha_image_width), mt_rand(0, $captcha_image_height), mt_rand(0, $captcha_image_width), mt_rand(0, $captcha_image_height), $image_noise_color);
        }

        // Add CAPTCHA text
        $text_box = imagettfbbox($captcha_font_size, 0, $captcha_font, $captcha_code);
        $x = ($captcha_image_width - $text_box[4]) / 2;
        $y = ($captcha_image_height - $text_box[5]) / 2;
        imagettftext($captcha_image, $captcha_font_size, 0, $x, $y, $captcha_text_color, $captcha_font, $captcha_code);

        // Store CAPTCHA code in session
        $this->session->set('captcha_code', $captcha_code);
		/*
        // Output the image
        header('Content-Type: image/jpeg');
        imagejpeg($captcha_image);
        imagedestroy($captcha_image);
		*/
		// Convert the CAPTCHA image to base64
		ob_start();
		imagejpeg($captcha_image);
		$image_data = ob_get_contents();
		ob_end_clean();
		imagedestroy($captcha_image);

		$base64_captcha = 'data:image/jpeg;base64,' . base64_encode($image_data);

		// Return the base64 CAPTCHA image as JSON
		echo json_encode(['captcha_base64' => $base64_captcha]);
	}

    // Convert hex to RGB
    private function hextorgb($hex) {
        $hex = str_replace("0x", "", $hex);
        return [
            'red' => hexdec(substr($hex, 0, 2)),
            'green' => hexdec(substr($hex, 2, 2)),
            'blue' => hexdec(substr($hex, 4, 2))
        ];
    }
    /**
     * Register
     */
    public function register()
    {
        if (authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("register");
        $data['description'] = trans("register") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("register") . ',' . $this->baseVars->appName;
        $data['userSession'] = getUserSession();
        echo view('partials/_header', $data);
        echo view('auth/register');
        echo view('partials/_footer');
    }

    /**
     * Register Post
     */
    public function registerNewMethodPost()
    {
        if (authCheck()) {
            echo json_encode(['result' => 1]);
            exit();
        }
        
        $val = \Config\Services::validation();
        $val->setRule('email', trans("email_address"), 'required|max_length[255]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            echo view('partials/_messages');
        } else {
            $email = inputPost('email');
            if (!$this->authModel->isEmailUnique($email)) {
				$user = $this->authModel->getUserByEmail($email);
				if($user->password != "" && $user->password != NULL)
				{
					echo json_encode(['result' => 3]);
					exit();
				}
				else
				{
					$this->authModel->loginUserNewData($user);
					echo json_encode(['result' => 2]);
					exit();
				}
            }
            if ($this->authModel->registerNew()) {
               echo json_encode(['result' => 1]);	
            }
        }
        resetFlashData();
    }
	
	public function registerPost()
    {
		$_POST = array_map('trim', $this->request->getPost());
	
        if (authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->baseVars->recaptchaStatus) {
            if (reCAPTCHA('validate') == 'invalid') {
                setErrorMessage(trans("msg_recaptcha"));
                return redirect()->to(generateUrl('register'));
            }
        }
        $val = \Config\Services::validation();
		/*
		if ($_POST['captachIndex'] == 1) {
			if ($_POST['captcha_text'] != "HSB9W") {
				// Set a custom error message for CAPTCHA error
				$val->setError('captcha_text', 'Captcha text is incorrect.');
			}
		} else if ($_POST['captachIndex'] == 2) {
			if ($_POST['captcha_text'] != "D35UA") {
				// Set a custom error message for CAPTCHA error
				$val->setError('captcha_text', 'Captcha text is incorrect.');
			}
		}
		*/
		if ($_POST['captcha_text'] != $this->session->captcha_code) {
			$val->setError('captcha_text', 'Captcha text is incorrect.');
		}
		
		if (preg_match('/[^a-zA-Z\s]/', inputPost('first_name')) || !preg_match('/^[A-Z][a-z]+$/', inputPost('first_name')) || !preg_match('/[aeiouAEIOU]/', inputPost('first_name'))) {
			$val->setError('first_name', 'Invalid First Name');
		} else {
			$val->setRule('first_name', trans("first_name"), 'required|alpha_space|max_length[100]');
		}

		if (preg_match('/[^a-zA-Z\s]/', inputPost('last_name')) || !preg_match('/^[A-Z][a-z]+$/', inputPost('last_name')) || !preg_match('/[aeiouAEIOU]/', inputPost('last_name'))) {
			$val->setError('last_name', 'Invalid Last Name');
		} else {
			$val->setRule('last_name', trans("last_name"), 'required|alpha_space|max_length[100]');
		}


		
		// $val->setRule('first_name', trans("first_name"), 'required|alpha_space|max_length[100]');
		// $val->setRule('last_name', trans("last_name"), 'required|alpha_space|max_length[100]');
		
		
		
		$val->setRule('phone_number', trans("phone_number"), 'required|numeric|min_length[10]|max_length[15]');
		$val->setRule('email', trans("email_address"), 'required|valid_email|max_length[255]');
		$val->setRule('password', trans("password"), 'required|min_length[4]|max_length[255]');
		$val->setRule('confirm_password', trans("password_confirm"), 'required|matches[password]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->to(generateUrl('register'))->withInput();
        } else {
            $email = inputPost('email');
            if (!$this->authModel->isEmailUnique($email)) {
                setErrorMessage(trans("msg_email_unique_error"));
                return redirect()->to(generateUrl('register'))->withInput();
            }
			
            if ($this->authModel->register()) {
                setSuccessMessage(trans("msg_register_success"));
                return redirect()->to(generateUrl('settings', 'edit_profile'));
            }
        }
        setErrorMessage(trans("msg_error"));
        return redirect()->to(generateUrl('register'));
    }

    /**
     * Register Success
     */
    public function registerSuccess()
    {
        if (authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("register");
        $data['description'] = trans("register") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("register") . ',' . $this->baseVars->appName;
        $token = inputGet('u');
        $data['user'] = $this->authModel->getUserByToken($token);
        if (empty($data['user']) || $data['user']->email_status == 1) {
            return redirect()->to(langBaseUrl());
        }

        echo view('partials/_header', $data);
        echo view('auth/register_success', $data);
        echo view('partials/_footer');
    }

    /**
     * Confirm Account
     */
    public function confirmAccount()
    {
        $data['title'] = trans("confirm_your_account");
        $data['description'] = trans("confirm_your_account") . " - " . $this->baseVars->appName;
        $data['keywords'] = trans("confirm_your_account") . "," . $this->baseVars->appName;

        $token = trim(inputGet('token') ?? '');
        $data['user'] = $this->authModel->getUserByToken($token);
        if (empty($data['user'])) {
            return redirect()->to(langBaseUrl());
        }
        if ($data['user']->email_status == 1) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->authModel->verifyEmail($data['user'])) {
            $data['success'] = trans("msg_confirmed");
        } else {
            $data['error'] = trans("msg_error");
        }
        echo view('partials/_header', $data);
        echo view('auth/confirm_email', $data);
        echo view('partials/_footer');
    }

    /**
     * Forgot Password
     */
    public function forgotPassword()
    {
        if (authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("reset_password");
        $data['description'] = trans("reset_password") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("reset_password") . ',' . $this->baseVars->appName;

        echo view('partials/_header', $data);
        echo view('auth/forgot_password');
        echo view('partials/_footer');
    }

    /**
     * Forgot Password Post
     */
    public function forgotPasswordPost()
    {
        if (authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $email = inputPost('email');
        $user = $this->authModel->getUserByEmail($email);
        if (empty($user)) {
            setErrorMessage(trans("msg_reset_password_error"));
            return redirect()->to(generateUrl('forgot_password'));
        } else {
            $token = $user->token;
            if (empty($token)) {
                $token = generateToken();
                $this->authModel->updateUserToken($user->id, $token);
            }
            $emailData = [
                'email_type' => 'reset_password',
                'email_address' => $user->email,
                'email_data' => serialize([
                    'content' => trans("email_reset_password"),
                    'url' => generateUrl("reset_password") . '?token=' . $token,
                    'buttonText' => trans("reset_password")
                ]),
                'email_priority' => 1,
                'email_subject' => trans("reset_password"),
                'template_path' => 'email/main'
            ];
            addToEmailQueue($emailData);
            setSuccessMessage(trans("msg_reset_password_success"));
            return redirect()->to(generateUrl('forgot_password'));
        }
    }

    /**
     * Reset Password
     */
    public function resetPassword()
    {
        if (authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("reset_password");
        $data['description'] = trans("reset_password") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("reset_password") . ',' . $this->baseVars->appName;
        $token = inputGet('token');
        $data['user'] = $this->authModel->getUserByToken($token);
        $data['success'] = $this->session->getFlashdata('success');
        if (empty($data['user']) && empty($data['success'])) {
            return redirect()->to(langBaseUrl());
        }

        echo view('partials/_header', $data);
        echo view('auth/reset_password');
        echo view('partials/_footer');
    }

    /**
     * Reset Password Post
     */
    public function resetPasswordPost()
    {
        $success = inputPost('success');
        if ($success == 1) {
            return redirect()->to(langBaseUrl());
        }
        $val = \Config\Services::validation();
        $val->setRule('password', trans("new_password"), 'required|min_length[4]|max_length[255]');
        $val->setRule('password_confirm', trans("password_confirm"), 'required|matches[password]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $token = inputPost('token');
            $user = $this->authModel->getUserByToken($token);
            if (!empty($user)) {
                if ($this->authModel->resetPassword($user)) {
                    setSuccessMessage(trans("msg_change_password_success"));
                    return redirect()->back();
                }
                setErrorMessage(trans("msg_change_password_error"));
                return redirect()->back()->withInput();
            }
        }
    }

    /**
     * Send Activation Email
     */
    public function sendActivationEmailPost()
    {
        $token = inputPost('token');
        $user = $this->authModel->getUserByToken($token);
        if(!empty($user)){
            $this->authModel->addActivationEmail($user);
        }
        $emailModel = new EmailModel();
        $emailModel->runEmailQueue();
        $data = [
            'result' => 1,
            'successMessage' => '<div class="text-success text-center m-b-15">' . trans("activation_email_sent") . '</div>'
        ];
        echo json_encode($data);
    }
}

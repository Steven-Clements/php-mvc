<?php

class Users extends Controller {
  /* ~ ~ ~ ~ ~ ${ Write a Constructor Method } ~ ~ ~ ~ ~ */
  public function __construct() {
    $this->userModel = $this->model('User');
  }

  /* ~ ~ ~ ~ ~ ${ Attempt to Start a New User Session } ~ ~ ~ ~ ~ */
  private function attemptNewUserSession($user) {
    if ($user->status === 'Unverified') {
      flash('authentication_error', '');
    } else if ($user->status !== 'Active') {
      flash('authentication_error', '');
    }

    $_SESSION['user_name'] = $user->name;
    $_SESSION['user_role'] = $user->role;

    if ($user->reset_flag === true) {
      redirect('users/secure');
    } else {
      redirect('users/profile');
    }
  }

  /* ~ ~ ~ ~ ~ ${ Create Redirect Method for User Index } ~ ~ ~ ~ ~ */
  public function index() {
    redirect('users/login');
  }

  /* ~ ~ ~ ~ ~ ${ Create View for Register Page } ~ ~ ~ ~ ~ */
  public function register() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      /* - - - - - < Filter & Sanitize User Input /> - - - - - */
      $_POST = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);

      /* - - - - - < Check Checkbox Input Fields /> - - - - - */
      $agree = false;
      if (isset($_POST['agree'])) {
        $agree = true;
      }

      /* - - - - - < Make Data Available to Application /> - - - - - */
      $data = [
        'page_title' => 'Join Now | ' . APP_NAME,
        'page_description' => '',
        'page_keywords' => '',
        'page_url' => '/users/register',
        'user_name' => trim($_POST['name']),
        'user_email' => trim($_POST['email']),
        'user_password' => trim($_POST['password']),
        'user_confirm' => trim($_POST['confirm']),
        'user_agree' => $agree,
        'user_verification' => '',
        'name_error' => '',
        'email_error' => '',
        'password_error' => '',
        'confirm_error' => '',
        'agree_error' => ''
      ];

      /* - - - - - < Check that User Input is Valid /> - - - - - */
      if (empty($data['user_name'])) {
        $data['name_error'] = '<div class="alrt alrt-error">Please enter your first and last name.</div>';
      } else if (strlen($data['user_name']) > 50) {
        $data['name_error'] = '<div class="alrt alrt-error">The name field must be 50 characters or less.</div>';
      }

      if (empty($data['user_email']) || !filter_var($data['user_email'], FILTER_VALIDATE_EMAIL)) {
        $data['email_error'] = '<div class="alrt alrt-error">Please enter a valid email address.</div>';
      } else if (strlen($data['user_email']) > 100) {
        $data['email_error'] = '<div class="alrt alrt-error">The email field must be 100 characters or less.</div>';
      } else if ($this->userModel->findUserByEmail($data['user_email'])) {
        $data['email_error'] = '<div class="alrt alrt-error">Email address is already in use.</div>';
      }

      if (empty($data['user_password'])) {
        $data['password_error'] = '<div class="alrt alrt-error">Please create a password with at least 7 characters.</div>';
      } else if (strlen($data['user_password']) > 7) {
        $data['password_error'] = '<div class="alrt alrt-error">Please create a password with at least 7 characters.</div>';
      }

      if (empty($data['user_confirm'])) {
        $data['confirm_error'] = '<div class="alrt alrt-error">Please confirm your new password.</div>';
      } else if ($data['user_password'] !== $data['user_confirm']) {
        $data['confirm_error'] = '<div class="alrt alrt-error">Passwords do not match.</div>';
      }

      if ($agree !== true) {
        $data['agree_error'] = '<div class="alrt alrt-error">You must agree to our site terms to register.</div>';
      }

      /* - - - - - < Perform Form Validation /> - - - - - */
      if (empty($data['name_error']) && empty($data['email_error']) && empty($data['password_error']) && empty($data['confirm_error']) && empty($data['agree_error'])) {
        /* * * * * ( Hash User Password Entry )=> * * * * */
        $data['user_password'] = password_hash($data['user_password'], PASSWORD_BCRYPT);

        /* * * * * ( Create & Send Random Verification Code )=> * * * * */
        $verification = $this->userModel->createSendVerificationCode($data['user_email']);
        $data['user_verification'] = $verification;

        /* * * * * ( Check for Code Generation Errors )=> * * * * */
        if ($verification) {
          // <> Attempt to Register User </>
          if ($this->userModel->registerNewUser($data)) {
            // Set Temporary Email
            $_SESSION['veri_email'] = $data['user_email'];

            // Redirect User to Verify
            redirect('users/verify');
          } else {
            // Prepare a Flash Error Message
            flash('register_error', '<div class="alrt alrt-error">An unexpected error occurred during registration [USRR02]. Please try your request again later.</div>');

            // Reload View with the Error
            $this->view($data['page_url'], $data);
          }
        } else {
          // <> Prepare a Flash Error Message </>
          flash('register_error', '<div class="alrt alrt-error">An unexpected error occurred during registration [USRR01]. Please try your request again later.</div>');

          // <> Reload View with the Error </>
          $this->view($data['page_url'], $data);
        }
      } else {
        /* * * * * ( Reload View with the Error(s) )=> * * * * */
        $this->view($data['page_url'], $data);
      }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      /* - - - - - < Make Data Available to Application /> - - - - - */
      $data = [
        'page_title' => 'Join Now | ' . APP_NAME,
        'page_description' => '',
        'page_keywords' => '',
        'page_url' => '/users/register',
        'user_name' => '',
        'user_email' => '',
        'user_password' => '',
        'user_confirm' => '',
        'user_agree' => '',
        'name_error' => '',
        'email_error' => '',
        'password_error' => '',
        'confirm_error' => '',
        'agree_error' => ''
      ];

      /* - - - - - < Load the View & Pass in the Data /> - - - - - */
      $this->view($data['page_url'], $data);
    }
  }

  /* ~ ~ ~ ~ ~ ${ Create View for Verify Page } ~ ~ ~ ~ ~ */
  public function verify() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      /* - - - - - < Filter & Sanitize User Input /> - - - - - */
      $_POST = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);

      /* - - - - - < Attempt to Prefill Email Address /> - - - - - */
      if (isset($_SESSION['veri_email'])) {
        $email = $_SESSION['veri_email'];
      } else {
        $email = trim($_POST['email']);
      }

      /* - - - - - < Make Data Available to Application /> - - - - - */
      $data = [
        'page_title' => 'Verify Your Email | ' . APP_NAME,
        'page_description' => '',
        'page_keywords' => '',
        'page_url' => '/users/verify',
        'user_email' => $email,
        'user_verification' => trim($_POST['verification']),
        'email_error' => '',
        'verification_error' => ''
      ];

      /* - - - - - < Check that Input Fields are Valid /> - - - - - */
      if (empty($data['user_email'])) {
        $data['email_error'] = '';
      } else if (!filter_var($data['user_email'], FILTER_VALIDATE_EMAIL)) {
        $data['email_error'] = '';
      }

      if (empty($data['user_verification'])) {
        $data['verification_error'] = '';
      }

      /* - - - - - < Perform Form Validation /> - - - - - */
      if (empty($data['email_error']) && empty($data['verification_error'])) {
        /* * * * * ( Verify User Verification Code Entry )=> * * * * */
        $user = $this->userModel->verifyUserVerificationCode($data['user_email'], $data['user_verification']);
        
        if ($user) {
          // <> Remove Temporary Email </>
          unset($_SESSION['veri_email']);
          session_destroy();
          session_start();

          // <> Attempt a New User Session </>
          $this->attemptNewUserSession($user);
        } else {
          // <> Prepare a Flash Error Message </>
          flash('verification_error', '');

          // <> Reload the View with the Error </>
          $this->view($data['page_url'], $data);
        }
      } else {
        /* * * * * ( Reload the View with the Error(s) )=> * * * * */
        $this->view($data['page_url'], $data);
      }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      /* - - - - - < Attempt to Prefill Email Address /> - - - - - */
      $email = '';
      if (isset($_SESSION['veri_email'])) {
        $email = $_SESSION['veri_email'];
      }

      /* - - - - - < Make Data Available to Application /> - - - - - */
      $data = [
        'page_title' => 'Verify Your Email | ' . APP_NAME,
        'page_description' => '',
        'page_keywords' => '',
        'page_url' => '/users/verify',
        'user_email' => $email,
        'user_verification' => '',
        'email_error' => '',
        'verification_error' => ''
      ];

      /* - - - - - < Load the View & Pass in the Data /> - - - - - */
      $this->view($data['page_url'], $data);
    }
  }
}
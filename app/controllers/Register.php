<?php
class Register extends Controller {
  public function __construct($controller, $action) {
    parent::__construct($controller, $action);
    $this->load_model('Users');
    $this->view->setLayout('default');
  }

  public function indexAction() {
    self::loginAction();
  }

  public function loginAction() {
    $validation = new Validate();
    $confirmation = new Confirm();
    if ($_POST) {
      //form validation
      $validation->check($_POST, [
        'username' => [
          'display' => "Username",
          'required' => true
        ],
        'password' => [
          'display' => 'Password',
          'required' => true,
          'min' => 6
        ]
      ]);
      if ($validation->passed()) {
        $user = $this->UsersModel->findByUsername($_POST['username']);
        if ($user->id == null)
          $user = $this->UsersModel->findByEmail($_POST['username']);
        $confirmation = $confirmation->findConfirm($user);
        if ($user->id != null && password_verify(sanitize($_POST['password']), $user->password) && $confirmation->isConfirmed($user)) {
          $remember = (isset($_POST['remember_me']) && Input::get('remember_me')) ? true: false;
          $user->login($remember);
          Router::redirect('');
        } else {
          if (!$confirmation->isConfirmed($user)) {
            $this->view->displayModal = createVerifyModal($user, verifyResend($user));
            $validation->addError("Please validate your email address in order to be able to login");
          } else
            $validation->addError("There is an error with your username or password");
        }
      }
    }
    $this->view->displayErrors = $validation->displayErrors();
    $this->view->render('register/login');
  }

  public function resendVerifyAction($username) {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8";
    $user = new Users($username);
    $confirm = new Confirm();
    $confirm = $confirm->findConfirm($user);
    mail($user->email, "Email Verification", formatEmail($confirm->confirmation_str, $user), $headers);
    Router::redirect('register/login');
  }

  public function logoutAction() {
    if (currentUser()) {
      currentUser()->logout();
    }
    Router::redirect('register/login');
  }

  public function registerAction() {
    $validation = new Validate();
    $postedValues = ["fname" => "", "lname" =>"", "email"=>"", "username"=>"", "password"=>"", "confirm"=>""];

    if ($_POST) {
      $postedValues = postedValues($_POST);
      $validation->check($_POST, [
        'fname' => [
          'display' => 'First Name',
          'required' => true
        ],
        'lname' => [
          'display' => 'Last Name',
          'required' => true
        ],
        'username' => [
          'allowedChars' => true,
          'display' => 'Username',
          'required' => true,
          'unique' => 'users',
          'min' => 6,
          'max' => 150
        ],
        'email' => [
          'display' => 'Email',
          'required' => true,
          'unique' => 'users',
          'max' => 150,
          'valid_email' => true
        ],
        'password' => [
          'display' => 'Password',
          'required' => true,
          'min' => 6,
          'complexity' => true
        ],
        'confirm' => [
          'display' => 'Password confirmation',
          'required' => true,
          'min' => 6,
          'matches' => 'password'
        ]
      ]);
      if ($validation->passed()) {
        $newUser = new Users();
        $newUser->registerNewUser($_POST);
        $db = Database::getInstance();
        $this->_confirmation($_POST);
        Router::redirect('register/login');
      }
    }
    $this->view->post = $postedValues;
    $this->view->displayErrors = $validation->displayErrors();
    $this->view->render('register/register');
  }

  public function activateAction($username = '', $confirmation_str) {
    $user = new Users($username);
    $confirm = new Confirm();
    $confirm = $confirm->findFirst([
      'conditions' => 'user_id = ?',
      'bind' => [$user->id]
    ]);
    $confirm->confirmed = true;
    $user->confirmed = true;
    $user->save();
    $confirm->save();
    $user->login();
    Router::redirect('');
  }

  private function _confirmation($values) {
    $confirm = new Confirm();
    $confirm->sendConfirmation($values);
  }

  public function forgotPasswordAction() {
    $this->view->render('register/forgotPassword');
  }

  public function passwordResetRequestAction() {
    if ($_POST) {
      $user = new Users();
      $user = $user->findByEmail(sanitize($_POST['email']));
      if ($user->id == null) {
        $user = $user->findByUsername(sanitize($_POST['email']));
      }
      sendPasswordReset($user);
    }
  }

  public function pwresetTicketAction($token, $username) {
    if ($_POST) {
      $user = new Users();
      $user = $user->findByUsername($username);
      $confirm = new Confirm();
      $confirm = $confirm->findConfirm($user);
      if ($confirm->confirmation_str == $token) {
        if ($_POST['pass1'] == $_POST['pass2']) {
          $user->password = password_hash(sanitize($_POST['pass1']), PASSWORD_DEFAULT);
          $user->save();
          Router::redirect('');
        }
      }
      Router::redirect('register/pwresetTicket/'.$token.'/'.$username);
    }
    $this->view->render('register/pwreset');
  }
}

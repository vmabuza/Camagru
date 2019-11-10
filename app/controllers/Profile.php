<?php
class Profile extends Controller {
    public $user;
    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
    }

    public function indexAction() {
        $user = currentUser();
        $this->view->user = $user;
        if ($user->notifications == "1") {
            $this->view->Notification = "Notifications On";
        } else {
            $this->view->Notification = "Notifications Off";
        }
        $this->view->render('profile/index');
    }

    public function notifyToggleAction() {
        $user = currentUser();
        if ($user->notifications == "1") {
            $user->notifications = "0";
        } else {
            $user->notifications = "1";
        }
        $user->save();
        Router::redirect('profile');
    }

    public function editAction() {
        $user = currentUser();
        $this->view->user = $user;
        if ($_POST) {
            foreach($_POST as $field => $value) {
                if ($value == '')
                    continue;
                else if ($field == 'fname') {
                    $user->fname = sanitize($value);
                } else if ($field == 'lname') {
                    $user->lname = sanitize($value);
                } else if ($field == 'username') {
                    $temp_user = new Users(sanitize($value));
                    if ($temp_user->id == null) {
                        $user->username = sanitize($value);
                    }
                }
                $user->save();
            }
        }
        $this->view->render('profile/edit');
    }

    public function pwresetAction() {
        $user = currentUser();
        if ($_POST) {
            if ($_POST['password'] == $_POST['confirm']) {
                $user->password = password_hash(sanitize($_POST['password']), PASSWORD_DEFAULT);
                $user->save();
                Router::redirect('profile');
            }
        }
        $this->view->render('profile/reset');
    }

    public function emailResetAction() {
        $user = currentUser();
        if ($_POST) {
            $email = sanitize($_POST['email']);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $user->email = $email;
                $confirm = new Confirm();
                $confirm = $confirm->findFirst([
                'conditions' => 'user_id = ?',
                'bind' => [$user->id]
                ]);
                $user->confirmed = 0;
                $confirm->confirmed = 0;
                $user->save();
                $confirm->sendConfirmationUser($user);
                Router::redirect('register/logout');
            } else {
                $this->view->displayErrors = $this->_emailError();
            }
        }
        $this->view->render('profile/resetEmail');
    }

    private function _emailError() {
        $html = '<li class="text-danger">incorrectly formatted email address</li>';
        return ($html);
    }
}
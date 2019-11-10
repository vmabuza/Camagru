<?php
class Confirm extends Model {
    public function __construct() {
        $table = 'confirm';
        parent::__construct($table);
    }

    public function sendConfirmation($fields) {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8";
        $user = new Users($fields['username']);
        $params = [
            'user_id' => $user->id,
        ];
        $this->assign($params);
        $this->confirmed = 0;
        $this->confirmation_str = md5(str_shuffle($user->fname . $user->email . 'askjdhkjsahdlhaslkjdhlakjshd'));
        $this->save();
        $msg = formatEmail($this->confirmation_str, $user);
        mail($fields['email'], 'Camagru membership confirmation', $msg, $headers);
    }

    public function sendConfirmationUser($user) {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8";
        $params = [
            'user_id' => $user->id,
        ];
        $this->assign($params);
        $this->confirmed = 0;
        $this->confirmation_str = md5(str_shuffle($user->fname . $user->email . 'askjdhkjsahdlhaslkjdhlakjshd'));
        $this->save();
        $msg = formatEmail($this->confirmation_str, $user);
        mail($user->email, 'Camagru membership confirmation', $msg, $headers);
    }

    public function sendPwReset($user) {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8";
        $this->confirmation_str = md5(str_shuffle($user->fname . $user->email . 'askjdhkjsahdlhaslkjdhlakjshd'));
        $message = '
            <html>
            <head>
                <title>Password Reset Message</title>
            </head>
            <body>
                <h1>Hi '.$user->fname.' '.$user->lname.'</h1>
                <h3>Click on the following link in order to reset your password to a new one<h3>
                <a href="http://localhost:8080/camagru/register/pwresetTicket/'.$this->confirmation_str.'/'.$user->username.'"><h3>Reset Password</h3></a>
            </body>
            </html>
        ';
        if (mail($user->email, 'Camagru password reset', $message, $headers)) {
            $this->save();
        }
        Router::redirect('register/login');
    }

    public function isConfirmed($user) {
        $confirmation = new Confirm();
        $confirmation = $confirmation->findConfirm($user);
        if ($confirmation->id == null)
            return (true);
        return ($confirmation->confirmed);
    }

    public function findConfirm($user) {
        $confirmation = $this->findFIrst([
            'conditions' => 'user_id = ?',
            'bind' => [$user->id]
        ]);
        return ($confirmation);
    }

    public function errors() {
        return ($this->_db->errors());
    }
}

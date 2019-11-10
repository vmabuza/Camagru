<?php

function dnd($data) {
  echo '<pre>';
  var_dump($data);
  echo '</pre>';
  die();
}

function sanitize($dirty) {
  return htmlentities($dirty, ENT_QUOTES, 'UTF-8');
}

function currentUser() {
  return (Users::currentLoggedInUser());
}

function postedValues($post = []) {
  $cleanAry = [];
  foreach($post as $key => $value) {
    $cleanAry[$key] = sanitize($value);
  }
  return ($cleanAry);
}

function currentPage() {
  $currentPage = $_SERVER['REQUEST_URI'];
  if ($currentPage == PROOT || $currentPage == PROOT . '/home/index') {
    $currentPage = PROOT . 'home';
  }
  return ($currentPage);
}

function formatEmail($confirmation, $user) {
  if (php_uname('s') != 'Linux') {
    $msg = "
    <html>
    <head>
    <title>Camagru confirmation email</title>
    </head>
    <body>
    <h1>Good day {$user->fname} {$user->lname}</h1> <br />
    <h3>Please click on the following link to verify your email: </h3> <b />
    <a href=\"http://127.0.0.1:8080/camagru/register/activate/{$user->username}/{$confirmation}\"><h3>email confirmation</h3></a> <br />
    <br />
    <h5>Regards</h5>
    <h5>Camagru Inc</h5>
    </body>
    </html>
    ";
  } else {
    $msg = "
    <html>
    <head>
    <title>Camagru confirmation email</title>
    </head>
    <body>
    <h1>Good day {$user->fname} {$user->lname}</h1> <br />
    <h3>Please click on the following link to verify your email: </h3> <b />
    <a href=\"localhost/camagru/register/activate/{$user->username}/{$confirmation}\"><h3>email confirmation</h3></a> <br />
    <br />
    <h5>Regards</h5>
    <h5>Camagru Inc</h5>
    </body>
    </html>
    ";
  }
  return ($msg);
}

function createVerifyModal($modal = false, $message = '') {
  if ($modal) {
    return (
      '<div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content" style="width: 50%;">
          <span class="close">&times;</span>
          <p> ' . $message . ' </p>
        </div>

      </div>'
    );
  }
  return ('');
}

function verifyResend($user) {
  $msg = "Please click on the following link to resend the verification message: ";
  if (php_uname('s') == "Linux") {
    $msg .= "<a href=\"http://localhost/camagru/register/resendVerify/{$user->username}\"><p>Resend Verification Email</p></a>";
  } else {
    $msg .= "<a href=\"http://localhost:8080/camagru/register/resendVerify/{$user->username}\"><p>Resend Verification Email</p></a>";
  }
    return ($msg);
}

function is_dir_empty($dir) {
  if (!is_readable($dir)) return NULL;
  return (count(scandir($dir)) == 2);
}

function imageList() {
  $images = new Image();
  $images = $images->find();
  return ($images);
}

function imageTotal() {
  return (count(imageList()));
}

function pageCount() {
  return (ceil(imageTotal() / PAGE_SIZE));
}

function pageNated($page) {
  $db = new Image();
  $results = $db->query("SELECT * FROM image ORDER BY id DESC LIMIT " . PAGE_SIZE . ' OFFSET ' . $page - 1);
  $results = $results->makeUseOf();
  return ($results);
}

function imageOptions($for = '', $image) {
  $user = currentUser();
  return ;
  if ($user->id == $image->user_id) {
    echo "
      <button class=\"btn btn-large btn-primary\" id=\"{$user->username}ID{$image->id}Like\">LIKE</button>
    ";
  }
}

function sendPasswordReset($user) {
  $confirmation = new Confirm();
  $confirmation = $confirmation->findConfirm($user);
  $confirmation->sendPwReset($user);
}

function sendNotification($owner, $sender, $image, $flag) {
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8";
  $message = '';
  $subject = '';
  if ($flag == COM_MAIL) {
    $message = '
      <html>
      <head>
        <title>Comment recieved</title>
      </head>
      <body>
        <h1>Hi '.$owner->fname.' '.$owner->lname.'</h1>
        <h3>'.$sender->username.' has just commented on the image:</h3>
        <h3>Click the following link to see your image\'s page: <a href="http://localhost:8080/camagru/home/article/'.$image->id.'">MY IMAGE</a></h3>
      </body>
      </html>
    ';
    $subject = 'Camagru Comment Recieved';
  } else if ($flag == LIKE_MAIL) {
    $message = '
      <html>
      <head>
        <title>You got a like</title>
      </head>
      <body>
        <h1>Hi '.$owner->fname.' '.$owner->lname.'</h1>
        <h3>'.$sender->username.' just liked the following image of yours: </h3>
        <h3>Click the following link to see your image\'s page: <a href="http://localhost:8080/camagru/home/article/'.$image->id.'">MY IMAGE</a></h3>
      </body>
      </html>
    ';
    $subject = 'Camagru Image Liked';
  }
  if ($sender->id != $owner->id) {
    mail($owner->email, $subject, $message, $headers);
  }
}

function passwordComplexity($pwd) {
  if (strlen($pwd) < 8) {
    return (false);
  }
  if (!preg_match("#[0-9]+#", $pwd)) {
    return (false);
  }
  if (!preg_match("#[a-z]+#", $pwd)) {
    return (false);
  }
  if (!preg_match("#[A-Z]+#", $pwd)) {
    return (false);
  }
  return (true);
}
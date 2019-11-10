<?php $this->setSiteTitle('login page'); ?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
  <div><?= $this->displayModal ?></div>
  <div class="col-md-6 col-md-offset-3 well">
    <form class="form" action="<?=PROOT?>register/login" method="post">
      <h3 class="text-center" style="color: grey;">Login</h3>
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username or Email">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control">
      </div>
      <div class="form-group">
        <label for="remember_me">Remember me <input type="checkbox" id="remember_me" name="remember_me" value="on"></label>
      </div>
      <div class="form-group">
        <input type="submit" value="login" class="btn btn-large btn-primary">
      </div>
      <div class="text-right">
        <a href="<?=PROOT?>register/register" class="text-primary">Register</a>
      </div>
      <div class="text-left">
        <a href="<?=PROOT?>register/forgotPassword" class="text-primary">Forgot password?</a>
      </div>
      <div><?=$this->displayErrors ?></div>
    </form>
  </div>
  <?php if ($this->displayModal != '' || $this->displayModal != null)
    echo '<script src="' . PROOT . 'js/modal.js"></script>';
  ?>
<?php $this->end(); ?>

<?php $this->setSiteTitle('reset password'); ?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
  <div><?= $this->displayModal ?></div>
  <div class="col-md-6 col-md-offset-3 well">
    <form class="form" action"<?=PROOT?>register/reset" method="post">
      <h3 class="text-center" style="color: grey;">Login</h3>
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username or Email">
      </div>
      <div class="form-group">
        <input type="submit" value="reset" class="btn btn-large btn-primary">
      </div>
      <div class="text-right">
        <a href="<?=PROOT?>register/register" class="text-primary">Register</a>
      </div>
      <div><?=$this->displayErrors ?></div>
    </form>
  </div>
<?php $this->end(); ?>

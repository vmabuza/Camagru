<?php $this->setSiteTitle("Edit {$this->user->userrname} Profile"); ?>
<?php $this->start('body'); ?>
<center>
    <div class="col-md-6 col-md-offset-3 jumbotron">
        <form class="form" action="" method="post">
            <div class="form-group">
                <label for="fname">Change first Name</label>
                <input type="text" id="fname" name="fname" placeholder="<?= $this->user->fname ?>" class="form-control" value="<?= $this->post['fname']?>">
            </div>
            <div class="form-group">
                <label for="lname">Change last Name</label>
                <input type="text" id="lname" name="lname" placeholder="<?= $this->user->lname ?>" class="form-control" value="<?= $this->post['lname']?>">
            </div>
            <div class="form-group">
                <label for="username">Change your username</label>
                <input type="text" id="username" name="username" placeholder="<?= $this->user->username ?>" class="form-control" value="<?= $this->post['username']?>">
            </div>
            <div class="bg-danger"><?= $this->displayErrors; ?></div>
            <div class="pull-right">
                <input type="submit" class="btn btn-primary btn-large" value="Confirm">
            </div>
            <div class="pull-left">
                <a href="http://localhost:8080/camagru/profile/pwreset"><h5>Reset Password</h5></a>
            </div>
            <br />
            <br />
            <div class="pull-left" style="margin: 0px;">
                <a href="http://localhost:8080/camagru/profile/emailReset"><h5>Change Email Address</h5></a>
            </div>
        </form>
    </div>
</center>
<?php $this->end(); ?>
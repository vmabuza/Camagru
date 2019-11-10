<?php $this->setSiteTitle('Password Reset'); ?>
<?php $this->start('body'); ?>
<div class="col-md-6 col-md-offset-3 well">
    <form class="form" action="" method="post">
        <div class="form-group">
            <label for="password">Create a new Password</label>
            <input type="password" id="pass1" name="pass1" class="form-control" value="<?= $this->post['password']?>">
        </div>
        <div class="form-group">
            <label for="confirm">Confirm Password</label>
            <input type="password" id="pass2" name="pass2" class="form-control" value="<?= $this->post['confirm']?>">
        </div>
        <div class="bg-danger"><?= $this->displayErrors; ?></div>
        <div class="pull-right">
            <input type="submit" class="btn btn-primary btn-large" value="Reset">
        </div>
    </form>
</div>
<?php $this->end(); ?>
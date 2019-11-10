<?php $this->setSiteTitle('Reset Email'); ?>
<?php $this->start('body'); ?>
<div class="col-md-6 col-md-offset-3 well">
    <form class="form" action="" method="post">
        <div class="form-group">
            <label for="email">Enter your new email address</label>
            <input type="text" id="email" name="email" class="form-control" value="<?= $this->post['email']?>">
        </div>
        <div class="bg-danger"><?= $this->displayErrors; ?></div>
        <div class="pull-right">
            <input type="submit" class="btn btn-primary btn-large" value="Reset">
        </div>
        <div class="pull-right">
            <h3 class="text-danger">Warning: </h3>
            <h3>Changing your email will require you to verify it again</h3>
        </div>
    </form>
</div>
<?php $this->end(); ?>
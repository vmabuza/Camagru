<?php $this->start('body'); ?>
<div class="container">
    <div class="jumbotron">
        <form action="<?=PROOT?>register/passwordResetRequest" method="post" id="passwordResetRequest">
            <label for="email">Enter Email</label>
            <input type="text" name="email" id="email">
            <input type="submit" class="btn btn-md btn-warning" value="submit" id="requestButton">
        </form>
    </div>
</div>
<?php $this->end(); ?>
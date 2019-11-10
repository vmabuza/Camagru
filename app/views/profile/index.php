<?php $this->setSiteTitle("{$this->user->username} Profile"); ?>
<?php $this->start('body'); ?>
<div class="container">
    <h1 class="text-center blue"><?=$this->user->username?> Profile Page</h1> <br />
    <center>
        <div class="table-responsive">
            <table class="table" style="width: 60%;">
                <tr>
                    <td class="label-info">First Name:</td>
                    <td><?=$this->user->fname?></td>
                </tr>
                <tr>
                    <td class="label-info">Last Name:</td>
                    <td><?=$this->user->lname?></td>
                </tr>
                <tr>
                    <td class="label-info">Email Address:</td>
                    <td><?=$this->user->email?></td>
                </tr>
                <tr>
                    <td class="label-info">Username:</td>
                    <td><?=$this->user->username?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><a href="http://localhost:8080/camagru/profile/edit"><h4>Edit Profile</h4></a></td>
                </tr>
            </table>
        </div>
    </center>
</div>
<center><a href="http://localhost:8080/camagru/profile/notifyToggle"><button class="btn btn-large btn-info"><?=$this->Notification?></button></a></center>
<?php $this->end(); ?>
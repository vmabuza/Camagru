<?php $this->setSiteTitle("Article"); ?>
<?php $this->start('head'); ?>
<?php $this->end();?>
<?php $this->start('body'); ?>
<center><div class="polaroid">
    <center><img src="<?=$this->image->image_data?>" alt="article image" class="img-thumbnail" style="width: 100%"><center>
    <center>
        <div class="container">
            <?php
                $user = currentUser();
                if ($user->id != null) {
                    echo '<a href="'.PROOT.'home/like/'.$this->image->id.'"><button class="btn btn-large btn-primary">Like <span class="badge">'.$this->liked.'</span></button></a>';
                }
                if ($user->id == $this->image->user_id) {
                    echo '<a href="'.PROOT.'home/deleteImage/'.$this->image->id.'"><button class="btn btn-large btn-danger">Delete</button></a>';
                }
            ?>
        </div>
    </center>
</div></center>
<center>
    <div class="container">
        <center>
        <?php
        $user = currentUser();
        if ($user->id != null) {
            echo '<div class="container" style="width: 50%">
                <form action="'.PROOT.'home/makeComment/'.$this->image->id.'" method="post" id="comment_form">
                    <div class="form-group">
                        <center><textarea name="comment_content" id="comment_content" cols="90" rows="5" placeholder="Enter comment here"></textarea><center>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-large btn-info" value="submit comment" id="submitBtn">
                    </div>
                </form>
            </div>';
        }
        ?>
        </center>
        <center>
            <?=$this->comments?>
        </center>
    </div>
</center>
<?php $this->end();?>
<?php $this->setSiteTitle('upload or take a pic'); ?>
<?php $this->start('body'); ?>
<div class="primary">
    <div class="side-bar sidebar jumbotron" style="flex: 1; max-width: 300px;">
        <h4>Select a frame for your picture</h4>
        <nav class="sidebar-nav">
            <ul class="nav">
                <?php
                    $fileDir = ROOT . DS . 'app' . DS . 'resources' . DS . 'stickers';
                    if (!is_dir_empty($fileDir)) {
                        $files = scandir($fileDir);
                        $itr = 2;
                        while ($itr < count($files)) {
                            echo '<li class="nav-item">';
                            echo "<img src=\"" . PROOT . 'app' . DS . 'resources' . DS . "stickers" . DS . "{$files[$itr]}\" class=\"frame\" alt=\"frame\" style=\"width: 100%; height: 100%; max-width: 160px; max-height: 120px;\">";
                            echo '</li>';
                            $itr++;
                        }
                    }
                ?>
            </ul>
        </nav>
    </div>
    <div class="main-section" style="flex: 2;" class="container">
        <div class="col-md-6 col-md-offset-3 jumbotron submit-form">
            <form action="<?=PROOT?>images/upload" method="post" enctype="multipart/form-data" name="get_image">
            <label>File Image:</label><br/>
            <input type="file" id="imageLoader" name="imageLoader"/>
            <input type="button" value="Camera" class="btn btn-large btn-primary" onclick="toggleCamera()" id="photograph">
            <input name="hidden_data" id='hidden_data' type="hidden"/>
            <input name="hidden_top" id='hidden_top' type="hidden"/>
            <div class="pull-right">
                <input type="submit" class="btn btn-primary btn-large" value="submit" id="image_submit">
            </div>
            </form>
        </div>
        <canvas id="canvas" style="display: none;"></canvas>
        <br>
        <center><canvas id="imageCanvas" style="width: 100%; height: 100%; max-height: 480px; max-width: 640px;"></canvas></center>
        <center>
        <div class="camera">
            <video id="video" style="width: 100%; height: 100%; max-height: 480px; max-width: 640px;">Video stream not available</video> <br />
            <button id="startbutton" class="btn btn-primary btn-large" style="display: inline-block;">Take photo</button>
        </div>
        </center>
        <script src="<?=PROOT?>js/canvas.js"></script>
        <script src="<?=PROOT?>js/camcontrol.js"></script>
    </div>
    <div class="end-section" style="flex: 3; max-width:300px;">
        <?php
            $images = new Image();
            $user = currentUser();
            $images = $images->find([
                'conditions' => 'user_id = ?',
                'bind' => [$user->id]
            ]);
            foreach($images as $image) {
                echo '<img src="'.$image->image_data.'" class="user_images jumbotron">';
            }
        ?>
    </div>
</div>
<?php $this->end(); ?>
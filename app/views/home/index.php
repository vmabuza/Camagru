<?php $this->setSiteTitle("Gallery"); ?>
<?php $this->start('head'); ?>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<div class="gallery">
    <?php
    $images = imageList();
    $images = array_slice(array_reverse($images), ($this->page - 1) * PAGE_SIZE, PAGE_SIZE);
    foreach($images as $image) {
        echo '<a href="http://localhost:8080/camagru/home/article/'.$image->id.'"><img src="'. $image->image_data .'" class="mypics img-circle" id="'. $image->id .'"></a>';
        imageOptions('gallery', $image);
    }
    ?>
</div>
<center>
    <ul class="pagination">
        <?php
        $numPages = pageCount();
        $itr = $this->page > 1? $this->page - 1: $this->page;
        $pages = [];
        while ($itr <= $numPages){
            $pages[] =  '<li><a href="http://localhost:8080/camagru/home/index/'.$itr.'" class="pages" id="pageNum'.$itr.'">'.$itr.'</a></li>';
            $itr++;
        }
        if (count($pages) > 3) {
            $pages = array_slice($pages, 0, 3);
        }
        echo  '<li><a href="http://localhost:8080/camagru/home/index/1" class="pages" id="pageNum1">Start</a></li>';
        foreach($pages as $page) {
            echo $page;
        }
        echo  '<li><a href="http://localhost:8080/camagru/home/index/'.$numPages.'" class="pages" id="pageNum'.$numPages.'">End</a></li>';
        ?>
    </ul>
</center>
<?php $this->end(); ?>

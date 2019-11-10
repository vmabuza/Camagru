<?php
class Image extends Model {
    public function __construct() {
        $table = 'image';
        parent::__construct($table);
    }

    public function upload($tmpFile, $name) {
        $user = currentUser();
        $this->user_id = $user->id;
        $this->image_name = $name;
        $this->image_data = $tmpFile;
        $this->save();
        Router::redirect('');
    }
}
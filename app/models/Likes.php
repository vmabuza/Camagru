<?php
class Likes extends Model {
    public function __construct() {
        $table = 'likes';
        parent::__construct($table);
    }

    public function upload($imageId = '') {
        $user = currentUser();
        $image = new Image();
        $image = $image->findById($imageId);
        $tempLike = new Likes();
        $tempLike = $tempLike->find([
            'conditions' => 'user_id = ?',
            'bind' => [$user->id]
        ]);
        $tempLike = $tempLike[0];
        if ($tempLike->id != null) {
            $tempLike->unlike($tempLike->id);
        } else if ($image->id != null) {
            $this->image_id = $imageId;
            $this->user_id = $user->id;
            $this->save();
            $owner = new Users();
            $owner = $owner->findById($image->user_id);
            if ($owner->notifications == "1")
                sendNotification($owner, $user, $image, LIKE_MAIL);
        }
    }

    public function unlike($likeId = '') {
        $user = currentUser();
        $like = $this->findById($likeId);
        if ($like->id != null && $like->user_id == $user->id) {
            $like->delete();
        }
    }

    public function count($imageId = '') {
        $likes = $this->find([
            'conditions' => 'image_id = ?',
            'bind' => [$imageId]
        ]);
        if ($likes == false)
            return (0);
        return (count($likes));
    }
}
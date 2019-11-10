<?php
class Comments extends Model {
    public function __construct() {
        $table = 'comments';
        parent::__construct($table);
    }

    public function upload($image, $comment) {
        $user = currentUser();
        $this->user_id = $user->id;
        $this->image_id = $image;
        $this->content = $comment;
        $this->save();
        $owner = new Users();
        $the_image = new Image();
        $the_image = $the_image->findById($image);
        $owner = $owner->findById($the_image->user_id);
        if ($owner->notifications == "1")
            sendNotification($owner, $user, $the_image, COM_MAIL);
        Router::redirect('home/article/' . $image);
    }

    public static function fetchComments($imageId) {
        $comments = new Comments();
        $comments = $comments->find(['conditions' => 'image_id = ?', 'bind' => [$imageId]]);
        $user = currentUser();
        $comments_text = '';
        if ($comments) {
            $comments_text .= '<h1>Comments</h1>';
        }
        foreach($comments as $comment) {
            $comments_text .= '<div class="panel-group">';
            $comments_text .= '<div class="panel panel-primary">';
            $comments_text .= '<div class="panel-body">';
            $com_user = new Users();
            $com_user = $com_user->findFirst([
                'conditions' => 'id = ?',
                'bind' => [$comment->user_id]
            ]);
            $comments_text .= '<center><h4 style="text-decoration: underline">'.$com_user->username.'</h4><center>';
            $comments_text .= '</div></div>';
            $comments_text .= '<div class="panel panel-default"><div class="panel-header panel-body">';
            $comments_text .= '<center><h5 id="'.$com_user->username.'_'.$comment->id.'">'.$comment->content.'</h5></center>';
            $comments_text .= '</div></div>';
            if ($comment->user_id == $user->id) {
                $comments_text .= '<div class="panel panel-default panel-danger"><div class="panel-body">';
                $comments_text .= '<a href="'.PROOT.'home/deleteComment/'.$comment->id.'"><h1 class="text-danger">Delete Comment</h1></a>';
                $comments_text .= '</div></div></div>';
            } else {
                $comments_text .= '</div>';
            }
        }
        return ($comments_text);
    }
}
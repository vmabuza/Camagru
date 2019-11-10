<?php

class Home extends Controller {
  public function __construct($controller, $action) {
    parent::__construct($controller, $action);
  }

  public function indexAction($page = 1) {
    $this->view->page = $page;
    $this->view->render('home/index');
  }

  public function articleAction($imageId = '') {
    if ($imageId == '') {
      Router::redirect('');
    }
    $image = new Image();
    $image = $image->findById($imageId);
    if ($image->id != $imageId)
      Router::redirect('');
    $this->view->image = $image;
    $like = new Likes();
    $this->view->liked = $like->count($imageId);
    $this->view->comments = Comments::fetchComments($image->id);
    $this->view->render('home/article');
  }

  public function makeCommentAction($imageId = '') {
    if (isset($_POST['comment_content'])) {
      $user = currentUser();
      if ($user->id == null)
        Router::redirect('');
      $comment = new Comments();
      $comment->upload($imageId, sanitize($_POST['comment_content']));
      $this->articleAction($imageId);
    }
  }

  public function deleteCommentAction($comment_id = '') {
    if ($comment_id == '')
      Router::redirect('');
    $comment = new Comments();
    $comment = $comment->findById($comment_id);
    $article = $comment->image_id;
    $user = currentUser();
    if ($comment->user_id == $user->id)
      $comment->delete();
    Router::redirect('home/article/' . $article);
  }

  public function likeAction($imageId) {
    $user = currentUser();
    $like = new Likes();
    $like->upload($imageId);
    Router::redirect('home/article/'.$imageId);
  }

  public function deleteImageAction($imageId) {
    $user = currentUser();
    $image = new Image();
    $image = $image->findById($imageId);
    if ($user->id == $image->user_id) {
      $image->delete();
      Router::redirect('');
    } else {
      Router::redirect('home/article/'.$imageId);
    }
  }
}

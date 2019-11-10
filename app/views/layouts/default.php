<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=PROOT?>css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="<?=PROOT?>css/custom.css" media="screen" title="no title" charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Poor+Story" rel="stylesheet">
    <title><?= $this->siteTitle(); ?></title>
    <?= $this->content('head'); ?>

  </head>
  <body style = "">
    <?php include 'mainmenu.php'; ?>
    <div class="container-fluid" style="min-height:cal(100% - 125px);">
    <?= $this->content('body'); ?>
    </div>
    <script src="<?=PROOT?>js/custom.js"></script>
  </body>
</html>

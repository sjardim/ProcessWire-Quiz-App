<!DOCTYPE html>
<html lang="<?php echo _x('en', 'HTML language code'); ?>">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo $title; ?></title>
  <meta name="description" content="<?php echo $page->summary; ?>" />

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

  <!-- Optional theme -->
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> -->

  <style type="text/css">

    .questions-form {
      padding: 1em
    }

    label {
      display: block;
      /*background: #f7f7f7;*/
      padding: .4rem;
      text-indent: .3rem     
    }
    label:hover {
      background: #eee;
    }

    input[type="radio"]:checked+span{ font-weight: bold; } 
    
  </style>

</head>
<body>
<?php 
  $questions = $pages->find("template=question, limit=1, sort=title");
  $pagination = $questions->renderPager();
  
  foreach($questions as $question) :
?>
<div class="container questions-form">
  
  <p class="lead question-title"><?php echo $page->question_title; ?></p>
  
  <form role="form">    
    
    <?php 
      
      $i = 0;
      foreach($page->answers as $answer) { 
    
    ?>
      
    <div class="radio options-list">
    
      <label title="<?php echo __('Marcar esta opção') ?>"><input accesskey="<?php echo $i+1; ?>" class="option" type="radio" name="optradio" id="op<?php echo $i; ?>"><span><?php echo $answer->title; ?></span></label>
    
    </div>   
      
    <?php $i++; } ?>

    <hr />    
    <div class="row">
      <div class="col-md-10">
        <button type="submit" class="btn btn-success"><?php echo __('Responder') ?></button>
      </div>
      <div class="col-md-2">
        
        <a class="btn btn-default" href="#" role="button"><?php echo __('Marcar para revisão') ?></a>  
      </div>
    </div>    
  </form>

</div>
<?php endforeach; echo $pagination; ?>

<!-- Latest compiled and minified JavaScript -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->
<script src="<?php echo $config->urls->templates?>scripts/mousetrap.min.js"></script>

<script>
    // var form = document.querySelector('form');
    // var mousetrap = new Mousetrap(form);
    Mousetrap.bind('1', function() { 
      // console.log('You have selected option 1'); 
      var option = document.getElementById("op0");
      option.checked = true;      
    });
    Mousetrap.bind('2', function() {       
      var option = document.getElementById("op1");
      option.checked = true;
      // document.getElementsByTagName('label')[1].style["background"]='#D2EEEE';

    });     
    Mousetrap.bind('3', function() {       
      var option = document.getElementById("op2");
      option.checked = true;    
    });     
    Mousetrap.bind('4', function() { 
      var option = document.getElementById("op3");
      option.checked = true;    
    });     
        
</script>
</body>
</html>
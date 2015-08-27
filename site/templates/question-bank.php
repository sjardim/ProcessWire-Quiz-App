<!DOCTYPE html>
<html lang="<?php echo _x('en', 'HTML language code'); ?>">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Bla bla bla</title>
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
  $limit = 1;
  $questions = $page->children("limit=".$limit);  
  $total_pages = $questions->getTotal();
  $current_page = $input->pageNum;

  //if if is the last page, go to test results
  if($current_page <= $total_pages) {
    $next_page = $current_page + 1;
  } else {
    $next_page = $current_page - 1;
    // $session->redirect("/results", false);
  }

  $pagination = $questions->renderPager(array(
    'nextItemLabel' => __('Próxima'),
    'previousItemLabel' => __('Anterior'),
    'listMarkup' => "<ul class='pagination'>{out}</ul>",
    // 'itemMarkup' => "<li class='{class}'>{out}</li>",
    'currentItemClass' => "active",
    'linkMarkup' => "<a href='{url}'><span>{out}</span></a>",
  ));  
  foreach($questions as $question) :

?>
<div class="container questions-form">
  
  <p class="lead question-title"><?php echo $question->question_title; ?></p>
  
  <form role="form" id="form" action="<?php echo $page->url . $config->pageNumUrlPrefix . ($next_page) ?>" method="post">    
    <input type="hidden" name="question_id" value="<?php echo $question->id; ?>">
    <?php   

    $i = 0;
    foreach($question->answers as $answer) { 
    
    ?>
      
    <div class="radio options-list">
    
      <label title="<?php echo __('Marcar esta opção') ?>"><input accesskey="<?php echo $i+1; ?>" class="option" type="radio" name="choice" value="<?php echo $answer->id; ?>" id="op<?php echo $i+1; ?>"><span><?php echo $answer->title; ?> - <?php echo $answer->id; ?></span></label>
    
    </div>   
      
    <?php $i++; } ?>

    <hr />    
    <div class="row">
      <div class="col-md-10">
        <button type="submit" id="btsubmit" class="btn btn-success"><?php echo __('Responder') ?></button>
      </div>
      <div class="col-md-2">
        
        <a class="btn btn-default" href="#" role="button"><?php echo __('Marcar para revisão') ?></a>  
      </div>
    </div>    
  </form>

</div>
<?php endforeach; ?>


<div class="container">
<script>

  function setValue(choice_value) {
    var radios = document.getElementsByName('choice');

    for (var i = 0, length = radios.length; i < length; i++) {      
        if (radios[i].value == choice_value) {
            // do whatever you want with the checked radio
            radios[i].checked = true;
            // only one radio can be logically checked, don't check the rest
            break;
        }
    }
  }
</script>
<?php 
  echo $pagination;
    
    if(!is_array($session->user_answers)) {
        $session->user_answers = array('user' => $user->id);
    } else {
      $old = $session->user_answers;
      // $old[$question->id] = $input->post->question_id;
      if(array_key_exists($question->id, $old)) {
        echo $question->id." already answered!";
        echo "<script>setValue('".$old[$question->id]."');</script>";
      }

      $new = array($input->post->question_id => $input->post->choice);
      
      $session->user_answers = $old + $new;
    }
  
    // $session->remove('user_answers');
  

    echo "<pre>";
    print_r($session->user_answers);
    echo "</pre>";
  
  

?>
</div>



<!-- Latest compiled and minified JavaScript -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->
<script src="<?php echo $config->urls->templates?>scripts/mousetrap.min.js"></script>

<script>
    // var form = document.querySelector('form');
    // var mousetrap = new Mousetrap(form);
    Mousetrap.bind('1', function() { 
      // console.log('You have selected option 1'); 
      var option = document.getElementById("op1");
      option.checked = true;      
    });
    Mousetrap.bind('2', function() {       
      var option = document.getElementById("op2");
      option.checked = true;
      // document.getElementsByTagName('label')[1].style["background"]='#D2EEEE';

    });     
    Mousetrap.bind('3', function() {       
      var option = document.getElementById("op3");
      option.checked = true;    
    });     
    Mousetrap.bind('4', function() { 
      var option = document.getElementById("op4");
      option.checked = true;    
    });
    Mousetrap.bind('space', function() { 
      // console.log('You submitted the form');
      document.getElementById("form").submit();
    });
        
</script>
</body>
</html>
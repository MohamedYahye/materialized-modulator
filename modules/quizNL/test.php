<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Wat voor tuintype ben jij?</title>
    
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,400' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic' rel='stylesheet' type='text/css'>
    <?php 
    include 'test/includes/database.php';
    include 'test/includes/functions.php';
    ?>
    <link rel="stylesheet" type="text/css" href="css/style.css" />

</head>
<body>
<?php
session_start();
$counting = 0;
function insertHTML($nRows, $nummer, $title, $name, $image, $firstImage, $secondImage, $thirdImage, $fourthImae, $counting){
  if($image == 'yes'){
    //checks if the file format is .jpg. if it is, insert with jpg else insert with JPG.
    if(file_exists('imgs/'.$firstImage.'.jpg')) {
      $img1 = '<img src="imgs/'.$firstImage.'.jpg"></img>';
    } else  {
      $img1 = '<img src="imgs/'.$firstImage.'.JPG"></img>';
    }
    if(file_exists('imgs/'.$secondImage.'.jpg')) {
      $img2 = '<img src="imgs/'.$secondImage.'.jpg"></img>';
    } else  {
      $img2 = '<img src="imgs/'.$secondImage.'.JPG"></img>';
    }
    if(file_exists('imgs/'.$thirdImage.'.jpg')) {
      $img3 = '<img src="imgs/'.$thirdImage.'.jpg"></img>';
    } else  {
      $img3 = '<img src="imgs/'.$thirdImage.'.JPG"></img>';
    }
    if(file_exists('imgs/'.$fourthImae.'.jpg')) {
      $img4 = '<img src="imgs/'.$fourthImae.'.jpg"></img>';
    } else  {
      $img4 = '<img src="imgs/'.$fourthImae.'.JPG"></img>';
    }
    //creates the style of the image 
    $color = 'none';
    $styleTop = '';
    $labelLH = 'style="line-height: 50px;"';
    $centerQuestion = '';

  } else {
    //creates the style of the textbox.
    $img1 = $firstImage.'<br />';
    $img2 = $secondImage.'<br />';
    $img3 = $thirdImage.'<br />';
    $img4 = $fourthImae.'<br />';

    $color = 'colorBackground';
    $styleTop = 'style="margin-top:1%; width: 45%;"';
    $labelLH = 'style="line-height: 22px;"';
    $centerQuestion = 'questionBox';
  }
  //echo's the quiz.
  echo '
  <div class="view" data-number='.$counting.'>
  <div id="header">
      <span id="headerTitle">Tuintest Snoek: Wat voor tuintype ben jij?</span>
      <img id="logo" src="img/SnoekWit.png"></img>
  </div>
  <h1 style="text-align: center;">'.$title.'</h1>

        <div id="questions">
          <div id="questions2">
          <div class="'.$centerQuestion.'">
          <div '.$styleTop.' id="blok1" class="blok '.$color.'">
          <input type="radio" name="'.$name.'-answers" id="'.$name.'-answers-A" value="A" />
                    <label '.$labelLH.' for="'.$name.'-answers-A" class="fwrd labela">'.$img1.'</label>
          </div>
          <div '.$styleTop.' id="blok2" class="blok '.$color.'">
          <input type="radio" name="'.$name.'-answers" id="'.$name.'-answers-B" value="B" />
                <label '.$labelLH.'for="'.$name.'-answers-B" class="fwrd labelb">'.$img2.'</label>
          </div>
          <div '.$styleTop.' id="blok3" class="blok '.$color.'">
          <input type="radio" name="'.$name.'-answers" id="'.$name.'-answers-C" value="C" />

                <label '.$labelLH.' for="'.$name.'-answers-C" class="fwrd labelc">'.$img3.'</label>
          </div>
          <div '.$styleTop.' id="blok4" class="blok '.$color.'">
          <input type="radio" name="'.$name.'-answers" id="'.$name.'-answers-D" value="D" />
                
                <label '.$labelLH.' for="'.$name.'-answers-D" class="fwrd labeld">'.$img4.'</label>
          </div>
          </div>
          </div>
          <ul class="pagination">';
         //pagination
         for($i=1;$i<=$nRows;$i++){
          if($i == $nummer){
            $active = 'active';
          } else {
            $active = '';
          }
          echo '<li class="'.$active.'">'.$i.'</li>';
         }
         echo '</ul></div></div>';
}
$query = $db->prepare("SELECT * FROM insertquestion ORDER BY nummer");
$query->execute();
$TEST = $query->execute();
$results = $query->fetchAll();

$nRows = $db->query('select count(*) from insertquestion')->fetchColumn(); 
?>
    <div id="page-wrap">
        <h1 class="transparent index-headline">Wat voor tuintype ben jij?</h1>
          <form action="grade.php?nrows=<?php echo $nRows ?>" method="post" id="quiz">
            <ul id="test-questions">
                    <?php
                      foreach($results as $result){
                        $naam = $result['naam'];
                        $nummer = $result['nummer'];
                        $nummer_question = 'question-'.$nummer;
                        $yn = $result['yn'];
                        $firstImage = $result['imgFirst'];
                        $secondImage = $result['imgSecond'];
                        $thirdImage = $result['imgThird'];
                        $fourthImae = $result['imgFourth'];
                        ?>
                        <li>
                        <?php
                        //number equal to the page your on.
                        //increases everytime a question is clicked on and the next one is generated on the screen.
                        $counting = $counting + 1;
                        //inserts the quiz.
                        insertHTML($nRows, $nummer , $naam, $nummer_question, $yn, $firstImage, $secondImage, $thirdImage, $fourthImae, $counting);
                        ?>
                        </li>
                        <?php
                      }
                    ?>
                    <div id="submit"></div>
            </ul>

          </form>
        <div class="nomargin"></div>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script>
    <script>
           (function($) {
              var timeout= null;
              var $mt = 0;
              var number = <?php echo $counting ?>;
              $('.blok').on('click', function(e) {
                //displays the next question.
                var huidigeView = $(e.currentTarget).parent().parent().parent().parent().data('number');
                //nextview = the number of the question after the question your currently on.
                var nextView = huidigeView + 1;
                var text = "<div id='header'><span id='headerTitle'>Tuintest Snoek: Wat voor tuintype ben jij?</span><img id='logo' src='img/SnoekWit.png'></img></div><div id='submitResultsOuter'><ul id='padding' style='border-radius:20px;border: 1px solid green;'><li><h3 class='anticipate'>Bekijk nu je resultaat!</h3><input class='resultSubmit' type='submit' value='Bekijk je resultaat!' id='submit-quiz' /></li></ul></div>";

                  //hides current question
                  $('.view').delay("slow").hide();
                  //shows next question
                  $('.view[data-number="' + nextView + '"]').show()

                  if(huidigeView == number){
                    $( "#submit" ).replaceWith(text);
                  }
              });
           }(jQuery))
    </script>
    <script>
      //if device is hold vertical force the quiz on landscape (horizontal) mode
      var start = function() {
        screen.orientation.lock('landscape-primary').then(
          startInternal,
          function() {
            alert('To start, rotate your screen to landscape.');

            var orientationChangeHandler = function() {
              if (!screen.orientation.type.startsWith('landscape')) {
                return;
              }
              screen.orientation.removeEventListener('change', orientationChangeHandler);
              startInternal();
            }

            screen.orientation.addEventListener('change', orientationChangeHandler);
          });
      }
      window.onload = start;
    </script>

    <div id="warning-message">
        this website is only viewable in landscape mode
    </div>
</body>
</html>


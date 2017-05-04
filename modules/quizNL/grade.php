<!DOCTYPE html>
<html>
<head>
    <title>Wat voor tuintype ben jij?</title>
    <?php    
    include 'test/includes/database.php';
    include 'test/includes/functions.php';
    ?>
    <link rel="stylesheet" type="text/css" href="css/result.css" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,400' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script type="text/javascript" src="test/includes/jspdf.min.js"></script>

</head>
<body>
    <div id="page-wrap">
    <div id="header">
        <span id="headerTitle">Tuintest Snoek: Wat voor tuintype ben jij?</span>
        <img id="logo" src="img/SnoekWit.png"></img>
    </div>
    <div id="buttons">

        <a class="button button1 logout" href="index.html">Opnieuw</a>
        <a class="button button1 logout contact" href="http://www.snoekgroep.nl/contact/grou/"  target="_blank">Neem contact op!</a>
    </div>

        <?php
        error_reporting(0);
        	$totalA = 0;
        	$totalB = 0;
        	$totalC = 0;
        	$totalD = 0;

            if(!empty($_GET['nrows'])){
                $nRows = $_GET['nrows'];
                
                for($i = 1; $i < $nRows; $i++){
                    $vraag = $i;
                    $answer = '$answer'.$i;
                    $answerNumber = $_POST['question-'.$i.'-answers'];
                    $query = $db->prepare("SELECT * FROM vraag WHERE vraagnummer = :VRAAG AND antwoord = :ANTWOORD");
                    $query->bindparam(":VRAAG",$vraag);
                    $query->bindparam(":ANTWOORD",$answerNumber);
                    $query->execute();
                    $TEST = $query->execute();
                    while ($has_author = $query->fetch()) {
                        $VN = $has_author['vraagnummer'];
                        $A = $has_author['antwoord'];
                        $PA = $has_author['puntenA'];
                        $PB = $has_author['puntenB'];
                        $PC = $has_author['puntenC'];
                        $PD = $has_author['puntenD'];
                        
                        $totalA = $totalA + $PA; 
                        $totalB = $totalB + $PB; 
                        $totalC = $totalC + $PC; 
                        $totalD = $totalD + $PD; 
                    }
                }
            } else {
              echo 'empty';
            }

          ?>
          <div id="overlay" class="results-overlay">
                     <?php

                        $percentA = $totalA * 3;
                        $percentB = $totalB * 3;
                        $percentC = $totalC * 3;
                        $percentD = $totalD * 3;
                        $percentE = $percentA + $percentD;
                        $percentF = $percentB + $percentC;

                        if($percentE > 100){
                            $percentE = 100;
                        } 
                        if($percentF > 100){
                            $percentF = 100;
                        }
                        if($percentD > 100){
                            $percentD = 100;
                        }
                    $temp_array = [];

                    $results = array(
                        'A' => 
                          ['percent' => $percentA, 
                           'value'=>'blauw',
                           'letter' => 'A', 
                           'text' => 'De Prestigieuze Perfectionisten. Willen succes, erkenning, rust en privacy. Zij zijn assertief, kritisch, carri&#232;re gericht en verdienen bovengemiddeld.Met hun tuin maar ook met hun interieur willen zij status uitstralen. Huis en tuin zijn vaak bovengemiddeld groot, de inrichting van beide is stijlvol en op het gebied van interieur hecht deze consument aan hoogwaardige kwaliteit en aan een exclusieve uitstraling. In de tuin willen zij exclusief en duurzaam materiaalgebruik. Dit type tuinbezitter zal dan ook vaker dan de andere types een tuinarchitect inschakelen.Dit type zegt een natuurlijke tuin vol groen te hebben; een plek van rust en gezelligheid. Maar ook tijdloos en representatief. Men is bovengemiddeld tevreden met de tuin en heeft ervaring met tuinonderhoud. 78% heeft een plantenborder, meerdere terrassen (56%) en een vijver of vijverelementen (44%). De ideale tuin is gezellig en een plek van rust (60%) en ook sfeervol en vol groen (37%). Deze groep kijkt meer dan gemiddeld in tuinboeken.'
                           ],
                        'B' => 
                          ['percent' => $percentB, 
                           'value'=>'rood', 
                           'letter' => 'B', 
                           'text' => 'Eigenzinnige Tuinbezitters: onafhankelijk, impulsief en individueel.  Gericht op zelfontplooiing en groei. vrijgezel of samenwonend en heeft als beroep vaak een zelfstandige functie. Dit type is vaker een man (57%), heeft een bovenmodaal inkomen en vaak een koopwoning. De tuin is wel belangrijk maar tuinieren is een noodzakelijk kwaad en steekt er dus liever geen tijd in. Ideale tuin is makkelijk te onderhouden, gezellig en praktisch. Minder tevreden dan de andere types over zijn huidige tuin. Als hij bij het tuincentrum komt, wil hij meer dan de andere types worden geadviseerd over de inrichting van zijn tuin.Doet impulsieve aankopen voor zowel het huis als de tuin.'
                           ],
                        'C' => 
                          ['percent' => $percentC, 
                           'value'=>'geel', 
                           'letter' => 'C', 
                           'text' => 'De Sociale Buitengenieters zijn uitermate sociaal gericht. Ze houden van  gezelligheid, samen genieten en gemak. Het zijn vaker vrouwen tussen tussen en 30 en 40 jaar met twee of meer kinderen. Huis en tuin zijn een plek om leuke dingen te doen, liefst met anderenen en dus sluit de inrichting daarop aan: terras met tafel en stoelen, kinderspeelgoed.Hun ideale tuin is gemakkelijk te onderhouden (want het mag niet teveel tijd kosten), gezellig en aangepast aan de kinderen.In het tuincentrum zien ze ter plekke wel wat ze kopen. Ze kijken het meest van alle types naar woonprogramma&#39;s en lezen de meeste woontijdschriften. Ze geven niet veel geld uit aan inriuchting en de tuin, maar als ze  dan geld uitgegeven is dit meestal voor  accessoires of verf.'
                           ],
                        'D' => 
                          ['percent' => $percentD, 
                           'value'=>'groen', 
                           'letter' => 'D', 
                           'text' => ' Tuinliefhebbers. Deze mensen zijn behulpzaam, zachtaardig en ge&iuml;nteresseerd in anderen. Tuinieren is hun grootste hobby en tuinonderhoud is leuk en mag best tijd kosten. Men is bovengemiddeld tevreden met de tuin, heeft ervaring met tuinonderhoud, Hun ideale tuin is gezellig, een plek van rust, natuurlijk en vol groen. Ze hebben vaker een moestuin, vinden het belangrijk dat planten in de tuin op elkaar zijn afgestemd en zijn altijd op zoek naar nieuwe soorten. Zij lezen meer dan gemiddeld de Libelle  en de Groei & Bloei.'
                            ],
                        'E' => 
                          ['percent' => $percentE, 
                           'value'=>'geelgroen', 
                           'letter' => 'E', 
                           'text' => 'Tuinconformisten. Sociaal, maar minder bezig met de inrichting van het huis of met de tuin dan de gele tuintypes. Hun tuin past bij de tuinen in de omgeving en de buren; en er is geen behoefte om zich te onderscheiden van anderen. Tuinconformisten vervangen huis interieur alleen als dat echt nodig is en ook  in de tuin wordt over het algemeen weinig energie gestoken.'],
                        'F' => 
                          ['percent' => $percentF, 
                           'value'=>'blauwgroen', 
                           'letter' => 'F', 
                           'text' => ' De Trotse Tuinbezitters. Ze hebben grote binding met de tuin, zijn er trots op. Deze mensen zijn  spontaan, vrolijk, vlot, gezellig met klasse. Hun tuin is sfeervol, gezellig en netjes. Het zijn vaak warme gezinnen. In hun vrije tijd gaan ze uit, leggen bezoekjes af en tuinieren. Waarden zijn vriendschap, respect en genieten van het leven. Dit type is ook vaker vrouw . Ze zijn bovengemiddeld tevreden met de eigen tuin en zeggen ervaring te hebben met het tuinonderhou waarvan 40% zegt dat het leuk is en dus best wat tijd mag kosten. De ideale tuin is gezellig, een plek van rust, netjes en natuurlijk. Dit type noemt de tuin ook buitenkamer.Een kwart kijkt &eacute;&eacute;n keer per week of vaker naar tuinprogramma&#39;s en leest ook Libelle en Margriet.'
                            ]
                    );
                    $aValue = $results['A']['value'];
                    $bValue = $results['B']['value'];
                    $cValue = $results['C']['value'];
                    $dValue = $results['D']['value'];
                    $eValue = $results['E']['value'];
                    $fValue = $results['F']['value'];


                    $aPercent = $results['A']['percent'];
                    $bPercent = $results['B']['percent'];
                    $cPercent = $results['C']['percent'];
                    $dPercent = $results['D']['percent'];
                    $ePercent = $results['E']['percent'];
                    $fPercent = $results['F']['percent'];

                    ?>  
                    <form method="post" action="mailer.php" target="_blank">
                        <input type="hidden" name="aValue" value="<?php echo $aValue ?>">
                        <input type="hidden" name="bValue" value="<?php echo $bValue ?>">
                        <input type="hidden" name="cValue" value="<?php echo $cValue ?>">
                        <input type="hidden" name="dValue" value="<?php echo $dValue ?>">
                        <input type="hidden" name="eValue" value="<?php echo $eValue ?>">
                        <input type="hidden" name="fValue" value="<?php echo $fValue ?>">


                        <input type="hidden" name="aPercent" value="<?php echo $aPercent ?>">
                        <input type="hidden" name="bPercent" value="<?php echo $bPercent ?>">
                        <input type="hidden" name="cPercent" value="<?php echo $cPercent ?>">
                        <input type="hidden" name="dPercent" value="<?php echo $dPercent ?>">
                        <input type="hidden" name="ePercent" value="<?php echo $ePercent ?>">
                        <input type="hidden" name="fPercent" value="<?php echo $fPercent ?>">

                        <input type="submit" class="button button1 logout mail" value="Mail je resultaat" >
                    </form>

<!--                        <a class="button button1 logout mail" href="mailer.php?aV=<?php echo $aValue ?>&aP=<?php echo $aPercent?>"  target="_blank">Mail je resultaat</a>
 -->                    <?php


                    usort($results, function($a, $b) {
                        if ($a['percent'] == $b['percent']) {
                            return 0;
                        }
                        return ($a['percent'] > $b['percent']) ? -1 : 1;
                    });

                    foreach($results as $result){
                        $letter = $result['letter'];
                        $percent_ = $result['percent'];
                        $img = $result['value'];
                        $text = $result['text'];
                        $value = $result['value'];
                        insertResultbar($percent_, $letter, $img, $text, $value);
                    }

                     $percentA = $percentA.'%';
                     $percentB = $percentB.'%';
                     $percentC = $percentC.'%';
                     $percentD = $percentD.'%';
                     $percentE = $percentE.'%';
                     $percentF = $percentF.'%';

                 ?>
                     </div>
                     </div>
                     <script>

                     var thisLabelA = document.getElementById("resultA");
                     thisLabelA.style.width="<?php echo $percentA ?>";

                     var thisLabelB = document.getElementById("resultB");
                     thisLabelB.style.width="<?php echo $percentB ?>";
                                          
                    var thisLabelC = document.getElementById("resultC");
                    thisLabelC.style.width="<?php echo $percentC ?>";
                                                               
                     var thisLabelD = document.getElementById("resultD");
                     thisLabelD.style.width="<?php echo $percentD ?>";

                     var thisLabelE = document.getElementById("resultE");
                     thisLabelE.style.width="<?php echo $percentE ?>";

                     var thisLabelF = document.getElementById("resultF");
                     thisLabelF.style.width="<?php echo $percentF ?>";

                     </script>
</body>
</html>

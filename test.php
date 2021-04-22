<?php
require('vendor/autoload.php');

$session_1 = new \MathPractice\PlayerSession(25, 50, [], 0);

$session_1->addQuestionsFromFile( 'tests/data/questions.json' );

$session_1->printQuestions();

$session_1->getTotalPoints();


?>

<?php
require('vendor/autoload.php');

$session_1 = new \MathPractice\PlayerSession(25, 50, []);

$session_1->addQuestionsFromFile( 'tests/data/questions.json' );

$session_1->printQuestions();


?>

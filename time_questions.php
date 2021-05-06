<?php
require('vendor/autoload.php');

$questionsQuantity = $argv[0];
$questionsFilter = [];
$timeLimit = 59;
if (isset($argv[2])) {
    $questionsFilter['level'] = intval($argv[2]);
}
if (isset($argv[1])) {
    $timeLimit = intval($argv[1]);
}

$session = new \MathPractice\PlayerSession($timeLimit, []);
$session->addQuestionsFromFile('tests/data/questions.json', $questionsFilter);
$questions = $session->getQuestions();
foreach($questions as $questionIndex => $questions) {
    $session->prepareQuestion($questionIndex);
    echo $session->getQuestionText($questionIndex) . "\n";
    $answerInput = readline('Answer: ');
    if (!$session->answerQuestion($questionIndex, $answerInput)) {
        echo 'Wrong!';
    } else {
        echo 'Cool you did it!';
    }
    echo  "\n";
    echo  "\n";
}
echo 'Puntaje total: ' . $session->getScore() . ' / ' . $session->getTotalPoints() . "\n";
echo 'Score (%): ' .  ($session->getScore() * 100) * $session->getTotalPoints();

<?php
/**
 * @author  Flormarys Diaz <flormarysdiaz@gmail.com>
 * @license GPLv3 (or any later version)
 * PHP 7.3.27
 */

namespace MathPractice;

class PlayerSession
{
  private $timeLimit;
  private $score;
  private $questions;

  // Una propiedad questions

  public function __construct(
    int $timeLimit,
    int $score,
    array $questions
    )
  {
    $this->timeLimit = $timeLimit;
    $this->score = $score;
    $this->questions = $questions;
  }

  public function setSessionTime(int $sessionTime) : void
  {
    $this->time = $sessionTime;
  }

  public function printQuestions() : void
  {
    $counter = 1;
    foreach($this->questions as $question) {
      echo "Q{$counter}: " . $question->getText() .
        ". Points: {$question->getPoints()}." .
        " Type: {$question->getType()->getName()}  \n";
      $counter ++;
    }
  }

  public function addQuestionsFromFile(string $filePath) : void
  {
    $jsonDataEncoded = file_get_contents($filePath);
    $questionsJson = json_decode($jsonDataEncoded);
    foreach( $questionsJson->questions as $question ) {
      $questionTypeObject = new QuestionsType(
        $question->questionsType->name,
        $question->questionsType->level
      );
      $this->questions[] = new Question(
        $questionTypeObject,
        $question->text,
        $question->points,
        $question->status
      );
    }
  }

  public function getQuestions() : array
  {
    return $this->questions;
  }

}

?>

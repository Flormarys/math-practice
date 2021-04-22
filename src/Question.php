<?php
/**
 * @author  Flormarys Diaz <flormarysdiaz@gmail.com>
 * @license GPLv3 (or any later version)
 * PHP 7.3.27
 */

namespace MathPractice;

class Question
{
  private $type;
  private $text;
  private $points;
  private $status;

  public function __construct(
    QuestionsType $type,
    string $text,
    int $points,
    int $status
    )
  {
    $this->type = $type;
    $this->text = $text;
    $this->points = $points;
    $this->status = $status;
  }

  public function getText() : string {
    return $this->text;
  }

  public function getPoints() : int {
    return $this->points;
  }

  public function getStatus() : int {
    return $this->status;
  }

  public function getType() : QuestionsType {
    return $this->type;
  }
}

?>

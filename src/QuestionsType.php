<?php
/**
 * @author  Flormarys Diaz <flormarysdiaz@gmail.com>
 * @license GPLv3 (or any later version)
 * PHP 7.3.27
 */

namespace MathPractice;

class QuestionsType
{
  private $name;
  private $level;

  public function __construct(
    string $name,
    int $level
    )
  {
    $this->name = $name;
    $this->level = $level;
  }

  public function getName() : string {
    return $this->name;
  }

  public function getLevel() : int {
    return $this->level;
  }

}

?>

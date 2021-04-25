<?php
/**
 * @author  Flormarys Diaz <flormarysdiaz@gmail.com>
 * @license GPLv3 (or any later version)
 * PHP 7.4.16
 */

namespace MathPractice;

class QuestionsType
{
    private $name;
    private $level;
    private $timeLimit;

    public function __construct(
        string $name,
        int $level,
        int $timeLimit
    ) {
        $this->name = $name;
        $this->level = $level;
        $this->timeLimit = $timeLimit * 60;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getLevel() : int
    {
        return $this->level;
    }

    public function getTimeLimit() : int
    {
        return $this->timeLimit;
    }

    public function setLimit(int $timeLimit) : void
    {
        if ($timeLimit >= 0){
            $this->timeLimit = $timeLimit;
        }
    }

}

?>

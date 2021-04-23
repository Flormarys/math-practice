<?php
/**
* @author  Flormarys Diaz <flormarysdiaz@gmail.com>
* @license GPLv3 (or any later version)
* PHP 7.4.16
*/

namespace MathPractice;

class Question
{
    private $type;
    private $text;
    private $points;
    private $status;
    private $operator;
    private $firstTime;
    private $secondTime;
    private $answer;

    public function __construct(
        QuestionsType $type,
        string $text,
        int $points,
        bool $status,
        string $operator
    ) {
        $this->type = $type;
        $this->text = $text;
        $this->points = $points;
        $this->status = false;
        $this->operator = $operator;
    }

    public function getText() : string
    {
        return $this->text;
    }

    public function getPoints() : int
    {
        return $this->points;
    }

    public function getStatus() : bool
    {
        return $this->status;
    }

    public function setStatus(bool $status) : void
    {
        $this->status = $status;
    }

    public function getType() : QuestionsType
    {
        return $this->type;
    }

    public function getOperator() : string
    {
        return $this->operator;
    }

    public function setFirstTime(int $firstTime) : void
    {
        $this->firstTime = $firstTime;
    }

    public function setSecondTime(int $secondTime) : void
    {
        $this->secondTime = $secondTime;
    }

    public function isBetweenTheLimits() : bool
    {
        $checkTimeLimit = $this->secondTime - $this->firstTime;
        if($checkTimeLimit <= $this->type->getTimeLimit()){
            return true;
        }
        return false;
    }

    public function getAnswer() {
        switch ($this->operator) {
            case '-':
                return $this->secondTime - $this->firstTime;
            break;
            case "+":
                return $this->secondTime + $this->firstTime;
            break;
        }
    }

}

?>

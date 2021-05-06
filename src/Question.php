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
    private $firstTime;
    private $secondTime;
    private $answer;
    private $formula;
    private $answerFormat;
    private $parameterFormat;

    public function __construct(
        QuestionsType $type,
        string $text,
        int $points,
        bool $status,
        array $formula,
        string $answerFormat,
        ?string $parameterFormat = null
    ) {
        $this->type = $type;
        $this->text = $text;
        $this->points = $points;
        $this->status = false;
        $this->formula = $formula;
        $this->answerFormat = $answerFormat;
        $this->parameterFormat = (isset($parameterFormat)) ? $parameterFormat : null;
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

    public function setVariables(int $firstTime, int $secondTime) : void
    {
        if ($firstTime > $secondTime) {
            throw new \Exception("First value must be bellow second value");
            return;
        }
        $this->firstTime = new Variable($firstTime);
        $this->secondTime = new Variable($secondTime);
        $this->calculateAnswer();
    }

    public function isBetweenTheLimits() : bool
    {
        if (!empty($this->firstTime)) {
            $timeDifference = $this->secondTime->getValue() - $this->firstTime->getValue();
            if ($timeDifference <= $this->type->getTimeLimit()) {
                return true;
            }
        }
        return false;
    }

    public function getAnswer() : Variable
    {
        return $this->answer;
    }

    private function calculateAnswer() : Variable
    {
        $this->answer = ($this->formula[1] == "+") ?
             $this->firstTime->addition($this->secondTime) :
             $this->secondTime->substraction($this->firstTime, $this->answerFormat);
        return $this->answer;
    }

    public function getReeplacedText() : string
    {
        $firstTime = date("g:i A", $this->firstTime->getValue() * 60);
        $secondTime = date("g:i A", $this->secondTime->getValue() * 60);
        if ($this->answerFormat == Variable::TIME_TYPE) {
            $secondTime = date("i", $this->secondTime->getValue() * 60);
        }
        $firstVariableReplaced = str_replace("%1", $firstTime, $this->text);
        return str_replace("%2", $secondTime, $firstVariableReplaced);
    }

    public function tryAnswer($tryingToAnswer) : bool
    {
        return $this->answer->getValue($this->answerFormat) == $tryingToAnswer;
    }
}

?>

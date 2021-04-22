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
    private $answer;

    public function __construct(
        QuestionsType $type,
        string $text,
        int $points,
        string $answer
    ) {
        $this->type = $type;
        $this->text = $text;
        $this->points = $points;
        $this->status = false;
        $this->answer = $answer;
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

    public function getAnswer() : string
    {
        return $this->answer;
    }
}

?>

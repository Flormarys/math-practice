<?php
/**
 * @author  Flormarys Diaz <flormarysdiaz@gmail.com>
 * @license GPLv3 (or any later version)
 * PHP 7.4.16
 */

declare(strict_types=1);

require __DIR__ . "/../vendor/autoload.php";
use PHPUnit\Framework\TestCase;
use MathPractice\Question;
use MathPractice\QuestionsType;

final class QuestionTest extends TestCase
{

    public function testQuestionLimits()
    {
        $question = $this->getNewQuestion();
        $question->getType()->setLimit(60 * 20);
        $date_from = strtotime('2021-04-15 14:20');
        $date_to = strtotime('2021-04-15 14:45');
        $question->setFirstTime($date_from);
        $question->setSecondTime($date_to);
        $this->assertFalse($question->isBetweenTheLimits());
        $question->getType()->setLimit(60 * 24);
        $this->assertFalse($question->isBetweenTheLimits());
        $question->getType()->setLimit((60 * 25) - 1);
        $this->assertFalse($question->isBetweenTheLimits());
        $question->getType()->setLimit(60 * 25);
        $this->assertTrue($question->isBetweenTheLimits());
        $question->getType()->setLimit(60 * 9999999);
        $this->assertTrue($question->isBetweenTheLimits());
        $date_from = strtotime('2021-04-15 14:20');
        $date_to = strtotime('2021-04-15 14:21');
        $question->setFirstTime($date_from);
        $question->setSecondTime($date_to);
        $question->getType()->setLimit(60);
        $this->assertTrue($question->isBetweenTheLimits());
        $question->getType()->setLimit(59);
        $this->assertFalse($question->isBetweenTheLimits());
    }

    public function testIncorrectLimits() {
        $question = $this->getNewQuestion();
        $question->getType()->setLimit(59);
        $date_from = strtotime('2021-04-15 14:20');
        $date_to = strtotime('2021-04-15 14:45');
        $question->setFirstTime($date_from);
        $question->setSecondTime($date_to);
        $question->getType()->setLimit(-1);
        $this->assertEquals($question->getType()->getTimeLimit(), 59);
        $question->getType()->setLimit(-200);
        $this->assertEquals($question->getType()->getTimeLimit(), 59);
    }

    public function testQuestionText() {
        $question = $this->getNewQuestion();
        $date_from = strtotime('2021-04-15 14:20');
        $date_to = strtotime('2021-04-15 14:45');
        $question->setFirstTime($date_from);
        $question->setSecondTime($date_to);
        $question->setLimit(60 * 60);
        $this->assertTrue($question->isBetweenTheLimits());
        $this->assertEquals(
            $question->getReeplacedText(),
            'Indicate difference between 2:20 PM and 2:45 PM'
        );

        $date_from = strtotime('2021-04-15 14:20');
        $date_to = strtotime('2021-04-15 13:45');
        $question->setFirstTime($date_from);
        $question->setSecondTime($date_to);
        $this->assertFalse($question->isBetweenTheLimits());
        $this->assertEquals(
            $question->getReeplacedText(),
            'Indicate difference between %1 and %2'
        );
    }

    public function testTryAnswers() {
        $question = $this->getNewQuestion();
        $question->setLimit(60 * 60);
        $date_from = strtotime('2021-04-15 14:20');
        $date_to = strtotime('2021-04-15 14:45');
        $question->setFirstTime($date_from);
        $question->setSecondTime($date_to);
        $correctAnswer = 60 * 25; // 25 minutes

        $this->assertEquals($question->getAnswer(), $correctAnswer);
        $this->assertFalse($question->tryAnswer($correctAnswer + 60));
        $this->assertFalse($question->tryAnswer($correctAnswer - 60));
        $this->assertFalse($question->tryAnswer(-60));
        $this->assertFalse($question->tryAnswer(-90000));
        $this->assertFalse($question->tryAnswer(999999));
        $this->assertTrue($question->tryAnswer($correctAnswer));
    }

    private function getNewQuestion()
    {
        $questionTypeObject = new QuestionsType(
            'Test name',
            rand(1, 10),
            rand(5, 360)
        );
        $operators = ['-', '+'];
        return new Question(
            $questionTypeObject,
            'Indicate difference between %1 and %2',
            rand(1, 100),
            false,
            $operators[array_rand($operators, 1)]
        );
    }
}

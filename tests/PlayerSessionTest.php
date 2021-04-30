<?php
/**
 * @author  Flormarys Diaz <flormarysdiaz@gmail.com>
 * @license GPLv3 (or any later version)
 * PHP 7.4.16
 */

declare(strict_types=1);

require __DIR__ . "/../vendor/autoload.php";
use PHPUnit\Framework\TestCase;

final class PlayerSessionTest extends TestCase
{

    private $session;
    private $questionsFromFile;
    const QUESTIONS_FILE_PATH = __DIR__ . '/data/questions.json';

    protected function setUp() : void
    {
        $this->session = new \MathPractice\PlayerSession(25, []);
        $this->session->addQuestionsFromFile(self::QUESTIONS_FILE_PATH);
        $jsonDataEncoded = file_get_contents(self::QUESTIONS_FILE_PATH);
        $questionsJson = json_decode($jsonDataEncoded);
        $this->questionsFromFile = $questionsJson->questions;
        parent::setUp();
    }

    public function testPlayerSessionQuestions()
    {
        $questionsSessionTexts = [];
        $questionsType = [];
        foreach ($this->session->getQuestions() as $sessionQuestion) {
            $questionsSessionTexts[] = $sessionQuestion->getText();
            $questionsType[] = $sessionQuestion->getType()->getName();
        }
        foreach ($this->questionsFromFile as $questionFile) {
            $this->assertContains($questionFile->text, $questionsSessionTexts);
            $this->assertContains(
                $questionFile->questionsType->name,
                $questionsType
            );
        }
    }

    public function testGetTotalPoints()
    {
        $pointsFromFile = 0;
        foreach ($this->questionsFromFile as $questionFile) {
            $pointsFromFile += $questionFile->points;
        }
        $this->assertEquals($this->session->getTotalPoints(), $pointsFromFile);
    }

    public function testCorrectAnswerQuestions()
    {
        $questions = $this->session->getQuestions();
        $randomKeyQuestion = array_rand($questions, 1);
        $question = $questions[$randomKeyQuestion];
        $date_from = strtotime('2021-04-15 14:20');
        $date_to = strtotime('2021-04-15 14:45');
        $question->setVariables($date_from, $date_to);
        if ($question->isBetweenTheLimits()) {
            $operator = $question->getOperator();
            $answer = $this->makeOperation($date_from, $date_to, $operator);
            $this->assertEquals($answer, $question->getAnswer());
        }
    }

    private function makeOperation(int $date1, int $date2, string $operator)
    {
        switch ($operator) {
        case '-':
            return $date2 - $date1;
            break;
        default:
            return $date1 + $date2;
            break;
        }
    }

    public function testWrongAnswerQuestions()
    {
        $questions = $this->session->getQuestions();
        $randomKeyQuestion = array_rand($questions, 1);
        $question = $questions[$randomKeyQuestion];
        $date_from = strtotime('2021-04-15 18:50');
        $date_to = strtotime('2021-04-15 19:22');
        $question->setVariables($date_from, $date_to);
        if ($question->isBetweenTheLimits()) {
            $operator = $question->getOperator();
            $answer = $this->makeOperation($date_from, $date_to, $operator) + 100;
            $this->assertNotEquals($answer, $question->getAnswer());
        }
    }

    public function testOutsideLimitAnswerQuestions()
    {
        $questions = $this->session->getQuestions();
        $randomKeyQuestion = array_rand($questions, 1);
        $question = $questions[$randomKeyQuestion];
        $timeLimit = $question->getType()->getTimeLimit();
        $date_from = strtotime('2021-04-15 18:50');
        $date_to = $date_from + $timeLimit + 10;
        $question->setVariables($date_from, $date_to);
        $this->assertFalse($question->isBetweenTheLimits());
    }

    public function testReadQuestionsWithSpecificLevel()
    {
        $this->session = new \MathPractice\PlayerSession(25, []);
        $this->session->addQuestionsFromFile(self::QUESTIONS_FILE_PATH, ['level' => 2]);
        $questions = $this->session->getQuestions();
        foreach ($questions as $question) {
            $this->assertEquals($question->getType()->getLevel(), 2);
        }
    }

    public function testCalculateScore()
    {
        $questions = $this->session->getQuestions();
        $sessionScore = 0;
        $totalQuestionsAnsweredCorrectly = 2;
        $date_from = strtotime('2021-04-15 18:50');
        $date_to = strtotime('2021-04-15 19:22');
        foreach ($questions as $questionIndex => $question) {
            $question->setVariables($date_from, $date_to);
            $correctAnswer = $question->getAnswer();
            $questionPoints = $question->getPoints();
            if ($totalQuestionsAnsweredCorrectly > 0) {
                $this->session->answerQuestion($questionIndex, $correctAnswer);
                $sessionScore += $questionPoints;
                $totalQuestionsAnsweredCorrectly--;
                continue;
            }
            $this->session->answerQuestion($questionIndex, $correctAnswer + rand(1, 1000));
        }
        $this->assertEquals($this->session->getScore(), $sessionScore);
    }
}

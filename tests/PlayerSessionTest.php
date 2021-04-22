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

    protected function setUp() : void
    {
        $this->session = new \MathPractice\PlayerSession(25, 50, [], 0);
        $filePath = __DIR__ . '/data/questions.json';
        $this->session->addQuestionsFromFile($filePath);
        $jsonDataEncoded = file_get_contents($filePath);
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

    public function testAnswerQuestionCorrectly()
    {
        $this->session->getQuestions()[0]->setStatus(true);
        $this->assertTrue($this->session->getQuestions()[0]->getStatus());
    }

    public function testAnswerQuestionWrong()
    {
        $this->session->getQuestions()[0]->setStatus(false); // Wrong answer
        $this->assertFalse($this->session->getQuestions()[0]->getStatus());
    }
}

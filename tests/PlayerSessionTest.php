<?php declare(strict_types=1);

require __DIR__ . "/../vendor/autoload.php";
use PHPUnit\Framework\TestCase;

final class PlayerSessionTest extends TestCase
{

  private $session;
  private $questionsFromFile;

  protected function setUp() : void {
    $this->session = new \MathPractice\PlayerSession(25, 50, []);
    $filePath = __DIR__ . '/data/questions.json';
    $this->session->addQuestionsFromFile( $filePath );
    $jsonDataEncoded = file_get_contents($filePath);
    $questionsJson = json_decode($jsonDataEncoded);
    $this->questionsFromFile = $questionsJson->questions;
    parent::setUp();
  }

  public function testPlayerSessionQuestions() {
    $questionsSessionTexts = [];
    $questionsType = [];
    foreach($this->session->getQuestions() as $sessionQuestion) {
      $questionsSessionTexts[] = $sessionQuestion->getText();
      $questionsType[] = $sessionQuestion->getType()->getName();
    }
    foreach($this->questionsFromFile as $questionFile) {
      $this->assertContains($questionFile->text, $questionsSessionTexts);
      $this->assertContains($questionFile->questionsType->name, $questionsType);
    }
  }
}

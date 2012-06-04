<?php

namespace Armada\MovieBundle\Tests;

use Armada\MovieBundle\MovieScoreParser\KinopoiskScoreParser;

class KinopoiscScoreParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParse() {
        $html = file_get_contents(__DIR__ . '/../../Resources/test/kinopoisk_score.htm');
        $parser = new KinopoiskScoreParser();
        $result = $parser->parse($html);
        $this->assertCount(250, $result, 'Not all movie rows parsed');
    }
}
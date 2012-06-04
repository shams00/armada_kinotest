<?php

namespace Armada\MovieBundle\MovieScoreParser;

use Armada\MovieBundle\MovieScoreParser\MovieScoreParser;


class KinopoiskScoreParser implements MovieScoreParser
{

    public function parse($html)
    {
        $html = html_entity_decode($html);
        $rowPattern = '~<tr[^>]*id="top250_place_(\d+)">(.*)</tr>~sU';

        $valuePatterns = array(
            'name' => '~<a href=".*" class="all">(.+)\(.*\)</a>~U',
            'year' => '~<a href=".*" class="all">.+\((\d+)\).*</a>~U',
            'originalName' => '~<span.*class="text-grey">(.+)</span>~U',
            'score' => '~<a href=".*" class="continue">(\d+\.?\d*)</a>~U',
            'voteCount' => '~<span style="color: #777">\((.+)\)</span>~U'
        );

        preg_match_all($rowPattern, $html, $rowMatches);
        $result = array();

        // parse movie rating by rows
        for ($iRow = 0; $iRow < count($rowMatches[0]); $iRow++)
        {
            // find individual movie values
            $movie = array();
            foreach($valuePatterns as $key => $valuePattern) {
                if(preg_match($valuePattern, $rowMatches[0][$iRow], $valueMatches)) {
                    $movie[$key] = $valueMatches[1];
                }
            }

            // do some data corrections
            if(!empty($movie)) {
                $movie['place'] = $rowMatches[1][$iRow];
                if(empty($movie['originalName'])) {
                    $movie['originalName'] = $movie['name'];
                }
                $movie['score'] = str_replace(' ', '', $movie['score']);
                foreach($movie as &$val) {
                    $val = iconv('windows-1251', 'utf-8', $val);
                }
                $result[] = $movie;
            }
        }
        return $result;
    }
}
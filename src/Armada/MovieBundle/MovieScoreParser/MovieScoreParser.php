<?php

namespace Armada\MovieBundle\MovieScoreParser;

interface MovieScoreParser {

    /**
     * @param $html
     * @return array Movie score data
     */
    public function parse($html);
}

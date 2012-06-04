<?php
namespace Armada\MovieBundle\MovieScoreParser;

use Armada\MovieBundle\MovieScoreParser\MovieScoreParser;
use Doctrine\Common\Persistence\ObjectManager;
use Armada\MovieBundle\Entity\Movie;
use Armada\MovieBundle\Entity\MovieScore;

class MovieScoreSaver {
    private $em;
    private $parser;

    public function __construct(ObjectManager $em, MovieScoreParser $parser) {
        $this->em = $em;
        $this->parser = $parser;
    }

    public function parseAndSave($html, \DateTime $date) {
        $scoreData = $this->parser->parse($html);
        $this->saveScoreData($scoreData, $date);
    }

    public function saveScoreData($scoreData, \DateTime $date) {
        $movieRepo = $this->em->getRepository('ArmadaMovieBundle:Movie');
        $scoreRepo = $this->em->getRepository('ArmadaMovieBundle:MovieScore');

        foreach($scoreData as $scoreRow) {
            // persist movie
            $movie = $movieRepo->findOneBy(array(
                'name' => $scoreRow['name'],
                'originalName' => $scoreRow['originalName'],
                'year' => $scoreRow['year']
            ));
            if(empty($movie)) {
                $movie = new Movie();
                $movie->setName($scoreRow['name']);
                $movie->setOriginalName($scoreRow['originalName']);
                $movie->setYear($scoreRow['year']);
                $this->em->persist($movie);
            }

            // persist score
            $score = $scoreRepo->findOneBy(array(
                'movie' => $movie->getId(),
                'scoreDate' => $date
            ));
            if(empty($score)) {
                $score = new MovieScore();
                $score->setScoreDate($date);
                $score->setMovie($movie);
                $this->em->persist($score);
            }
            $score->setPlace($scoreRow['place']);
            $score->setScore($scoreRow['score']);
            $score->setVoteCount($scoreRow['voteCount']);
        }
        $this->em->flush();
    }
}
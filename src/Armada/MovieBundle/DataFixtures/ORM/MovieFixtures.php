<?php
namespace Armada\MovieBundle\DataFixtures\ORM;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\Yaml\Parser;
use Armada\MovieBundle\Entity\Movie;
use Armada\MovieBundle\Entity\MovieScore;


class MovieFixtures extends AbstractFixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param Doctrine\Common\Persistence\ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $parser = new Parser();
        $data = $parser->parse(file_get_contents(__DIR__ . '/../../Resources/fixtures/movie_fixtures.yml'));

        // load movies
        $movies = array();
        if (!empty($data['movie'])) {
            foreach ($data['movie'] as $key => $movieData) {
                $movie = new Movie();
                $movie->setName($movieData['name']);
                $movie->setOriginalName($movieData['originalName']);
                $movie->setYear($movieData['year']);
                $manager->persist($movie);
                $movies[$key] = $movie;
            }
        }

        // load scores
        if (!empty($data['movie_score'])) {
            foreach ($data['movie_score'] as $scoreData) {
                $score = new MovieScore();
                $score->setPlace($scoreData['place']);
                $score->setScoreDate(new \DateTime($scoreData['scoreDate']));
                $score->setScore($scoreData['score']);
                $score->setVoteCount($scoreData['voteCount']);
                $score->setMovie($movies[$scoreData['movie']]);
                $manager->persist($score);
            }
        }

        $manager->flush();
    }
}
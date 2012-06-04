<?php

namespace Armada\MovieBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Armada\MovieBundle\DataFixtures\ORM\MovieFixtures;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $router = $client->getContainer()->get('router');
        $em = $client->getContainer()->get('doctrine')->getEntityManager();

        $loader = new Loader();
        $loader->addFixture(new MovieFixtures());
        $purger = new ORMPurger();
        $executor = new ORMExecutor($em, $purger);
        $executor->execute($loader->getFixtures());

        $crawler = $client->request('GET', $router->generate('ArmadaMovieBundle_homepage'));
        $this->assertEquals($crawler->filter('.movie_list .movie_row')->count(), 10,
            'There are no 10 movies in default score view');

        $crawler = $client->request('GET', $router->generate('ArmadaMovieBundle_homepage'),
            array('ajax' => 1, 'date' => '2012-06-01'));
        $this->assertEquals($crawler->filter('.movie_list .movie_row')->count(), 10,
            'There are no 10 movies in ajax score query');
        $this->assertEquals($crawler->filter('.movie_score')->first()->text(), '9.18',
            'The score data for concrete date is not correct'
        );


    }
}

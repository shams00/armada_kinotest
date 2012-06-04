<?php
namespace Armada\MovieBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManager;
use Armada\MovieBundle\MovieScoreParser\MovieScoreSaver;
use Armada\MovieBundle\MovieScoreParser\KinopoiskScoreParser;

class ImportMovieScoreCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('kinotest:import')
            ->setDescription('Import current movie score data');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $this->getContainer()->getParameter('kinopoisk_rating_url');
        $content = file_get_contents($url);
        if($content === false) {
            throw new \Exception('Can\'t load source data');
        }
        $saver = new MovieScoreSaver(
            $this->getContainer()->get('doctrine')->getEntityManager(),
            new KinopoiskScoreParser()
        );
        $saver->parseAndSave($content, new \DateTime());
    }
}
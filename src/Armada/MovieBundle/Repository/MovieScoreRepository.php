<?php
namespace Armada\MovieBundle\Repository;

use \Doctrine\ORM\EntityRepository;

class MovieScoreRepository extends EntityRepository
{
    /**
     * Get movie rating for date
     *
     * @param \DateTime $date
     * @return array
     */
    public function getRatingForDate(\DateTime $date = null, $limit = 10)
    {
        if (is_null($date))
        {
            $date = $this->getLastDate();
        }

        $scores = $this->_em->createQuery("
            SELECT s, m
            FROM ArmadaMovieBundle:MovieScore s
            INNER JOIN s.movie m
            WHERE s.scoreDate = :scoreDate
            ORDER BY s.place ASC
            ")
            ->setParameter('scoreDate', $date)
            ->setMaxResults($limit)
            ->useResultCache(true, 3600)
            ->getResult();

        return $scores;
    }

    /**
     * Get last rating date
     * @return \DateTime
     */
    public function getLastDate()
    {
        $maxDate = $this->_em->createQuery("
            SELECT MAX(s.scoreDate) FROM ArmadaMovieBundle:MovieScore s
        ")->useResultCache(true, 3600)
            ->getSingleScalarResult();

        return new \DateTime($maxDate);
    }

    /**
     * Returns true if there are movie scores for today
     * @return boolean
     */
    public function hasTodayScores() {
        $scoreCount = $this->_em->createQuery('
            SELECT COUNT(*)
            FROM ArmadaMovieBundle:MovieScore s
            WHERE s.scoreDate = :scoreDate
        ')->setParameter('scoreDate', new \DateTime())
        ->getSingleScalarResult();

        if($scoreCount > 0) {
            return true;
        }
        else {
            return false;
        }
    }
}
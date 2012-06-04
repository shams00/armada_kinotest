<?php
namespace Armada\MovieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Armada\MovieBundle\Repository\MovieScoreRepository")
 * @ORM\Table(name="movie_score",
 *  indexes={@ORM\index(name="date_idx", columns={"score_date"})})
 */
class MovieScore
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="score_date", type="date", nullable=false)
     */
    private $scoreDate;

    /**
     * @ORM\Column(name="place", type="integer", nullable=false)
     */
    private $place;
    /**
     * @ORM\Column(name="score", type="float", nullable=false)
     */
    private $score;

    /**
     * @ORM\Column(name="vote_count", type="integer", nullable=false)
     */
    private $voteCount;


    /**
     * @ORM\ManyToOne(targetEntity="Armada\MovieBundle\Entity\Movie")
     * @ORM\JoinColumn(name="movie_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     **/
    private $movie;

    public function getId()
    {
        return $this->id;
    }

    public function getScoreDate()
    {
        return $this->scoreDate;
    }

    public function setScoreDate($scoreDate)
    {
        $this->scoreDate = $scoreDate;
    }

    public function getPlace()
    {
        return $this->place;
    }

    public function setPlace($place)
    {
        $this->place = $place;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function setScore($score)
    {
        $this->score = $score;
    }

    public function getVoteCount()
    {
        return $this->voteCount;
    }

    public function setVoteCount($voteCount)
    {
        $this->voteCount = $voteCount;
    }

    public function getMovie()
    {
        return $this->movie;
    }

    public function setMovie($movie)
    {
        $this->movie = $movie;
    }
}
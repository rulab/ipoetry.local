<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of DailyUserRating
 *
 * @author d.krasavin
 * 
 * @ORM\Table(name="daily_user_rating")
 * @ORM\Entity(repositoryClass="IpoetryBundle\Entity\Repository\DailyUserRatingRepository")
 */
class DailyUserRating {
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="cdate", type="string",length=10, nullable=false)
     */
    private $cDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_rating", type="integer", nullable=true)
     */
    private $userRating;

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }
    
    /**
     * Set cdate
     *
     * @param string $cdate
     *
     * @return DailyUserRating
     */
    public function setcDate($cDate)
    {
        $this->cDate = $cDate;

        return $this;
    }

    /**
     * Get cDate
     *
     * @return string
     */
    public function getcDate()
    {
        return $this->cDate;
    }

    /**
     * Set userRating
     *
     * @param integer $userRating
     *
     * @return DailyUserRating
     */
    public function setUserRating($userRating)
    {
        $this->userRating = $userRating;

        return $this;
    }

    /**
     * Get userRating
     *
     * @return integer
     */
    public function getUserRating()
    {
        return $this->userRating;
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of DailyPoetryRating
 *
 * @author d.krasavin
 * 
 * @ORM\Table(name="daily_poetry_rating")
 * @ORM\Entity(repositoryClass="IpoetryBundle\Entity\Repository\DailyPoetryRatingRepository")
 */
class DailyPoetryRating {
    /**
     * @var integer
     *
     * @ORM\Column(name="poetry_id", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $poetryId;

    /**
     * @var string
     *
     * @ORM\Column(name="cdate", type="string",length=10, nullable=false)
     */
    private $cDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="poetry_rating", type="integer", nullable=true)
     */
    private $poetryRating;

    /**
     * Get poetryId
     *
     * @return integer
     */
    public function getPoetryId()
    {
        return $this->poetryId;
    }
    
    /**
     * Set cdate
     *
     * @param string $cdate
     *
     * @return DailyPoetryRating
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
     * Set poetryRating
     *
     * @param integer $poetryRating
     *
     * @return DailyPoetryRating
     */
    public function setPoetryRating($poetryRating)
    {
        $this->poetryRating = $poetryRating;

        return $this;
    }

    /**
     * Get poetryRating
     *
     * @return integer
     */
    public function getPoetryRating()
    {
        return round($this->poetryRating);
    }

}

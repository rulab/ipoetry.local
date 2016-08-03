<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IpoetryBundle\Entity;

/**
 * Description of IpoetryPoetryRating
 *
 * @author d.krasavin
 */
use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryPoetryRating
 *
 * @ORM\Table(name="ipoetry_poetry_rating")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="IpoetryBundle\Entity\Repository\IpoetryPoetryRatingRepository")
 */
class IpoetryPoetryRating {

    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_poetry_rating_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $ipoetryPoetryRatingId;
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_poetry_poetry_id", type="integer", nullable=false)
     */
    private $ipoetryPoetryPoetryId;
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_user_id", type="integer", nullable=false)
     */
    private $ipoetryUserUserId;
    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_poetry_rating_value", type="integer", nullable=false)
     */
    private $ipoetryPoetryRatingValue=0;
    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_poetry_poetry_parent_id", type="integer", nullable=false)
     */
    private $ipoetryPoetryPoetryParentId=0;
    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_user_user_parent_id", type="integer", nullable=false)
     */
    private $ipoetryUserUserParentId=0;
    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_poetry_rating_value_up", type="integer", nullable=false)
     */
    private $ipoetryPoetryRatingValueUp=0;
    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_poetry_rating_value_down", type="integer", nullable=false)
     */

    private $ipoetryPoetryRatingValueDown=0;
    
     /**
     * @var \IpoetryBundle\Entity\IpoetryPoetry
     *
     * @ORM\OneToOne(targetEntity="IpoetryBundle\Entity\IpoetryPoetry")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_poetry_rating_id", referencedColumnName="poetry_id"),
     * })
     */
    private $ipoetryPoetryPoetry;
    
    /**
     * Get ipoetryPoetryRatingId
     *
     * @return integer
     */
    public function getIpoetryPoetryRatingId()
    {
        return $this->ipoetryPoetryRatingId;
    }
    /**
     * Set ipoetryPoetryPoetryId
     *
     * @param string $ipoetryPoetryPoetryId
     *
     * @return IpoetryPoetryRating
     */
    public function setIpoetryPoetryPoetryId($ipoetryPoetryPoetryId)
    {
        $this->ipoetryPoetryPoetryId = $ipoetryPoetryPoetryId;

        return $this;
    }
    /**
     * Get ipoetryPoetryPoetryId
     *
     * @return integer
     */
    public function getIpoetryPoetryPoetryId()
    {
        return $this->ipoetryPoetryPoetryId;
    }
    /**
     * Set ipoetryUserUserId
     *
     * @param string $ipoetryUserUserId
     *
     * @return IpoetryPoetryRating
     */
    public function setIpoetryUserUserId($ipoetryUserUserId)
    {
        $this->ipoetryUserUserId = $ipoetryUserUserId;

        return $this;
    }
    /**
     * Get IpoetryUserUserId
     *
     * @return integer
     */
    public function getIpoetryUserUserId()
    {
        return $this->ipoetryUserUserId;
    }
    /**
     * Set ipoetryPoetryRatingValue
     *
     * @param string $ipoetryPoetryRatingValue
     *
     * @return IpoetryPoetryRating
     */
    public function setIpoetryPoetryRatingValue($ipoetryPoetryRatingValue)
    {
        $this->ipoetryPoetryRatingValue = $ipoetryPoetryRatingValue;

        return $this;
    }

    /**
     * Get IpoetryPoetryRatingValue
     *
     * @return string
     */
    public function getIpoetryPoetryRatingValue()
    {
        return $this->ipoetryPoetryRatingValue;
    }
    /**
     * Set ipoetryPoetryPoetryParentId
     *
     * @param string $ipoetryPoetryPoetryParentId
     *
     * @return IpoetryPoetryRating
     */
    public function setIpoetryPoetryPoetryParentId($ipoetryPoetryPoetryParentId)
    {
        $this->ipoetryPoetryPoetryParentId = $ipoetryPoetryPoetryParentId;

        return $this;
    }

    /**
     * Get ipoetryPoetryPoetryParentId
     *
     * @return string
     */
    public function getIpoetryPoetryPoetryParentId()
    {
        return $this->ipoetryPoetryPoetryParentId;
    }
    /**
     * Set ipoetryUserUserParentId
     *
     * @param string $ipoetryUserUserParentId
     *
     * @return IpoetryPoetryRating
     */
    public function setIpoetryUserUserParentId($ipoetryUserUserParentId)
    {
        $this->ipoetryUserUserParentId = $ipoetryUserUserParentId;

        return $this;
    }

    /**
     * Get ipoetryUserUserParentId
     *
     * @return string
     */
    public function getIpoetryUserUserParentId()
    {
        return $this->ipoetryUserUserParentId;
    }
    /**
     * Set ipoetryPoetryRatingValueUp
     *
     * @param string $ipoetryPoetryRatingValueUp
     *
     * @return IpoetryPoetryRating
     */
    public function setIpoetryPoetryRatingValueUp($ipoetryPoetryRatingValueUp)
    {
        $this->ipoetryPoetryRatingValueUp = $ipoetryPoetryRatingValueUp;

        return $this;
    }

    /**
     * Get ipoetryPoetryRatingValueUp
     *
     * @return string
     */
    public function getIpoetryPoetryRatingValueUp()
    {
        return $this->ipoetryPoetryRatingValueUp;
    }
    /**
     * Set ipoetryPoetryRatingValueDown
     *
     * @param string $ipoetryPoetryRatingValueDown
     *
     * @return IpoetryPoetryRating
     */
    public function setIpoetryPoetryRatingValueDown($ipoetryPoetryRatingValueDown)
    {
        $this->ipoetryPoetryRatingValueDown = $ipoetryPoetryRatingValueDown;

        return $this;
    }

    /**
     * Get ipoetryPoetryRatingValueDown
     *
     * @return string
     */
    public function getIpoetryPoetryRatingValueDown()
    {
        return $this->ipoetryPoetryRatingValueDown;
    }
    /**
     * Set ipoetryPoetryPoetry
     *
     * @param \IpoetryBundle\Entity\IpoetryPoetry $ipoetryPoetryPoetry
     *
     * @return IpoetryBackgroundImages
     */
    public function setIpoetryPoetryPoetry(\IpoetryBundle\Entity\IpoetryPoetry $ipoetryPoetryPoetry = null)
    {
        $this->ipoetryPoetryPoetry = $ipoetryPoetryPoetry;

        return $this;
    }

    /**
     * Get ipoetryPoetryPoetry
     *
     * @return \IpoetryBundle\Entity\IpoetryPoetry
     */
    public function getIpoetryPoetryPoetry()
    {
        return $this->ipoetryPoetryPoetry;
    }

}
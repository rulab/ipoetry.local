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
 * @ORM\Table(name="ipoetry_blogpost_rating")
 * @ORM\Entity(repositoryClass="IpoetryBundle\Entity\Repository\IpoetryBlogPostRatingRepository")
 */
class IpoetryBlogPostRating {

    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_blogpost_rating_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $ipoetryBlogPostRatingId;
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_blogpost_poetry_id", type="integer", nullable=false)
     */
    private $ipoetryBlogPostPoetryId;
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_user_id", type="integer", nullable=false)
     */
    private $ipoetryUserUserId;
    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_blogpost_rating_value", type="integer", nullable=false)
     */
    private $ipoetryBlogPostRatingValue=0;
    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_blogpost_poetry_parent_id", type="integer", nullable=false)
     */
    private $ipoetryBlogPostPoetryParentId=0;
    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_user_user_parent_id", type="integer", nullable=false)
     */
    private $ipoetryUserUserParentId=0;
    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_blogpost_rating_value_up", type="integer", nullable=false)
     */
    private $ipoetryBlogPostRatingValueUp=0;
    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_blogpost_rating_value_down", type="integer", nullable=false)
     */

    private $ipoetryBlogPostRatingValueDown=0;
    
     /**
     * @var \IpoetryBundle\Entity\IpoetryUserBlogPost
     *
     * @ORM\OneToOne(targetEntity="IpoetryBundle\Entity\IpoetryUserBlogPost")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_blogpost_rating_id", referencedColumnName="ipoetry_user_blog_post_id"),
     * })
     */
    private $ipoetryPoetryBlogPost;
    
    /**
     * Get ipoetryBlogPostRatingId
     *
     * @return integer
     */
    public function getIpoetryBlogPostRatingId()
    {
        return $this->ipoetryBlogPostRatingId;
    }
    /**
     * Set ipoetryBlogPostPoetryId
     *
     * @param string $ipoetryBlogPostPoetryId
     *
     * @return IpoetryBlogPostPoetryId
     */
    public function setIpoetryPoetryPoetryId($ipoetryBlogPostPoetryId)
    {
        $this->ipoetryBlogPostPoetryId = $ipoetryBlogPostPoetryId;

        return $this;
    }
    /**
     * Get ipoetryBlogPostPoetryId
     *
     * @return integer
     */
    public function getIpoetryBlogPostPoetryId()
    {
        return $this->ipoetryBlogPostPoetryId;
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
     * Set ipoetryBlogPostRatingValue
     *
     * @param string $ipoetryBlogPostRatingValue
     *
     * @return IpoetryBlogPostRatingValue
     */
    public function setIpoetryBlogPostRatingValue($ipoetryBlogPostRatingValue)
    {
        $this->ipoetryBlogPostRatingValue = $ipoetryBlogPostRatingValue;

        return $this;
    }

    /**
     * Get ipoetryBlogPostRatingValue
     *
     * @return string
     */
    public function getIpoetryBlogPostRatingValue()
    {
        return $this->ipoetryBlogPostRatingValue;
    }
    /**
     * Set ipoetryBlogPostPoetryParentId
     *
     * @param integer $ipoetryBlogPostPoetryParentId
     *
     * @return ipoetryBlogPostPoetryParentId
     */
    public function setIpoetryBlogPostPoetryParentId($ipoetryBlogPostPoetryParentId)
    {
        $this->ipoetryBlogPostPoetryParentId = $ipoetryBlogPostPoetryParentId;

        return $this;
    }

    /**
     * Get ipoetryBlogPostPoetryParentId
     *
     * @return integer
     */
    public function getIpoetryBlogPostPoetryParentId()
    {
        return $this->ipoetryBlogPostPoetryParentId;
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
     * Set ipoetryBlogPostRatingValueUp
     *
     * @param string $ipoetryBlogPostRatingValueUp
     *
     * @return ipoetryBlogPostRatingValueUp
     */
    public function setIpoetryBlogPostRatingValueUp($ipoetryBlogPostRatingValueUp)
    {
        $this->ipoetryBlogPostRatingValueUp = $ipoetryBlogPostRatingValueUp;

        return $this;
    }

    /**
     * Get ipoetryBlogPostRatingValueUp
     *
     * @return integer
     */
    public function getIpoetryBlogPostRatingValueUp()
    {
        return $this->ipoetryBlogPostRatingValueUp;
    }
    /**
     * Set ipoetryBlogPostRatingValueDown
     *
     * @param string $ipoetryBlogPostRatingValueDown
     *
     * @return ipoetryBlogPostRatingValueDown
     */
    public function setIpoetryBlogPostRatingValueDown($ipoetryBlogPostRatingValueDown)
    {
        $this->ipoetryBlogPostRatingValueDown = $ipoetryBlogPostRatingValueDown;

        return $this;
    }

    /**
     * Get ipoetryBlogPostRatingValueDown
     *
     * @return string
     */
    public function getIpoetryBlogPostRatingValueDown()
    {
        return $this->ipoetryBlogPostRatingValueDown;
    }
    /**
     * Set IpoetryPoetryBlogPost
     *
     * @param \IpoetryBundle\Entity\IpoetryPoetryBlogPost $ipoetryPoetryBlogPost
     *
     * @return ipoetryPoetryBlogPost
     */
    public function setIpoetryPoetryBlogPost(\IpoetryBundle\Entity\IpoetryPoetryBlogPost $ipoetryPoetryBlogPost = null)
    {
        $this->ipoetryPoetryBlogPost = $ipoetryPoetryBlogPost;

        return $this;
    }

    /**
     * Get ipoetryPoetryBlogPost
     *
     * @return \IpoetryBundle\Entity\IpoetryPoetryBlogPost
     */
    public function getIpoetryPoetryBlogPost()
    {
        return $this->ipoetryPoetryBlogPost;
    }

}
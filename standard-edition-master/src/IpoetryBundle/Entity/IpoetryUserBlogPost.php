<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryUserBlogPost
 *
 * @ORM\Table(name="ipoetry_user_blog_post")
 * @ORM\Entity
 */
class IpoetryUserBlogPost
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_blog_post_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $ipoetryUserBlogPostId;

    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_blogpost_rating_id", type="integer")
     */
    private $ipoetryUserBlogPostRatingId;

    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_blog_post_parent_id", type="integer")
     */
    private $ipoetryUserBlogPostParentId;

    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_blog_post_poetry_id", type="integer")
     */
    private $ipoetryUserBlogPostPoetryId;

    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_blog_moderated", type="integer")
     */
    private $ipoetryUserBlogPostModerated;

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_user_blog_post_text", type="mediumtext", nullable=false)
     */
    private $ipoetryUserBlogPostText;

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_user_blog_post_theme", type="string", length=255, nullable=true)
     */
    private $ipoetryUserBlogPostTheme;

     /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_user_blog_post_updated_at", type="datetime", nullable=false)
     */
    private $ipoetryUserBlogPostUpdatedAt;

    /**
     * @var datetime
     *
     * @ORM\Column(name="ipoetry_user_blog_post_created_at", type="datetime", nullable=false)
     */
    private $ipoetryUserBlogPostCreatedAt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="IpoetryBundle\Entity\IpoetryUser", inversedBy="IpoetryUserBlogPost")
     * @ORM\JoinTable(name="ipoetry_user_blog_post_ipoetry_user_relation",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ipoetry_user_blog_post_ipoetry_user_blog_post_id", referencedColumnName="ipoetry_user_blog_post_id"),
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ipoetry_user_user_id", referencedColumnName="user_id"),
     *   }
     * )
     */
    private $ipoetryUserUser;
    /**
     * @var \IpoetryBundle\Entity\IpoetryBlogPostRating
     *
     * @ORM\OneToOne(targetEntity="IpoetryBundle\Entity\IpoetryBlogPostRating")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_blogpost_rating_id", referencedColumnName="ipoetry_blogpost_rating_id")
     * })
     */
    private $ipoetryBlogPostRating;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ipoetryUserUser = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * Get ipoetryUserBlogPostId
     *
     * @return integer
     */
    public function getIpoetryUserBlogPostId()
    {
        return $this->ipoetryUserBlogPostId;
    }

    /**
     * Get ipoetryUserBlogPostRatingId
     *
     * @return integer
     */
    public function getIpoetryUserBlogPostRatingId()
    {
        return $this->ipoetryUserBlogPostRatingId;
    }

    /**
     * Set ipoetryUserBlogPostRatingId
     *
     * @return integer
     */
    public function setIpoetryUserBlogPostRatingId($ipoetryUserBlogPostRatingId)
    {
        $this->ipoetryUserBlogPostRatingId=$ipoetryUserBlogPostRatingId;
        
        return $this;
    }
    
    /**
     * Get ipoetryUserBlogPostParentId
     *
     * @return integer
     */
    public function getIpoetryUserBlogPostParentId()
    {
        return $this->ipoetryUserBlogPostParentId;
    }

    /**
     * Set ipoetryUserBlogPostParentId
     *
     * @return integer
     */
    public function setIpoetryUserBlogPostParentId($ipoetryUserBlogPostParentId)
    {
        $this->ipoetryUserBlogPostParentId=$ipoetryUserBlogPostParentId;
        
        return $this;
    }

    /**
     * Get ipoetryUserBlogPostPoetryId
     *
     * @return integer
     */
    public function getIpoetryUserBlogPostPoetryId()
    {
        return $this->ipoetryUserBlogPostPoetryId;
    }
    /**
     * Set ipoetryUserBlogPostPoetryId
     *
     * @return integer
     */
    public function setIpoetryUserBlogPostPoetryId($ipoetryUserBlogPostPoetryId)
    {
        $this->ipoetryUserBlogPostPoetryId=$ipoetryUserBlogPostPoetryId;
        
        return $this;
    }

    /**
     * Get ipoetryUserBlogPostModerated
     *
     * @return integer
     */
    public function getIpoetryUserBlogPostModerated()
    {
        return $this->ipoetryUserBlogPostModerated;
    }
    /**
     * Set ipoetryUserBlogPostModerated
     *
     * @return integer
     */
    public function setIpoetryUserBlogPostModerated($ipoetryUserBlogPostModerated)
    {
        $this->ipoetryUserBlogPostModerated=$ipoetryUserBlogPostModerated;
        
        return $this;
    }

    /**
     * Set ipoetryUserBlogPostText
     *
     * @param string $ipoetryUserBlogPostText
     *
     * @return IpoetryUserBlogPost
     */
    public function setIpoetryUserBlogPostText($ipoetryUserBlogPostText)
    {
        $this->ipoetryUserBlogPostText = $ipoetryUserBlogPostText;

        return $this;
    }
    
    /**
     * Get ipoetryUserBlogPostText
     *
     * @return string
     */
    public function getIpoetryUserBlogPostText()
    {
        return $this->ipoetryUserBlogPostText;
    }

    /**
     * Set ipoetryUserBlogPostTheme
     *
     * @param string $ipoetryUserBlogPostTheme
     *
     * @return IpoetryUserBlogPost
     */
    public function setIpoetryUserBlogPostTheme($ipoetryUserBlogPostTheme)
    {
        $this->ipoetryUserBlogPostTheme = $ipoetryUserBlogPostTheme;

        return $this;
    }

    /**
     * Get ipoetryUserBlogPostTheme
     *
     * @return string
     */
    public function getIpoetryUserBlogPostTheme()
    {
        return $this->ipoetryUserBlogPostTheme;
    }

    /**
     * Set ipoetryUserBlogPostUpdatedAt
     *
     * @param string $ipoetryUserBlogPostUpdatedAt
     *
     * @return IpoetryUserBlogPost
     */
    public function setIpoetryUserBlogPostUpdatedAt($ipoetryUserBlogPostUpdatedAt)
    {
        $this->ipoetryUserBlogPostUpdatedAt = $ipoetryUserBlogPostUpdatedAt;

        return $this;
    }    
    /**
     * Get getipoetryUserBlogPostUpdatedAt
     *
     * @return string
     */
    public function getIpoetryUserBlogPostUpdatedAt() {
        return $this->ipoetryUserBlogPostUpdatedAt->format('Y-m-d H:i:s');
    }

    /**
     * Set ipoetryUserBlogPostCreatedAt
     *
     * @param string $ipoetryUserBlogPostCreatedAt
     *
     * @return IpoetryUserBlogPost
     */
    public function setIpoetryUserBlogPostCreatedAt($ipoetryUserBlogPostCreatedAt)
    {
        $this->ipoetryUserBlogPostCreatedAt = $ipoetryUserBlogPostCreatedAt;

        return $this;
    }    
    /**
     * Get getIpoetryUserBlogPostCreatedAt
     *
     * @return string
     */
    public function getIpoetryUserBlogPostCreatedAt() {
        return $this->ipoetryUserBlogPostCreatedAt->format('Y-m-d H:i:s');
    }
    
    /**
     * Set class IpoetryPoetryRating
     *
     * @param \IpoetryBundle\Entity\IpoetryPoetryRating $ipoetryBlogPostRating
     *
     * @return IpoetryPoetryRating
     */
    public function setIpoetryBlogPostRating(\IpoetryBundle\Entity\IpoetryPoetryRating $ipoetryBlogPostRating  = null)
    {
        $this->ipoetryBlogPostRating = $ipoetryBlogPostRating;

        return $this;
    }

    /**
     * Get IpoetryPoetryRating
     *
     * @return \IpoetryBundle\Entity\IpoetryPoetryRating
     */
    public function getIpoetryBlogPostRating()
    {
        return $this->$ipoetryBlogPostRating;
    }

}

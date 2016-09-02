<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryPoetry
 *
 * @ORM\Table(name="ipoetry_poetry")
 * @ORM\Entity
 */
class IpoetryPoetry
{
    /**
     * @var integer
     *
     * @ORM\Column(name="poetry_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $poetryId;

    /**
     * @var integer
     *
     * @ORM\Column(name="poetry_parent_id", type="integer")
     */
    private $poetryParentId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="poetry_body", type="blob", nullable=true)
     */
    private $poetryBody;

    /**
     * @var integer
     *
     * @ORM\Column(name="poetry_tag_id", type="integer", nullable=false)
     */
    private $poetryTagId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="poetry_discuss_id", type="integer", nullable=false)
     */
    private $poetryDiscussId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="poetry_video_id", type="integer", nullable=false)
     */
    private $poetryVideoId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="poetry_photo_id", type="integer", nullable=false)
     */
    private $poetryPhotoId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="poetry_audio_id", type="integer", nullable=false)
     */
    private $poetryAudioId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="poetry_theme_id", type="integer", nullable=false)
     */
    private $poetryThemeId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="poetry_background_image_id", type="integer", nullable=false)
     */
    private $poetryBackgroundImageId = '0';
    /**
     * @var integer
     *
     * @ORM\Column(name="poetry_poetry_rating_id", type="integer", nullable=false)
     */
    private $poetryPoetryRatingId = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="poetry_is_gift", type="boolean", nullable=false)
     */
    private $poetryIsGift = '0';
    
    /**
     * @var string
     *
     * @ORM\Column(name="poetry_title", type="string", length=255, nullable=false)
     */
    private $poetryTitle;
    
    /**
     * @var string
     *
     * @ORM\Column(name="poetry_description", type="string", length=1024, nullable=false)
     */
    private $poetryDescription;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="ipoetry_poetry_created_at", type="datetime", nullable=false)
     */
    private $poetryCreatedAt;

    /**
     * @var mediumtext
     *
     * @ORM\Column(name="ipoetry_poetry_body_text", type="mediumtext", nullable=true)
     */
    private $poetryBodyText;

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_poetry_resource_ext", length=5, type="string", nullable=false)
     */
    private $poetryResourceExt;

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_poetry_tags", length=255, type="string", nullable=true)
     */
    private $poetryPoetryTags;

    /**
     * @var boolean
     *
     * @ORM\Column(name="recommended", type="boolean", nullable=false)
     */
    private $recommended = '0';
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="IpoetryBundle\Entity\IpoetryUser", inversedBy="ipoetryPoetryPoetry")
     * @ORM\JoinTable(name="ipoetry_user_ipoetry_poetry_relation",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ipoetry_poetry_poetry_id", referencedColumnName="poetry_id"),
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ipoetry_user_user_id", referencedColumnName="user_id"),
     *   }
     * )
     */
    private $ipoetryUserUser;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="IpoetryBundle\Entity\IpoetryTags", inversedBy="ipoetryPoetryPoetry")
     * @ORM\JoinTable(name="ipoetry_poetry_ipoetry_tags_relation",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ipoetry_poetry_poetry_id", referencedColumnName="poetry_id"),
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ipoetry_tags_tags_id", referencedColumnName="ipoetry_tags_tags_id"),
     *   }
     * )
     */
    private $ipoetryTagsTags;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="IpoetryBundle\Entity\PoetryRepostToOwnFeed", mappedBy="ipoetryPoetryPoetry")
     */
    private $ipoetryUserRepost;
    
    /**
     * @var \IpoetryBundle\Entity\IpoetryBackgroundImages
     *
     * @ORM\OneToOne(targetEntity="IpoetryBundle\Entity\IpoetryBackgroundImages")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="poetry_background_image_id", referencedColumnName="ipoetry_background_images_id")
     * })
     */
    private $ipoetryPoetryBackgroundImages;

    /**
     * @var \IpoetryBundle\Entity\IpoetryPoetryRating
     *
     * @ORM\OneToOne(targetEntity="IpoetryBundle\Entity\IpoetryPoetryRating")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="poetry_poetry_rating_id", referencedColumnName="ipoetry_poetry_rating_id")
     * })
     */
    private $ipoetryPoetryRating;

        
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ipoetryUserUser = new \Doctrine\Common\Collections\ArrayCollection();
        
        $this->ipoetryTags = new \Doctrine\Common\Collections\ArrayCollection();
        
        $this->ipoetryUserRepost = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set poetryId
     *
     * @param integer $poetryId
     *
     * @return IpoetryPoetry
     */
    public function setPoetryId($poetryId)
    {
        $this->poetryId = $poetryId;

        return $this;
    }

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
     * Set poetryParentId
     *
     * @param integer $poetryParentId
     *
     * @return IpoetryPoetry
     */
    public function setPoetryParentId($poetryParentId)
    {
        $this->poetryParentId = $poetryParentId;

        return $this;
    }

    /**
     * Get poetryParentId
     *
     * @return integer
     */
    public function getPoetryParentId()
    {
        return $this->poetryParentId;
    }

    /**
     * Set poetryBody
     *
     * @param string $poetryBody
     *
     * @return IpoetryPoetry
     */
    public function setPoetryBody($poetryBody)
    {
        $this->poetryBody = $poetryBody;

        return $this;
    }

    /**
     * Get poetryBody
     *
     * @return string
     */
    public function getPoetryBody()
    {
        return stripslashes(stream_get_contents($this->poetryBody));
    }

    /**
     * Set poetryTagId
     *
     * @param integer $poetryTagId
     *
     * @return IpoetryPoetry
     */
    public function setPoetryTagId($poetryTagId)
    {
        $this->poetryTagId = $poetryTagId;

        return $this;
    }

    /**
     * Get poetryTagId
     *
     * @return integer
     */
    public function getPoetryTagId()
    {
        return $this->poetryTagId;
    }

    /**
     * Set poetryDiscussId
     *
     * @param integer $poetryDiscussId
     *
     * @return IpoetryPoetry
     */
    public function setPoetryDiscussId($poetryDiscussId)
    {
        $this->poetryDiscussId = $poetryDiscussId;

        return $this;
    }

    /**
     * Get poetryDiscussId
     *
     * @return integer
     */
    public function getPoetryDiscussId()
    {
        return $this->poetryDiscussId;
    }

    /**
     * Set poetryVideoId
     *
     * @param integer $poetryVideoId
     *
     * @return IpoetryPoetry
     */
    public function setPoetryVideoId($poetryVideoId)
    {
        $this->poetryVideoId = $poetryVideoId;

        return $this;
    }

    /**
     * Get poetryVideoId
     *
     * @return integer
     */
    public function getPoetryVideoId()
    {
        return $this->poetryVideoId;
    }

    /**
     * Set poetryPhotoId
     *
     * @param integer $poetryPhotoId
     *
     * @return IpoetryPoetry
     */
    public function setPoetryPhotoId($poetryPhotoId)
    {
        $this->poetryPhotoId = $poetryPhotoId;

        return $this;
    }

    /**
     * Get poetryPhotoId
     *
     * @return integer
     */
    public function getPoetryPhotoId()
    {
        return $this->poetryPhotoId;
    }

    /**
     * Set poetryAudioId
     *
     * @param integer $poetryAudioId
     *
     * @return IpoetryPoetry
     */
    public function setPoetryAudioId($poetryAudioId)
    {
        $this->poetryAudioId = $poetryAudioId;

        return $this;
    }

    /**
     * Get poetryAudioId
     *
     * @return integer
     */
    public function getPoetryAudioId()
    {
        return $this->poetryAudioId;
    }

    /**
     * Set poetryThemeId
     *
     * @param integer $poetryThemeId
     *
     * @return IpoetryPoetry
     */
    public function setPoetryThemeId($poetryThemeId)
    {
        $this->poetryThemeId = $poetryThemeId;

        return $this;
    }

    /**
     * Get poetryThemeId
     *
     * @return integer
     */
    public function getPoetryThemeId()
    {
        return $this->poetryThemeId;
    }

    /**
     * Set poetryBackgroundImageId
     *
     * @param integer $poetryBackgroundImageId
     *
     * @return IpoetryPoetry
     */
    public function setPoetryBackgroundImageId($poetryBackgroundImageId)
    {
        $this->poetryBackgroundImageId = $poetryBackgroundImageId;

        return $this;
    }

    /**
     * Get poetryBackgroundImageId
     *
     * @return integer
     */
    public function getPoetryBackgroundImageId()
    {
        return $this->poetryBackgroundImageId;
    }

    /**
     * Set poetryPoetryRatingId
     *
     * @param integer $poetryPoetryRatingId
     *
     * @return IpoetryPoetry
     */
    public function setPoetryPoetryRatingId($poetryPoetryRatingId)
    {
        $this->poetryPoetryRatingId = $poetryPoetryRatingId;

        return $this;
    }

    /**
     * Get poetryPoetryRatingId
     *
     * @return integer
     */
    public function getPoetryPoetryRatingId()
    {
        return $this->poetryPoetryRatingId;
    }

    /**
     * Set poetryIsGift
     *
     * @param boolean $poetryIsGift
     *
     * @return IpoetryPoetry
     */
    public function setPoetryIsGift($poetryIsGift)
    {
        $this->poetryIsGift = $poetryIsGift;

        return $this;
    }

    /**
     * Get poetryIsGift
     *
     * @return boolean
     */
    public function getPoetryIsGift()
    {
        return $this->poetryIsGift;
    }
    
    /**
     * Set  recommended
     *
     * @param boolean $recommended
     *
     * @return IpoetryPoetry
     */
    public function setRecommended($recommended)
    {
        $this->recommended = $recommended;

        return $this;
    }

    /**
     * Get recommended
     *
     * @return boolean
     */
    public function getRecommended()
    {
        return $this->recommended;
    }

    /**
     * Set poetryTitle
     *
     * @param string $poetryTitle
     *
     * @return IpoetryPoetry
     */
    public function setPoetryTitle($poetryTitle)
    {
        $this->poetryTitle = $poetryTitle;

        return $this;
    }

    /**
     * Get poetryTitle
     *
     * @return string
     */
    public function getPoetryTitle()
    {
        return $this->poetryTitle;
    }

    /**
     * Set poetryDescription
     *
     * @param string $poetryDescription
     *
     * @return IpoetryPoetry
     */
    public function setPoetryDescription($poetryDescription)
    {
        $this->poetryDescription = $poetryDescription;

        return $this;
    }

    /**
     * Get poetryDescription
     *
     * @return string
     */
    public function getPoetryDescription()
    {
        return $this->poetryDescription;
    }
    
    /**
     * Set poetryCreatedAt
     *
     * @param string $poetryCreatedAt
     *
     * @return IpoetryPoetry
     */
    public function setPoetryCreatedAt($poetryCreatedAt)
    {
        $this->poetryCreatedAt = $poetryCreatedAt;

        return $this;
    }    
    
    /**
     * Get poetryCreatedAt
     *
     * @return string
     */
    public function getPoetryCreatedAt()
    {
        return $this->poetryCreatedAt;
    }

    /**
     * Set poetryBodyText
     *
     * @param mediumtext $poetryBodyText
     *
     * @return IpoetryPoetry
     */
    public function setPoetryBodyText($poetryBodyText)
    {
        $this->poetryBodyText = $poetryBodyText;

        return $this;
    }    
    
    /**
     * Get poetryBodyText
     *
     * @return mediumtext
     */
    public function getPoetryBodyText()
    {
        return $this->poetryBodyText;
    }

    /**
     * Set poetryResourceExt
     *
     * @param string $poetryResourceExt
     *
     * @return IpoetryPoetry
     */
    public function setPoetryResourceExt($poetryResourceExt)
    {
        $this->poetryResourceExt = $poetryResourceExt;

        return $this;
    }    

    /**
     * Get poetryResourceExt
     *
     * @return string
     */
    public function getPoetryResourceExt()
    {
        return $this->poetryResourceExt;
    }

    /**
     * Set poetryPoetryTags
     *
     * @param string $poetryPoetryTags
     *
     * @return IpoetryPoetry
     */
    public function setPoetryPoetryTags($poetryPoetryTags)
    {
        $this->poetryPoetryTags = $poetryPoetryTags;

        return $this;
    }    

    /**
     * Get poetryPoetryTags
     *
     * @return string
     */
    public function getPoetryPoetryTags()
    {
        return $this->poetryPoetryTags;
    }
    
    /**
     * Add ipoetryUserUser
     *
     * @param \IpoetryBundle\Entity\IpoetryUser $ipoetryUserUser
     *
     * @return IpoetryPoetry
     */
    public function addIpoetryUserUser(\IpoetryBundle\Entity\IpoetryUser $ipoetryUserUser)
    {
        $this->ipoetryUserUser[] = $ipoetryUserUser;

        return $this;
    }

    /**
     * Remove ipoetryUserUser
     *
     * @param \IpoetryBundle\Entity\IpoetryUser $ipoetryUserUser
     */
    public function removeIpoetryUserUser(\IpoetryBundle\Entity\IpoetryUser $ipoetryUserUser)
    {
        $this->ipoetryUserUser->removeElement($ipoetryUserUser);
    }

    /**
     * Get ipoetryUserUser
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIpoetryUserUser()
    {
        return $this->ipoetryUserUser;
    }

    /**
     * Add ipoetryTagsTags
     *
     * @param \IpoetryBundle\Entity\IpoetryTags $ipoetryTagsTags
     *
     * @return IpoetryPoetry
     */
    public function addIpoetryTagsTags(\IpoetryBundle\Entity\IpoetryTags $ipoetryTagsTags)
    {
        $this->ipoetryTagsTags[] = $ipoetryTagsTags;

        return $this;
    }

    /**
     * Remove ipoetryTagsTags
     *
     * @param \IpoetryBundle\Entity\IpoetryTags $ipoetryTagsTags
     */
    public function removeIpoetryTagsTags(\IpoetryBundle\Entity\IpoetryTags $ipoetryTagsTags)
    {
        $this->ipoetryTagsTags->removeElement($ipoetryTagsTags);
    }

    /**
     * Get ipoetryTagsTags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIpoetryTagsTags()
    {
        return $this->ipoetryTagsTags;
    }
    
    /**
     * Set IpoetryBackgroundImages
     *
     * @param \IpoetryBundle\Entity\IpoetryBackgroundImages $ipoetryBackgroundImages
     *
     * @return IpoetryBackgroundImages
     */
    public function setIpoetryBackgroundImages(\IpoetryBundle\Entity\IpoetryBackgroundImages $ipoetryPoetryBackgroundImages  = null)
    {
        $this->ipoetryPoetryBackgroundImages = $ipoetryPoetryBackgroundImages;

        return $this;
    }

    /**
     * Get IpoetryBackgroundImages
     *
     * @return \IpoetryBundle\Entity\IpoetryBackgroundImages
     */
    public function getIpoetryBackgroundImages()
    {
        return $this->$ipoetryPoetryBackgroundImages;
    }
    
    /**
     * Set class IpoetryPoetryRating
     *
     * @param \IpoetryBundle\Entity\IpoetryPoetryRating $ipoetryPoetryRating
     *
     * @return IpoetryPoetryRating
     */
    public function setIpoetryPoetryRating(\IpoetryBundle\Entity\IpoetryPoetryRating $ipoetryPoetryRating  = null)
    {
        $this->ipoetryPoetryRating = $ipoetryPoetryRating;

        return $this;
    }

    /**
     * Get IpoetryPoetryRating
     *
     * @return \IpoetryBundle\Entity\IpoetryPoetryRating
     */
    public function getIpoetryPoetryRating()
    {
        return $this->$ipoetryPoetryRating;
    }

    /**
     * Get ipoetryUserRepost
     *
     * @return \IpoetryBundle\Entity\PoetryRepostToOwnFeed
     */
    public function getIpoetryUserRepost()
    {
        return $this->ipoetryUserRepost;
    }

    /**
     * Add ipoetryUserRepost
     *
     * @param \IpoetryBundle\Entity\PoetryRepostToOwnFeed $ipoetryUserRepost
     *
     * @return PoetryRepostToOwnFeed
     */
    public function addIpoetryUserRepost(\IpoetryBundle\Entity\PoetryRepostToOwnFeed $ipoetryUserRepost)
    {
        $this->ipoetryUserRepost[] = $ipoetryUserRepost;

        return $this;
    }

    /**
     * Remove ipoetryUserRepost
     *
     * @param \IpoetryBundle\Entity\PoetryRepostToOwnFeed $ipoetryUserRepost
     */
    public function removeIpoetryPoetryPoetry(\IpoetryBundle\Entity\PoetryRepostToOwnFeed $ipoetryUserRepost)
    {
        $this->ipoetryUserRepost->removeElement($ipoetryUserRepost);
    }
}
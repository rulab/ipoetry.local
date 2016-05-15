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
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $poetryId;

    /**
     * @var integer
     *
     * @ORM\Column(name="poetry_parent_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $poetryParentId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="poetry_body", type="text", length=255, nullable=true)
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
     * @ORM\Column(name="poetry_video_id", type="integer", nullable=true)
     */
    private $poetryVideoId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="poetry_photo_id", type="integer", nullable=true)
     */
    private $poetryPhotoId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="poetry_audio_id", type="integer", nullable=true)
     */
    private $poetryAudioId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="poetry_theme_id", type="integer", nullable=true)
     */
    private $poetryThemeId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="poetry_background_image_id", type="integer", nullable=true)
     */
    private $poetryBackgroundImageId = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="poetry_is_gift", type="boolean", nullable=true)
     */
    private $poetryIsGift = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="poetry_description", type="string", length=1024, nullable=true)
     */
    private $poetryDescription;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="IpoetryBundle\Entity\IpoetryUser", inversedBy="ipoetryPoetryPoetry")
     * @ORM\JoinTable(name="ipoetry_poetry_rating",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ipoetry_poetry_poetry_id", referencedColumnName="poetry_id"),
     *     @ORM\JoinColumn(name="ipoetry_poetry_poetry_parent_id", referencedColumnName="poetry_parent_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ipoetry_user_user_id", referencedColumnName="user_id"),
     *     @ORM\JoinColumn(name="ipoetry_user_user_parent_id", referencedColumnName="user_parent_id")
     *   }
     * )
     */
    private $ipoetryUserUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ipoetryUserUser = new \Doctrine\Common\Collections\ArrayCollection();
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
        return $this->poetryBody;
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
}

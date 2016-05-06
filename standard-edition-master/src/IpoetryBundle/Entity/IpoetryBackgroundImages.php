<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryBackgroundImages
 *
 * @ORM\Table(name="ipoetry_background_images", indexes={@ORM\Index(name="fk_ipoetry_background_images_ipoetry_event1_idx", columns={"ipoetry_event_ipoetry_event_id"}), @ORM\Index(name="fk_ipoetry_background_images_ipoetry_poetry1_idx", columns={"ipoetry_poetry_poetry_id", "ipoetry_poetry_ipoetry_poetry_parent_id"}), @ORM\Index(name="fk_ipoetry_background_images_ipoetry_user_group1_idx", columns={"ipoetry_user_group_ipoetry_user_group_id"})})
 * @ORM\Entity
 */
class IpoetryBackgroundImages
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idipoetry_background_images_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idipoetryBackgroundImagesId;

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_background_image", type="blob", length=65535, nullable=true)
     */
    private $ipoetryBackgroundImage;

    /**
     * @var \IpoetryBundle\Entity\IpoetryEvent
     *
     * @ORM\ManyToOne(targetEntity="IpoetryBundle\Entity\IpoetryEvent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_event_ipoetry_event_id", referencedColumnName="ipoetry_event_id")
     * })
     */
    private $ipoetryEventIpoetryEvent;

    /**
     * @var \IpoetryBundle\Entity\IpoetryPoetry
     *
     * @ORM\ManyToOne(targetEntity="IpoetryBundle\Entity\IpoetryPoetry")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_poetry_poetry_id", referencedColumnName="poetry_id"),
     *   @ORM\JoinColumn(name="ipoetry_poetry_ipoetry_poetry_parent_id", referencedColumnName="poetry_parent_id")
     * })
     */
    private $ipoetryPoetryPoetry;

    /**
     * @var \IpoetryBundle\Entity\IpoetryUserGroup
     *
     * @ORM\ManyToOne(targetEntity="IpoetryBundle\Entity\IpoetryUserGroup")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_user_group_ipoetry_user_group_id", referencedColumnName="ipoetry_user_group_id")
     * })
     */
    private $ipoetryUserGroupIpoetryUserGroup;



    /**
     * Get idipoetryBackgroundImagesId
     *
     * @return integer
     */
    public function getIdipoetryBackgroundImagesId()
    {
        return $this->idipoetryBackgroundImagesId;
    }

    /**
     * Set ipoetryBackgroundImage
     *
     * @param string $ipoetryBackgroundImage
     *
     * @return IpoetryBackgroundImages
     */
    public function setIpoetryBackgroundImage($ipoetryBackgroundImage)
    {
        $this->ipoetryBackgroundImage = $ipoetryBackgroundImage;

        return $this;
    }

    /**
     * Get ipoetryBackgroundImage
     *
     * @return string
     */
    public function getIpoetryBackgroundImage()
    {
        return $this->ipoetryBackgroundImage;
    }

    /**
     * Set ipoetryEventIpoetryEvent
     *
     * @param \IpoetryBundle\Entity\IpoetryEvent $ipoetryEventIpoetryEvent
     *
     * @return IpoetryBackgroundImages
     */
    public function setIpoetryEventIpoetryEvent(\IpoetryBundle\Entity\IpoetryEvent $ipoetryEventIpoetryEvent = null)
    {
        $this->ipoetryEventIpoetryEvent = $ipoetryEventIpoetryEvent;

        return $this;
    }

    /**
     * Get ipoetryEventIpoetryEvent
     *
     * @return \IpoetryBundle\Entity\IpoetryEvent
     */
    public function getIpoetryEventIpoetryEvent()
    {
        return $this->ipoetryEventIpoetryEvent;
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

    /**
     * Set ipoetryUserGroupIpoetryUserGroup
     *
     * @param \IpoetryBundle\Entity\IpoetryUserGroup $ipoetryUserGroupIpoetryUserGroup
     *
     * @return IpoetryBackgroundImages
     */
    public function setIpoetryUserGroupIpoetryUserGroup(\IpoetryBundle\Entity\IpoetryUserGroup $ipoetryUserGroupIpoetryUserGroup = null)
    {
        $this->ipoetryUserGroupIpoetryUserGroup = $ipoetryUserGroupIpoetryUserGroup;

        return $this;
    }

    /**
     * Get ipoetryUserGroupIpoetryUserGroup
     *
     * @return \IpoetryBundle\Entity\IpoetryUserGroup
     */
    public function getIpoetryUserGroupIpoetryUserGroup()
    {
        return $this->ipoetryUserGroupIpoetryUserGroup;
    }
}

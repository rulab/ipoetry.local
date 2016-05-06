<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryEvent
 *
 * @ORM\Table(name="ipoetry_event")
 * @ORM\Entity
 */
class IpoetryEvent
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_event_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ipoetryEventId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ipoetry_event_date", type="datetime", nullable=true)
     */
    private $ipoetryEventDate;

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_event_place", type="string", length=1024, nullable=true)
     */
    private $ipoetryEventPlace = 'undefined';

    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_event_background_image_id", type="integer", nullable=true)
     */
    private $ipoetryEventBackgroundImageId = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="ipoetry_event_user_group_welcome", type="boolean", nullable=true)
     */
    private $ipoetryEventUserGroupWelcome = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_event_description", type="string", length=1024, nullable=true)
     */
    private $ipoetryEventDescription;



    /**
     * Get ipoetryEventId
     *
     * @return integer
     */
    public function getIpoetryEventId()
    {
        return $this->ipoetryEventId;
    }

    /**
     * Set ipoetryEventDate
     *
     * @param \DateTime $ipoetryEventDate
     *
     * @return IpoetryEvent
     */
    public function setIpoetryEventDate($ipoetryEventDate)
    {
        $this->ipoetryEventDate = $ipoetryEventDate;

        return $this;
    }

    /**
     * Get ipoetryEventDate
     *
     * @return \DateTime
     */
    public function getIpoetryEventDate()
    {
        return $this->ipoetryEventDate;
    }

    /**
     * Set ipoetryEventPlace
     *
     * @param string $ipoetryEventPlace
     *
     * @return IpoetryEvent
     */
    public function setIpoetryEventPlace($ipoetryEventPlace)
    {
        $this->ipoetryEventPlace = $ipoetryEventPlace;

        return $this;
    }

    /**
     * Get ipoetryEventPlace
     *
     * @return string
     */
    public function getIpoetryEventPlace()
    {
        return $this->ipoetryEventPlace;
    }

    /**
     * Set ipoetryEventBackgroundImageId
     *
     * @param integer $ipoetryEventBackgroundImageId
     *
     * @return IpoetryEvent
     */
    public function setIpoetryEventBackgroundImageId($ipoetryEventBackgroundImageId)
    {
        $this->ipoetryEventBackgroundImageId = $ipoetryEventBackgroundImageId;

        return $this;
    }

    /**
     * Get ipoetryEventBackgroundImageId
     *
     * @return integer
     */
    public function getIpoetryEventBackgroundImageId()
    {
        return $this->ipoetryEventBackgroundImageId;
    }

    /**
     * Set ipoetryEventUserGroupWelcome
     *
     * @param boolean $ipoetryEventUserGroupWelcome
     *
     * @return IpoetryEvent
     */
    public function setIpoetryEventUserGroupWelcome($ipoetryEventUserGroupWelcome)
    {
        $this->ipoetryEventUserGroupWelcome = $ipoetryEventUserGroupWelcome;

        return $this;
    }

    /**
     * Get ipoetryEventUserGroupWelcome
     *
     * @return boolean
     */
    public function getIpoetryEventUserGroupWelcome()
    {
        return $this->ipoetryEventUserGroupWelcome;
    }

    /**
     * Set ipoetryEventDescription
     *
     * @param string $ipoetryEventDescription
     *
     * @return IpoetryEvent
     */
    public function setIpoetryEventDescription($ipoetryEventDescription)
    {
        $this->ipoetryEventDescription = $ipoetryEventDescription;

        return $this;
    }

    /**
     * Get ipoetryEventDescription
     *
     * @return string
     */
    public function getIpoetryEventDescription()
    {
        return $this->ipoetryEventDescription;
    }
}

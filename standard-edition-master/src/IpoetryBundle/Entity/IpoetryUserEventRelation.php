<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryUserEventRelation
 *
 * @ORM\Table(name="ipoetry_user_event_relation", indexes={@ORM\Index(name="fk_ipoetry_user_event_relation_ipoetry_event1_idx", columns={"ipoetry_event_ipoetry_event_id"}), @ORM\Index(name="fk_ipoetry_user_event_relation_ipoetry_user1_idx", columns={"ipoetry_user_user_id"})})
 * @ORM\Entity
 */
class IpoetryUserEventRelation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idipoetry_user_event_relation_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idipoetryUserEventRelationId;

    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_user_parent_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $ipoetryUserUserParentId;

    /**
     * @var \IpoetryBundle\Entity\IpoetryUser
     *
     * @ORM\OneToOne(targetEntity="IpoetryBundle\Entity\IpoetryUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_user_user_id", referencedColumnName="user_id", unique=true)
     * })
     */
    private $ipoetryUserUser;

    /**
     * @var \IpoetryBundle\Entity\IpoetryEvent
     *
     * @ORM\OneToOne(targetEntity="IpoetryBundle\Entity\IpoetryEvent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_event_ipoetry_event_id", referencedColumnName="ipoetry_event_id", unique=true)
     * })
     */
    private $ipoetryEventIpoetryEvent;



    /**
     * Set idipoetryUserEventRelationId
     *
     * @param integer $idipoetryUserEventRelationId
     *
     * @return IpoetryUserEventRelation
     */
    public function setIdipoetryUserEventRelationId($idipoetryUserEventRelationId)
    {
        $this->idipoetryUserEventRelationId = $idipoetryUserEventRelationId;

        return $this;
    }

    /**
     * Get idipoetryUserEventRelationId
     *
     * @return integer
     */
    public function getIdipoetryUserEventRelationId()
    {
        return $this->idipoetryUserEventRelationId;
    }

    /**
     * Set ipoetryUserUserParentId
     *
     * @param integer $ipoetryUserUserParentId
     *
     * @return IpoetryUserEventRelation
     */
    public function setIpoetryUserUserParentId($ipoetryUserUserParentId)
    {
        $this->ipoetryUserUserParentId = $ipoetryUserUserParentId;

        return $this;
    }

    /**
     * Get ipoetryUserUserParentId
     *
     * @return integer
     */
    public function getIpoetryUserUserParentId()
    {
        return $this->ipoetryUserUserParentId;
    }

    /**
     * Set ipoetryUserUser
     *
     * @param \IpoetryBundle\Entity\IpoetryUser $ipoetryUserUser
     *
     * @return IpoetryUserEventRelation
     */
    public function setIpoetryUserUser(\IpoetryBundle\Entity\IpoetryUser $ipoetryUserUser = null)
    {
        $this->ipoetryUserUser = $ipoetryUserUser;

        return $this;
    }

    /**
     * Get ipoetryUserUser
     *
     * @return \IpoetryBundle\Entity\IpoetryUser
     */
    public function getIpoetryUserUser()
    {
        return $this->ipoetryUserUser;
    }

    /**
     * Set ipoetryEventIpoetryEvent
     *
     * @param \IpoetryBundle\Entity\IpoetryEvent $ipoetryEventIpoetryEvent
     *
     * @return IpoetryUserEventRelation
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
}

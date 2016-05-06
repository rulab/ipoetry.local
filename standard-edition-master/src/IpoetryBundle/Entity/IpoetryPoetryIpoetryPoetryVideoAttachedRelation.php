<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryPoetryIpoetryPoetryVideoAttachedRelation
 *
 * @ORM\Table(name="ipoetry_poetry_ipoetry_poetry_video_attached_relation", indexes={@ORM\Index(name="fk_ipoetry_poetry_has_ipoetry_poetry_video_attached_ipoetry_idx", columns={"ipoetry_poetry_video_attached_ipoetry_poetry_video_attached_id"}), @ORM\Index(name="fk_ipoetry_poetry_has_ipoetry_poetry_video_attached_ipoetry_idx1", columns={"ipoetry_poetry_poetry_id"})})
 * @ORM\Entity
 */
class IpoetryPoetryIpoetryPoetryVideoAttachedRelation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_poetry_ipoetry_poetry_video_attached_relation_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $ipoetryPoetryIpoetryPoetryVideoAttachedRelationId;

    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_poetry_poetry_parent_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $ipoetryPoetryPoetryParentId;

    /**
     * @var \IpoetryBundle\Entity\IpoetryPoetry
     *
     * @ORM\OneToOne(targetEntity="IpoetryBundle\Entity\IpoetryPoetry")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_poetry_poetry_id", referencedColumnName="poetry_id", unique=true)
     * })
     */
    private $ipoetryPoetryPoetry;

    /**
     * @var \IpoetryBundle\Entity\IpoetryPoetryVideoAttached
     *
     * @ORM\OneToOne(targetEntity="IpoetryBundle\Entity\IpoetryPoetryVideoAttached")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_poetry_video_attached_ipoetry_poetry_video_attached_id", referencedColumnName="ipoetry_poetry_video_attached_id", unique=true)
     * })
     */
    private $ipoetryPoetryVideoAttachedIpoetryPoetryVideoAttached;



    /**
     * Set ipoetryPoetryIpoetryPoetryVideoAttachedRelationId
     *
     * @param integer $ipoetryPoetryIpoetryPoetryVideoAttachedRelationId
     *
     * @return IpoetryPoetryIpoetryPoetryVideoAttachedRelation
     */
    public function setIpoetryPoetryIpoetryPoetryVideoAttachedRelationId($ipoetryPoetryIpoetryPoetryVideoAttachedRelationId)
    {
        $this->ipoetryPoetryIpoetryPoetryVideoAttachedRelationId = $ipoetryPoetryIpoetryPoetryVideoAttachedRelationId;

        return $this;
    }

    /**
     * Get ipoetryPoetryIpoetryPoetryVideoAttachedRelationId
     *
     * @return integer
     */
    public function getIpoetryPoetryIpoetryPoetryVideoAttachedRelationId()
    {
        return $this->ipoetryPoetryIpoetryPoetryVideoAttachedRelationId;
    }

    /**
     * Set ipoetryPoetryPoetryParentId
     *
     * @param integer $ipoetryPoetryPoetryParentId
     *
     * @return IpoetryPoetryIpoetryPoetryVideoAttachedRelation
     */
    public function setIpoetryPoetryPoetryParentId($ipoetryPoetryPoetryParentId)
    {
        $this->ipoetryPoetryPoetryParentId = $ipoetryPoetryPoetryParentId;

        return $this;
    }

    /**
     * Get ipoetryPoetryPoetryParentId
     *
     * @return integer
     */
    public function getIpoetryPoetryPoetryParentId()
    {
        return $this->ipoetryPoetryPoetryParentId;
    }

    /**
     * Set ipoetryPoetryPoetry
     *
     * @param \IpoetryBundle\Entity\IpoetryPoetry $ipoetryPoetryPoetry
     *
     * @return IpoetryPoetryIpoetryPoetryVideoAttachedRelation
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
     * Set ipoetryPoetryVideoAttachedIpoetryPoetryVideoAttached
     *
     * @param \IpoetryBundle\Entity\IpoetryPoetryVideoAttached $ipoetryPoetryVideoAttachedIpoetryPoetryVideoAttached
     *
     * @return IpoetryPoetryIpoetryPoetryVideoAttachedRelation
     */
    public function setIpoetryPoetryVideoAttachedIpoetryPoetryVideoAttached(\IpoetryBundle\Entity\IpoetryPoetryVideoAttached $ipoetryPoetryVideoAttachedIpoetryPoetryVideoAttached = null)
    {
        $this->ipoetryPoetryVideoAttachedIpoetryPoetryVideoAttached = $ipoetryPoetryVideoAttachedIpoetryPoetryVideoAttached;

        return $this;
    }

    /**
     * Get ipoetryPoetryVideoAttachedIpoetryPoetryVideoAttached
     *
     * @return \IpoetryBundle\Entity\IpoetryPoetryVideoAttached
     */
    public function getIpoetryPoetryVideoAttachedIpoetryPoetryVideoAttached()
    {
        return $this->ipoetryPoetryVideoAttachedIpoetryPoetryVideoAttached;
    }
}

<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryPoetryIpoetryPoetryPhotoAttachedRelation
 *
 * @ORM\Table(name="ipoetry_poetry_ipoetry_poetry_photo_attached_relation", indexes={@ORM\Index(name="fk_ipoetry_poetry_has_ipoetry_poetry_photo_attached_ipoetry_idx", columns={"ipoetry_poetry_photo_attached_ipoetry_poetry_photo_attached_id"}), @ORM\Index(name="fk_ipoetry_poetry_has_ipoetry_poetry_photo_attached_ipoetry_idx1", columns={"ipoetry_poetry_poetry_id"})})
 * @ORM\Entity
 */
class IpoetryPoetryIpoetryPoetryPhotoAttachedRelation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_poetry_ipoetry_poetry_photo_attached_relation_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $ipoetryPoetryIpoetryPoetryPhotoAttachedRelationId;

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
     * @var \IpoetryBundle\Entity\IpoetryPoetryPhotoAttached
     *
     * @ORM\OneToOne(targetEntity="IpoetryBundle\Entity\IpoetryPoetryPhotoAttached")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_poetry_photo_attached_ipoetry_poetry_photo_attached_id", referencedColumnName="ipoetry_poetry_photo_attached_id", unique=true)
     * })
     */
    private $ipoetryPoetryPhotoAttachedIpoetryPoetryPhotoAttached;



    /**
     * Set ipoetryPoetryIpoetryPoetryPhotoAttachedRelationId
     *
     * @param integer $ipoetryPoetryIpoetryPoetryPhotoAttachedRelationId
     *
     * @return IpoetryPoetryIpoetryPoetryPhotoAttachedRelation
     */
    public function setIpoetryPoetryIpoetryPoetryPhotoAttachedRelationId($ipoetryPoetryIpoetryPoetryPhotoAttachedRelationId)
    {
        $this->ipoetryPoetryIpoetryPoetryPhotoAttachedRelationId = $ipoetryPoetryIpoetryPoetryPhotoAttachedRelationId;

        return $this;
    }

    /**
     * Get ipoetryPoetryIpoetryPoetryPhotoAttachedRelationId
     *
     * @return integer
     */
    public function getIpoetryPoetryIpoetryPoetryPhotoAttachedRelationId()
    {
        return $this->ipoetryPoetryIpoetryPoetryPhotoAttachedRelationId;
    }

    /**
     * Set ipoetryPoetryPoetryParentId
     *
     * @param integer $ipoetryPoetryPoetryParentId
     *
     * @return IpoetryPoetryIpoetryPoetryPhotoAttachedRelation
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
     * @return IpoetryPoetryIpoetryPoetryPhotoAttachedRelation
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
     * Set ipoetryPoetryPhotoAttachedIpoetryPoetryPhotoAttached
     *
     * @param \IpoetryBundle\Entity\IpoetryPoetryPhotoAttached $ipoetryPoetryPhotoAttachedIpoetryPoetryPhotoAttached
     *
     * @return IpoetryPoetryIpoetryPoetryPhotoAttachedRelation
     */
    public function setIpoetryPoetryPhotoAttachedIpoetryPoetryPhotoAttached(\IpoetryBundle\Entity\IpoetryPoetryPhotoAttached $ipoetryPoetryPhotoAttachedIpoetryPoetryPhotoAttached = null)
    {
        $this->ipoetryPoetryPhotoAttachedIpoetryPoetryPhotoAttached = $ipoetryPoetryPhotoAttachedIpoetryPoetryPhotoAttached;

        return $this;
    }

    /**
     * Get ipoetryPoetryPhotoAttachedIpoetryPoetryPhotoAttached
     *
     * @return \IpoetryBundle\Entity\IpoetryPoetryPhotoAttached
     */
    public function getIpoetryPoetryPhotoAttachedIpoetryPoetryPhotoAttached()
    {
        return $this->ipoetryPoetryPhotoAttachedIpoetryPoetryPhotoAttached;
    }
}

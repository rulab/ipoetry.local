<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryPoetryIpoetryPoetryAudioAttachedRelation
 *
 * @ORM\Table(name="ipoetry_poetry_ipoetry_poetry_audio_attached_relation", indexes={@ORM\Index(name="fk_ipoetry_poetry_has_ipoetry_poetry_audio_attached_ipoetry_idx", columns={"ipoetry_poetry_audio_attached_ipoetry_poetry_audio_attached_id"}), @ORM\Index(name="fk_ipoetry_poetry_has_ipoetry_poetry_audio_attached_ipoetry_idx1", columns={"ipoetry_poetry_poetry_id"})})
 * @ORM\Entity
 */
class IpoetryPoetryIpoetryPoetryAudioAttachedRelation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_poetry_ipoetry_poetry_audio_attached_relation_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $ipoetryPoetryIpoetryPoetryAudioAttachedRelationId;

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
     * @var \IpoetryBundle\Entity\IpoetryPoetryAudioAttached
     *
     * @ORM\OneToOne(targetEntity="IpoetryBundle\Entity\IpoetryPoetryAudioAttached")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_poetry_audio_attached_ipoetry_poetry_audio_attached_id", referencedColumnName="ipoetry_poetry_audio_attached_id", unique=true)
     * })
     */
    private $ipoetryPoetryAudioAttachedIpoetryPoetryAudioAttached;



    /**
     * Set ipoetryPoetryIpoetryPoetryAudioAttachedRelationId
     *
     * @param integer $ipoetryPoetryIpoetryPoetryAudioAttachedRelationId
     *
     * @return IpoetryPoetryIpoetryPoetryAudioAttachedRelation
     */
    public function setIpoetryPoetryIpoetryPoetryAudioAttachedRelationId($ipoetryPoetryIpoetryPoetryAudioAttachedRelationId)
    {
        $this->ipoetryPoetryIpoetryPoetryAudioAttachedRelationId = $ipoetryPoetryIpoetryPoetryAudioAttachedRelationId;

        return $this;
    }

    /**
     * Get ipoetryPoetryIpoetryPoetryAudioAttachedRelationId
     *
     * @return integer
     */
    public function getIpoetryPoetryIpoetryPoetryAudioAttachedRelationId()
    {
        return $this->ipoetryPoetryIpoetryPoetryAudioAttachedRelationId;
    }

    /**
     * Set ipoetryPoetryPoetryParentId
     *
     * @param integer $ipoetryPoetryPoetryParentId
     *
     * @return IpoetryPoetryIpoetryPoetryAudioAttachedRelation
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
     * @return IpoetryPoetryIpoetryPoetryAudioAttachedRelation
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
     * Set ipoetryPoetryAudioAttachedIpoetryPoetryAudioAttached
     *
     * @param \IpoetryBundle\Entity\IpoetryPoetryAudioAttached $ipoetryPoetryAudioAttachedIpoetryPoetryAudioAttached
     *
     * @return IpoetryPoetryIpoetryPoetryAudioAttachedRelation
     */
    public function setIpoetryPoetryAudioAttachedIpoetryPoetryAudioAttached(\IpoetryBundle\Entity\IpoetryPoetryAudioAttached $ipoetryPoetryAudioAttachedIpoetryPoetryAudioAttached = null)
    {
        $this->ipoetryPoetryAudioAttachedIpoetryPoetryAudioAttached = $ipoetryPoetryAudioAttachedIpoetryPoetryAudioAttached;

        return $this;
    }

    /**
     * Get ipoetryPoetryAudioAttachedIpoetryPoetryAudioAttached
     *
     * @return \IpoetryBundle\Entity\IpoetryPoetryAudioAttached
     */
    public function getIpoetryPoetryAudioAttachedIpoetryPoetryAudioAttached()
    {
        return $this->ipoetryPoetryAudioAttachedIpoetryPoetryAudioAttached;
    }
}

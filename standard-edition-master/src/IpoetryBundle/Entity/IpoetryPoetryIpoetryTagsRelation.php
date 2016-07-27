<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryPoetryIpoetryTagsRelation
 *
 * @ORM\Table(name="ipoetry_poetry_ipoetry_tags_relation")
 * @ORM\Entity
 */
class IpoetryPoetryIpoetryTagsRelation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_poetry_ipoetry_tags_relation_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ipoetryPoetryIpoetryTagsRelationId;

    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_poetry_poetry_parent_id", type="integer", nullable=false)
     */
    private $ipoetryPoetryPoetryParentId;

    /**
     * @var \IpoetryBundle\Entity\IpoetryPoetry
     *
     * @ORM\ManyToOne(targetEntity="IpoetryBundle\Entity\IpoetryPoetry")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_poetry_poetry_id", referencedColumnName="poetry_id")
     * })
     */
    private $ipoetryPoetryPoetry;

    /**
     * @var \IpoetryBundle\Entity\IpoetryTags
     *
     * @ORM\ManyToOne(targetEntity="IpoetryBundle\Entity\IpoetryTags")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_tags_tags_id", referencedColumnName="ipoetry_tags_tags_id")
     * })
     */
    private $ipoetryTagsTags;



    /**
     * Get ipoetryPoetryIpoetryTagsRelationId
     *
     * @return integer
     */
    public function getIpoetryPoetryIpoetryTagsRelationId()
    {
        return $this->ipoetryPoetryIpoetryTagsRelationId;
    }

    /**
     * Set ipoetryPoetryPoetryParentId
     *
     * @param integer $ipoetryPoetryPoetryParentId
     *
     * @return IpoetryPoetryIpoetryTagsRelation
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
     * @return IpoetryPoetryIpoetryTagsRelation
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
     * Set ipoetryTagsTags
     *
     * @param \IpoetryBundle\Entity\IpoetryTags $ipoetryTagsTags
     *
     * @return IpoetryPoetryIpoetryTagsRelation
     */
    public function setIpoetryTagsTags(\IpoetryBundle\Entity\IpoetryTags $ipoetryTagsTags = null)
    {
        $this->ipoetryTagsTags = $ipoetryTagsTags;

        return $this;
    }

    /**
     * Get ipoetryTagsTags
     *
     * @return \IpoetryBundle\Entity\IpoetryTags
     */
    public function getIpoetryTagsTags()
    {
        return $this->ipoetryTagsTags;
    }
}

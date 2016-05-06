<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryUserIpoetryPoetryTypesRelation
 *
 * @ORM\Table(name="ipoetry_user_ipoetry_poetry_types_relation", indexes={@ORM\Index(name="fk_ipoetry_user_has_ipoetry_poetry_types_ipoetry_poetry_typ_idx", columns={"ipoetry_poetry_types_ipoetry_poetry_types_id"}), @ORM\Index(name="fk_ipoetry_user_has_ipoetry_poetry_types_ipoetry_user1_idx", columns={"ipoetry_user_user_id"})})
 * @ORM\Entity
 */
class IpoetryUserIpoetryPoetryTypesRelation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_ipoetry_poetry_types_relation_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $ipoetryUserIpoetryPoetryTypesRelationId;

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
     * @var \IpoetryBundle\Entity\IpoetryPoetryTypes
     *
     * @ORM\OneToOne(targetEntity="IpoetryBundle\Entity\IpoetryPoetryTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_poetry_types_ipoetry_poetry_types_id", referencedColumnName="ipoetry_poetry_types_id", unique=true)
     * })
     */
    private $ipoetryPoetryTypesIpoetryPoetryTypes;



    /**
     * Set ipoetryUserIpoetryPoetryTypesRelationId
     *
     * @param integer $ipoetryUserIpoetryPoetryTypesRelationId
     *
     * @return IpoetryUserIpoetryPoetryTypesRelation
     */
    public function setIpoetryUserIpoetryPoetryTypesRelationId($ipoetryUserIpoetryPoetryTypesRelationId)
    {
        $this->ipoetryUserIpoetryPoetryTypesRelationId = $ipoetryUserIpoetryPoetryTypesRelationId;

        return $this;
    }

    /**
     * Get ipoetryUserIpoetryPoetryTypesRelationId
     *
     * @return integer
     */
    public function getIpoetryUserIpoetryPoetryTypesRelationId()
    {
        return $this->ipoetryUserIpoetryPoetryTypesRelationId;
    }

    /**
     * Set ipoetryUserUserParentId
     *
     * @param integer $ipoetryUserUserParentId
     *
     * @return IpoetryUserIpoetryPoetryTypesRelation
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
     * @return IpoetryUserIpoetryPoetryTypesRelation
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
     * Set ipoetryPoetryTypesIpoetryPoetryTypes
     *
     * @param \IpoetryBundle\Entity\IpoetryPoetryTypes $ipoetryPoetryTypesIpoetryPoetryTypes
     *
     * @return IpoetryUserIpoetryPoetryTypesRelation
     */
    public function setIpoetryPoetryTypesIpoetryPoetryTypes(\IpoetryBundle\Entity\IpoetryPoetryTypes $ipoetryPoetryTypesIpoetryPoetryTypes = null)
    {
        $this->ipoetryPoetryTypesIpoetryPoetryTypes = $ipoetryPoetryTypesIpoetryPoetryTypes;

        return $this;
    }

    /**
     * Get ipoetryPoetryTypesIpoetryPoetryTypes
     *
     * @return \IpoetryBundle\Entity\IpoetryPoetryTypes
     */
    public function getIpoetryPoetryTypesIpoetryPoetryTypes()
    {
        return $this->ipoetryPoetryTypesIpoetryPoetryTypes;
    }
}

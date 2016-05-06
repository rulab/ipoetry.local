<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryUserIpoetryPoetryRelation
 *
 * @ORM\Table(name="ipoetry_user_ipoetry_poetry_relation", indexes={@ORM\Index(name="fk_ipoetry_user_poetry_relation_ipoetry_user1_idx", columns={"ipoetry_user_user_id"}), @ORM\Index(name="fk_ipoetry_user_poetry_relation_ipoetry_poetry1_idx", columns={"ipoetry_poetry_poetry_id"})})
 * @ORM\Entity
 */
class IpoetryUserIpoetryPoetryRelation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_poetry_relation_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ipoetryUserPoetryRelationId;

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
     * @var \IpoetryBundle\Entity\IpoetryUser
     *
     * @ORM\ManyToOne(targetEntity="IpoetryBundle\Entity\IpoetryUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_user_user_id", referencedColumnName="user_id")
     * })
     */
    private $ipoetryUserUser;



    /**
     * Get ipoetryUserPoetryRelationId
     *
     * @return integer
     */
    public function getIpoetryUserPoetryRelationId()
    {
        return $this->ipoetryUserPoetryRelationId;
    }

    /**
     * Set ipoetryPoetryPoetryParentId
     *
     * @param integer $ipoetryPoetryPoetryParentId
     *
     * @return IpoetryUserIpoetryPoetryRelation
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
     * @return IpoetryUserIpoetryPoetryRelation
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
     * Set ipoetryUserUser
     *
     * @param \IpoetryBundle\Entity\IpoetryUser $ipoetryUserUser
     *
     * @return IpoetryUserIpoetryPoetryRelation
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
}

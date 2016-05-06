<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryUserUsergroupRelation
 *
 * @ORM\Table(name="ipoetry_user_usergroup_relation", indexes={@ORM\Index(name="fk_ipoetry_user_usergroup_relation_ipoetry_user_group1_idx", columns={"ipoetry_user_group_ipoetry_user_group_id"}), @ORM\Index(name="fk_ipoetry_user_usergroup_relation_ipoetry_user1_idx", columns={"ipoetry_user_user_id"})})
 * @ORM\Entity
 */
class IpoetryUserUsergroupRelation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_usergroup_relation_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $ipoetryUserUsergroupRelationId;

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
     * @var \IpoetryBundle\Entity\IpoetryUserGroup
     *
     * @ORM\OneToOne(targetEntity="IpoetryBundle\Entity\IpoetryUserGroup")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_user_group_ipoetry_user_group_id", referencedColumnName="ipoetry_user_group_id", unique=true)
     * })
     */
    private $ipoetryUserGroupIpoetryUserGroup;



    /**
     * Set ipoetryUserUsergroupRelationId
     *
     * @param integer $ipoetryUserUsergroupRelationId
     *
     * @return IpoetryUserUsergroupRelation
     */
    public function setIpoetryUserUsergroupRelationId($ipoetryUserUsergroupRelationId)
    {
        $this->ipoetryUserUsergroupRelationId = $ipoetryUserUsergroupRelationId;

        return $this;
    }

    /**
     * Get ipoetryUserUsergroupRelationId
     *
     * @return integer
     */
    public function getIpoetryUserUsergroupRelationId()
    {
        return $this->ipoetryUserUsergroupRelationId;
    }

    /**
     * Set ipoetryUserUserParentId
     *
     * @param integer $ipoetryUserUserParentId
     *
     * @return IpoetryUserUsergroupRelation
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
     * @return IpoetryUserUsergroupRelation
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
     * Set ipoetryUserGroupIpoetryUserGroup
     *
     * @param \IpoetryBundle\Entity\IpoetryUserGroup $ipoetryUserGroupIpoetryUserGroup
     *
     * @return IpoetryUserUsergroupRelation
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

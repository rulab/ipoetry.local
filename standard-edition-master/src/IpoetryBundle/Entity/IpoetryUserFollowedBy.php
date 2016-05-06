<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryUserFollowedBy
 *
 * @ORM\Table(name="ipoetry_user_followed_by", indexes={@ORM\Index(name="fk_ipoetry_user_followed_by_ipoetry_user1_idx", columns={"ipoetry_user_user_id"})})
 * @ORM\Entity
 */
class IpoetryUserFollowedBy
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_followed_by_id", type="integer", nullable=false)
     */
    private $ipoetryUserFollowedById;

    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_user_parent_id", type="integer", nullable=false)
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
     * Set ipoetryUserFollowedById
     *
     * @param integer $ipoetryUserFollowedById
     *
     * @return IpoetryUserFollowedBy
     */
    public function setIpoetryUserFollowedById($ipoetryUserFollowedById)
    {
        $this->ipoetryUserFollowedById = $ipoetryUserFollowedById;

        return $this;
    }

    /**
     * Get ipoetryUserFollowedById
     *
     * @return integer
     */
    public function getIpoetryUserFollowedById()
    {
        return $this->ipoetryUserFollowedById;
    }

    /**
     * Set ipoetryUserUserParentId
     *
     * @param integer $ipoetryUserUserParentId
     *
     * @return IpoetryUserFollowedBy
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
     * @return IpoetryUserFollowedBy
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

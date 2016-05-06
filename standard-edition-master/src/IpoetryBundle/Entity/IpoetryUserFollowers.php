<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryUserFollowers
 *
 * @ORM\Table(name="ipoetry_user_followers",indexes={@ORM\Index(name="fk_ipoetry_user_followers_ipoetry_user1_idx", columns={"ipoetry_user_user_id"})})
 * @ORM\Entity
 */
class IpoetryUserFollowers
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_followers_id", type="integer", nullable=false)
     */
    private $ipoetryUserFollowersId;

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
     * Set ipoetryUserFollowersId
     *
     * @param integer $ipoetryUserFollowersId
     *
     * @return IpoetryUserFollowers
     */
    public function setIpoetryUserFollowersId($ipoetryUserFollowersId)
    {
        $this->ipoetryUserFollowersId = $ipoetryUserFollowersId;

        return $this;
    }

    /**
     * Get ipoetryUserFollowersId
     *
     * @return integer
     */
    public function getIpoetryUserFollowersId()
    {
        return $this->ipoetryUserFollowersId;
    }

    /**
     * Set ipoetryUserUserParentId
     *
     * @param integer $ipoetryUserUserParentId
     *
     * @return IpoetryUserFollowers
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
     * @return IpoetryUserFollowers
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

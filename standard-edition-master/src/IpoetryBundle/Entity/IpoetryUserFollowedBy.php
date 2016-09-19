<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryUserFollowedBy
 *
 * @ORM\Table(name="ipoetry_user_followed_by")
 * @ORM\Entity
 */
class IpoetryUserFollowedBy
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="pk_ipoetry_user_followed_by_id", type="integer", nullable=false, strategy="AUTO")
     */
    private $pkipoetryUserFollowedById;
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_followed_by_id", type="integer", nullable=false)
     */
    private $ipoetryUserFollowedById;
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_user_id", type="integer", nullable=false)
     */
    private $ipoetryUserUserId;

    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_user_parent_id", type="integer", nullable=false)
     */
    private $ipoetryUserUserParentId;

    /**
     * @var IpoetryBundle\Entity\IpoetryUser
     *
     * @ORM\ManyToOne(targetEntity="IpoetryBundle\Entity\IpoetryUser", inversedBy="ipoetryUserSubscribedBy")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_Id", referencedColumnName="ipoetry_user_user_id")
     * })
     */
    private $ipoetryUserSubscribers;

    /**
     * @var IpoetryBundle\Entity\IpoetryUser
     *
     * @ORM\ManyToOne(targetEntity="IpoetryBundle\Entity\IpoetryUser", inversedBy="ipoetryUserFollowedBy")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_Id", referencedColumnName="ipoetry_user_followed_by_id")
     * })
     */
    private $ipoetryUserFollowers;

    /**
     * Set pkipoetryUserFollowedById
     *
     * @param integer $pkipoetryUserFollowedById
     *
     * @return pkipoetryUserFollowedById
     */
    public function setpkipoetryUserFollowedById($pkipoetryUserFollowedById)
    {
        $this->pkipoetryUserFollowedById = $pkipoetryUserFollowedById;

        return $this;
    }
    /**
     * Get pkipoetryUserFollowedById
     *
     * @return integer
     */
    public function getpkipoetryUserFollowedById()
    {
        return $this->pkipoetryUserFollowedById;
    }

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
     * Set ipoetryUserUserId
     *
     * @param integer $ipoetryUserUserId
     *
     * @return IpoetryUserFollowedBy
     */
    public function setIpoetryUserUserId($ipoetryUserUserId)
    {
        $this->ipoetryUserUserId = $ipoetryUserUserId;

        return $this;
    }

    /**
     * Get ipoetryUserUserId
     *
     * @return integer
     */
    public function getIpoetryUserUserId()
    {
        return $this->ipoetryUserUserId;
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
     * Set ipoetryUserSubscribers
     *
     * @param \IpoetryBundle\Entity\IpoetryUser $ipoetryUserSubscribers
     */
    public function setIpoetryUserSubscribers(\IpoetryBundle\Entity\IpoetryUser $ipoetryUserUser)
    {
        $this->ipoetryUserUser->$ipoetryUserUser;
    }

    /**
     * Get ipoetryUserSubscribers
     *
     * @return \IpoetryBundle\Entity\IpoetryUser
     */
    public function getIpoetryUserSubscribers()
    {
        return $this->ipoetryUserSubscribers;
    }
    
    /**
     * Set ipoetryUserFollowers
     *
     * @param \IpoetryBundle\Entity\IpoetryUser $ipoetryUserFollowers
     */
    public function setIpoetryUserFollowers(\IpoetryBundle\Entity\IpoetryUser $ipoetryUserFollowers)
    {
        $this->ipoetryUserFollowers->$ipoetryUserFollowers;
    }

    /**
     * Get ipoetryUserFollowers
     *
     * @return \IpoetryBundle\Entity\IpoetryUser
     */
    public function getIpoetryUserFollowers()
    {
        return $this->ipoetryUserFollowers;
    }

}

<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryUserStatus
 *
 * @ORM\Table(name="ipoetry_user_status",indexes={@ORM\Index(name="fk_ipoetry_user_status_ipoetry_user1_idx", columns={"ipoetry_user_user_id"})})
 * @ORM\Entity
 */
class IpoetryUserStatus
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_status_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ipoetryUserStatusId;

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_user_status", type="string", length=45, nullable=true)
     */
    private $ipoetryUserStatus = 'undefined';

    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_user_parent_id", type="integer", nullable=false)
     */
    private $ipoetryUserUserParentId;

    /**
     * @var \IpoetryBundle\Entity\IpoetryUser
     *
     * @ORM\ManyToOne(targetEntity="IpoetryBundle\Entity\IpoetryUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_user_user_id", referencedColumnName="user_id", unique=true)
     * })
     */
    private $ipoetryUserUser;

    /**
     * Get ipoetryUserStatusId
     *
     * @return integer
     */
    public function getIpoetryUserStatusId()
    {
        return $this->ipoetryUserStatusId;
    }

    /**
     * Set ipoetryUserStatus
     *
     * @param string $ipoetryUserStatus
     *
     * @return IpoetryUserStatus
     */
    public function setIpoetryUserStatus($ipoetryUserStatus)
    {
        $this->ipoetryUserStatus = $ipoetryUserStatus;

        return $this;
    }

    /**
     * Get ipoetryUserStatus
     *
     * @return string
     */
    public function getIpoetryUserStatus()
    {
        return $this->ipoetryUserStatus;
    }
    /**
     * Set ipoetryUserUserParentId
     *
     * @param integer $ipoetryUserUserParentId
     *
     * @return IpoetryUserStatus
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
     * @return IpoetryUserStatus
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

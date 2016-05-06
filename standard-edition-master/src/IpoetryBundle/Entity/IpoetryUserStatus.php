<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryUserStatus
 *
 * @ORM\Table(name="ipoetry_user_status")
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
}

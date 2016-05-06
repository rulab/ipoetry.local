<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryUserPhone
 *
 * @ORM\Table(name="ipoetry_user_phone")
 * @ORM\Entity
 */
class IpoetryUserPhone
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_phone_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ipoetryUserPhoneId;

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_user_phone", type="string", length=11, nullable=false)
     */
    private $ipoetryUserPhone = 'undefined';



    /**
     * Get ipoetryUserPhoneId
     *
     * @return integer
     */
    public function getIpoetryUserPhoneId()
    {
        return $this->ipoetryUserPhoneId;
    }

    /**
     * Set ipoetryUserPhone
     *
     * @param string $ipoetryUserPhone
     *
     * @return IpoetryUserPhone
     */
    public function setIpoetryUserPhone($ipoetryUserPhone)
    {
        $this->ipoetryUserPhone = $ipoetryUserPhone;

        return $this;
    }

    /**
     * Get ipoetryUserPhone
     *
     * @return string
     */
    public function getIpoetryUserPhone()
    {
        return $this->ipoetryUserPhone;
    }
}

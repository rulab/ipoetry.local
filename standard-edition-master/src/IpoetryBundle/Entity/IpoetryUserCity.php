<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryUserCity
 *
 * @ORM\Table(name="ipoetry_user_city")
 * @ORM\Entity
 */
class IpoetryUserCity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_city_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ipoetryCityId;

    /**
     * @var string
     *
     * @ORM\Column(name="city_name", type="string", length=255, nullable=false)
     */
    private $cityName = 'undefined';

    /**
     * Get ipoetryCityId
     *
     * @return integer
     */
    public function getIpoetryCityId()
    {
        return $this->ipoetryCityId;
    }

    /**
     * Set cityName
     *
     * @param string $cityName
     *
     * @return IpoetryUserCity
     */
    public function setCityName($cityName)
    {
        $this->cityName = $cityName;

        return $this;
    }

    /**
     * Get cityName
     *
     * @return string
     */
    public function getCityName()
    {
        return $this->cityName;
    }
}

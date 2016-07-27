<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of CityReference
 *
 * @author d.krasavin
 * 
 * @ORM\Table(name="city_reference")
 */
class CityReference {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $cityId;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=145, nullable=true)
     */
    private $cityName;

    /**
     * Get cityId
     *
     * @param integer $cityId
     *
     */
    public function getCityId()
    {
        return $this->cityId;
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

    /**
     * Set cityName
     *
     * @param string $cityName
     *
     * @return CityReference
     */
    public function setCityName($cityName)
    {
        $this->cityName = $cityName;

        return $this;
    }


}

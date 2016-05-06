<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryPoetryTypes
 *
 * @ORM\Table(name="ipoetry_poetry_types")
 * @ORM\Entity
 */
class IpoetryPoetryTypes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_poetry_types_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ipoetryPoetryTypesId;

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_poetry_types", type="string", length=255, nullable=true)
     */
    private $ipoetryPoetryTypes = 'undefined';



    /**
     * Get ipoetryPoetryTypesId
     *
     * @return integer
     */
    public function getIpoetryPoetryTypesId()
    {
        return $this->ipoetryPoetryTypesId;
    }

    /**
     * Set ipoetryPoetryTypes
     *
     * @param string $ipoetryPoetryTypes
     *
     * @return IpoetryPoetryTypes
     */
    public function setIpoetryPoetryTypes($ipoetryPoetryTypes)
    {
        $this->ipoetryPoetryTypes = $ipoetryPoetryTypes;

        return $this;
    }

    /**
     * Get ipoetryPoetryTypes
     *
     * @return string
     */
    public function getIpoetryPoetryTypes()
    {
        return $this->ipoetryPoetryTypes;
    }
}

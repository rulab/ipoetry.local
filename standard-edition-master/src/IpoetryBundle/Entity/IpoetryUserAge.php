<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryUserAge
 *
 * @ORM\Table(name="ipoetry_user_age")
 * @ORM\Entity
 */
class IpoetryUserAge
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_age_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ipoetryUserAgeId;

    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_age", type="integer", nullable=true)
     */
    private $ipoetryUserAge;



    /**
     * Get ipoetryUserAgeId
     *
     * @return integer
     */
    public function getIpoetryUserAgeId()
    {
        return $this->ipoetryUserAgeId;
    }

    /**
     * Set ipoetryUserAge
     *
     * @param integer $ipoetryUserAge
     *
     * @return IpoetryUserAge
     */
    public function setIpoetryUserAge($ipoetryUserAge)
    {
        $this->ipoetryUserAge = $ipoetryUserAge;

        return $this;
    }

    /**
     * Get ipoetryUserAge
     *
     * @return integer
     */
    public function getIpoetryUserAge()
    {
        return $this->ipoetryUserAge;
    }
}

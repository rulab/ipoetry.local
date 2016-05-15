<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryUserWebsite
 *
 * @ORM\Table(name="ipoetry_user_website")
 * @ORM\Entity
 */
class IpoetryUserWebsite
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_website_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ipoetryUserWebsiteId;

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_user_website", type="string", length=2083, nullable=true)
     */
    private $ipoetryUserWebsite = 'undefined';

    /**
     * Get ipoetryUserWebsiteId
     *
     * @return integer
     */
    public function getIpoetryUserWebsiteId()
    {
        return $this->ipoetryUserWebsiteId;
    }

    /**
     * Set ipoetryUserWebsite
     *
     * @param string $ipoetryUserWebsite
     *
     * @return IpoetryUserWebsite
     */
    public function setIpoetryUserWebsite($ipoetryUserWebsite)
    {
        $this->ipoetryUserWebsite = $ipoetryUserWebsite;

        return $this;
    }

    /**
     * Get ipoetryUserWebsite
     *
     * @return string
     */
    public function getIpoetryUserWebsite()
    {
        return $this->ipoetryUserWebsite;
    }
}

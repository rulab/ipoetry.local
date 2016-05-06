<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryPoetryVideoAttached
 *
 * @ORM\Table(name="ipoetry_poetry_video_attached")
 * @ORM\Entity
 */
class IpoetryPoetryVideoAttached
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_poetry_video_attached_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ipoetryPoetryVideoAttachedId;

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_poetry_video_attached_url", type="string", length=2083, nullable=true)
     */
    private $ipoetryPoetryVideoAttachedUrl = 'undefined';

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_poetry_video_attached", type="blob", length=65535, nullable=true)
     */
    private $ipoetryPoetryVideoAttached;



    /**
     * Get ipoetryPoetryVideoAttachedId
     *
     * @return integer
     */
    public function getIpoetryPoetryVideoAttachedId()
    {
        return $this->ipoetryPoetryVideoAttachedId;
    }

    /**
     * Set ipoetryPoetryVideoAttachedUrl
     *
     * @param string $ipoetryPoetryVideoAttachedUrl
     *
     * @return IpoetryPoetryVideoAttached
     */
    public function setIpoetryPoetryVideoAttachedUrl($ipoetryPoetryVideoAttachedUrl)
    {
        $this->ipoetryPoetryVideoAttachedUrl = $ipoetryPoetryVideoAttachedUrl;

        return $this;
    }

    /**
     * Get ipoetryPoetryVideoAttachedUrl
     *
     * @return string
     */
    public function getIpoetryPoetryVideoAttachedUrl()
    {
        return $this->ipoetryPoetryVideoAttachedUrl;
    }

    /**
     * Set ipoetryPoetryVideoAttached
     *
     * @param string $ipoetryPoetryVideoAttached
     *
     * @return IpoetryPoetryVideoAttached
     */
    public function setIpoetryPoetryVideoAttached($ipoetryPoetryVideoAttached)
    {
        $this->ipoetryPoetryVideoAttached = $ipoetryPoetryVideoAttached;

        return $this;
    }

    /**
     * Get ipoetryPoetryVideoAttached
     *
     * @return string
     */
    public function getIpoetryPoetryVideoAttached()
    {
        return $this->ipoetryPoetryVideoAttached;
    }
}

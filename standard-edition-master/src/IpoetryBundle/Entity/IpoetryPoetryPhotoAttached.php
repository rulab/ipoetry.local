<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryPoetryPhotoAttached
 *
 * @ORM\Table(name="ipoetry_poetry_photo_attached")
 * @ORM\Entity
 */
class IpoetryPoetryPhotoAttached
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_poetry_photo_attached_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ipoetryPoetryPhotoAttachedId;

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_poetry_photo_attached_url", type="string", length=2083, nullable=true)
     */
    private $ipoetryPoetryPhotoAttachedUrl = 'undefined';

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_poetry_photo_attached", type="blob", length=65535, nullable=true)
     */
    private $ipoetryPoetryPhotoAttached;



    /**
     * Get ipoetryPoetryPhotoAttachedId
     *
     * @return integer
     */
    public function getIpoetryPoetryPhotoAttachedId()
    {
        return $this->ipoetryPoetryPhotoAttachedId;
    }

    /**
     * Set ipoetryPoetryPhotoAttachedUrl
     *
     * @param string $ipoetryPoetryPhotoAttachedUrl
     *
     * @return IpoetryPoetryPhotoAttached
     */
    public function setIpoetryPoetryPhotoAttachedUrl($ipoetryPoetryPhotoAttachedUrl)
    {
        $this->ipoetryPoetryPhotoAttachedUrl = $ipoetryPoetryPhotoAttachedUrl;

        return $this;
    }

    /**
     * Get ipoetryPoetryPhotoAttachedUrl
     *
     * @return string
     */
    public function getIpoetryPoetryPhotoAttachedUrl()
    {
        return $this->ipoetryPoetryPhotoAttachedUrl;
    }

    /**
     * Set ipoetryPoetryPhotoAttached
     *
     * @param string $ipoetryPoetryPhotoAttached
     *
     * @return IpoetryPoetryPhotoAttached
     */
    public function setIpoetryPoetryPhotoAttached($ipoetryPoetryPhotoAttached)
    {
        $this->ipoetryPoetryPhotoAttached = $ipoetryPoetryPhotoAttached;

        return $this;
    }

    /**
     * Get ipoetryPoetryPhotoAttached
     *
     * @return string
     */
    public function getIpoetryPoetryPhotoAttached()
    {
        return $this->ipoetryPoetryPhotoAttached;
    }
}

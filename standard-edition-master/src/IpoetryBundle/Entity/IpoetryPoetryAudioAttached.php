<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryPoetryAudioAttached
 *
 * @ORM\Table(name="ipoetry_poetry_audio_attached")
 * @ORM\Entity
 */
class IpoetryPoetryAudioAttached
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_poetry_audio_attached_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ipoetryPoetryAudioAttachedId;

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_poetry_audio_attached_url", type="string", length=2083, nullable=true)
     */
    private $ipoetryPoetryAudioAttachedUrl = 'undefined';

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_poetry_audio_attached", type="blob", length=65535, nullable=true)
     */
    private $ipoetryPoetryAudioAttached;



    /**
     * Get ipoetryPoetryAudioAttachedId
     *
     * @return integer
     */
    public function getIpoetryPoetryAudioAttachedId()
    {
        return $this->ipoetryPoetryAudioAttachedId;
    }

    /**
     * Set ipoetryPoetryAudioAttachedUrl
     *
     * @param string $ipoetryPoetryAudioAttachedUrl
     *
     * @return IpoetryPoetryAudioAttached
     */
    public function setIpoetryPoetryAudioAttachedUrl($ipoetryPoetryAudioAttachedUrl)
    {
        $this->ipoetryPoetryAudioAttachedUrl = $ipoetryPoetryAudioAttachedUrl;

        return $this;
    }

    /**
     * Get ipoetryPoetryAudioAttachedUrl
     *
     * @return string
     */
    public function getIpoetryPoetryAudioAttachedUrl()
    {
        return $this->ipoetryPoetryAudioAttachedUrl;
    }

    /**
     * Set ipoetryPoetryAudioAttached
     *
     * @param string $ipoetryPoetryAudioAttached
     *
     * @return IpoetryPoetryAudioAttached
     */
    public function setIpoetryPoetryAudioAttached($ipoetryPoetryAudioAttached)
    {
        $this->ipoetryPoetryAudioAttached = $ipoetryPoetryAudioAttached;

        return $this;
    }

    /**
     * Get ipoetryPoetryAudioAttached
     *
     * @return string
     */
    public function getIpoetryPoetryAudioAttached()
    {
        return $this->ipoetryPoetryAudioAttached;
    }
}

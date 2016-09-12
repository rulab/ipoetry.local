<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryUserPhoto
 *
 * @ORM\Table(name="ipoetry_user_photo", indexes={@ORM\Index(name="photo_url", columns={"user_photo_url"})})
 * @ORM\Entity
 */
class IpoetryUserPhoto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_photo_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ipoetryUserPhotoId;

    /**
     * @var string
     *
     * @ORM\Column(name="user_bkground", type="blob", length=65535, nullable=true)
     */
    private $userBkground;

    /**
     * @var string
     *
     * @ORM\Column(name="user_bkground_url", type="string", length=2083, nullable=true)
     */
    private $userBkgroundUrl = 'undefined';
    /**
     * @var string
     *
     * @ORM\Column(name="user_photo", type="blob", length=65535, nullable=true)
     */
    private $userPhoto;

    /**
     * @var string
     *
     * @ORM\Column(name="user_photo_url", type="string", length=2083, nullable=true)
     */
    private $userPhotoUrl = 'undefined';

    /**
     * Get ipoetryUserPhotoId
     *
     * @return integer
     */
    public function getIpoetryUserPhotoId()
    {
        return $this->ipoetryUserPhotoId;
    }

    /**
     * Set userPhoto
     *
     * @param string $userPhoto
     *
     * @return IpoetryUserPhoto
     */
    public function setUserPhoto($userPhoto)
    {
        $this->userPhoto = $userPhoto;

        return $this;
    }

    /**
     * Get userPhoto
     *
     * @return string
     */
    public function getUserPhoto()
    {
        return stripslashes(stream_get_contents($this->userPhoto));
    }

    /**
     * Set userPhotoUrl
     *
     * @param string $userPhotoUrl
     *
     * @return IpoetryUserPhoto
     */
    public function setUserPhotoUrl($userPhotoUrl)
    {
        $this->userPhotoUrl = $userPhotoUrl;

        return $this;
    }

    /**
     * Get userPhotoUrl
     *
     * @return string
     */
    public function getUserPhotoUrl()
    {
        return $this->userPhotoUrl;
    }
    /**
     * Set userBkground
     *
     * @param string $userBkground
     *
     * @return IpoetryUserPhoto
     */
    public function setUserBkground($userBkground)
    {
        $this->userBkground = $userBkground;

        return $this;
    }

    /**
     * Get UserBkground
     *
     * @return string
     */
    public function getUserBkground()
    {
        return stripslashes(stream_get_contents($this->userBkground));
    }

    /**
     * Set userBkground
     *
     * @param string $userBkgroundUrl
     *
     * @return IpoetryUserPhoto
     */
    public function setUserBkgroundUrl($userBkgroundUrl)
    {
        $this->userBkgroundUrl = $userBkgroundUrl;

        return $this;
    }

    /**
     * Get UserBkgroundUrl
     *
     * @return string
     */
    public function getUserBkgroundUrl()
    {
        return $this->userBkgroundUrl;
    }

}

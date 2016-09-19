<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IpoetryBundle\Entity\IpoetryUserStatus;
/**
 * IpoetryUser
 *
 * @ORM\Table(name="ipoetry_user", indexes={@ORM\Index(name="user_name_index", columns={"user_name"}), @ORM\Index(name="user_password_index", columns={"user_password"}), @ORM\Index(name="user_password", columns={"user_name", "user_password"}), @ORM\Index(name="user_name_lastname_email", columns={"user_name", "user_lastname", "user_email"}), @ORM\Index(name="fk_ipoetry_user_ipoetry_user_photo1_idx", columns={"user_photo_id"}), @ORM\Index(name="fk_ipoetry_user_ipoetry_user_city1_idx", columns={"user_city_id"}), @ORM\Index(name="fk_ipoetry_user_ipoetry_user_age1_idx", columns={"user_age_id"}), @ORM\Index(name="fk_ipoetry_user_ipoetry_user_website1_idx", columns={"user_website_id"}), @ORM\Index(name="fk_ipoetry_user_ipoetry_user_phone_idx", columns={"user_phone_id"})})
 * @ORM\Entity
 */
class IpoetryUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_parent_id", type="integer", nullable=false)
     */
    private $userParentId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=50, nullable=false)
     */
    private $userName = 'undefined';

    /**
     * @var string
     *
     * @ORM\Column(name="user_password", type="string", length=20, nullable=false)
     */
    private $userPassword = 'undefined';

    /**
     * @var string
     *
     * @ORM\Column(name="user_lastname", type="string", length=50, nullable=true)
     */
    private $userLastname = 'undefined';

    /**
     * @var string
     *
     * @ORM\Column(name="user_email", type="string", length=255, nullable=false)
     */
    private $userEmail = 'undefined';

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_user_status", type="string", length=1024, nullable=true)
     */
    private $userStatus = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="user_rating_id", type="integer", nullable=false)
     */
    private $userRatingId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="user_post_message_id", type="integer", nullable=false)
     */
    private $userPostMessageId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="user_poetry_id", type="integer", nullable=false)
     */
    private $userPoetryId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="user_event_id", type="integer", nullable=false)
     */
    private $userEventId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="user_group_id", type="integer", nullable=false)
     */
    private $userGroupId = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="ipoetry_user_followers_can_read", type="boolean", nullable=false)
     */
    private $ipoetryUserFollowersCanRead = '0';

    /**
     * @var \IpoetryBundle\Entity\IpoetryUserAge
     *
     * @ORM\OneToOne(targetEntity="IpoetryBundle\Entity\IpoetryUserAge")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_age_id", referencedColumnName="ipoetry_user_age_id")
     * })
     */
    private $userAge;

    /**
     * @var \IpoetryBundle\Entity\IpoetryUserCity
     *
     * @ORM\OneToOne(targetEntity="IpoetryBundle\Entity\IpoetryUserCity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_city_id", referencedColumnName="ipoetry_city_id")
     * })
     */
    private $userCity;

    /**
     * @var \IpoetryBundle\Entity\IpoetryUserPhone
     *
     * @ORM\OneToOne(targetEntity="IpoetryBundle\Entity\IpoetryUserPhone")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_phone_id", referencedColumnName="ipoetry_user_phone_id")
     * })
     */
    private $userPhone;

    /**
     * @var \IpoetryBundle\Entity\IpoetryUserPhoto
     *
     * @ORM\OneToOne(targetEntity="IpoetryBundle\Entity\IpoetryUserPhoto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_photo_id", referencedColumnName="ipoetry_user_photo_id")
     * })
     */
    private $userPhoto;

    /**
     * @var \IpoetryBundle\Entity\IpoetryUserWebsite
     *
     * @ORM\OneToOne(targetEntity="IpoetryBundle\Entity\IpoetryUserWebsite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_website_id", referencedColumnName="ipoetry_user_website_id")
     * })
     */
    
    private $userWebsite;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @OneToMany(targetEntity="IpoetryBundle\Entity\IpoetryUserFollowedBy", mappedBy="ipoetryUserFollowers")
     */
    private $ipoetryUserFollowedBy;
    /**
     * @var \Doctrine\Common\Collections\Collection
     * @OneToMany(targetEntity="IpoetryBundle\Entity\IpoetryUserFollowedBy", mappedBy="ipoetryUserSubscribers")
     */
    private $ipoetryUserSubscribedBy;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="IpoetryBundle\Entity\IpoetryPoetry", mappedBy="ipoetryUserUser")
     */
    private $ipoetryPoetryPoetry;

    /**
     * Constructor
     */
    public function __construct()
    {
        //связь со стихом
        $this->ipoetryPoetryPoetry = new \Doctrine\Common\Collections\ArrayCollection();
        //связь с подписантами
        $this->ipoetryUserFollowedBy = new \Doctrine\Common\Collections\ArrayCollection();
        //связь с подписчиками
        $this->ipoetryUserSubscribedBy = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set userParentId
     *
     * @param integer $userParentId
     *
     * @return IpoetryUser
     */
    public function setUserParentId($userParentId)
    {
        $this->userParentId = $userParentId;

        return $this;
    }

    /**
     * Get userParentId
     *
     * @return integer
     */
    public function getUserParentId()
    {
        return $this->userParentId;
    }

    /**
     * Set userName
     *
     * @param string $userName
     *
     * @return IpoetryUser
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set userPassword
     *
     * @param string $userPassword
     *
     * @return IpoetryUser
     */
    public function setUserPassword($userPassword)
    {
        $this->userPassword = $userPassword;

        return $this;
    }

    /**
     * Get userPassword
     *
     * @return string
     */
    public function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * Set userLastname
     *
     * @param string $userLastname
     *
     * @return IpoetryUser
     */
    public function setUserLastname($userLastname)
    {
        $this->userLastname = $userLastname;

        return $this;
    }

    /**
     * Get userLastname
     *
     * @return string
     */
    public function getUserLastname()
    {
        return $this->userLastname;
    }

    /**
     * Set userEmail
     *
     * @param string $userEmail
     *
     * @return IpoetryUser
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    /**
     * Get userEmail
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * Set userStatus
     *
     * @param string $userStatus
     *
     * @return IpoetryUser
     */
    public function setUserStatus($userStatus)
    {
        $this->userStatus = $userStatus;

        return $this;
    }

    /**
     * Get userStatus
     *
     * @return string
     */
    public function getUserStatus()
    {
        return $this->userStatus;
    }

    /**
     * Set userRatingId
     *
     * @param integer $userRatingId
     *
     * @return IpoetryUser
     */
    public function setUserRatingId($userRatingId)
    {
        $this->userRatingId = $userRatingId;

        return $this;
    }

    /**
     * Get userRatingId
     *
     * @return integer
     */
    public function getUserRatingId()
    {
        return $this->userRatingId;
    }

    /**
     * Set userPostMessageId
     *
     * @param integer $userPostMessageId
     *
     * @return IpoetryUser
     */
    public function setUserPostMessageId($userPostMessageId)
    {
        $this->userPostMessageId = $userPostMessageId;

        return $this;
    }

    /**
     * Get userPostMessageId
     *
     * @return integer
     */
    public function getUserPostMessageId()
    {
        return $this->userPostMessageId;
    }

    /**
     * Set userPoetryId
     *
     * @param integer $userPoetryId
     *
     * @return IpoetryUser
     */
    public function setUserPoetryId($userPoetryId)
    {
        $this->userPoetryId = $userPoetryId;

        return $this;
    }

    /**
     * Get userPoetryId
     *
     * @return integer
     */
    public function getUserPoetryId()
    {
        return $this->userPoetryId;
    }

    /**
     * Set userEventId
     *
     * @param integer $userEventId
     *
     * @return IpoetryUser
     */
    public function setUserEventId($userEventId)
    {
        $this->userEventId = $userEventId;

        return $this;
    }

    /**
     * Get userEventId
     *
     * @return integer
     */
    public function getUserEventId()
    {
        return $this->userEventId;
    }

    /**
     * Set userGroupId
     *
     * @param integer $userGroupId
     *
     * @return IpoetryUser
     */
    public function setUserGroupId($userGroupId)
    {
        $this->userGroupId = $userGroupId;

        return $this;
    }

    /**
     * Get userGroupId
     *
     * @return integer
     */
    public function getUserGroupId()
    {
        return $this->userGroupId;
    }

    /**
     * Set ipoetryUserFollowersCanRead
     *
     * @param boolean $ipoetryUserFollowersCanRead
     *
     * @return IpoetryUser
     */
    public function setIpoetryUserFollowersCanRead($ipoetryUserFollowersCanRead)
    {
        $this->ipoetryUserFollowersCanRead = $ipoetryUserFollowersCanRead;

        return $this;
    }

    /**
     * Get ipoetryUserFollowersCanRead
     *
     * @return boolean
     */
    public function getIpoetryUserFollowersCanRead()
    {
        return $this->ipoetryUserFollowersCanRead;
    }

    /**
     * Set userAge
     *
     * @param \IpoetryBundle\Entity\IpoetryUserAge $userAge
     *
     * @return IpoetryUser
     */
    public function setUserAge(\IpoetryBundle\Entity\IpoetryUserAge $userAge  = null)
    {
        $this->userAge = $userAge;

        return $this;
    }

    /**
     * Get userAge
     *
     * @return \IpoetryBundle\Entity\IpoetryUserAge
     */
    public function getUserAge()
    {
        return $this->userAge;
    }

    /**
     * Set userCity
     *
     * @param \IpoetryBundle\Entity\IpoetryUserCity $userCity
     *
     * @return IpoetryUser
     */
    public function setUserCity(\IpoetryBundle\Entity\IpoetryUserCity $userCity = null)
    {
        $this->userCity = $userCity;

        return $this;
    }

    /**
     * Get userCity
     *
     * @return \IpoetryBundle\Entity\IpoetryUserCity
     */
    public function getUserCity()
    {
        return $this->userCity;
    }

    /**
     * Set userPhone
     *
     * @param \IpoetryBundle\Entity\IpoetryUserPhone $userPhone
     *
     * @return IpoetryUser
     */
    public function setUserPhone(\IpoetryBundle\Entity\IpoetryUserPhone $userPhone = null)
    {
        $this->userPhone = $userPhone;

        return $this;
    }

    /**
     * Get userPhone
     *
     * @return \IpoetryBundle\Entity\IpoetryUserPhone
     */
    public function getUserPhone()
    {
        return $this->userPhone;
    }

    /**
     * Set userPhoto
     *
     * @param \IpoetryBundle\Entity\IpoetryUserPhoto $userPhoto
     *
     * @return IpoetryUser
     */
    public function setUserPhoto(\IpoetryBundle\Entity\IpoetryUserPhoto $userPhoto = null)
    {
        $this->userPhoto = $userPhoto;

        return $this;
    }

    /**
     * Get userPhoto
     *
     * @return \IpoetryBundle\Entity\IpoetryUserPhoto
     */
    public function getUserPhoto()
    {
        return $this->userPhoto;
    }

    /**
     * Set userWebsite
     *
     * @param \IpoetryBundle\Entity\IpoetryUserWebsite $userWebsite
     *
     * @return IpoetryUser
     */
    public function setUserWebsite(\IpoetryBundle\Entity\IpoetryUserWebsite $userWebsite = null)
    {
        $this->userWebsite = $userWebsite;

        return $this;
    }

    /**
     * Get userWebsite
     *
     * @return \IpoetryBundle\Entity\IpoetryUserWebsite
     */
    public function getUserWebsite()
    {
        return $this->userWebsite;
    }

    /**
     * Add ipoetryPoetryPoetry
     *
     * @param \IpoetryBundle\Entity\IpoetryPoetry $ipoetryPoetryPoetry
     *
     * @return IpoetryUser
     */
    public function addIpoetryPoetryPoetry(\IpoetryBundle\Entity\IpoetryPoetry $ipoetryPoetryPoetry)
    {
        $this->ipoetryPoetryPoetry[] = $ipoetryPoetryPoetry;

        return $this;
    }

    /**
     * Remove ipoetryPoetryPoetry
     *
     * @param \IpoetryBundle\Entity\IpoetryPoetry $ipoetryPoetryPoetry
     */
    public function removeIpoetryPoetryPoetry(\IpoetryBundle\Entity\IpoetryPoetry $ipoetryPoetryPoetry)
    {
        $this->ipoetryPoetryPoetry->removeElement($ipoetryPoetryPoetry);
    }

    /**
     * Get ipoetryPoetryPoetry
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIpoetryPoetryPoetry()
    {
        return $this->ipoetryPoetryPoetry;
    }
    
    /**
     * Set ipoetryUserFollowedBy
     *
     * @param \IpoetryBundle\Entity\IpoetryUserFollowedBy $ipoetryUserFollowedBy
     */
    public function setIpoetryUserFollowedBy(\IpoetryBundle\Entity\IpoetryUserFollowedBy $ipoetryUserFollowedBy)
    {
        $this->ipoetryUserFollowers->$ipoetryUserFollowedBy;
    }

    /**
     * Get ipoetryUserFollowedBy
     *
     * @return \IpoetryBundle\Entity\IpoetryUserFollowedBy
     */
    public function getIpoetryUserFollowedBy()
    {
        return $this->ipoetryUserFollowedBy;
    }

    /**
     * Set ipoetryUserSubscribedBy
     *
     * @param \IpoetryBundle\Entity\IpoetryUserFollowedBy $ipoetryUserFollowedBy
     */
    public function setIpoetryUserSubscribedBy(\IpoetryBundle\Entity\IpoetryUserFollowedBy $ipoetryUserSubscribedBy)
    {
        $this->ipoetryUserFollowers->$ipoetryUserSubscribedBy;
    }

    /**
     * Get ipoetryUserSubscribedBy
     *
     * @return \IpoetryBundle\Entity\IpoetryUserFollowedBy
     */
    public function getIpoetryUserSubscribedBy()
    {
        return $this->ipoetryUserSubscribedBy;
    }

}

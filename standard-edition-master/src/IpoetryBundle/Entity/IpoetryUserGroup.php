<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryUserGroup
 *
 * @ORM\Table(name="ipoetry_user_group", indexes={@ORM\Index(name="fk_ipoetry_user_group_ipoetry_user_city1_idx", columns={"ipoetry_user_city_ipoetry_city_id"})})
 * @ORM\Entity
 */
class IpoetryUserGroup
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_group_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ipoetryUserGroupId;

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_user_group_name", type="string", length=255, nullable=true)
     */
    private $ipoetryUserGroupName = 'undefined';

    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_group_background_image_id", type="integer", nullable=true)
     */
    private $ipoetryUserGroupBackgroundImageId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_user_group_description", type="string", length=1024, nullable=true)
     */
    private $ipoetryUserGroupDescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_group_city_id", type="integer", nullable=true)
     */
    private $ipoetryUserGroupCityId;

    /**
     * @var \IpoetryBundle\Entity\IpoetryUserCity
     *
     * @ORM\ManyToOne(targetEntity="IpoetryBundle\Entity\IpoetryUserCity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_user_city_ipoetry_city_id", referencedColumnName="ipoetry_city_id")
     * })
     */
    private $ipoetryUserCityIpoetryCity;



    /**
     * Get ipoetryUserGroupId
     *
     * @return integer
     */
    public function getIpoetryUserGroupId()
    {
        return $this->ipoetryUserGroupId;
    }

    /**
     * Set ipoetryUserGroupName
     *
     * @param string $ipoetryUserGroupName
     *
     * @return IpoetryUserGroup
     */
    public function setIpoetryUserGroupName($ipoetryUserGroupName)
    {
        $this->ipoetryUserGroupName = $ipoetryUserGroupName;

        return $this;
    }

    /**
     * Get ipoetryUserGroupName
     *
     * @return string
     */
    public function getIpoetryUserGroupName()
    {
        return $this->ipoetryUserGroupName;
    }

    /**
     * Set ipoetryUserGroupBackgroundImageId
     *
     * @param integer $ipoetryUserGroupBackgroundImageId
     *
     * @return IpoetryUserGroup
     */
    public function setIpoetryUserGroupBackgroundImageId($ipoetryUserGroupBackgroundImageId)
    {
        $this->ipoetryUserGroupBackgroundImageId = $ipoetryUserGroupBackgroundImageId;

        return $this;
    }

    /**
     * Get ipoetryUserGroupBackgroundImageId
     *
     * @return integer
     */
    public function getIpoetryUserGroupBackgroundImageId()
    {
        return $this->ipoetryUserGroupBackgroundImageId;
    }

    /**
     * Set ipoetryUserGroupDescription
     *
     * @param string $ipoetryUserGroupDescription
     *
     * @return IpoetryUserGroup
     */
    public function setIpoetryUserGroupDescription($ipoetryUserGroupDescription)
    {
        $this->ipoetryUserGroupDescription = $ipoetryUserGroupDescription;

        return $this;
    }

    /**
     * Get ipoetryUserGroupDescription
     *
     * @return string
     */
    public function getIpoetryUserGroupDescription()
    {
        return $this->ipoetryUserGroupDescription;
    }

    /**
     * Set ipoetryUserGroupCityId
     *
     * @param integer $ipoetryUserGroupCityId
     *
     * @return IpoetryUserGroup
     */
    public function setIpoetryUserGroupCityId($ipoetryUserGroupCityId)
    {
        $this->ipoetryUserGroupCityId = $ipoetryUserGroupCityId;

        return $this;
    }

    /**
     * Get ipoetryUserGroupCityId
     *
     * @return integer
     */
    public function getIpoetryUserGroupCityId()
    {
        return $this->ipoetryUserGroupCityId;
    }

    /**
     * Set ipoetryUserCityIpoetryCity
     *
     * @param \IpoetryBundle\Entity\IpoetryUserCity $ipoetryUserCityIpoetryCity
     *
     * @return IpoetryUserGroup
     */
    public function setIpoetryUserCityIpoetryCity(\IpoetryBundle\Entity\IpoetryUserCity $ipoetryUserCityIpoetryCity = null)
    {
        $this->ipoetryUserCityIpoetryCity = $ipoetryUserCityIpoetryCity;

        return $this;
    }

    /**
     * Get ipoetryUserCityIpoetryCity
     *
     * @return \IpoetryBundle\Entity\IpoetryUserCity
     */
    public function getIpoetryUserCityIpoetryCity()
    {
        return $this->ipoetryUserCityIpoetryCity;
    }
}

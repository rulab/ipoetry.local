<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryUserIpoetryClassicAuthorsRelation
 *
 * @ORM\Table(name="ipoetry_user_ipoetry_classic_authors_relation", indexes={@ORM\Index(name="fk_ipoetry_classic_authors_has_ipoetry_user_ipoetry_classic_idx", columns={"ipoetry_classic_authors_classic_authors_id"}), @ORM\Index(name="fk_ipoetry_classic_authors_has_ipoetry_user_ipoetry_user1_idx", columns={"ipoetry_user_user_id"})})
 * @ORM\Entity
 */
class IpoetryUserIpoetryClassicAuthorsRelation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_ipoetry_classic_authors_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $ipoetryUserIpoetryClassicAuthorsId;

    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_user_parent_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $ipoetryUserUserParentId;

    /**
     * @var \IpoetryBundle\Entity\IpoetryUser
     *
     * @ORM\OneToOne(targetEntity="IpoetryBundle\Entity\IpoetryUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_user_user_id", referencedColumnName="user_id", unique=true)
     * })
     */
    private $ipoetryUserUser;

    /**
     * @var \IpoetryBundle\Entity\IpoetryClassicAuthors
     *
     * @ORM\OneToOne(targetEntity="IpoetryBundle\Entity\IpoetryClassicAuthors")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_classic_authors_classic_authors_id", referencedColumnName="classic_authors_id", unique=true)
     * })
     */
    private $ipoetryClassicAuthorsClassicAuthors;



    /**
     * Set ipoetryUserIpoetryClassicAuthorsId
     *
     * @param integer $ipoetryUserIpoetryClassicAuthorsId
     *
     * @return IpoetryUserIpoetryClassicAuthorsRelation
     */
    public function setIpoetryUserIpoetryClassicAuthorsId($ipoetryUserIpoetryClassicAuthorsId)
    {
        $this->ipoetryUserIpoetryClassicAuthorsId = $ipoetryUserIpoetryClassicAuthorsId;

        return $this;
    }

    /**
     * Get ipoetryUserIpoetryClassicAuthorsId
     *
     * @return integer
     */
    public function getIpoetryUserIpoetryClassicAuthorsId()
    {
        return $this->ipoetryUserIpoetryClassicAuthorsId;
    }

    /**
     * Set ipoetryUserUserParentId
     *
     * @param integer $ipoetryUserUserParentId
     *
     * @return IpoetryUserIpoetryClassicAuthorsRelation
     */
    public function setIpoetryUserUserParentId($ipoetryUserUserParentId)
    {
        $this->ipoetryUserUserParentId = $ipoetryUserUserParentId;

        return $this;
    }

    /**
     * Get ipoetryUserUserParentId
     *
     * @return integer
     */
    public function getIpoetryUserUserParentId()
    {
        return $this->ipoetryUserUserParentId;
    }

    /**
     * Set ipoetryUserUser
     *
     * @param \IpoetryBundle\Entity\IpoetryUser $ipoetryUserUser
     *
     * @return IpoetryUserIpoetryClassicAuthorsRelation
     */
    public function setIpoetryUserUser(\IpoetryBundle\Entity\IpoetryUser $ipoetryUserUser = null)
    {
        $this->ipoetryUserUser = $ipoetryUserUser;

        return $this;
    }

    /**
     * Get ipoetryUserUser
     *
     * @return \IpoetryBundle\Entity\IpoetryUser
     */
    public function getIpoetryUserUser()
    {
        return $this->ipoetryUserUser;
    }

    /**
     * Set ipoetryClassicAuthorsClassicAuthors
     *
     * @param \IpoetryBundle\Entity\IpoetryClassicAuthors $ipoetryClassicAuthorsClassicAuthors
     *
     * @return IpoetryUserIpoetryClassicAuthorsRelation
     */
    public function setIpoetryClassicAuthorsClassicAuthors(\IpoetryBundle\Entity\IpoetryClassicAuthors $ipoetryClassicAuthorsClassicAuthors = null)
    {
        $this->ipoetryClassicAuthorsClassicAuthors = $ipoetryClassicAuthorsClassicAuthors;

        return $this;
    }

    /**
     * Get ipoetryClassicAuthorsClassicAuthors
     *
     * @return \IpoetryBundle\Entity\IpoetryClassicAuthors
     */
    public function getIpoetryClassicAuthorsClassicAuthors()
    {
        return $this->ipoetryClassicAuthorsClassicAuthors;
    }
}

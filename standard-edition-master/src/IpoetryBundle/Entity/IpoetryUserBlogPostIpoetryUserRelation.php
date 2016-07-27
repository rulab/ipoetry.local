<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryUserBlogPostIpoetryUserRelation
 *
 * @ORM\Table(name="ipoetry_user_blog_post_ipoetry_user_relation")
 * @ORM\Entity
 */
class IpoetryUserBlogPostIpoetryUserRelation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_blog_post_ipoetry_user_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $ipoetryUserBlogPostIpoetryUserId;

    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_ipoetry_user_parent_id", type="integer", nullable=false)
     */
    private $ipoetryUserIpoetryUserParentId;

    /**
     * @var \IpoetryBundle\Entity\IpoetryUser
     *
     * @ORM\ManyToOne(targetEntity="IpoetryBundle\Entity\IpoetryUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_user_user_id", referencedColumnName="user_id")
     * })
     */
    private $ipoetryUserUser;

    /**
     * @var \IpoetryBundle\Entity\IpoetryUserBlogPost
     *
     * @ORM\ManyToOne(targetEntity="IpoetryBundle\Entity\IpoetryUserBlogPost")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ipoetry_user_blog_post_ipoetry_user_blog_post_id", referencedColumnName="ipoetry_user_blog_post_id")
     * })
     */
    private $ipoetryUserBlogPostIpoetryUserBlogPost;



    /**
     * Get ipoetryUserBlogPostIpoetryUserId
     *
     * @return integer
     */
    public function getIpoetryUserBlogPostIpoetryUserId()
    {
        return $this->ipoetryUserBlogPostIpoetryUserId;
    }

    /**
     * Set ipoetryUserIpoetryUserParentId
     *
     * @param integer $ipoetryUserIpoetryUserParentId
     *
     * @return IpoetryUserBlogPostIpoetryUserRelation
     */
    public function setIpoetryUserIpoetryUserParentId($ipoetryUserIpoetryUserParentId)
    {
        $this->ipoetryUserIpoetryUserParentId = $ipoetryUserIpoetryUserParentId;

        return $this;
    }

    /**
     * Get ipoetryUserIpoetryUserParentId
     *
     * @return integer
     */
    public function getIpoetryUserIpoetryUserParentId()
    {
        return $this->ipoetryUserIpoetryUserParentId;
    }

    /**
     * Set ipoetryUserUser
     *
     * @param \IpoetryBundle\Entity\IpoetryUser $ipoetryUserUser
     *
     * @return IpoetryUserBlogPostIpoetryUserRelation
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
     * Set ipoetryUserBlogPostIpoetryUserBlogPost
     *
     * @param \IpoetryBundle\Entity\IpoetryUserBlogPost $ipoetryUserBlogPostIpoetryUserBlogPost
     *
     * @return IpoetryUserBlogPostIpoetryUserRelation
     */
    public function setIpoetryUserBlogPostIpoetryUserBlogPost(\IpoetryBundle\Entity\IpoetryUserBlogPost $ipoetryUserBlogPostIpoetryUserBlogPost = null)
    {
        $this->ipoetryUserBlogPostIpoetryUserBlogPost = $ipoetryUserBlogPostIpoetryUserBlogPost;

        return $this;
    }

    /**
     * Get ipoetryUserBlogPostIpoetryUserBlogPost
     *
     * @return \IpoetryBundle\Entity\IpoetryUserBlogPost
     */
    public function getIpoetryUserBlogPostIpoetryUserBlogPost()
    {
        return $this->ipoetryUserBlogPostIpoetryUserBlogPost;
    }
}

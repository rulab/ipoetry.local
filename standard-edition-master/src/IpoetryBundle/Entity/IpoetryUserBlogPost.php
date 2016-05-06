<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryUserBlogPost
 *
 * @ORM\Table(name="ipoetry_user_blog_post")
 * @ORM\Entity
 */
class IpoetryUserBlogPost
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_user_blog_post_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ipoetryUserBlogPostId;

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_user_blog_post_text", type="text", length=255, nullable=true)
     */
    private $ipoetryUserBlogPostText;

    /**
     * @var string
     *
     * @ORM\Column(name="ipoetry_user_blog_post_theme", type="string", length=255, nullable=true)
     */
    private $ipoetryUserBlogPostTheme;



    /**
     * Get ipoetryUserBlogPostId
     *
     * @return integer
     */
    public function getIpoetryUserBlogPostId()
    {
        return $this->ipoetryUserBlogPostId;
    }

    /**
     * Set ipoetryUserBlogPostText
     *
     * @param string $ipoetryUserBlogPostText
     *
     * @return IpoetryUserBlogPost
     */
    public function setIpoetryUserBlogPostText($ipoetryUserBlogPostText)
    {
        $this->ipoetryUserBlogPostText = $ipoetryUserBlogPostText;

        return $this;
    }

    /**
     * Get ipoetryUserBlogPostText
     *
     * @return string
     */
    public function getIpoetryUserBlogPostText()
    {
        return $this->ipoetryUserBlogPostText;
    }

    /**
     * Set ipoetryUserBlogPostTheme
     *
     * @param string $ipoetryUserBlogPostTheme
     *
     * @return IpoetryUserBlogPost
     */
    public function setIpoetryUserBlogPostTheme($ipoetryUserBlogPostTheme)
    {
        $this->ipoetryUserBlogPostTheme = $ipoetryUserBlogPostTheme;

        return $this;
    }

    /**
     * Get ipoetryUserBlogPostTheme
     *
     * @return string
     */
    public function getIpoetryUserBlogPostTheme()
    {
        return $this->ipoetryUserBlogPostTheme;
    }
}

<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryTags
 *
 * @ORM\Table(name="ipoetry_tags")
 * @ORM\Entity
 */
class IpoetryTags
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ipoetry_tags_tags_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $ipoetryTagsTagsId;

    /**
     * @var string
     *
     * @ORM\Column(name="tags_text", type="string", length=255, nullable=false)
     */
    private $tagsText = 'undefined';

    /**
     * @var string
     *
     * @ORM\Column(name="moderated", type="integer", length=1, nullable=false)
     */
    private $moderated=0;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="IpoetryBundle\Entity\IpoetryPoetry", mappedBy="ipoetryTagsTags")
     */
    private $ipoetryPoetryPoetry;

    /**
     * Get ipoetryTagsTagsId
     *
     * @return integer
     */
    public function getIpoetryTagsTagsId()
    {
        return $this->ipoetryTagsTagsId;
    }

    /**
     * Set tagsText
     *
     * @param string $tagsText
     *
     * @return IpoetryTags
     */
    public function setTagsText($tagsText)
    {
        $this->tagsText = $tagsText;

        return $this;
    }

    /**
     * Get tagsText
     *
     * @return string
     */
    public function getTagsText()
    {
        return $this->tagsText;
    }

    /**
     * Set tagsText
     *
     * @param integer $moderated
     *
     * @return IpoetryTags
     */
    public function setModerated($moderated)
    {
        $this->moderated = $moderated;

        return $this;
    }

    /**
     * Get tagsText
     *
     * @return integer
     */
    public function getModerated()
    {
        return $this->moderated;
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
    
}

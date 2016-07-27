<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryTagsSelected
 *
 * @ORM\Table(name="ipoetry_tags_selected")
 * @ORM\Entity
 */
class IpoetryTagsSelected
{
    /**
     * @var integer
     *
     * @ORM\Column(name="tags_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $tagsId;

    /**
     * @var string
     *
     * @ORM\Column(name="tags_text", type="string", length=255, nullable=true)
     */
    private $tagsText = 'undefined';



    /**
     * Get tagsId
     *
     * @return integer
     */
    public function getTagsId()
    {
        return $this->tagsId;
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
}
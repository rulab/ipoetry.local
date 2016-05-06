<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpoetryClassicAuthors
 *
 * @ORM\Table(name="ipoetry_classic_authors")
 * @ORM\Entity
 */
class IpoetryClassicAuthors
{
    /**
     * @var integer
     *
     * @ORM\Column(name="classic_authors_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $classicAuthorsId;

    /**
     * @var string
     *
     * @ORM\Column(name="classic_authors_name", type="string", length=255, nullable=true)
     */
    private $classicAuthorsName = 'undefined';



    /**
     * Get classicAuthorsId
     *
     * @return integer
     */
    public function getClassicAuthorsId()
    {
        return $this->classicAuthorsId;
    }

    /**
     * Set classicAuthorsName
     *
     * @param string $classicAuthorsName
     *
     * @return IpoetryClassicAuthors
     */
    public function setClassicAuthorsName($classicAuthorsName)
    {
        $this->classicAuthorsName = $classicAuthorsName;

        return $this;
    }

    /**
     * Get classicAuthorsName
     *
     * @return string
     */
    public function getClassicAuthorsName()
    {
        return $this->classicAuthorsName;
    }
}

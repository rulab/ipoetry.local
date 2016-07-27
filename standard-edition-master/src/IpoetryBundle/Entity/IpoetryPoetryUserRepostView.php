<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * IpoetryPoetryUserRepostView
 *
 * @ORM\Table(name="ipoetry_poetryuserrepost")
 * @ORM\Entity
 */
class IpoetryPoetryUserRepostView {
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="poetryrepost_id", type="string", nullable=false)
     */
    private $poetryRepostId;
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="poetry_id", type="integer", nullable=false)
     */    
   private $poetryId;
    /**
     * @var integer
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */    
   private $userId;
    /**
     * @var integer
     * @ORM\Column(name="createdat", type="datetime", nullable=false)
     */
   private $createdAt;
    /**
     * @var integer
     * @ORM\Column(name="user_poetryowner_id", type="integer", nullable=true)
     */
   private $userPoetryownerId;

    /**
     * Get poetryRepostId
     *
     * @return integer
     */
    public function getPoetryRepostId()
    {
        return $this->poetryRepostId;
    }

    /**
     * Get poetryId
     *
     * @return integer
     */
    public function getPoetryId()
    {
        return $this->poetryId;
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
     * Get createdAt
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    /**
     * Get userPoetryownerId
     *
     * @return integer
     */
    public function getUserPoetryownerId()
    {
        return $this->userPoetryownerId;
    }   
    
}

<?php

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of poetryrepost
 *
 * @author d.krasavin
 * 
 * @ORM\Table(name="poetryrepost")
 * @ORM\Entity(repositoryClass="IpoetryBundle\Entity\Repository\PoetryRepostToOwnFeedRepository")
 */
class PoetryRepostToOwnFeed {
    /**
     * @var string
     *
     * @ORM\Column(name="poetryrepost_id", type="string", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */    
    private $poetryRepostId;
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;
    /**
     * @var integer
     *
     * @ORM\Column(name="poetry_id", type="integer", nullable=false)
     */
    private $poetryId;

    /**
     * @var datetime
     *
     * @ORM\Column(name="repostedat", type="datetime", nullable=false)
     */
    private $repostedAt;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="user_poetryowner_id, type="integer", nullable=false)
     */
    private $userPoetryOwnerId;
    
    /**
     * Set poetryRepostId
     *
     * @param string $poetryRepostId
     *
     * @return PoetryRepostToOwnFeed
     */
    public function setPoetryRepostId($poetryRepostId)
    {
        $this->poetryRepostId = $poetryRepostId;

        return $this;
    }

    /**
     * Get poetryRepostId
     *
     * @return PoetryRepostToOwnFeed
     */
    public function getPoetryRepostId()
    {
        return $this->poetryRepostId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return PoetryRepostToOwnFeed
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
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
     * Set repostedAt
     *
     * @param datetime $repostedAt
     *
     * @return PoetryRepostToOwnFeed
     */
    public function setRepostedAt($repostedAt)
    {
        $this->repostedAt = $repostedAt;

        return $this;
    }

    /**
     * Get repostedAt
     *
     * @return datetime
     */
    public function getRepostedAt()
    {
        return $this->repostedAt;
    }

    /**
     * Set poetryId
     *
     * @param integer $poetryId
     *
     * @return PoetryRepostToOwnFeed
     */
    public function setPoetryId($poetryId)
    {
        $this->poetryId = $poetryId;

        return $this;
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
     * Set userPoetryOwnerId
     *
     * @param integer $userPoetryOwnerId
     *
     * @return PoetryRepostToOwnFeed
     */
    public function setUserPoetryOwnerId($userPoetryOwnerId)
    {
        $this->userPoetryOwnerId = $userPoetryOwnerId;

        return $this;
    }

    /**
     * Get userPoetryOwnerId
     *
     * @return integer
     */
    public function getUserPoetryOwnerId()
    {
        return $this->userPoetryOwnerId;
    }
}

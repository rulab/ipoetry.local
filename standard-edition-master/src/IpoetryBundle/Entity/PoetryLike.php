<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of DailyUserRating
 *
 * @author d.krasavin
 * 
 * @ORM\Table(name="poetrylike")
 */
class PoetryLike {
    
    /**
     * @var integer
     *
     * @ORM\Column(name="like_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $likeId;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="poetry_id", type="integer", nullable=false)
     */
    private $poetryId;

    /**
     * Set LlkeId
     *
     * @param integer $likeId
     *
     * @return PoetryLike
     */
    public function setLikeId($LikeId)
    {
        $this->LikeId = $LikeId;

        return $this;
    }    
    /**
     * Get likeId
     *
     * @return integer
     */
    public function getLikeId()
    {
        return $this->likeId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return PoetryLike
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
     * Set poetryId
     *
     * @param integer $poetryId
     *
     * @return PoetryLike
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

}

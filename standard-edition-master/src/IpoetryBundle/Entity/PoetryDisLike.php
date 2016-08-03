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
 * @ORM\Table(name="poetrydislike")
 */
class PoetryDisLike {
    /**
     * @var integer
     *
     * @ORM\Column(name="dislike_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $dislikeId;

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
     * Set userId
     *
     * @param integer $userId
     *
     * @return PoetryLike
     */
    public function setDislikeId($dislikeId)
    {
        $this->dislikeId = $dislikeId;

        return $this;
    }
    
    /**
     * Get dislikeId
     *
     * @return integer
     */
    public function getDislikeId()
    {
        return $this->dislikeId;
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

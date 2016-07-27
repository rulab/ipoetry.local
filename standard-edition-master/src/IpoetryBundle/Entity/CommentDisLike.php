<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of CommentDisLike
 *
 * @author d.krasavin
 * 
 * @ORM\Table(name="commentdislike")
 */
class CommentDisLike {
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
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="comment_id", type="integer", nullable=false)
     */
    private $commentId;

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
     * Set commentId
     *
     * @param integer $commentId
     *
     * @return CommentLike
     */
    public function setCommentId($commentId)
    {
        $this->commentId = $commentId;

        return $this;
    }

    /**
     * Get commentId
     *
     * @return integer
     */
    public function getCommentId()
    {
        return $this->commentId;
    }

}

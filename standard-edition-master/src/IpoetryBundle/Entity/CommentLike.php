<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IpoetryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\EntityManagerInterface;
/**
 * Description of CommentLike
 *
 * @author d.krasavin
 * 
 * @ORM\Table(name="commentlike")
 * @ORM\Entity(repositoryClass="IpoetryBundle\Entity\Repository\CommentLikeRepository")
 */
class CommentLike {
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
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="comment_id", type="integer", nullable=false)
     */
    private $commentId;
    /**
     * Set LlkeId
     *
     * @param integer $likeId
     *
     * @return CommentLike
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

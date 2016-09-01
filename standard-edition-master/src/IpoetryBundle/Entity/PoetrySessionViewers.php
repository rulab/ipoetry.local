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
 * @ORM\Table(name="poetryviewer")
 * @ORM\Entity(repositoryClass="IpoetryBundle\Entity\Repository\PoetrySessionViewersRepository")
 */
class PoetrySessionViewers {
    
    /**
     * @var integer
     *
     * @ORM\Column(name="sessionid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $sessionId;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="poetryid", type="integer", nullable=false)
     */
    private $poetryId;

    /**
     * Set sessionId
     *
     * @param integer $sessionId
     *
     * @return PoetrySessionViewers
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }    
    /**
     * Get sessionId
     *
     * @return integer
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Set poetryId
     *
     * @param integer $poetryId
     *
     * @return PoetrySessionViewers
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

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace IpoetryBundle\Entity\Repository;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\VarDumper\Dumper\HTMLDumper;

use Doctrine\ORM\EntityRepository;

/**
 * Description of PoetryRepostToOwnFeedRepository
 *
 * @author d.krasavin
 */
class PoetryRepostToOwnFeedRepository extends EntityRepository {
    public function getPoetryReposts($userid,$poetryid)
        {
            $qb = $this->createQueryBuilder('pr')
                    ->where('pr.userId= :userid AND pr.poetryId= :poetryid')
                    ->setParameter('userid',$userid )
                    ->setParameter('poetryid',$poetryid);
            return $qb->getQuery()
                      ->getResult();
        }
}

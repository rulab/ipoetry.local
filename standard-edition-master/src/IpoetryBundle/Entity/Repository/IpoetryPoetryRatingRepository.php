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
 * Description of IpoetryPoetryRatingRepository
 *
 * @author d.krasavin
 */
class IpoetryPoetryRatingRepository extends EntityRepository {
    public function getPoetryLikes($poetryId)
        {
            $qb = $this->createQueryBuilder('prr')
                    ->select('SUM(prr.ipoetryPoetryRatingValueUp) poetrylike','SUM(prr.ipoetryPoetryRatingValueDown) poetrydislike')
                    ->where('prr.ipoetryPoetryPoetryId=:ipoetryPoetryPoetryId');
            $qb->setParameter('ipoetryPoetryPoetryId',$poetryId);
            \Symfony\Component\VarDumper\VarDumper::dump(array($qb->getQuery()));
            return $qb->getQuery()
                      ->getResult();
        }
}

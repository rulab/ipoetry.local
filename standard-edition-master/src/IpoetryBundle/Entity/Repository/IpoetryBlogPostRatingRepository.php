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
 * Description of IpoetryBlogPostRatingRepository
 *
 * @author d.krasavin
 */
class IpoetryBlogPostRatingRepository extends EntityRepository {
    public function getBlogPostLikes($commentId)
        {
            $qb = $this->createQueryBuilder('pbpr')
                    ->select('SUM(pbpr.ipoetryBlogPostRatingValueUp) commentlike','SUM(pbpr.ipoetryBlogPostRatingValueDown) commentdislike')
                    ->where('pbpr.ipoetryBlogPostPoetryId=:ipoetryBlogPostPoetryId');
            $qb->setParameter('ipoetryBlogPostPoetryId',$commentId);
            \Symfony\Component\VarDumper\VarDumper::dump(array($qb->getQuery()));
            return $qb->getQuery()
                      ->getResult();
        }
}

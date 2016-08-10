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
 * Description of DailypoetryRatingRepository
 *
 * @author d.krasavin
 */
class DailyPoetryRatingRepository extends EntityRepository {
    public function getLatestRating($limit = null,$period=null)
        {
        $where='1=1';
        if (strtoupper($period)=='DAY')
            $where='dpr.cDate>= ADDDATE(now(),INTERVAL -1 DAY)';
        if (strtoupper($period)=='WEEK')
            $where='dpr.cDate>= ADDDATE(now(),INTERVAL -7 DAY)';
        if (strtoupper($period)=='MONTH')
            $where='dpr.cDate>= ADDDATE(now(),INTERVAL -30 DAY)';
        if (strtoupper($period)=='YEAR')
            $where='dpr.cDate>= ADDDATE(now(),INTERVAL -365 DAY)';

            $qb = $this->createQueryBuilder('dpr')
                    ->select('dpr.poetryId','ROUND(SUM(dpr.poetryRating)/COUNT(dpr.cDate),1) poetryRating','ipr.poetryTitle','SUM(ippr.ipoetryPoetryRatingValueUp) poetrylike','SUM(ippr.ipoetryPoetryRatingValueDown) poetrydislike','iprbackgrimg.ipoetryBackgroundImage')//                       ->select('dpr.poetryId','ROUND(SUM(dpr.poetryRating)/COUNT(dpr.cDate),1) poetryRating','ipr.poetryTitle','SUM(ippr.ipoetryPoetryRatingValueUp) poetrylike')//
                    ->join('IpoetryBundle\Entity\IpoetryPoetry','ipr','WITH','ipr.poetryId=dpr.poetryId' )
                    ->leftjoin('IpoetryBundle\Entity\IpoetryPoetryRating','ippr','WITH','ipr.poetryId=ippr.ipoetryPoetryPoetryId')
                    ->leftjoin('IpoetryBundle\Entity\IpoetryBackgroundImages','iprbackgrimg','WITH','iprbackgrimg.ipoetryPoetryPoetry=ipr.poetryId')
                    ->where($where)
                    ->groupBy('dpr.poetryId')
                    //->having($where)
                    ->addOrderBy('dpr.poetryRating', 'DESC');

            if (false === is_null($limit)){
                    $qb->setFirstResult(0)->setMaxResults($limit); 
            }
            VarDumper::dump(array($qb->getQuery()));
            return $qb->getQuery()
                      ->getResult();
        }
    public function getCountRating($poetryid=null)
        {
        if (!is_null($poetryid)){
            $qb = $this->createQueryBuilder('dpr')
                       ->select('COUNT(dpr.poetryId)')
                    ->where('dpr.poetryId=:poetryid')
                       ->setParameter('poetryid',$poetryid);            
        } else {
            $qb = $this->createQueryBuilder('dpr')
                       ->select('COUNT(dpr.poetryId)');
        }

            return $qb->getQuery()
                      ->getResult();
        }
}

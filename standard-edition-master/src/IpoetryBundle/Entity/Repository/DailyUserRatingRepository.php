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
 * Description of DailyUserRatingRepository
 *
 * @author d.krasavin
 */
class DailyUserRatingRepository extends EntityRepository {
    public function getLatestRating($limit = null,$period=null)
        {
        $where='1=1';
        if (strtoupper($period)=='WEEK')
            $where='dur.cDate>= ADDDATE(now(),INTERVAL -7 DAY)';
        if (strtoupper($period)=='MONTH')
            $where='dur.cDate>= ADDDATE(now(),INTERVAL -30 DAY)';
        if (strtoupper($period)=='YEAR')
            $where='dur.cDate>= ADDDATE(now(),INTERVAL -365 DAY)';

            $qb = $this->createQueryBuilder('dur')
                       ->select('dur.userId','ROUND(SUM(dur.userRating)/COUNT(dur.cDate),1) userRating','usr.userName','usr.userLastname','usrcity.cityName','usrphoto.userPhotoUrl')
                       ->addSelect('(SELECT COUNT(iuf.ipoetryUserFollowedById) FROM IpoetryBundle\Entity\IpoetryUserFollowedBy iuf WHERE iuf.ipoetryUserFollowedById=dur.userId) followers')//,'usr.userCity','usr.userPhoto'
                    ->join('IpoetryBundle\Entity\IpoetryUser','usr','WITH','usr.userId=dur.userId' )
                    ->join('usr.userCity','usrcity' )
                    ->join('usr.userPhoto','usrphoto' )
                    ->where($where)
                    ->groupBy('dur.userId')
                    //->having($where)
                    ->addOrderBy('dur.userRating', 'DESC');

            if (false === is_null($limit)){
                    $qb->setFirstResult(0)->setMaxResults($limit); 
            }
            VarDumper::dump(array($qb->getQuery()));
            return $qb->getQuery()
                      ->getResult();
        }
    public function getCountRating($userid=null)
        {
        if (!is_null($userid)){
            $qb = $this->createQueryBuilder('dur')
                       ->select('COUNT(dur.userId)')
                    ->where('dur.userId=:userid')
                       ->setParameter('userid',$userid);            
        } else {
            $qb = $this->createQueryBuilder('dur')
                       ->select('COUNT(dur.userId)');            
        }

            return $qb->getQuery()
                      ->getResult();
        }
}

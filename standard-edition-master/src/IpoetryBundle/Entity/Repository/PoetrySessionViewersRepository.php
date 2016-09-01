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
 * Description of PoetrySessionViewersRepository
 *
 * @author d.krasavin
 */
class PoetrySessionViewersRepository extends EntityRepository {
    public function CountOneBy($poetryid)
        {
            $qb = $this->createQueryBuilder('psv')
                    ->select('COUNT(psv.poetryId) poetryViewers')
                    ->where('psv.poetryId=:poetryid');
            $qb ->setParameter(':poetryid',$poetryid);
            VarDumper::dump(array($qb->getQuery()));
            return $qb->getQuery()
                      ->getResult();
        }
}

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
class CommentLikeRepository extends EntityRepository {
    public function getLatestlikeId()
        {
        //заводим новый пост, через хранимую процедуру
        $stmt = $this->getDoctrine()
                     ->getConnection()
                     ->prepare('SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = \'ipoetry\' AND TABLE_NAME = \'commentlike\'');
        \Symfony\Component\VarDumper\VarDumper::dump(array($stmt));
        $retval=$stmt->execute(null, null);

            return $retval;
        }
}

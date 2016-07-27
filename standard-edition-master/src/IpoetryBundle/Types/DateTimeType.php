<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace IpoetryBundle\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
/**
 * Description of DatetimeType
 *
 * @author d.krasavin
 */

class DateTimeType extends Type{
    //put your code here
    const DATETIME = 'datetime';
public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        // return the SQL used to create your column type. To create a portable column type, use the $platform.
    return 'DATETIME';
    }
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $val=\DateTime::createFromFormat($platform->getDateTimeTzFormatString(), $value);
        //$val=$val->format($platform->getDateTimeTzFormatString());
        //var_dump($val);
        return $val;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        // This is executed when the value is written to the database. Make your conversions here, optionally using the $platform.
        return $value;
    }

    public function getName()
    {
        return self::DATETIME; // modify to match your constant name
    }
}

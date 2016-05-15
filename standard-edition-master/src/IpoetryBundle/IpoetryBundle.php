<?php

namespace IpoetryBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use IpoetryBundle\DependencyInjection\IpoetryExtension;

class IpoetryBundle extends Bundle
{
    public function getContainerExtension(){
        return new IpoetryExtension();
    }
}

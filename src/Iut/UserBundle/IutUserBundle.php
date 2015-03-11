<?php

namespace Iut\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class IutUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

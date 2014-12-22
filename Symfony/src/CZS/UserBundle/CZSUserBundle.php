<?php

namespace CZS\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CZSUserBundle extends Bundle
{

    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

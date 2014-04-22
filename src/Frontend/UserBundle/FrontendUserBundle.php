<?php

namespace Frontend\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FrontendUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

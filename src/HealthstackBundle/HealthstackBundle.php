<?php

namespace HealthstackBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class HealthstackBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

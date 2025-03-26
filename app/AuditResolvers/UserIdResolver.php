<?php

namespace App\AuditResolvers;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Resolver;

class UserIdResolver implements Resolver
{
    public static function resolve(Auditable $auditable)
    {
        //session_start();
        // TODO: Implement resolve() method.

        return session('userid');
    }
}

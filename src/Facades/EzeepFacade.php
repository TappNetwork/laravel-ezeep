<?php

namespace Tapp\Ezeep\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tapp\Ezeep\Skeleton\SkeletonClass
 */
class EzeepFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ezeep';
    }
}

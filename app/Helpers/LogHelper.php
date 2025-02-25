<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

trait LogHelper
{
    /**
     * Log exception details.
     *
     * @param \Exception $exception
     * @return void
     */
    public function logExceptionDetails(\Exception $exception)
    {
        Log::error(sprintf(
            'File %s Line %s Message %s',
            $exception->getFile(),
            $exception->getLine(),
            $exception->getMessage()
        ));
    }
}

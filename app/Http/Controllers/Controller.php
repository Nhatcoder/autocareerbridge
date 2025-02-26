<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use App\Helpers\LogHelper;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, LogHelper;

    /**
     * Log message catch.
     * @param \Exception $exception
     * @return void
     */
    public function logExceptionDetails(\Exception $exception)
    {
        Log::error(sprintf('File %s Line %s Message %s', $exception->getFile(), $exception->getLine(), $exception->getMessage()));
    }
}

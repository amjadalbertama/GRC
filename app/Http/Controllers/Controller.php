<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="GRC API",
 *      description="List of GRC API",
 *      @OA\Contact(
 *          email="galih@aturtoko.id"
 *      )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST
 * )
 * 
 * @OA\PathItem(
 *     path="/api"
 * )
 *
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

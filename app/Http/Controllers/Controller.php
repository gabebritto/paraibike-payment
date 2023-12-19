<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Laravel RESTful API Project with JWT",
 *     version="1.0",
 *     @OA\Contact(name="Gabriel Souto | @gabebritto")
 * ),
 *  @OA\Server(
 *     description="Learning env",
 *     url="http://rest.localhost/api/"
 * ),
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}

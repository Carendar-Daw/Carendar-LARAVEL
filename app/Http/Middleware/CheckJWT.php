<?php
// app/Http/Middleware/CheckJWT.php

namespace App\Http\Middleware;

use Auth0\Login\Contract\Auth0UserRepository;
use Auth0\SDK\Exception\CoreException;
use Auth0\SDK\Exception\InvalidTokenException;
use Closure;
use App\Http\Controllers\SaloonController;
class CheckJWT
{
    protected $userRepository;

    public $attributes;
    /**
     * CheckJWT constructor.
     *
     * @param Auth0UserRepository $userRepository
     */
    public function __construct(Auth0UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth0 = \App::make('auth0');

        $accessToken = $request->bearerToken();
        $Saloon = new SaloonController;
        try {
            $tokenInfo = $auth0->decodeJWT($accessToken);
            $user = $this->userRepository->getUserByDecodedJWT($tokenInfo);
            $existsSaloon = $Saloon->checkIfSaloonExistsAuth($user->sub, $request);
             if($existsSaloon){
             $request->attributes->add(['sal_id' => $existsSaloon->sal_id]);
             }


            if (!$user) {
                return response()->json(["message" => "Unauthorized user"], 401);
            }

        } catch (InvalidTokenException $e) {
            return response()->json(["message" => $e->getMessage()], 401);
        } catch (CoreException $e) {
            return response()->json(["message" => $e->getMessage()], 401);
        }

        return $next($request);
    }
}

<?php
namespace App\Http\Middleware;
use Closure;
use Exception;
use App\Models\User;
use App\Http\Helpers\Responser;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class JwtMiddleware
{

    private $responser;

    public function __construct(Responser $responser)
    {
        $this->responser = $responser;
    }

    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->header('token');
        
        if(!$token) {
            $this->responser->setErrors(['Token not provided.']);
            $this->responser->setStatus(Responser::UNAUTHORIZED);
            return $this->responser->respond();
        }
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {

            $this->responser->setErrors(['Token has expired.']);
            $this->responser->setStatus(Responser::ERROR);
            return $this->responser->respond();

        } catch(Exception $e) {

            $this->responser->setErrors([$e->getMessage()]);
            $this->responser->setStatus(Responser::ERROR);
            return $this->responser->respond();
        }
        
        $user = User::find($credentials->sub);
        $request->request->add(['auth' => $user]);
        
        return $next($request);
    }
}
<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;
use InvalidArgumentException;
use Symfony\Component\Finder\Exception\AccessDeniedException as ExceptionAccessDeniedException;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

use function Laravel\Prompts\error;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $e) {
           
            if($e instanceof InvalidArgumentException || $e instanceof NotFoundHttpException) {
                Log::info('From renderable method: '.$e->getMessage());
    
                // you can return a view, json object, e.t.c
                return response()->json([
                    'message' => 'Not Found!'
                ],Response::HTTP_NOT_FOUND );
            }
             if($e instanceof AuthenticationException) {
                Log::info('From renderable method: '.$e->getMessage());
    
                // you can return a view, json object, e.t.c
                return response()->json([
                    'message' => 'Unauthenticated !'
                ],Response::HTTP_UNAUTHORIZED );
            }
          
             if($e instanceof AuthorizationException ||  $e instanceof AccessDeniedException  ) {
                Log::info('From renderable method: '.$e->getMessage());
    
                // you can return a view, json object, e.t.c
                return response()->json([
                    'message' => 'UNAUTHORIZED !'
                ],Response::HTTP_UNAUTHORIZED );
            }
            
            
    
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage()
            ] ,  Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    }

  /* public function render($request, Throwable $exception)
    {
        if ($exception instanceof InvalidArgumentException) {
            return response()->json(['error' => 'Not Found item'], 404);
        }
       
        

    }*/
}

<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception)
    {
        // Responsableインターフェースを継承したクラスはここでレスポンスを返す
        if ($exception instanceof Responsable) {
            return $exception->toResponse($request);
        }

        $paths = explode("/", request()->path());
        if ($paths[0] == "api") {
            if ($exception instanceof ModelNotFoundException) {
                return (new NotFoundErrorResponseException())->toResponse($request);
            } elseif ($exception instanceof AuthenticationException) {
                return (new UnauthorizedErrorResponseException())->toResponse($request);
            }
            return $this->toResponse($request, $exception->getMessage());
        }

        return parent::render($request, $exception);
    }

    protected function toResponse($request, string $message)
    {
        return (new InternalServerErrorResponseException($message))->toResponse($request);
    }

    protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        if (in_array('admin', $exception->guards())) {
            return redirect()->guest('/manage-login');
        }
        return redirect()->guest(route('login'));
    }
}

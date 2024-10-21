<?php

namespace App\Exceptions;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use DB;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    protected function logNotFoundError(Throwable $e)
    {
        if (auth()->check()) {
            $mail = auth()->user()->email;
        } else {
            $mail = '';
        }
        // dd("404");
        DB::table('error_logs')->insert([
            'message' => '404 Not Found: ' . $e->getMessage(),
            'context' => '404 Not Found',
                'code' => 404,
                'line' => $e->getLine(),
                'created_at' => now(),
                // 'trace' => $e->getTraceAsString(),
                'email' => $mail,
                'url' => url()->current(),
                // Add any additional context information here
        ]);
        parent::report($e);
    }

    protected function logRegularError(Throwable $e)
    {
        if(auth()->user()){
            $mail = auth()->user()->email;
        }else{
            $mail = "";
        }
        DB::table('error_logs')->insert([
            'message' => $e->getMessage(),
            'context' => $e->getMessage(),
            'code' => $e->getCode(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            // 'trace' => $e->getTraceAsString(),
            'email' => $mail,
            'url' => url()->current(),
            'created_at' => now(),
        ]);
        parent::report($e);
    }
    public function report(Throwable $e)
    {
        if ($e instanceof NotFoundHttpException) {
            $this->logNotFoundError($e);
        } else {
            $this->logRegularError($e);
        }

    }
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            // if(auth()->user()){
            //     $mail = auth()->user()->email;
            // }else{
            //     $mail = "";
            // }
            // DB::table('error_logs')->insert([
            //     'message' => $e->getMessage(),
            //     'context' => $e->getMessage(),
            //     'email' => '$mail',
            // ]);
            // DB::insert('error_logs')->error($e->getMessage(), [
            //     'exception' => $e,
            // ]);
        });

    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            return redirect()->route('login');
        }
        return parent::render($request, $exception);
    }
}

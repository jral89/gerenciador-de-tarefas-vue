<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Os middlewares globais da aplicação.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class, // Validação do tamanho do POST
        \App\Http\Middleware\VerifyCsrfToken::class, // Verificação de CSRF
    ];

    /**
     * Os grupos de middleware para as rotas web e api.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\VerifyCsrfToken::class,  // Verificação CSRF
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * A lista de middlewares que podem ser aplicados a rotas específicas.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // Middlewares específicos para cada rota podem ser definidos aqui
    ];
}

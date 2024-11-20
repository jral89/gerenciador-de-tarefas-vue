<?php 
// app/Http/Middleware/VerifyCsrfToken.php
namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * As URIs que devem ser excluídas da verificação CSRF.
     *
     * @var array
     */
    protected $except = [
        '/tarefas/store',  // Aqui você desativa a verificação CSRF para essa rota
    ];
}

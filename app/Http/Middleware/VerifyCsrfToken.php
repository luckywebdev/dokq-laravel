<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/api/teacher/doB',
    	'/api/teacher/doC',
    	'mypage/article_history_ajax/{mode}',
	'/mypage/top/setpublic/{type}',
        '/api/mobile/*'];
}

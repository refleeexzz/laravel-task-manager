<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInput
{
    // fields that can have some html tags
    private array $allowHtmlFields = [];

    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();
        
        array_walk_recursive($input, function (&$value, $key) {
            if (is_string($value)) {
                if (in_array($key, $this->allowHtmlFields)) {
                    $value = strip_tags($value, '<p><br><strong><em><ul><ol><li><a>');
                } else {
                    $value = strip_tags($value);
                }
                
                $value = trim($value);
            }
        });

        $request->merge($input);

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Shop;

class CartEmpty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!(Shop::totalCartItem() > 0)){
            return redirect(route('shop'));
        }
        return $next($request);
    }
}

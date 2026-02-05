<?php

namespace App\Http\Middleware;

use App\Constants\Status;
use Closure;

class AuctionMiddleware
{
    public function handle($request, Closure $next)
    {
        $general = gs();
        if ($general->auction_permission == Status::DISABLE) {
            return to_route('user.home');
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\DataSensus;
use Closure;

class CheckKodeAkses
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        DataSensus::where('kode_akses', '=', $request->all());
        return $next($request);
    }
}

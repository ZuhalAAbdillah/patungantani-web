<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class MultiSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $activeAccounts = $request->session()->get('active_accounts', []);
        
        // Auto-heal: jika user login tapi belum masuk daftar aktif
        if (Auth::check() && !in_array(Auth::id(), $activeAccounts)) {
            $activeAccounts[] = Auth::id();
            $request->session()->put('active_accounts', $activeAccounts);
        }

        if ($request->has('authuser')) {
            $authuser = $request->query('authuser');
            
            if (in_array($authuser, $activeAccounts)) {
                // Otentikasi sementara untuk request ini
                Auth::onceUsingId($authuser);
                
                // Pastikan semua rute yang di-generate menambahkan parameter ini
                URL::defaults(['authuser' => $authuser]);
            }
        } elseif (Auth::check()) {
            // Jika user punya sesi utama, gunakan ID-nya sebagai default
            URL::defaults(['authuser' => Auth::id()]);
        }

        return $next($request);
    }
}

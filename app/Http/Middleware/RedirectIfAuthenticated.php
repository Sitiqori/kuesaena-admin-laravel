public function handle(Request $request, Closure $next, string ...$guards)
{
    $guards = empty($guards) ? [null] : $guards;

    foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
            // Redirect based on role
            if (auth()->user()->role === 'admin') {
                return redirect()->route('dashboard');
            }
            return redirect()->route('kasir.index');
        }
    }

    return $next($request);
}

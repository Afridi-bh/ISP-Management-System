// app/Http/Middleware/CustomerMiddleware.php
namespace App\Http\Middleware;

use Closure;

class CustomerMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'customer') {
            return redirect()->route('customer.login');
        }
        return $next($request);
    }
}

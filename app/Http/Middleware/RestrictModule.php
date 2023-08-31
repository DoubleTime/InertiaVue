<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RestrictModule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        /*
        * use in menu and inside other module, causing restrict error need to add ignore
        * Full Path : "admin.product_costs", "admin.customer_price_groups" 
        * Exact Path: "admin.reports.goods_received_note_history.trade_records"
        */
        $ignore_path = [
            "logout"
        ];

        if (Auth::guard($guard)->check()) {
            $route_name = $this->getFullRouteName($request->route()->getName());

            if (!in_array($route_name, $ignore_path) && !in_array($request->route()->getName(), $ignore_path)) {
                $menus = Auth::user()->menu_permission;
                if (isset($menus[$route_name]) && isset($menus[$route_name]['active']) && $menus[$route_name]['active'] == "0") {
                    return abort(403, 'Unauthorized access');
                }
            }
        }
        return $next($request);
    }

    private function getFullRouteName($value)
    {
        return substr($value, 0, strrpos($value, "."));
    }
}

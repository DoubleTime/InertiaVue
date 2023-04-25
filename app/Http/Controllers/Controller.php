<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function filterSessions(Request $request, $prefix, $fields)
    {
        //Create filters and sort and store in sessions
        $filters = [];
        $fields['sort'] = ['field' => '', 'direction' => ''];
        foreach ($fields as $k => $default_value) {
            if ($request->has($k)) {
                session([$prefix . '_' . $k => $request->{$k}]);
            }
            $filters[$k] = session($prefix . '_' . $k, $default_value);
        }
        return $filters;
    }
}

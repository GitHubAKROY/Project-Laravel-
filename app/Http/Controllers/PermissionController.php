<?php
namespace App\Http\Controllers;

use App\Models\AccessControl;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PermissionController extends Controller {

    public function show($tenant, $role_id = '') {
        $alert_col       = 'col-lg-8 offset-lg-2';
        $permission_list = [];

        if ($role_id != '') {
            $permission_list = AccessControl::where("role_id", $role_id)
                ->pluck('permission')
                ->toArray();
        }

        $ignoreRoute = [
            //'support_tickets.destroy',
        ];

        $app = app();

        $routeCollection = Route::getRoutes();

        $routes = [];

        // loop through the collection of routes
        foreach ($routeCollection as $route) {

            // get the action which is an array of items
            $action = $route->getAction();

            // if the action has the key 'controller'
            if (array_key_exists('controller', $action)) {

                if (! isset($action['middleware'])) {
                    continue;
                }

                if (! in_array("tenant.user", $action['middleware'])) {
                    continue;
                }

                // explode the string with @ creating an array with a count of 2
                $explodedAction = explode('@', $action['controller']);

                if (! isset($routes[$explodedAction[0]])) {
                    $routes[$explodedAction[0]] = [];
                }

                if (isset($explodedAction[1]) && strpos($explodedAction[0], 'App') === 0) {
                    $test = new $explodedAction[0]();
                    if (method_exists($test, $explodedAction[1])) {
                        $routes[$explodedAction[0]][] = ["method" => $explodedAction[1], "action" => $route->action];
                    }
                }
            }
        }

        $permission = [];

        foreach ($routes as $key => $route) {
            foreach ($route as $r) {
                if (strpos($r['method'], 'get') === 0) {
                    continue;
                }

                if (array_key_exists('as', $r['action'])) {
                    $routeName = $r['action']['as'];
                    //If not needed so ignore
                    if (in_array($routeName, $ignoreRoute)) {
                        continue;
                    }
                    $permission[$key][$routeName] = $r['method'];
                }

            }
        }

        foreach ($permission as $key => $val) {
            foreach ($val as $name => $url) {
                if ($url == "store" && in_array("create", $val)) {
                    unset($permission[$key][$name]);
                }
                if ($url == "update" && in_array("edit", $val)) {
                    unset($permission[$key][$name]);
                }
            }
        }

        return view('backend.admin.permission.create', compact('permission', 'permission_list', 'role_id', 'alert_col'));

    }

    public function store(Request $request) {
        $this->validate($request, [
            'role_id'     => 'required',
            'permissions' => 'required',
        ]);

        DB::beginTransaction();

        $permission = AccessControl::where('role_id', $request->role_id);
        $permission->delete();

        foreach ($request->permissions as $role) {
            $permission             = new AccessControl();
            $permission->role_id    = $request->role_id;
            $permission->permission = $role;
            $permission->save();
        }

        DB::commit();

        return back()->with('success', _lang('Saved successfully'));

    }

}

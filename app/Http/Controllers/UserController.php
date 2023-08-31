<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Build Filter
        $filters = $this->filterSessions($request, 'user', [
            'keyword' => ''
        ]);

        $list = User::query()->when(!empty($filters['keyword']), function ($q) use ($filters) {
            $q->orWhere('name', 'like', '%' . $filters['keyword'] . '%');
            $q->orWhere('email', 'like', '%' . $filters['keyword'] . '%');
        })->filterSort($filters)->paginate(2);

        return Inertia::render('User/Index', [
            'header' => User::header(),
            'filters' => $filters,
            'list' => $list,
            'useUsername' => env(LOGIN_USERNAME, false)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->edit(null);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserUpdateRequest $request)
    {
        return $this->update($request, null);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(string $id = null)
    {
        if (null == $id) {
            $data = new User;
        } else {
            $data = User::find($id);
        }
        $menu_list = config('menus.items');

        return Inertia::render('User/Edit', [
            'data' => $data,
            'useUsername' => env(LOGIN_USERNAME, false),
            'menu_list' => $menu_list,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id = null)
    {
        $data = $request->validated();
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if (null == $id) {
            $data = User::create($data);
            return Redirect::route('users.edit', $data->id)->with('message', 'User created successfully');
        } else {
            User::find($id)->update($data);
            return Redirect::route('users.edit', $id)->with('message', 'User updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return Redirect::route('users.index')->with('message', 'User deleted successfully');
    }

    /**
     * Save Menu
     */
    public function patchMenu(Request $request, $id)
    {
        $data = User::find($id);
        $data->menu_permission = $request->menus;
        $data->save();
        return Redirect::route('users.edit', $data->id)->with('message', 'Menu Permission Updated');
    }
}

<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\AuthModal as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable //implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'menu_permission' => 'array',
    ];

    //Default attributes
    protected $attributes = [
        'active' => true,
    ];

    protected $appends = [
        'menu_flags'
    ];

    public function active(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value ? true : false
        );
    }

    protected function username(): Attribute
    {
        if (env(LOGIN_USERNAME, false)) {
            return Attribute::make(
                set: fn (string $value) => $value != null ? strtolower($value) : null,
            );
        }
        return Attribute::make();
    }

    //Use for User/MenuForm
    protected function menuFlags(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $this->set_menu_flag()
        );
    }

    //Layout User Accessable Menu
    protected function activeMenus(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $this->set_menu_flag()
        );
    }

    //Static Functions Below Here

    /*
    * Build Table Header
    */
    public static function header()
    {
        $headers = [];
        if (env(LOGIN_USERNAME, false)) {
            $headers[] = ['field' => 'username', 'title' => 'Username', 'sortable' => true];
        }
        return array_merge($headers, [
            ['field' => 'name', 'title' => 'Name', 'sortable' => true],
            ['field' => 'email', 'title' => 'Email', 'sortable' => true],
            ['field' => 'created_at', 'title' => 'Created At'],
        ]);
    }

    public function set_menu_flag($output = [], $data = [])
    {
        $user_menu = $this->menu_permission;
        $data = empty($data) ? config('menus.items') : $data;
        foreach ($data as $item) {
            $name = "";
            if (isset($item['route'])) {
                $name = substr($item['route'], 0, strrpos($item['route'], ".")); //Remove .index
            } else if (isset($item['title'])) {
                $name = $item['title'];
            }
            if ($name !== "") {
                $active = isset($user_menu[$name]) && $user_menu[$name]['active'] ? true : false;
                $output[$name] = ['active' => $active];
            }

            if (isset($item['submenus'])) {
                $output = $this->set_menu_flag($output, $item['submenus']);
            }
        }
        return $output;
    }

    public function build_menu($data = [])
    {
        $user_menu = $this->menu_permission;
        $data = empty($data) ? config('menus.items') : $data;
        if ($user_menu != null) {
            foreach ($data as $index => $item) {
                if (isset($item['route'])) {
                    //Got route
                    $name = substr($item['route'], 0, strrpos($item['route'], ".")); //Remove .index
                    if ($name != "" && isset($user_menu[$name]) && $user_menu[$name]['active'] == false) {
                        unset($data[$index]);
                    }
                } else {
                    //Title only
                    if (isset($user_menu[$item['title']]) && $user_menu[$item['title']]['active'] == false) {
                        unset($data[$index]);
                    }

                    if (isset($data[$index]['submenus'])) {
                        //Recursive
                        $data[$index]['submenus'] = array_values($this->build_menu($data[$index]['submenus']));
                    }
                }
            }
        }
        return $data;
    }
}

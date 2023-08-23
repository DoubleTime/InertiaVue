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
    ];

    //Default attributes
    protected $attributes = [
        'active' => true,
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
}

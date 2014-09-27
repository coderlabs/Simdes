<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/15/2014
 * Time: 15:49
 */

namespace Simdes\Models\User;

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\UserInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 *
 * @package Simdes\Models\User
 */
class User extends Model implements UserInterface, RemindableInterface
{

    /**
     * @var string
     */
    protected $tabel = 'users';

    /**
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'activation_code'];

    /**
     * @var array
     */
    protected $with = ['organisasi'];

    /**
     * @var array
     */
    protected $attributes = [
        'is_admin' => true
    ];

    /**
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return mixed
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * @param string $value
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organisasi()
    {
        return $this->belongsTo('Organisasi', 'organisasi_id');
    }

    /**
     * @param $query
     * @param $organisasi_id
     * @return mixed
     */
    public function scopeOrganisasi($query, $organisasi_id)
    {
        return $query->whereOrganisasi_id($organisasi_id);
    }

    /**
     * @param $query
     * @param $user_id
     * @return mixed
     */
    public function scopeUser($query, $user_id)
    {
        return $query->whereUser_id($user_id);
    }

    /**
     * @param $query
     * @param $slug
     * @return mixed
     */
    public function scopeSlug($query, $slug)
    {
        return $query->whereSlug($slug);
    }

    /**
     * @param $query
     * @param $q
     * @return mixed
     */
    public function scopeFullTextSearch($query, $q)
    {
        return empty($q) ? $query : $query->whereRaw("MATCH(name,email,desa)AGAINST(? IN BOOLEAN MODE)", [$q]);
    }
}
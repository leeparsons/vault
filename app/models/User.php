<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

    /*
     * define the relations of the user model to the roles
     */
    public function userRoles()
    {
        return $this->hasMany('userroles');
    }

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
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


//    public static function isPrivaledged()
//    {
//        if (!Auth::check()) {
//            return false;
//        }
//
//        $user = Auth::user();
//
//        $roles = $user->userRoles;
//
//        foreach ($roles as $role) {
//            if ($role->role_id == 2) {
//                return true;
//            }
//        }
//
//        return false;
//    }

    /*
     * returns the period between now and the last login time for the current user loaded in the model
     */
    public function getPeriodSinceLogin()
    {
        return $this->calculatePeriodDifference($this->last_login);
    }

    /*
     * returns the period between now and the last active time for the current user loaded in the model
     */
    public function getPeriodSinceActive()
    {
        return $this->calculatePeriodDifference($this->last_active);
    }

    /*
     * @param string $date_time mysql format yyyy-mm-dd hh:ii:ss
     *
     * returns string detailing the time difference between now and the given date time string
     */
    private function calculatePeriodDifference($date_time)
    {
        $diff = date_diff(new DateTime($date_time), new DateTime);

        if ($diff->y == 0 && $diff->m == 0) {

            if ($diff->d > 0) {
                return $diff->d . ' day' . ($diff->d == 1 ? '' : 's') . ' ago';
            } elseif ($diff->h > 0) {
                return $diff->h . ' hour' . ($diff->h == 1 ? '' : 's') . ' ago';
            } elseif ($diff->i > 0) {
                return $diff->i . ' minute' . ($diff->i == 1 ? '' : 's') . ' ago';
            } else {
                return 'Just now';
            }
        } else {
            if ($diff->y > 0) {
                if ($diff->y >= 2 && $diff->m >= 2) {
                    return 'a very long time ago, in a galaxy far far away';
                } elseif ($diff->m > 2) {
                    return 'over ' . $diff->y . ' year' . ($diff->y == 1 ? '':'s') . ' ago';
                } else {
                    return $diff->y . ' year' . ($diff->y == 1 ? '':'s') . ' ago';
                }

            } else {

                return $diff->m . ' month' . ($diff->m == 1 ? '':'s') . ' ago';
            }

        }
    }

    public function isAdmin()
    {
        foreach ($this->userRoles as $role) {
            if ($role->role->level >= 3) {
                return true;
            }
        }

        return false;
    }

    public function canEdit()
    {

        foreach ($this->userRoles as $role) {
            if ($role->role->level >= 2) {
                return true;
            }
        }

        return false;
    }

    public function canDelete()
    {
        foreach ($this->userRoles as $role) {
            if ($role->role->level > 2) {
                return true;
            }
        }

        return false;
    }

}

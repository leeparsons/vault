<?php
/**
 * User: leeparsons
 * Date: 27/05/2014
 * Time: 16:08
 */
 
class Userroles extends Eloquent {

    protected $table = 'user_2_roles';

    public function roles()
    {
        $this->belongsTo('Role');
    }

}
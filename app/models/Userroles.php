<?php
/**
 * User: leeparsons
 * Date: 27/05/2014
 * Time: 16:08
 */
 
class Userroles extends Eloquent {

    CONST VIEWER = 1;
    CONST EDITOR = 2;
    CONST ADMIN = 3;

    protected $table = 'user_2_roles';

    public function role()
    {
        $b = $this->belongsTo('Role', 'role_id');

        return $b;
    }

}
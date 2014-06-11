<?php
/**
 * User: leeparsons
 * Date: 27/05/2014
 * Time: 09:17
 */

class UserController extends BaseController {

    public function actionIndex()
    {
        return View::make('users/login');
    }

    public function authenticate()
    {
        if ($this->isPostRequest()) {

            $validator = $this->getLoginValidator();

            if ($validator->passes()) {

                $credentials = $this->getLoginCredentials();

                if (Auth::attempt($credentials)) {
                    return Redirect::intended('dashboard');
                }

                return Redirect::back()->withErrors(array(
                    "password" => array("Credentials invalid.")
                ));

            } else {
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator);

            }
        }

        return View::make('users/login');

    }

    public function actionLogout()
    {
        Auth::logout();
        return Redirect::action('UserController@actionIndex');
    }

    protected function isPostRequest()
    {
        return Input::server("REQUEST_METHOD") == "POST";
    }

    protected function getLoginValidator()
    {
        return Validator::make(Input::all(), array(
            "username" => "required",
            "password" => "required"
        ));
    }

    protected function getLoginCredentials()
    {
        return array(
            "username" => Input::get("username"),
            "password" => Input::get("password")
        );
    }
}

 
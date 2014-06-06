<?php
/**
 * User: leeparsons
 * Date: 27/05/2014
 * Time: 11:35
 */

class RecordController extends BaseController {

    public function __construct()
    {

        $this->beforeFilter(function() {
            if (!Auth::check()) {
                return Redirect::action('UserController@actionIndex');
            }
        });

    }

    public function actionSearch()
    {
        $s = Input::get('s');

        if (trim($s) == '') {
            $records = array();
        } else {
            $records = Record::where(
                'record_name',
                'LIKE',
                '%' . $s . '%'
            )->
                where(
                    'fields',
                    'LIKE',
                    '%' . $s . '%',
                    'OR'
                )
                ->get();
        }

        return View::make('record/list', array('records' =>  $records, 'search' =>  $s));
    }

    public function actionList()
    {

        $records = Record::get();

        return View::make('record/list', array('records' =>  $records));

    }



    public function actionViewRecord($id)
    {
        if (intval($id) < 1) {
            return View::make('record/404');
        } else {
            if ($record = Record::find($id)) {
                return View::make('record/item', array('record'   =>  $record));
            } else {
                return View::make('record/404');
            }


        }


    }

    public function actionEditRecord($id = null)
    {

        if (intval($id) > 0) {
            if ($record = Record::find($id)) {
                if ($record->canEdit()) {
                    return View::make('record/edit', array('record'   =>  $record));
                }
            }
        } elseif (is_null($id)) {
            if (App::make('record')->canEdit()) {
                return View::make('record/add');
            }
        }

        return View::make('record/404');
    }


    public function actionSaveRecord($id = null)
    {
        $validator = App::make('Record')->validateInput();

        if (!$validator->passes()) {
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        }


        if (intval($id) > 0) {

            //updating
            $record = Record::find($id);
        } else {
            //new record
            $record = new Record();

        }

        $record->readFromPost();

        $record->save();

        return Redirect::action('RecordController@actionSearch', array('s' => $record->record_name));

    }
}


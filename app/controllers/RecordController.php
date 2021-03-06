<?php
/**
 * User: leeparsons
 * Date: 27/05/2014
 * Time: 11:35
 */

class RecordController extends BaseController {

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

        $records = Record::orderBy('record_name')->get();

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
                return View::make('record/edit', array('record'   =>  $record));
            }
        } elseif (is_null($id)) {
            return View::make('record/add');
        }

        return View::make('record/404');
    }


    public function actionDeleteRecord($id = null)
    {
        $record = App::make('record')->find($id);

        if ($record) {
            $record->delete();
            return Redirect::to('/dashboard')->with(array('info' => 'Record Deleted'));
        } else {

            return Redirect::to('/dashboard')->withErrors(array('msg' => 'Oops! Looks like this record has already been deleted!'));

        }

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


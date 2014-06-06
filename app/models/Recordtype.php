<?php

class RecordType extends Eloquent {

    public function recordTypes()
    {
        $this->belongsTo('Record');
    }

    public function availableOptions()
    {

        $options = DB::table('record_types')->get();

        if (is_array($options) && !empty($options)) {
            reset($options);


            $available_options = array();

            foreach ($options as $option) {
                $available_options[$option->record_type] = $option->record_type;
            }


            return $available_options;
        }


        return false;
    }

}
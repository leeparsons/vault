<?php

class HelperRecordType {



    public function renderFields($record)
    {
        $html = array();

        $fields = $record->getFieldInputs();

        $field_values = $record->getFields();

        foreach ($fields as $name =>  $field) {

            $value = '';

            if (property_exists($field_values, $name)) {

                if (property_exists($field_values, 'encrypt') && $field_values->encrypt === true) {
                    $value = $field_values->$name;
                    $value = $record->encryptValue($value->value);

                } else {
                    $value = $field_values->$name;
                    $value = $value->value;
                }
            }

            $id = property_exists($field, 'id')?$field->id:$name;

            $html[] = '<label for="' . $id . '">' . $field->label . '</label>';

            $html[] = $this->generateHtml($field, $name, $value, $id);
        }


        echo implode('', $html);

    }

    /*
     * Accessible from the ajax call to get a json ecnoded list of available options
     */
    public function availableOptionsJson()
    {

        $types = App::make('RecordType')->availableOptions();

        $json = array(
                ''  =>  'Select Option'

        );

        foreach ($types as $type) {
            $json[$type] =
            $type
            ;
        }



        return json_encode($json);

    }

    /*
     * Accessed by the ajax request to get a list of fields for this field type
     *
     */
    public function availableFieldsJson($type = '')
    {

        $rows = App::make('RecordType')->where(
            'record_type',
            '=',
            $type
        )->get();

        $fields = array();

        if (count($rows) > 0) {

            foreach ($rows as $row) {

                $row_config = json_decode($row->config);

                foreach ($row_config as $key => $config) {
                    $fields[] = array(
                        'name'  =>  "field[$key]",
                        'label' =>  $config->label,
                        'id'    =>  $key,
                        'type'  =>  $config->type
                    );
                }

            }
        }


        return json_encode($fields);
    }

    private function generateHtml($field, $name, $value, $id)
    {

        $html = '';

        switch ($field->type) {
            default:

                echo $field->type;

                $html = $this->{'render' . ucfirst($field->type)}($name, $value, $id);
                break;
        }

        return $html;
    }

    private function renderText($name, $value, $id)
    {
        return '<input type="text" name="field[' . $name . ']" id="' . $id . '" value="' . $value . '">';
    }

    private function renderTextarea($name, $value, $id)
    {
        return '<textarea name="field[' . $name . ']" id="' . $id . '">' . $value . '</textarea>';
    }

    private function renderPassword($name, $value, $id)
    {
        return '<input type="password" name="field[' . $name . ']" id="' . $id . '" value="' . $value . '" >';
    }
}

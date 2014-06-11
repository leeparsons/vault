<?php

class Record extends Eloquent {

    protected $appends = array('record_type_slug');

    private $decoded_fields = array();

    private $salt = 'A5uZNPYu6s3JSpL9lcy3GrE8yhMLKr28';

    public function validateInput()
    {
        return Validator::make(Input::all(), array(
            "record_name"   =>  "required",
            "record_type"   =>  "required",
            "field"        =>  "required"
        ));
    }

    public function canEdit()
    {

        if (!Auth::check()) {
            return false;
        }

        $user = Auth::user();

        $roles = $user->userRoles;

        foreach ($roles as $role) {
            if ($role->role_id == 2) {
                return true;
            }
        }

        return false;


    }

    public function getRecordTypeSlugAttribute()
    {
        return Illuminate\Support\Str::lower(Illuminate\Support\Str::slug($this->record_type));
    }

    public function getFields()
    {

        if (empty($this->decoded_fields)) {
            $this->decoded_fields = json_decode($this->fields);

            foreach ($this->decoded_fields as $key => $field) {

                if (property_exists($field, 'encrypted') && $field->encrypted == true) {

                    $this->decoded_fields->$key->value = $this->decryptValue($field->value);

                }

            }
        }

        return $this->decoded_fields;
    }



    /*
     * decodes the json encoded string for the json response and slugs any fields
     */
    public function prepareForAngularData()
    {
        $this->fields = json_decode($this->fields);

        $fields = array();

        if ($this->fields) {
            foreach ($this->fields as $field) {

                if ($field->encrypted === true) {
                    $field->value = $this->decryptValue($field->value);
                }

                $fields[] = $field;
            }
        }

        $this->fields = $fields;
    }

    public function getFieldInputs()
    {

        $inputs = array();

        if (intval($this->id) < 1) {

            //new record
            $type = RecordType::where(
                'record_type', '=', Input::get('record_type')?:'weblogin'
            )->first();

            if (!is_null($type)) {
                $inputs = json_decode($type->config);
            }

        } else {
            //get the type as a related object
            $type = $this->recordType;

            if (!is_null($type) && $type->count() > 0) {
                $inputs = json_decode($type[0]->config);
            }
        }

        return $inputs;

    }

    /*
     * define the relations
     */
    public function recordType()
    {
        return $this->hasMany('recordtype', 'record_type', 'record_type');
    }

    /*
     * Encrypts a value - in one common place
     */
    public function encryptValue($value)
    {
        $cryptographer = new \Illuminate\Encryption\Encrypter($this->salt);

        return $cryptographer->encrypt($value);
    }

    /*
     * Decrypts a value - in one common place
     */
    public function decryptValue($value)
    {
        $cryptographer = new \Illuminate\Encryption\Encrypter($this->salt);

        return $cryptographer->decrypt($value);
    }

    public function readFromPost()
    {

        $inputs = $this->getFieldInputs();

        $fields = array();

        $post_fields = Input::get('field');


        foreach ($inputs as $input_id => $input) {

            if ($input->encrypt === true) {
                $value = $this->encryptValue(isset($post_fields[$input_id])?$post_fields[$input_id]:'');
                $encrypted = true;
            } else {
                $value = isset($post_fields[$input_id])?$post_fields[$input_id]:'';
                $encrypted = false;
            }

            $fields[$input_id] = array(
                'value'     =>  $value,
                'type'      =>  $input->type,
                'label'     =>  $input->label,
                'encrypted' =>  $encrypted
            );

        }

        $this->record_type = Input::get('record_type');
        $this->record_name = Input::get('record_name');
        $this->fields = json_encode($fields);
    }

}
<?php
class User {
    private $_db,
            $_data;

    public function __construct($user = null) {
        $this->_db = DB::getInstance();
    }

    public function create($fields = array()) {
        // var_dump($fields);
        if (!$this->_db->insert('users', $fields)) {
            throw new Exception('There was a problem creating an account.');
        }
    }

    public function find($user = null) {
        if($user) {
            $field = (is_numeric($user)) ? 'id' : 'u_name';
            $data = $this->_db->get('users', array($field, '=', $user));

            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function login($u_name = null, $pword = null) {
        $user = $this->find($u_name);
        if ($user) {
            if ($this->data()->pword === Hash::make($pword, $this->data()->salt)) {
                echo 'OK!';
            }

        }

        return false;
    }

    private function data() {
        return $this->_data;
    }
}
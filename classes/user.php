<?php
class User {
    private $_db,
            $_datai,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn;

    public function __construct($user = null) {
        $this->_db = DB::getInstance();

        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if (!$user) {
            if (Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);

                if ($this->find($user)) {
                    $this->_isLoggedIn = true;
                } else {
                    //process Logout
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function create($fields = array()) {
        // var_dump($fields);
        if (!$this->_db->insert('users', $fields)) {
            throw new Exception('There was a problem creating an account.');
        }
    }

    public function find($user = null) {
        if($user) {
            $field = (is_numeric($user)) ? 'u_id' : 'u_name';
            $data = $this->_db->get('users', array($field, '=', $user));

            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function login($u_name = null, $pword = null, $remember = false) {
        

        if (!$u_name && !$pword && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->u_id);
        } else {
            $user = $this->find($u_name);
            if ($user) {
                if ($this->data()->pword === Hash::make($pword, $this->data()->salt)) {
                    Session::put($this->_sessionName, $this->data()->u_id);

                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('user_session', array('u_id', '=', $this->data()->u_id));

                        if (!$hashCheck->count()) {
                            $this->_db->insert('user_session', array(
                                'u_id' => $this->data()->u_id,
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }
                    return true;
                }
            }
            return false;
        }
    }

    public static function exists() {
        return (!empty($this->_data)) ? true : false;
    }

    public function logout() {

        $this->_db->delete('user_session', array('u_id', '=', $this->data()->u_id));

        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }

    public function data() {
        return $this->_data;
    }

    public function isLoggedIn() {
        return $this->_isLoggedIn;
    }
}
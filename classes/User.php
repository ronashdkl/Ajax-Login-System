<?php

/*
 *  Author: Ronash Dhakal
 *  Project: Guest Registration System
 *  @page: user.php
 *  @Description: Overal user operation class
 */

class User {

    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn;

    public function __construct($user = NULL) {
        $this->_db = DB::getIntance();
        $this->_sessionName = Config::get("session/session_name");
        $this->_cookieName = Config::get("remember/cookie_name");

        if (!$user) {
            if (Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);
                if ($this->find($user)) {
                    $this->_isLoggedIn = true;
                } else {
                    //process logout
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function create($fields = array()) {
        if (!$this->_db->insert('user', $fields)) {
            throw new Exception("There was a problem creating an account");
        }
    }

    public function update($id, $fields = array()) {
        if (!$this->_db->update('user', $id, $fields)) {
            throw new Exception("There was a problem updating an account");
        }
    }

    public function login($credential = NULL, $password = NULL, $remember) {
        $user = $this->find($credential);
        if ($user) {
            if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
                Session::put($this->_sessionName, $this->data()->id);
                if ($remember==TRUE) {
                    $hash = Hash::unique();
                    $hashCheck = $this->_db->get('user_session', array('user_id', '=', $this->_data->id));
                if (!$hashCheck->count())
                    {
                    $this->_db->insert('user_session', array(
                        'user_id' => $this->data()->id,
                        'hash' => $hash
                    ));
                } else {
                    $hash = $hashCheck->first()->hash;
                }
                Cookie::put($this->_cookieName, $hash, Config::get("remember/cookie_expiry"));
                
            }
            return true;
                }
        }
        return false;
    }

    public function fast_login() {
        if (!empty($this->_data)) {
            Session::put($this->_sessionName, $this->data()->id);
        }
    }

    public function find($user = NULL) {
        if ($user) {

            if (is_numeric($user)) {
                $field = 'id';
            } else if (filter_var($user, FILTER_VALIDATE_EMAIL)) {
                $field = 'email';
            } else {
                $field = 'username';
            }
            $data = $this->_db->get('user', array($field, '=', $user));

            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function logout() {
        $this->_db->delete('user_session', array('user_id', '=', $this->data()->id));
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

?>
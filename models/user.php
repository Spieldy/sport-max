<?php

require_once 'base.php';

class User extends Model_Base
{
	private $_id;

	private $_login;

	private $_password;

	private $_state;

	public function __construct($id, $login, $password, $state) {
		$this->set_id($id);
		$this->set_login($login);
		$this->set_password($password);
		$this->set_state($state);
	}


	// Getter
	public function id() {
		return $this->_id;
	}

	public function login() {
		return $this->_login;
	}

	public function password() {
		return $this->_password;
	}

	public function state() {
		return $this->_state;
	}


	// Setter
	public function set_id($v) {
		$this->_id = (int) $v;
	}

	public function set_login($v) {
		$this->_login = strval($v);
	}

	public function set_password($v) {
		$this->_password = strval($v);
	}

	public function set_state($v) {
		$this->_state = strval($v);
	}



	public static function insert($login,$password,$state)
	{
		$q = self::$_db->prepare('INSERT INTO user (login, password, state) VALUES (:login,:password, :state)');
		$q->bindValue(':login', $login, PDO::PARAM_STR);
		$q->bindValue(':password', $password, PDO::PARAM_STR);
		$q->bindValue(':state', $state, PDO::PARAM_STR);
		$q->execute();
	}


	public function save()
	{
		if(!is_null($this->_id)) {
			$q = self::$_db->prepare('UPDATE user SET login=:login, password=:password, state=:state WHERE id = :id');
			// bind value des champs
			$q->bindValue(':id', $this->_id, PDO::PARAM_INT);
			$q->bindValue(':login', $this->_login, PDO::PARAM_STR);
			$q->bindValue(':password', $this->_password, PDO::PARAM_STR);
			$q->bindValue(':state', $this->_state, PDO::PARAM_STR);
			$q->execute();
		}
	}


	public function delete()
	{
		if(!is_null($this->_id)) {
			$q = self::$_db->prepare('DELETE FROM user WHERE id = :id');
			$q->bindValue(':id', $this->_id);
			$q->execute();
			$this->_id = null;
		}
	}


	public static function get_by_login($login) {
		// !!! attention au nom de la table !!!
		$s = self::$_db->prepare('SELECT * FROM user where login = :l');
		$s->bindValue(':l', $login, PDO::PARAM_STR);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new User($data['id'],$data['login'],$data['password'],$data['state']);
		}
		else {
			return null;
		}
	}


	public static function get_by_id($id) {
		$s = self::$_db->prepare('SELECT * FROM user where id = :id');
		$s->bindValue(':id', $id, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new User($data['id'],$data['login'],$data['password'],$data['state']);
		}
		else {
			return null;
		}
	}


	public static function exist_login($login) {
		$test = false;
		$s = self::$_db->prepare('SELECT * FROM user where login = :l');
		$s->bindValue(':l', $login, PDO::PARAM_STR);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data)
		{
			$test = true;
		}
		return $test;
	}
}

<?php

/**
 * \file      models/user.php
 * \author    Jordan Lang
 * \version   1.0
 * \date      25 octobre 2014
 * \brief     Modèle d'utilisateur
 */

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
		$this->set_email($state);
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

	public function set_email($v) {
		$this->_state = strval($v);
	}


	/**
 	 * \brief       Insert un utilisateur dans la base user
 	 * \param       login      login choisi par l'utilisateur
 	 * \param       password   password choisi par l'utilisateur
 	 * \param       state      état de l'utilisateur
 	 */
	public static function insert($login,$password,$state)
	{
		$q = self::$_db->prepare('INSERT INTO user (login, password, state) VALUES (:login,:password, :state)');
		$q->bindValue(':login', $login, PDO::PARAM_STR);
		$q->bindValue(':password', $password, PDO::PARAM_STR);
		$q->bindValue(':state', $state, PDO::PARAM_STR);
		$q->execute();
	}

	/**
 	 * \brief       Met à jour l'utilisateur concerné
 	 */
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

	/**
 	 * \brief       Supprime l'utilisateur concerné
 	 */
	public function delete()
	{
		if(!is_null($this->_id)) {
			$q = self::$_db->prepare('DELETE FROM user WHERE id = :id');
			$q->bindValue(':id', $this->_id);
			$q->execute();
			$this->_id = null;
		}
	}

	/**
 	 * \param       login     login de l'utilisateur
 	 * \return 	    L'utilisateur qui correspond au login
 	 */
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

	/**
 	 * \param       id      id de l'utilisateur
 	 * \return 	    L'utilisateur qui correspond à l'id
 	 */
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

	/**
 	 * \brief       Teste l'existence de l'utilisateur
 	 * \param       login      login de l'utilisateur
 	 * \return 	    Un booleen, si l'utilisateur existe ou non
 	 */
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

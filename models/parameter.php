<?php

/**
 * \file      models/parameter.php
 * \author    Jordan Lang
 * \version   1.0
 * \date      15 novembre 2014
 * \brief     Modèle de paramètre
 */

require_once 'base.php';

class Parameter extends Model_Base
{
	private $_idUser;

	private $_show_arrow;

	private $_step;

	private $_default_mode;

	public function __construct($idUser, $show_arrow, $step, $default_mode) {
		$this->set_idUser($idUser);
		$this->set_show_arrow($show_arrow);
		$this->set_step($step);
		$this->set_default_mode($default_mode);
	}

	// Getter
	public function idUser() {
		return $this->_idUser;
	}

	public function show_arrow() {
		return $this->_show_arrow;
	}

	public function step() {
		return (double) $this->_step;
	}

	public function default_mode() {
		return $this->_default_mode;
	}

	// Setter
	public function set_idUser($v) {
		$this->_idUser = (int) $v;
	}

	public function set_show_arrow($v) {
		$this->_show_arrow = (int) $v;
	}

	public function set_step($v) {
		$this->_step = strval($v);
	}

	public function set_default_mode($v) {
		$this->_default_mode = (int) $v;
	}

	/**
 	 * \brief     Insert les paramètres d'un utilisateur
 	 * \param    idUser    id de l'utilisateur
 	 */
	public static function insert($idUser)
	{
		$q = self::$_db->prepare('INSERT INTO parameter (idUser) VALUES (:idUser)');
		$q->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$q->execute();
	}

	/**
 	 * \brief     Met à jour les paramètres de l'utilisateur concerné
 	 */
	public function save()
	{
		if(!is_null($this->_idUser)) {
			$q = self::$_db->prepare('UPDATE parameter SET show_arrow=:show_arrow, step=:step, default_mode=:default_mode WHERE idUser = :idUser');
			$q->bindValue(':idUser', $this->idUser(), PDO::PARAM_INT);
			$q->bindValue(':show_arrow', $this->show_arrow(), PDO::PARAM_INT);
			$q->bindValue(':step', $this->step(), PDO::PARAM_STR);
			$q->bindValue(':default_mode', $this->default_mode(), PDO::PARAM_INT);
			$q->execute();
		}
	}

	/**
 	 * \brief     Supprime les paramètres de l'utilisateur concerné
 	 */
	public function delete()
	{
		if(!is_null($this->idUser())) {
			$q = self::$_db->prepare('DELETE FROM parameter WHERE idUser = :idUser');
			$q->bindValue(':idUser', $this->idUser(), PDO::PARAM_INT);
			$q->execute();
			$this->set_idUser(null);
		}
	}

	/**
 	 * \param     idUser    id de l'utilisateur
 	 * \return 	  Les paramètres qui correspondent à l'id
 	 */
	public static function get_by_id($idUser) {
		$s = self::$_db->prepare('SELECT * FROM parameter WHERE idUser = :idUser');
		$s->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new Parameter($data['idUser'], $data['show_arrow'], $data['step'], $data['default_mode']);
		}
		else {
			return null;
		}
	}

	/**
	 * \brief     Teste l'existence des paramètres de l'utilisateur dans la base
 	 * \param     idUser    id de l'utilisateur  
 	 * \return 	  Un booleen, si les paramètres existent ou non
 	 */
	public static function exist($idUser) {
		$s = self::$_db->prepare('SELECT * FROM parameter WHERE idUser = :idUser');
		$s->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return true;
		}
		else {
			return false;
		}
	}
}
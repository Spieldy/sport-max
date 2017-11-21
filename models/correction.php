<?php

/**
 * \file      models/correction.php
 * \author    Jordan Lang
 * \version   1.0
 * \date      15 novembre 2014
 * \brief     Modèle de correction
 */

require_once 'base.php';

class Correction extends Model_Base
{
	private $_id;

	private $_idSheet;

	private $_dateEdit;

	private $_idUser;

	public function __construct($id, $idSheet, $dateEdit, $idUser) {
		$this->set_id($id);
		$this->set_idSheet($idSheet);
		$this->set_dateEdit($dateEdit);
		$this->set_idUser($idUser);
	}

	// Getter
	public function id() {
		return $this->_id;
	}

	public function idSheet() {
		return $this->_idSheet;
	}

	public function dateEdit() {
		return $this->_dateEdit;
	}

	public function idUser() {
		return $this->_idUser;
	}

	// Setter
	public function set_id($v) {
		$this->_id = (int) $v;
	}

	public function set_idSheet($v) {
		$this->_idSheet = (int) $v;
	}

	public function set_dateEdit($v) {
		$this->_dateEdit = $v;
	}

	public function set_idUser($v) {
		$this->_idUser = (int) $v;
	}


	/**
	 * \brief      Insert une correction dans la base
	 * \param 	   idSheet     id de la copie
	 * \param 	   idUser     id de l'utilisateur
	 */
	public static function insert($idSheet, $idUser)
	{
		$q = self::$_db->prepare('INSERT INTO correction (idSheet, dateEdit, idUser) VALUES (:idSheet, :dateEdit, :idUser)');
		$q->bindValue(':idSheet', $idSheet, PDO::PARAM_INT);
		$q->bindValue(':dateEdit', date("Y-m-d H:i:s"), PDO::PARAM_STR);
		$q->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$q->execute();
	}

	/**
	 * \brief      Met à jour la correction concernée
	 */
	public function save()
	{
		if(!is_null($this->id())) {
			$q = self::$_db->prepare('UPDATE correction SET idSheet=:idSheet, dateEdit=:dateEdit, idUser=:idUser WHERE id = :id');
			$q->bindValue(':id', $this->id(), PDO::PARAM_INT);
			$q->bindValue(':idSheet', $this->idSheet(), PDO::PARAM_INT);
			$q->bindValue(':dateEdit', date("Y-m-d H:i:s", strtotime($this->dateEdit())), PDO::PARAM_STR);
			$q->bindValue(':idUser', $this->idUser(), PDO::PARAM_INT);
			$q->execute();
		}
	}

	/**
	 * \brief     Supprime la correction concernée
	 */
	public function delete()
	{
		if(!is_null($this->id())) {
			$q = self::$_db->prepare('DELETE FROM correction WHERE id = :id');
			$q->bindValue(':id', $this->id());
			$q->execute();
			$this->_id = null;
		}
	}

	/**
	 * \param         id       id de la correction
	 * \return     La correction à qui appartient l'id, si elle existe
	 */
	public static function get_by_id($id) {
		$s = self::$_db->prepare('SELECT * FROM correction WHERE id = :id');
		$s->bindValue(':id', $id, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new Correction($data['id'],$data['idSheet'],$data['dateEdit'],$data['idUser']);
		}
		else {
			return null;
		}
	}

	/**
	 * \param      idSheet     id de la copie
	 * \param 	   idUser      id de l'utilisateur
	 * \return     La correction qui correspond à la copie de l'utlisateur, si elle existe
	 */
	public static function get_by_sheet($idSheet, $idUser) {
		$s = self::$_db->prepare('SELECT * FROM correction WHERE idSheet = :id AND idUser = :idUser');
		$s->bindValue(':id', $idSheet, PDO::PARAM_INT);
		$s->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new Correction($data['id'],$data['idSheet'],$data['dateEdit'],$data['idUser']);
		}
		else {
			return null;
		}
	}

	/**
	 * \param    idUser      id de l'utilisateur
	 * \return    La dernière correction effectuée
	 */
	public static function get_last_correction($idUser) {
		$s = self::$_db->prepare('SELECT * FROM correction WHERE idUser = :idUser ORDER BY dateEdit DESC');
		$s->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		return new Correction($data['id'],$data['idSheet'],$data['dateEdit'],$data['idUser']);
	}

	/**
	 * \brief     Teste l'existence de la correction
	 * \param 	   idSheet     id de la copie
	 * \param      idUser      id de l'utilisateur
	 * \return    Un booleen, si la correction existe ou non
	 */
	public static function exist($idSheet, $idUser) {
		$test = false;
		$s = self::$_db->prepare('SELECT * FROM correction WHERE idSheet = :l AND idUser = :idUser');
		$s->bindValue(':l', $idSheet, PDO::PARAM_INT);
		$s->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data)
		{
			$test = true;
		}
		return $test;
	}

	/**
	 * \brief     Teste si une correction existe pour l'utilisateur
	 * \param     idUser     id de l'utilisateur
	 * \return    Un booleen, si une correction existe ou non pour l'utilisateur
	 */
	public static function exist_one($idUser) {
		$test = false;
		$s = self::$_db->prepare('SELECT * FROM correction WHERE idUser = :idUser');
		$s->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data)
		{
			$test = true;
		}
		return $test;
	}
}
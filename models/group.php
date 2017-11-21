<?php

/**
 * \file      models/group.php
 * \author    Jordan Lang
 * \version   1.0
 * \date      15 novembre 2014
 * \brief     Modèle de groupe
 */

require_once 'base.php';

class Group extends Model_Base
{
	private $_id;

	private $_name;

	private $_idFatherGroup;

	private $_idUser;

	public function __construct($id, $name, $idFatherGroup, $idUser) {
		$this->set_id($id);
		$this->set_name($name);
		$this->set_idFatherGroup($idFatherGroup);
		$this->set_idUser($idUser);
	}

	// Getter
	public function id() {
		return $this->_id;
	}

	public function name() {
		return $this->_name;
	}

	public function idFatherGroup() {
		return $this->_idFatherGroup;
	}

	public function idUser() {
		return $this->_idUser;
	}

	// Setter
	public function set_id($v) {
		$this->_id = (int) $v;
	}

	public function set_name($v) {
		$this->_name = strval($v);
	}

	public function set_idFatherGroup($v) {
		$this->_idFatherGroup = (int) $v;
	}

	public function set_idUser($v) {
		$this->_idUser = (int) $v;
	}


	/**
	 * \brief     Insert un groupe dans la table group
	 * \param     name              nom du groupe
	 * \param     idFatherGroup     id du groupe parent (non géré dans notre cas)
	 * \param     idUser            id de l'utilisateur
	 */
	public static function insert($name, $idFatherGroup, $idUser)
	{
		$q = self::$_db->prepare('INSERT INTO `group` (name, idFatherGroup, idUser) VALUES (:name, :idFatherGroup, :idUser)');
		$q->bindValue(':name', $name, PDO::PARAM_STR);
		$q->bindValue(':idFatherGroup', $idFatherGroup, PDO::PARAM_INT);
		$q->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$q->execute();
	}

	/**
	 * \brief     Met à jour le groupe concerné 
	 */
	public function save()
	{
		if(!is_null($this->id())) {
			$q = self::$_db->prepare('UPDATE `group` SET name=:name, idFatherGroup=:idFatherGroup, idUser=:idUser WHERE id = :id');
			$q->bindValue(':id', $this->id(), PDO::PARAM_INT);
			$q->bindValue(':name', $this->name(), PDO::PARAM_STR);
			$q->bindValue(':idFatherGroup', $this->idFatherGroup(), PDO::PARAM_INT);
			if(isset($idUser)) {
				$q->bindValue(':idUser', $idUser, PDO::PARAM_INT);
			}
			else {
				$q->bindValue(':idUser', 14, PDO::PARAM_INT);
			}
			$q->execute();
		}
	}

	/**
	 * \brief     Supprime le groupe concerné  
	 */
	public function delete()
	{
		if(!is_null($this->id())) {
			$q = self::$_db->prepare('DELETE FROM `group` WHERE id = :id');
			$q->bindValue(':id', $this->id(), PDO::PARAM_INT);
			$q->execute();
			$this->set_id(null);
		}
	}

	/**
	 * \param     name              nom du groupe
	 * \param     idUser            id de l'utilisateur
	 * \return 	  Le groupe qui correspond au nom
	 */
	public static function get_by_name($name, $idUser) {
		$s = self::$_db->prepare('SELECT * FROM `group` WHERE name = :l AND idUser = :idUser');
		$s->bindValue(':l', $name, PDO::PARAM_STR);
		$s->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new Group($data['id'], $data['name'], $data['idFatherGroup'], $data['idUser']);
		}
		else {
			return null;
		}
	}

	/**
	 * \param     id    id du groupe
	 * \return 	  Le groupe qui correspond à l'id
	 */
	public static function get_by_id($id) {
		$s = self::$_db->prepare('SELECT * FROM `group` where id = :id');
		$s->bindValue(':id', $id, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new Group($data['id'], $data['name'], $data['idFatherGroup'], $data['idUser']);
		}
		else {
			return null;
		}
	}

	/**
	 * \param     idUser    id de l'utilisateur
	 * \return 	  Tous les groupes qui appartiennent à l'utilisateur
	 */
	public static function get_all_groups($idUser) {
		$s = self::$_db->prepare('SELECT * FROM `group` WHERE idUser = :idUser ORDER BY name');
		$s->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$s->execute();
		$groups = array();
		while ($data = $s->fetch(PDO::FETCH_ASSOC)) {
			$groups[] = new Group($data['id'], $data['name'], $data['idFatherGroup'], $data['idUser']);
		}
		return $groups;
	}

	/**
	 * \brief     Teste l'existence d'un groupe qui correspond au nom
	 * \param     name              nom du groupe
	 * \param     idUser            id de l'utilisateur
	 * \return 	  Un booleen, si le groupe existe ou non
	 */
	public static function exist_name($name, $idUser) {
		$s = self::$_db->prepare('SELECT * FROM `group` WHERE name = :l AND idUser = :idUser');
		$s->bindValue(':l', $name, PDO::PARAM_STR);
		$s->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//operations sur la table link_group_student

	/**
	 * \param     idStudent    id de l'étudiant 
	 * \return 	  Le groupe auquel appartient l'étudiant
	 */
	public static function get_group($idStudent) {
		$s = self::$_db->prepare('SELECT * FROM link_group_student WHERE idStudent = :idStudent');
		$s->bindValue(':idStudent', $idStudent, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		return self::get_by_id($data['idGroup']);
	}
}
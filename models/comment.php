<?php

/**
 * \file      models/comment.php
 * \author    Jordan Lang
 * \version   1.0
 * \date      15 novembre 2014
 * \brief     Modèle de commentaires
 */

require_once 'base.php';

class Comment extends Model_Base
{
	private $_id;

	private $_name;

	private $_idUser;

	public function __construct($id, $name, $idUser) {
		$this->set_id($id);
		$this->set_name($name);
		$this->set_idUser($idUser);
	}

	// Getter
	public function id() {
		return $this->_id;
	}

	public function name() {
		return $this->_name;
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

	public function set_idUser($v) {
		$this->_idUser = (int) $v;
	}


	/**
	 * \brief   Insert un commentaire dans la table comment
	 * \param   name    nom du commentaire
	 * \param   idUser  id de l'utilisateur
	 */
	public static function insert($name, $idUser)
	{
		$q = self::$_db->prepare('INSERT INTO comment (name, idUser) VALUES (:name, :idUser)');
		$q->bindValue(':name', $name, PDO::PARAM_STR);
		$q->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$q->execute();
	}

	/**
	 * \brief   Met à jour le commentaire concerné
	 */
	public function save()
	{
		if(!is_null($this->id())) {
			$q = self::$_db->prepare('UPDATE comment SET name=:name, idUser=:idUser WHERE id = :id');
			$q->bindValue(':id', $this->id(), PDO::PARAM_INT);
			$q->bindValue(':name', $this->name(), PDO::PARAM_STR);
			$q->bindValue(':idUser', $this->idUser(), PDO::PARAM_INT);
			$q->execute();
		}
	}

	/**
	 * \brief   Supprime le commentaire concerné
	 */
	public function delete()
	{
		if(!is_null($this->id())) {
			$q = self::$_db->prepare('DELETE FROM comment WHERE id = :id');
			$q->bindValue(':id', $this->id(), PDO::PARAM_INT);
			$q->execute();
			$this->set_id(null);
		}
	}

	/**
	 * \param    name    nom du commentaire
	 * \return    Le commentaire recherché par nom
	 */
	public static function get_by_name($name) {
		$s = self::$_db->prepare('SELECT * FROM comment where name = :l');
		$s->bindValue(':l', $name, PDO::PARAM_STR);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new Comment($data['id'], $data['name'], $data['idUser']);
		}
		else {
			return null;
		}
	}

	/**
	 * \param    id     id du commentaire
	 * \return    Le commentaire recherché par id
	 */
	public static function get_by_id($id) {
		$s = self::$_db->prepare('SELECT * FROM comment where id = :id');
		$s->bindValue(':id', $id, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new Comment($data['id'], $data['name'], $data['idUser']);
		}
		else {
			return null;
		}
	}

	/**
	 * \brief    teste l'existence du nom
	 * \param    name       nom du commentaire
	 * \param    idUser     id de l'utilisateur
	 * \return    Un booleen, si le commentaire existe ou non
	 */
	public static function exist_name($name, $idUser) {
		$s = self::$_db->prepare('SELECT * FROM comment WHERE name = :name AND idUser = :idUser');
		$s->bindValue(':name', $name, PDO::PARAM_STR);
		$s->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data)
		{
			return true;
		}
		return false;
	}

	/**
	 * \param    idUser     id de l'utilisateur
	 * \return    Tous les commentaires qui appartiennent à l'utilisateur
	 */
	public static function get_user_comments($idUser) {
		$s = self::$_db->prepare('SELECT * FROM comment WHERE idUser = :idUser');
		$s->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$s->execute();
		$comments = array();
		while ($data = $s->fetch(PDO::FETCH_ASSOC)) {
			$comments[] = new Comment($data['id'], $data['name'], $data['idUser']);
		}
		return $comments;
	}

	/**
	 * \return    Tous les commentaires de la table comment
	 */
	public static function get_all_comments() {
		$s = self::$_db->prepare('SELECT * FROM comment');
		$s->execute();
		$comments = array();
		while ($data = $s->fetch(PDO::FETCH_ASSOC)) {
			$comments[] = new Comment($data['id'], $data['name'], $data['idUser']);
		}
		return $comments;
	}
}
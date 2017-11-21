<?php

/**
 * \file      models/student.php
 * \author    Jordan Lang
 * \version   2.0
 * \date      15 novembre 2014
 * \brief     Modèle d'étudiant
 */

require_once 'base.php';

class Student extends Model_Base
{
	private $_id;

	private $_name;

	private $_firstname;

	public function __construct($id, $name, $firstname) {
		$this->set_id($id);
		$this->set_name($name);
		$this->set_firstname($firstname);
	}

	// Getter
	public function id() {
		return $this->_id;
	}

	public function name() {
		return $this->_name;
	}

	public function firstname() {
		return $this->_firstname;
	}

	// Setter
	public function set_id($v) {
		$this->_id = (int) $v;
	}

	public function set_name($v) {
		$this->_name = strval($v);
	}

	public function set_firstname($v) {
		$this->_firstname = strval($v);
	}


	/**
 	 * \brief       Insert un étudiant dans la base student
 	 * \param       name          nom de l'étudiant
 	 * \param       firstname     prénom de l'étudiant
 	 * \param       idGroup       id du groupe de l'étudiant
 	 */
	public static function insert($name, $firstname, $idGroup)
	{
		$q = self::$_db->prepare('INSERT INTO student (name, firstname) VALUES (:name, :firstname)');
		$q->bindValue(':name', $name, PDO::PARAM_STR);
		$q->bindValue(':firstname', $firstname, PDO::PARAM_STR);
		$q->execute();
		$idStudent = self::$_db->lastInsertId();
		self::insert_link_group_student($idStudent, $idGroup);
	}

	/**
 	 * \brief       Met à jour l'étudiant concerné
 	 */
	public function save()
	{
		if(!is_null($this->id())) {
			$q = self::$_db->prepare('UPDATE student SET name=:name, firstname=:firstname WHERE id = :id');
			$q->bindValue(':id', $this->id(), PDO::PARAM_INT);
			$q->bindValue(':name', $this->name(), PDO::PARAM_STR);
			$q->bindValue(':firstname', $this->firstname(), PDO::PARAM_STR);
			$q->execute();
		}
	}

	/**
 	 * \brief       Supprime l'étudiant concerné
 	 */
	public function delete()
	{
		if(!is_null($this->id())) {
			$q = self::$_db->prepare('DELETE FROM `student` WHERE id = :id');
			$q->bindValue(':id', $this->id(), PDO::PARAM_INT);
			$q->execute();
			$this->set_id(null);
		}
	}

	/**
 	 * \param       name     nom de l'étudiant
 	 * \return 	    L'étudiant qui correspond au nom
 	 */
	public static function get_by_name($name)
	{
		$s = self::$_db->prepare('SELECT * FROM student where name = :l');
		$s->bindValue(':l', $name, PDO::PARAM_STR);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new Student($data['id'],$data['name'],$data['firstname']);
		} else {
			return null;
		}
	}

	/**
 	 * \param       id      id de l'étudiant
 	 * \return 	    L'étudiant qui correspond à l'id
 	 */
	public static function get_by_id($id)
	{
		$s = self::$_db->prepare('SELECT * FROM student where id = :id');
		$s->bindValue(':id', $id, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new Student($data['id'],$data['name'],$data['firstname']);
		} else {
			return null;
		}
	}

	/**
 	 * \brief       Teste l'existence de l'étudiant
 	 * \param       name     nom de l'étudiant
 	 * \param       firstname     prénom de l'étudiant
 	 * \return 	    Un booleen, si l'étudiant existe ou non
 	 */
	public static function exist($name, $firstname)
	{
		$test = false;
		$s = self::$_db->prepare('SELECT * FROM student WHERE name = :name AND firstname = :firstname');
		$s->bindValue(':name', $name, PDO::PARAM_STR);
		$s->bindValue(':firstname', $firstname, PDO::PARAM_STR);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data)
		{
			$test = true;
		}
		return $test;
	}

	/**
 	 * \return 	    Tous les étudiants contenus dans la base
 	 */
	public static function get_all_students()
	{
		$s = self::$_db->prepare('SELECT * FROM student ORDER BY name');
		$s->execute();
		$students = array();
		while ($data = $s->fetch(PDO::FETCH_ASSOC)) {
			$students[] = new Student($data['id'], $data['name'], $data['firstname']);
		}
		return $students;
	}

	//operations sur la table link_group_student

	/**
 	 * \brief       Insert un lien entre le groupe et l'étudiant
 	 * \param       idStudent      id de l'étudiant
 	 * \param       idGroup        id du groupe
 	 */
	public static function insert_link_group_student($idStudent, $idGroup)
	{
		if(!(is_null($idStudent) || is_null($idGroup))) {
			$q = self::$_db->prepare('INSERT INTO link_group_student (idStudent, idGroup) VALUES (:idStudent, :idGroup)');
			$q->bindValue(':idStudent', $idStudent, PDO::PARAM_INT);
			$q->bindValue(':idGroup', $idGroup, PDO::PARAM_INT);
			$q->execute();
		}
	}

	/**
 	 * \brief       Supprime le lien entre l'étudiant et le groupe
 	 * \param       idStudent      id de l'étudiant
 	 * \param       idGroup        id du groupe
 	 */
	public static function delete_link_group_student($idStudent, $idGroup)
	{
		if(!(is_null($idStudent) || is_null($idGroup))) {
			$q = self::$_db->prepare('DELETE FROM link_group_student WHERE idStudent=:idStudent AND idGroup=:idGroup');
			$q->bindValue(':idStudent', $idStudent, PDO::PARAM_INT);
			$q->bindValue(':idGroup', $idGroup, PDO::PARAM_INT);
			$q->execute();
		}
	}

	/**
 	 * \brief       Supprime les liens avec le groupe
 	 * \param       idGroup      id du groupe
 	 */
	public static function delete_link_group($idGroup)
	{
		if(!(is_null($idGroup))) {
			$q = self::$_db->prepare('DELETE FROM link_group_student WHERE idGroup=:idGroup');
			$q->bindValue(':idGroup', $idGroup, PDO::PARAM_INT);
			$q->execute();
		}
	}

	/**
 	 * \param       idGroup     id du groupe
 	 * \return 	    Tous les étudiants qui appartiennent au groupe
 	 */
	public static function get_students($idGroup) {
		$s = self::$_db->prepare('SELECT * FROM link_group_student WHERE idGroup = :idGroup');
		$s->bindValue(':idGroup', $idGroup, PDO::PARAM_INT);
		$s->execute();
		$students = array();
		while ($data = $s->fetch(PDO::FETCH_ASSOC)) {
			$students[] = self::get_by_id($data['idStudent']);
		}
		return $students;
	}
}

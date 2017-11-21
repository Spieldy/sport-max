<?php

/**
 * \file      models/exam.php
 * \author    Jordan Lang
 * \version   1.0
 * \date      15 novembre 2014
 * \brief     Modèle de sujet
 */

require_once 'base.php';

class Exam extends Model_Base
{
	private $_id;

	private $_name;

	private $_mark;

	private $_dateExam;

	private $_order;

	private $_idUser;

	public function __construct($id, $name, $mark, $dateExam, $order, $idUser) {
		$this->set_id($id);
		$this->set_name($name);
		$this->set_mark($mark);
		$this->set_dateExam($dateExam);
		$this->set_order($order);
		$this->set_idUser($idUser);
	}


	// Getter
	public function id() {
		return $this->_id;
	}

	public function name() {
		return $this->_name;
	}

	public function mark() {
		return $this->_mark;
	}

	public function dateExam() {
		return $this->_dateExam;
	}

	public function order() {
		return $this->_order;
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

	public function set_mark($v) {
		$this->_mark = strval($v);
	}

	public function set_dateExam($v) {
		$this->_dateExam = strval($v);
	}

	public function set_order($v) {
		$this->_order = (int) $v;
	}

	public function set_idUser($v) {
		$this->_idUser = (int) $v;
	}


	/**
	 * \brief     Insert un sujet dans la table sujet
	 * \param     name      nom du sujet
	 * \param     mark      barème du sujet
	 * \param     order     tri du sujet
	 * \param     idUser    id de l'utilisateur
	 */
	public static function insert($name, $mark, $order, $idUser)
	{
		$q = self::$_db->prepare('INSERT INTO exam (`name`, `mark`, `dateExam`, `order`, `idUser`) VALUES (:name, :mark, :dateExam, :order, :idUser)');
		$q->bindValue(':name', $name, PDO::PARAM_STR);
		$q->bindValue(':mark', $mark, PDO::PARAM_STR);
		$q->bindValue(':dateExam', date("Y-m-d H:i:s"), PDO::PARAM_STR);
		$q->bindValue(':order', $order, PDO::PARAM_INT);
		$q->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$q->execute();
	}

	/**
	 * \brief     Met à jour le sujet concerné
	 */
	public function save()
	{
		if(!is_null($this->id())) {
			$q = self::$_db->prepare('UPDATE exam SET `name`=:name, `mark`=:mark, `dateExam`=:dateExam, `order`=:order, `idUser`=:idUser WHERE `id` = :id');
			$q->bindValue(':id', $this->id(), PDO::PARAM_INT);
			$q->bindValue(':name', $this->name(), PDO::PARAM_STR);
			$q->bindValue(':mark', $this->mark(), PDO::PARAM_STR);
			$q->bindValue(':dateExam', $this->dateExam(), PDO::PARAM_STR);
			$q->bindValue(':order', $this->order(), PDO::PARAM_INT);
			$q->bindValue(':idUser', $this->idUser(), PDO::PARAM_INT);
			$q->execute();
		}
	}

	/**
	 * \brief     Supprime de la table le sujet concerné
	 */
	public function delete()
	{
		if(!is_null($this->id())) {
			$q = self::$_db->prepare('DELETE FROM exam WHERE id = :id');
			$q->bindValue(':id', $this->id(), PDO::PARAM_INT);
			$q->execute();
			$this->set_id(null);
		}
	}

	/**
	 * \param     name      nom du sujet
	 * \param     idUser    id de l'utilisateur
	 * \return    Le sujet qui correspond au nom
	 */
	public static function get_by_name($name, $idUser) {
		$s = self::$_db->prepare('SELECT * FROM exam WHERE name = :l AND idUser = :idUser');
		$s->bindValue(':l', $name, PDO::PARAM_STR);
		$s->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new Exam($data['id'], $data['name'], $data['mark'], $data['dateExam'], $data['order'], $data['idUser']);
		}
		else {
			return null;
		}
	}

	/**
	 * \param     id    id du sujet
	 * \return     Le sujet qui correspond à l'id
	 */
	public static function get_by_id($id) {
		$s = self::$_db->prepare('SELECT * FROM exam WHERE id = :id');
		$s->bindValue(':id', $id, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new Exam($data['id'], $data['name'], $data['mark'], $data['dateExam'], $data['order'], $data['idUser']);
		}
		else {
			return null;
		}
	}

	/**
	 * \param     idUser    id de l'utilisateur
	 * \return     Tous les sujets qui correspondent à l'utilisateur
	 */
	public static function get_all_exams($idUser) {
		$s = self::$_db->prepare('SELECT * FROM exam WHERE idUser = :idUser ORDER BY dateExam');
		$s->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$s->execute();
		$exams = array();
		while ($data = $s->fetch(PDO::FETCH_ASSOC)) {
			$exams[] = new Exam($data['id'],$data['name'], $data['mark'], $data['dateExam'],$data['order'], $data['idUser']);
		}
		return $exams;
	}

	/**
	 * \brief     Teste l'existence d'un sujet
	 * \param     name      nom du sujet
	 * \param     idUser    id de l'utilisateur
	 * \return 	  Un booleen, si le sujet existe ou non
	 */
	public static function exist_name($name, $idUser) {
		$s = self::$_db->prepare('SELECT * FROM exam where name = :l AND idUser = :idUser');
		$s->bindValue(':l', $name, PDO::PARAM_STR);
		$s->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data)
		{
			return true;
		}
		return false;
	}

	//operations sur la table link_exam_sheet

	/**
	 * \param     idSheet    id de la copie
	 * \return     Le sujet qui correspond à la copie
	 */
	public static function get_exam_sheet($idSheet)
	{
		if(!(is_null($idSheet))) {
			$s = self::$_db->prepare('SELECT * FROM link_exam_sheet WHERE idSheet = :idSheet');
			$s->bindValue(':idSheet', $idSheet, PDO::PARAM_INT);
			$s->execute();
			$exam = $s->fetch(PDO::FETCH_ASSOC);
			return self::get_by_id($exam['idExam']);
		}
	}
}

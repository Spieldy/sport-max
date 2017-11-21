<?php

/**
 * \file      models/sheet.php
 * \author    Jordan Lang
 * \version   2.0
 * \date      15 novembre 2014
 * \brief     Modèle de copie
 */

require_once 'base.php';

class Sheet extends Model_Base
{
	private $_id;

	private $_idStudent;

	private $_idComment;

	private $_pointReceived;

	private $_finished;

	private $_missing;

	public function __construct($id, $idStudent, $idComment, $pointReceived, $finished, $missing) {
		$this->set_id($id);
		$this->set_idStudent($idStudent);
		$this->set_idComment($idComment);
		$this->set_pointReceived($pointReceived);
		$this->set_finished($finished);
		$this->set_missing($missing);
	}

	// Getter
	public function id() {
		return $this->_id;
	}

	public function idStudent() {
		return $this->_idStudent;
	}

	public function idComment() {
		return $this->_idComment;
	}

	public function pointReceived() {
		return (double) $this->_pointReceived;
	}

	public function finished() {
		return $this->_finished;
	}

	public function missing() {
		return $this->_missing;
	}

	// Setter
	public function set_id($v) {
		$this->_id = (int) $v;
	}

	public function set_idStudent($v) {
		$this->_idStudent = (int) $v;
	}

	public function set_idComment($v) {
		$this->_idComment = (int) $v;
	}

	public function set_pointReceived($v) {
		$this->_pointReceived = strval($v);
	}

	public function set_finished($v) {
		$this->_finished = (int) $v;
	}

	public function set_missing($v) {
		$this->_missing = (int) $v;
	}

	/**
 	 * \brief      Insert une copie dans la base sheet
 	 * \param      idStudent       id de l'étudiant
 	 * \param      pointReceived   note de la copie
 	 * \param      finished        état de correction de la copie
 	 */
	public static function insert($idStudent, $pointReceived, $finished)
	{
		$q = self::$_db->prepare('INSERT INTO sheet (idStudent, pointReceived, finished) VALUES (:idStudent, :pointReceived, :finished)');
		$q->bindValue(':idStudent', $idStudent, PDO::PARAM_INT);
		$q->bindValue(':pointReceived', $pointReceived, PDO::PARAM_STR);
		$q->bindValue(':finished', $finished, PDO::PARAM_INT);
		$q->execute();
		return self::$_db->lastInsertId();
	}

	/**
 	 * \brief      Met à jour la copie concernée
 	 */
	public function save()
	{
		if(!is_null($this->id())) {
			if($this->idComment() == NULL) {
				$comm = NULL;
			}
			else {
				$comm = $this->idComment();
			}
			$q = self::$_db->prepare('UPDATE sheet SET `idStudent`=:idS, `idComment`=:c, `pointReceived`=:pR, `finished`=:f, `missing`=:m WHERE `id` = :id');
			$q->bindValue(':id', $this->id(), PDO::PARAM_INT);
			$q->bindValue(':idS', $this->idStudent(), PDO::PARAM_INT);
			$q->bindValue(':c', $comm, PDO::PARAM_INT);
			$q->bindValue(':pR', $this->pointReceived(), PDO::PARAM_STR);
			$q->bindValue(':f', $this->finished(), PDO::PARAM_INT);
			$q->bindValue(':m', $this->missing(), PDO::PARAM_INT);
			$q->execute();
		}
	}

	/**
 	 * \brief      Supprime la copie concernée
 	 */
	public function delete()
	{
		if(!is_null($this->id())) {
			$q = self::$_db->prepare('DELETE FROM sheet WHERE id = :id');
			$q->bindValue(':id', $this->id(), PDO::PARAM_INT);
			$q->execute();
			$this->_id = null;
		}
	}

	/**
 	 * \brief    Supprime la copie de l'étudiant
 	 * \param      idStudent       id de l'étudiant
 	 */
	public static function delete_sheet_student($idStudent)
	{
		if(!is_null($idStudent)) {
			$q = self::$_db->prepare('DELETE FROM sheet WHERE idStudent = :id');
			$q->bindValue(':id', $idStudent, PDO::PARAM_INT);
			$q->execute();
		}
	}

	/**
 	 * \param       id     id de la copie
 	 * \return 	    La copie qui correspond à l'id
 	 */
	public static function get_by_id($id) {
		$s = self::$_db->prepare('SELECT * FROM sheet where id = :id');
		$s->bindValue(':id', $id, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new Sheet($data['id'],$data['idStudent'],$data['idComment'],$data['pointReceived'],$data['finished'],$data['missing']);
		}
		else {
			return null;
		}
	}

	/**
 	 * \param       idStudent     id de l'étudiant
 	 * \return 	    Toutes les copies qui appartiennent à l'étudiant
 	 */
	public static function get_by_student($idStudent) {
		$s = self::$_db->prepare('SELECT * FROM sheet where idStudent = :id');
		$s->bindValue(':id', $idStudent, PDO::PARAM_INT);
		$s->execute();
		$sheets = array();
		while ($data = $s->fetch(PDO::FETCH_ASSOC)) {
			$sheets[] = new Sheet($data['id'],$data['idStudent'],$data['idComment'],$data['pointReceived'],$data['finished'],$data['missing']);
		}
		return $sheets;
	}

	/**
 	 * \param       idSheet     id de la copie
 	 * \return 	    La note de la copie
 	 */
	public static function get_note_sheet($idSheet) {
		$s = self::$_db->prepare('SELECT pointReceived FROM sheet WHERE id = :id');
		$s->bindValue(':id', $idSheet, PDO::PARAM_INT);
		$s->execute();
		$note = $s->fetch(PDO::FETCH_ASSOC);
		return $note;
	}

	/**
 	 * \brief       Teste l'existence de la copie
 	 * \param       idStudent     id de l'étudiant
 	 * \return 	    Un booleen, si la copie existe ou non
 	 */
	public static function exist($idStudent) {
		$test = false;
		$s = self::$_db->prepare('SELECT * FROM sheet WHERE idStudent = :l');
		$s->bindValue(':l', $idStudent, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data)
		{
			$test = true;
		}
		return $test;
	}

	//operations sur la table link_exam_sheet

	/**
 	 * \brief       Insert un lien entre le sujet et la copie
 	 * \param       idExam      id du sujet
 	 * \param       idSheet     id de la copie
 	 */
	public static function insert_link_exam_sheet($idExam, $idSheet)
	{
		if(!(is_null($idExam) || is_null($idSheet))) {
			$q = self::$_db->prepare('INSERT INTO link_exam_sheet (idExam, idSheet) VALUES (:idExam, :idSheet)');
			$q->bindValue(':idExam', $idExam, PDO::PARAM_INT);
			$q->bindValue(':idSheet', $idSheet, PDO::PARAM_INT);
			$q->execute();
		}
	}

	/**
 	 * \brief       Supprime le lien entre le sujet et la copie
 	 * \param       idExam      id du sujet
 	 * \param       idSheet     id de la copie
 	 */
	public static function delete_link_exam_sheet($idExam, $idSheet)
	{
		if(!(is_null($idExam) || is_null($idSheet))) {
			$q = self::$_db->prepare('DELETE FROM link_exam_sheet WHERE idExam=:idExam AND idSheet=:idSheet');
			$q->bindValue(':idExam', $idExam, PDO::PARAM_INT);
			$q->bindValue(':idSheet', $idSheet, PDO::PARAM_INT);
			$q->execute();
			$this->_id = null;
		}
	}

	/**
 	 * \brief       Teste l'existence du lien entre la copie et le sujet
 	 * \param       idExam      id du sujet
 	 * \param       idSheet     id de la copie
 	 * \return 	    Un booleen, si le lien existe ou non
 	 */
	public static function exist_link_exam_sheet($idExam, $idSheet)
	{
		if(!(is_null($idExam) || is_null($idSheet))) {
			$test = false;
			$s = self::$_db->prepare('SELECT * FROM link_exam_sheet WHERE idExam=:idExam AND idSheet=:idSheet');
			$s->bindValue(':idExam', $idExam, PDO::PARAM_INT);
			$s->bindValue(':idSheet', $idSheet, PDO::PARAM_INT);
			$s->execute();
			$data = $s->fetch(PDO::FETCH_ASSOC);
			if ($data)
			{
				$test = true;
			}
			return $test;
		}
	}

	/**
 	 * \param     idExam    id du sujet
 	 * \return 	  Toutes les copies qui sont en lien avec le sujet
 	 */
	public static function get_sheets($idExam) {
		if(!(is_null($idExam))) {
			$s = self::$_db->prepare('SELECT * FROM link_exam_sheet WHERE idExam = :idExam');
			$s->bindValue(':idExam', $idExam, PDO::PARAM_INT);
			$s->execute();
			$sheets = array();
			while ($data = $s->fetch(PDO::FETCH_ASSOC)) {
				$sheets[] = self::get_by_id($data['idSheet']);
			}
			return $sheets;
		}
	}
}

<?php

/**
 * \file      models/question.php
 * \author    Jordan Lang
 * \version   2.0
 * \date      15 novembre 2014
 * \brief     Modèle de question
 */

require_once 'base.php';

class Question extends Model_Base
{
	private $_id;

	private $_name;

	private $_negative;

	private $_mark;

	public function __construct($id, $name, $negative, $mark) {
		$this->set_id($id);
		$this->set_name($name);
		$this->set_negative($negative);
		$this->set_mark($mark);
	}


	// Getter
	public function id() {
		return $this->_id;
	}

	public function name() {
		return $this->_name;
	}

	public function negative() {
		return $this->_negative;
	}

	public function mark() {
		return (double) $this->_mark;
	}

	// Setter
	public function set_id($v) {
		$this->_id = (int) $v;
	}

	public function set_name($v) {
		$this->_name = strval($v);
	}

	public function set_negative($v) {
		$this->_negative = (bool) $v;
	}

	public function set_mark($v) {
		$this->_mark = strval($v);
	}


	/**
 	 * \brief     Insert une question dans la base question
 	 * \param     name    nom de la question
 	 * \param     mark    barème de la question
 	 */
	public static function insert($name, $mark)
	{
		$q = self::$_db->prepare('INSERT INTO question (name, negative, mark) VALUES (:name, :negative, :mark)');
		$q->bindValue(':name', $name, PDO::PARAM_STR);
		$q->bindValue(':negative', 0, PDO::PARAM_BOOL);
		$q->bindValue(':mark', $mark, PDO::PARAM_STR);
		$q->execute();
	}

	/**
 	 * \brief     Met à jour la question concernée 
 	 */
	public function save()
	{
		if(!is_null($this->_id)) {
			$q = self::$_db->prepare('UPDATE question SET name=:name, negative=:negative, `mark`=:`mark` WHERE id = :id');
			$q->bindValue(':id', $this->id(), PDO::PARAM_INT);
			$q->bindValue(':name', $this->name(), PDO::PARAM_STR);
			$q->bindValue(':negative', $this->negative(), PDO::PARAM_BOOL);
			$q->bindValue(':mark', $this->mark(), PDO::PARAM_STR);
			$q->execute();
		}
	}

	/**
 	 * \brief     Supprime la question concernée
 	 */
	public function delete()
	{
		if(!is_null($this->id())) {
			$q = self::$_db->prepare('DELETE FROM question WHERE id = :id');
			$q->bindValue(':id', $this->id(), PDO::PARAM_INT);
			$q->execute();
			$this->set_id(null);
		}
	}

	/**
 	 * \param     name    nom de la question
 	 * \return 	  La question qui correspond au nom
 	 */
	public static function get_by_name($name) {
		$s = self::$_db->prepare('SELECT * FROM question where name = :l');
		$s->bindValue(':l', $name, PDO::PARAM_STR);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new Question($data['id'], $data['name'], $data['negative'], $data['mark']);
		}
		else {
			return null;
		}
	}

	/** 
 	 * \param     id    id de la question
 	 * \return 	  La question qui correspond à l'id
 	 */
	public static function get_by_id($id) {
		$s = self::$_db->prepare('SELECT * FROM question where id = :id');
		$s->bindValue(':id', $id, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new Question($data['id'], $data['name'], $data['negative'], $data['mark']);
		}
		else {
			return null;
		}
	}

	/**
 	 * \brief     Teste l'existence de la question
 	 * \param     name    nom de la question
 	 * \return 	  Un booleen, si la question existe ou non
 	 */
	public static function exist_name($name) {
		$s = self::$_db->prepare('SELECT * FROM question where name = :l');
		$s->bindValue(':l', $name, PDO::PARAM_STR);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data)
		{
			return true;
		}
		return false;
	}

	/**
 	 * \return 	 Toutes les questions enregistrées en base
 	 */
	public static function get_all_question() {
		$s = self::$_db->prepare('SELECT * FROM question');
		$s->execute();
		$questions = array();
		while ($data = $s->fetch(PDO::FETCH_ASSOC)) {
			$questions[] = new Question($data['id'], $data['name'], $data['negative'], $data['mark']);
		}
		return $questions;
	}

	//operations sur la table link_sheet_question

	/**
 	 * \brief     Insert un lien entre une copie et une question
 	 * \param     idSheet          id de la copie
 	 * \param     idQuestion       id de la question
 	 * \param     pointReceived    nombre de points reçus
 	 */
	public static function insert_link_sheet_question($idSheet, $idQuestion, $pointReceived)
	{
		if(!(is_null($idSheet) || is_null($idQuestion) || is_null($pointReceived))) {
			$q = self::$_db->prepare('INSERT INTO link_sheet_question (idSheet, idQuestion, pointReceived) VALUES (:idSheet, :idQuestion, :pointReceived)');
			$q->bindValue(':idSheet', $idSheet, PDO::PARAM_INT);
			$q->bindValue(':idQuestion', $idQuestion, PDO::PARAM_INT);
			$q->bindValue(':pointReceived', $pointReceived, PDO::PARAM_STR);
			$q->execute();
		}
	}

	/**
 	 * \brief     Met à jour le lien entre la copie et la question
 	 * \param     idSheet          id de la copie
 	 * \param     idQuestion       id de la question
 	 * \param     pointReceived    nombre de points reçus
 	 * \param     idComment        id du commentaire attribué à la question de la copie
 	 */
	public static function update_link_sheet_question($idSheet, $idQuestion, $pointReceived, $idComment)
	{
		if(!(is_null($idSheet) || is_null($idQuestion) || is_null($pointReceived))) {
			$q = self::$_db->prepare('UPDATE link_sheet_question SET pointReceived=:pointReceived, idComment=:idComment WHERE idSheet=:idSheet AND idQuestion=:idQuestion');
			$q->bindValue(':idSheet', $idSheet, PDO::PARAM_INT);
			$q->bindValue(':idQuestion', $idQuestion, PDO::PARAM_INT);
			$q->bindValue(':pointReceived', $pointReceived, PDO::PARAM_STR);
			$q->bindValue(':idComment', $idComment, PDO::PARAM_INT);
			$q->execute();
		}
	}

	/**
 	 * \brief     Teste l'existence du lien entre la copie et la question
 	 * \param     idSheet          id de la copie
 	 * \param     idQuestion       id de la question  
 	 * \return 	  Un booleen, si le lien existe ou non
 	 */
	public static function exist_link_sheet_question($idSheet, $idQuestion)
	{
		if(!(is_null($idSheet) || is_null($idQuestion))) {
			$test = false;
			$s = self::$_db->prepare('SELECT * FROM link_sheet_question WHERE idSheet=:idSheet AND idQuestion=:idQuestion');
			$s->bindValue(':idSheet', $idSheet, PDO::PARAM_INT);
			$s->bindValue(':idQuestion', $idQuestion, PDO::PARAM_INT);
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
 	 * \param     idSheet          id de la copie
 	 * \return 	  Toutes les questions d'une copie
 	 */
	public static function get_by_sheet($idSheet)
	{
		$s = self::$_db->prepare('SELECT * FROM link_sheet_question WHERE idSheet = :idSheet');
		$s->bindValue(':idSheet', $idSheet, PDO::PARAM_INT);
		$s->execute();
		$questions = array();
		while ($data = $s->fetch(PDO::FETCH_ASSOC)) {
			$questions[] = self::get_by_id($data['idQuestion']);
		}
		return $questions;
	}

	/**
 	 * \param     idSheet          id de la copie
 	 * \param     idQuestion       id de la question   
 	 * \return 	  La note de la question concernée
 	 */
	public static function get_note_question($idSheet, $idQuestion) {
		$s = self::$_db->prepare('SELECT * FROM link_sheet_question WHERE idSheet=:idSheet AND idQuestion=:idQuestion');
		$s->bindValue(':idSheet', $idSheet, PDO::PARAM_INT);
		$s->bindValue(':idQuestion', $idQuestion, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		return $data['pointReceived'];
	}

	/**
 	 * \param     idSheet          id de la copie
 	 * \param     idQuestion       id de la question
 	 * \return 	  Le commentaire pour la question concernée
 	 */
	public static function get_comment_question($idSheet, $idQuestion) {
		$s = self::$_db->prepare('SELECT * FROM link_sheet_question WHERE idSheet=:idSheet AND idQuestion=:idQuestion');
		$s->bindValue(':idSheet', $idSheet, PDO::PARAM_INT);
		$s->bindValue(':idQuestion', $idQuestion, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		return $data['idComment'];
	}

	/**
 	 * \param     idSheet          id de la copie
 	 * \return 	  Toutes les notes dans l'ordre des questions de la copie
 	 */
	public static function get_notes_sheet($idSheet) {
		$s = self::$_db->prepare('SELECT * FROM link_sheet_question WHERE idSheet=:idSheet ORDER BY idQuestion');
		$s->bindValue(':idSheet', $idSheet, PDO::PARAM_INT);
		$s->execute();
		$notes = array();
		while ($data = $s->fetch(PDO::FETCH_ASSOC)) {
			$notes[] = $data['pointReceived'];
		}
		return $notes;
	}

	/**
 	 * \param     idSheet          id de la copie
 	 * \return 	  Tous les commentaires dans l'ordre des questions de la copie
 	 */
	public static function get_comments_sheet($idSheet) {
		$s = self::$_db->prepare('SELECT * FROM link_sheet_question WHERE idSheet=:idSheet ORDER BY idQuestion');
		$s->bindValue(':idSheet', $idSheet, PDO::PARAM_INT);
		$s->execute();
		$notes = array();
		while ($data = $s->fetch(PDO::FETCH_ASSOC)) {
			$notes[] = $data['idComment'];
		}
		return $notes;
	}

	//operations sur la table link_exam_question

	/**
 	 * \brief     Insert un lien entre le sujet et la question
 	 * \param     idExam     id du sujet
 	 * \param     idQuestion     id de la question
 	 */
	public static function insert_link_exam_question($idExam, $idQuestion)
	{
		if(!(is_null($idExam) || is_null($idQuestion))) {
			$q = self::$_db->prepare('INSERT INTO link_exam_question (idExam, idQuestion) VALUES (:idExam, :idQuestion)');
			$q->bindValue(':idExam', $idExam, PDO::PARAM_INT);
			$q->bindValue(':idQuestion', $idQuestion, PDO::PARAM_INT);
			$q->execute();
		}
	}

	/**
 	 * \brief     Supprime le lien entre le sujet et la question
 	 */
	public static function delete_link_exam_question($idExam, $idQuestion)
	{
		if(!(is_null($idExam) || is_null($idQuestion))) {
			$q = self::$_db->prepare('DELETE FROM link_exam_question WHERE idExam=:idExam AND idQuestion=:idQuestion');
			$q->bindValue(':idExam', $idExam, PDO::PARAM_INT);
			$q->bindValue(':idQuestion', $idQuestion, PDO::PARAM_INT);
			$q->execute();
			$this->_id = null;
		}
	}

	/**
 	 * \brief     Teste l'existence d'un lien entre le sujet et la question
 	 * \param     idExam     id du sujet
 	 * \param     idQuestion     id de la question
 	 * \return 	  Un booleen, si le lien entre le sujet et la question existe ou non
 	 */
	public static function exist_link_exam_question($idExam, $idQuestion)
	{
		if(!(is_null($idExam) || is_null($idQuestion))) {
			$test = false;
			$s = self::$_db->prepare('SELECT * FROM link_exam_question WHERE idExam=:idExam AND idQuestion=:idQuestion');
			$s->bindValue(':idExam', $idExam, PDO::PARAM_INT);
			$s->bindValue(':idQuestion', $idQuestion, PDO::PARAM_INT);
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
 	 * \param     idExam   id du sujet
 	 * \return 	  Toutes les questions en lien avec le sujet
 	 */
	public static function get_exam_questions($idExam)
	{
		if(!(is_null($idExam))) {
			$s = self::$_db->prepare('SELECT * FROM link_exam_question WHERE idExam = :idExam');
			$s->bindValue(':idExam', $idExam, PDO::PARAM_INT);
			$s->execute();
			$questions = array();
			while ($data = $s->fetch(PDO::FETCH_ASSOC)) {
				$questions[] = self::get_by_id($data['idQuestion']);
			}
			return $questions;
		}
	}
}
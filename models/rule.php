<?php

/**
 * \file      models/rule.php
 * \author    Jordan Lang
 * \version   2.0
 * \date      15 novembre 2014
 * \brief     Modèle de règle
 */

require_once 'base.php';

class Rule extends Model_Base
{
	private $_id;

	private $_name;

	private $_mark;

	private $_visible;

	public function __construct($id, $name, $mark, $visible) {
		$this->set_id($id);
		$this->set_name($name);
		$this->set_mark($mark);
		$this->set_visible($visible);
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

	public function visible() {
		return $this->_visible;
	}


	// Setter
	public function set_id($v) {
		$this->_id = (int) $v;
	}

	public function set_name($v) {
		$this->_name = strval($v);
	}

	public function set_mark($v) {
		$this->_mark =  strval($v);
	}

	public function set_visible($v) {
		$this->_visible = (bool) $v;
	}


	/**
 	 * \brief     Insert une règle dans la base rule
 	 * \param     name       nom de la règle
 	 * \param     mark       barème de la règle
 	 * \param     visible    visibilité de la règle
 	 */
	public static function insert($name,$mark,$visible)
	{
		$q = self::$_db->prepare('INSERT INTO rule (name, mark, visible) VALUES (:name, :mark, :visible)');
		$q->bindValue(':name', $name, PDO::PARAM_STR);
		$q->bindValue(':mark', $mark, PDO::PARAM_STR);
		$q->bindValue(':visible', $visible, PDO::PARAM_BOOL);
		$q->execute();
	}

	/**
 	 * \brief     Met à jour la règle concernée
 	 */
	public function save()
	{
		if(!is_null($this->id())) {
			$q = self::$_db->prepare('UPDATE rule SET name=:name, mark=:mark, visible=:visible WHERE id = :id');
			$q->bindValue(':id', $this->id(), PDO::PARAM_INT);
			$q->bindValue(':name', $this->name(), PDO::PARAM_STR);
			$q->bindValue(':mark', $this->mark(), PDO::PARAM_STR);
			$q->bindValue(':visible', $this->visible(), PDO::PARAM_BOOL);
			$q->execute();
		}
	}

	/**
 	 * \brief     Supprime la règle concernée
 	 */
	public function delete()
	{
		if(!is_null($this->id())) {
			$q = self::$_db->prepare('DELETE FROM rule WHERE id = :id');
			$q->bindValue(':id', $this->id());
			$q->execute();
			$this->_id = null;
		}
	}

	/**
 	 * \param     name       nom de la règle
 	 * \return 	  La règle qui correspond au nom
 	 */
	public static function get_by_name($name)
	{
		$s = self::$_db->prepare('SELECT * FROM rule WHERE name = :l');
		$s->bindValue(':l', $name, PDO::PARAM_STR);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new Rule($data['id'], $data['name'], $data['mark'], $data['visible']);
		}
		else {
			return null;
		}
	}

	/**
 	 * \param     id      id de la règle
 	 * \return 	  La règle qui correspond à l'id
 	 */
	public static function get_by_id($id)
	{
		$s = self::$_db->prepare('SELECT * FROM rule WHERE id = :id');
		$s->bindValue(':id', $id, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new Rule($data['id'], $data['name'], $data['mark'], $data['visible']);
		}
		else {
			return null;
		}
	}

	/**
 	 * \brief     Teste l'existence de la règle
 	 * \param     name     nom de la règle
 	 * \return 	  Un booleen, si la règle existe ou non
 	 */
	public static function exist_name($name)
	{
		$test = false;
		$s = self::$_db->prepare('SELECT * FROM rule WHERE name = :l');
		$s->bindValue(':l', $name, PDO::PARAM_STR);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data)
		{
			$test = true;
		}
		return $test;
	}

	/**
 	 * \return 	  Toutes les règles qui sont enregistrées en base
 	 */
	public static function get_all_rule()
	{
		$s = self::$_db->prepare('SELECT * FROM rule');
		$s->execute();
		return $s->fetchAll(PDO::FETCH_ASSOC);
		/*$rules = array();
		while ($data = $s->fetch(PDO::FETCH_ASSOC)) {
			$rules[] = new Rule($data['id'], $data['name'], $data['mark'], $data['visible']);
		}
		return $rules;*/
	}

	//operations sur la table link_question_rule

	/**
 	 * \brief     Insert un lien entre la question et la règle
 	 * \param     idQuestion     id de la question
 	 * \param     idRule         id de la règle
 	 */
	public static function insert_link_question_rule($idQuestion, $idRule)
	{
		if(!(is_null($idQuestion) || is_null($idRule))) {
			$q = self::$_db->prepare('INSERT INTO link_question_rule (idQuestion, idRule) VALUES (:idQuestion, :idRule)');
			$q->bindValue(':idQuestion', $idQuestion, PDO::PARAM_INT);
			$q->bindValue(':idRule', $idRule, PDO::PARAM_INT);
			$q->execute();
		}
	}

	/**
 	 * \brief     Supprime le lien entre la question et la règle
 	 * \param     idQuestion     id de la question
 	 * \param     idRule         id de la règle
 	 */
	public static function delete_link_question_rule($idQuestion, $idRule)
	{
		if(!(is_null($idQuestion) || is_null($idRule))) {
			$q = self::$_db->prepare('DELETE FROM link_question_rule WHERE idQuestion=:idQuestion AND idRule=:idRule');
			$q->bindValue(':idQuestion', $idQuestion, PDO::PARAM_INT);
			$q->bindValue(':idRule', $idRule, PDO::PARAM_INT);
			$q->execute();
			$this->_id = null;
		}
	}

	/**
 	 * \param     idQuestion     id de la question
 	 * \return 	  Toutes les règles qui appartiennent à la question
 	 */
	public static function get_by_question($idQuestion)
	{
		$rules = array();
		$s = self::$_db->prepare('SELECT * FROM link_question_rule WHERE idQuestion = :idQuestion');
		$s->bindValue(':idQuestion', $idQuestion, PDO::PARAM_INT);
		$s->execute();
		while ($data = $s->fetch(PDO::FETCH_ASSOC)) {
			$rules[] = self::get_by_id($data['idRule']);
		}
		return $rules;
	}

	//operations sur la table link_sheet_question_rule

	/**
 	 * \brief     Insert un lien entre la copie et la règle
 	 * \param     idSheet          id de la copie
 	 * \param     idRule           id de la règle
 	 * \param     pointReceived    nombre de points reçus
 	 */
	public static function insert_link_sheet_question_rule($idSheet, $idRule, $pointReceived)
	{
		if(!(is_null($idSheet) || is_null($idRule) || is_null($pointReceived))) {
			$q = self::$_db->prepare('INSERT INTO link_sheet_question_rule (idSheet, idRule, pointReceived) VALUES (:idSheet, :idRule, :pointReceived)');
			$q->bindValue(':idSheet', $idSheet, PDO::PARAM_INT);
			$q->bindValue(':idRule', $idRule, PDO::PARAM_INT);
			$q->bindValue(':pointReceived', $pointReceived, PDO::PARAM_STR);
			$q->execute();
		}
	}

	/**
 	 * \brief     Met à jour le lien entre la copie et la règle
 	 * \param     idSheet          id de la copie
 	 * \param     idRule           id de la règle
 	 * \param     pointReceived    nombre de points reçus
 	 */
	public static function update_link_sheet_question_rule($idSheet, $idRule, $pointReceived)
	{
		if(!(is_null($idSheet) || is_null($idRule) || is_null($pointReceived))) {
			$q = self::$_db->prepare('UPDATE link_sheet_question_rule SET pointReceived=:pointReceived WHERE idSheet=:idSheet AND idRule=:idRule');
			$q->bindValue(':idSheet', $idSheet, PDO::PARAM_INT);
			$q->bindValue(':idRule', $idRule, PDO::PARAM_INT);
			$q->bindValue(':pointReceived', $pointReceived, PDO::PARAM_STR);
			$q->execute();
		}
	}

	/**
 	 * \brief     Teste l'existence du lien entre la copie et la règle
 	 * \param     idSheet          id de la copie
 	 * \param     idRule           id de la règle
 	 * \return 	  Un booleen, si le lien existe ou non
 	 */
	public static function exist_link_sheet_question_rule($idSheet, $idRule)
	{
		if(!(is_null($idSheet) || is_null($idRule))) {
			$test = false;
			$s = self::$_db->prepare('SELECT * FROM link_sheet_question_rule WHERE idSheet=:idSheet AND idRule=:idRule');
			$s->bindValue(':idSheet', $idSheet, PDO::PARAM_INT);
			$s->bindValue(':idRule', $idRule, PDO::PARAM_INT);
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
 	 * \param     idRule           id de la règle
 	 * \return 	  La note attribuée à la règle
 	 */
	public static function get_note_rule($idSheet, $idRule)
	{
		$s = self::$_db->prepare('SELECT * FROM link_sheet_question_rule WHERE idSheet=:idSheet AND idRule=:idRule');
		$s->bindValue(':idSheet', $idSheet, PDO::PARAM_INT);
		$s->bindValue(':idRule', $idRule, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		return $data['pointReceived'];
	}
}

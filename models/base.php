<?php

/**
 * \file      models/base.php
 * \author    Jordan Lang
 * \version   1.0
 * \date      15 novembre 2014
 * \brief     Modèle de connexion à la base
 */

class Model_Base
{
	protected static $_db;

	/**
	 * \brief    Instancie l'objet PDO qui permet la connexion à la base
	 */
	public static function set_db(PDO $db) {
		self::$_db = $db;
	}
}

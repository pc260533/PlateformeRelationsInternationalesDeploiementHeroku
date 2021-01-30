<?php

/**
 * ExceptionAuthentification est la classe qui repr�sente une exception d'authentification.
 *
 * @author Pierre-Nicolas
 */
class ExceptionAuthentification extends ExceptionSerializable {

	/**
	 * Constructeur prennant en param�tre l'exception englob�e.
	 * @param mixed $previous : exeption englob�e.
	 */
	public function __construct() {
		parent::__construct("Le nom d'utilisateur et le mot de passe sont incorrects.", "Erreur mauvais nom d'utilisateur et mot de passe", 500, 500, null, null);
	}

}
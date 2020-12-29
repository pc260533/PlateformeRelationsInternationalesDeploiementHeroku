<?php

/**
 * ExceptionAuthentification short summary.
 *
 * ExceptionAuthentification description.
 *
 * @version 1.0
 * @author Jean-Claude
 */
class ExceptionAuthentification extends ExceptionSerializable {

	/**
	 * Constructeur prennant en param�tre l'exception englob�e.
	 * @param mixed $previous : exption englob�e.
	 */
	public function __construct() {
		parent::__construct("Le nom d'utilisateur et le mot de passe sont incorrects.", "Erreur mauvais nom d'utilisateur et mot de passe", 500, 500, null, null);
	}

}
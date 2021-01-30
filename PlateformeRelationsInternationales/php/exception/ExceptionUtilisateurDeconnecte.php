<?php

/**
 * ExceptionUtilisateurDeconnecte est la classe qui repr�sente une exception de d�connexion du serveur.
 *
 * @author Pierre-Nicolas
 */
class ExceptionUtilisateurDeconnecte extends ExceptionSerializable {

	/**
	 * Constructeur prennant en param�tre l'exception englob�e.
	 * @param mixed $previous : exption englob�e.
	 */
	public function __construct() {
		parent::__construct("Vous avez d�connect� du serveur. Veuillez vous reconnecter.", "D�connexion du serveur", 302, 302, null, null);
	}

}
<?php

/**
 * ExceptionUtilisateurDeconnecte short summary.
 *
 * ExceptionUtilisateurDeconnecte description.
 *
 * @version 1.0
 * @author Jean-Claude
 */
class ExceptionUtilisateurDeconnecte extends ExceptionSerializable {

	/**
	 * Constructeur prennant en param�tre l'exception englob�e.
	 * @param mixed $previous : exption englob�e.
	 */
	public function __construct() {
		parent::__construct("Vous avez d�connect� du serveur. Veuiilez vous reconnecter.", "D�connexion du serveur", 302, 302, null, null);
	}

}
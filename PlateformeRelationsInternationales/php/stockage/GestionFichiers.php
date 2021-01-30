<?php

/**
 *
 * GestionFichiers est la classe repr�sentant un gesitonnaire de fichiers.
 *
 * @version 1.0
 * @author Pierre-Nicolas
 */
class GestionFichiers {

	/**
	 * Constructeur GestionFichiers sans param�tres.
	 */
	public function __construct() {

	}

	/**
	 * Supprimer un fichier.
	 * @param string $cheminFichierASupprimer Le chmein du fichier � supprimer.
	 */
	public function supprimerFichier(string $cheminFichierASupprimer) {
		if (is_file($cheminFichierASupprimer)) {
			unlink($cheminFichierASupprimer);
		}
	}

	/**
	 * Cr�er un dossier.
	 * @param string $cheminDossierACreer Le chemin du dossier � cr�er.
	 */
	public function creerDossier(string $cheminDossierACreer) {
		if (!is_dir($cheminDossierACreer)) {
			mkdir($cheminDossierACreer);
		}
	}

	/**
	 * Suprimer un dossier.
	 * @param string $cheminDossierASupprimer Le chemin du dossier � cr�er.
	 */
	public function supprimerDossier(string $cheminDossierASupprimer) {
		if (is_dir($cheminDossierASupprimer)) {
			rmdir($cheminDossierASupprimer);
		}
	}

}
<?php

/**
 *
 * ControleurAuthentification est la classe repr�sentant un controleur d'authentification.
 * Elle impl�mente l'interface IControleurPlateforme.
 *
 * @version 1.0
 * @author Pierre-Nicolas
 */
class ControleurAuthentification {

	/**
	 * Constructeur ControleurAuthentification sans param�tres.
	 */
	public function __construct() {

	}

	/**
	 * Retourner l'utilisateur en session avec son identifiant.
	 * @param int $identifiantUtilisateur L'identifiant de l'utilisateur � r�cup�rer.
	 * @return null|Utilisateur L'utilisateur r�cup�r�.
	 */
	public function getUtilisateurEnSessionAvecIdentifiantUtilisateur(int $identifiantUtilisateur): Utilisateur {
		$res = null;
		session_start();
		if (isset($_SESSION["listeUtilisateurs"])) {
			foreach ($_SESSION["listeUtilisateurs"] as $utilisateurConnecte) {
				if ($utilisateurConnecte["identifiantUtilisateur"] == $identifiantUtilisateur) {
					$res = new Utilisateur();
					$res->setIdentifiantUtilisateur($utilisateurConnecte["identifiantUtilisateur"]);
					$res->setNomUtilisateur($utilisateurConnecte["nomUtilisateur"]);
					$res->setAdresseMailUtilisateur($utilisateurConnecte["adresseMailUtilisateur"]);
					$res->setEstAdministrateur($utilisateurConnecte["estAdministrateur"]);
				}
			}
		}
		return $res;
	}

	/**
	 * Essayer de connecter un utilisateur en comparant un utilisateur � tester avec son mot de passe et l'utilisateur stock� correspondant.
	 * @param Utilisateur $utilisateurATester L'utilisateur � tester.
	 * @param Utilisateur $utilisateurRecuperer L'utilisateur stock� r�cup�rer.
	 * @throws ExceptionAuthentification L'exception d'authentification.
	 */
	public function connecterUtilisateur(Utilisateur $utilisateurATester, Utilisateur $utilisateurRecuperer): void {
		if (password_verify($utilisateurATester->getMotDePasseUtilisateur(), $utilisateurRecuperer->getMotDePasseUtilisateur())) {
			$utilisateurRecuperer->setMotDePasseUtilisateur("");
			session_start();
			if (!isset($_SESSION["listeUtilisateurs"])) {
				$_SESSION["listeUtilisateurs"] = array();
			}
			$_SESSION["listeUtilisateurs"][] = $utilisateurRecuperer->getObjetSerializable();
		}
		else {
			throw new ExceptionAuthentification();
		}
	}

	/**
	 * Essayer de d�connecter un utilisateur.
	 * @param Utilisateur $utilisateurADeconnecter L'utilisateur � d�connecter.
	 * @throws ExceptionAuthentification L'exception d'authentification.
	 */
	public function deconnecterUtilisateur(Utilisateur $utilisateurADeconnecter): void {
		session_start();
		if (isset($_SESSION["listeUtilisateurs"])) {
			$indexUtilisateurASupprimer = null;
			foreach ($_SESSION["listeUtilisateurs"] as $key => $utilisateurConnecte) {
				if ($utilisateurConnecte["identifiantUtilisateur"] == $utilisateurADeconnecter->getIdentifiantUtilisateur()) {
					$indexUtilisateurASupprimer = $key;
				}
			}
			if (!is_null($indexUtilisateurASupprimer)) {
				unset($_SESSION["listeUtilisateurs"][$indexUtilisateurASupprimer]);
			}
			else {
				throw new ExceptionAuthentification();
			}
		}
		else {
			throw new ExceptionAuthentification();
		}
	}

}
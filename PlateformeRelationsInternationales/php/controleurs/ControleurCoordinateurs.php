<?php

/**
 *
 * ControleurCoordinateurs est la classe repr�sentant un controleur de coordinateurs.
 * Elle impl�mente l'interface IControleurPlateforme.
 *
 * @version 1.0
 * @author Pierre-Nicolas
 */
class ControleurCoordinateurs implements IControleurPlateforme {
	/**
	 * Le stockage de coordinateurs.
	 * @var StockageCoordinateurs
	 */
	private $stockageCoordinateurs;

	/**
	 * Cr�er un coordinateur � partir d'un tableau.
	 * @param array $coordinateurArray Le tableau repr�sentant le coordinateur.
	 * @return Coordinateur Le coordinateur cr��.
	 */
	private function creerCoordinateur(array $coordinateurArray): Coordinateur {
		$coordinateur = new Coordinateur();
		if (isset($coordinateurArray["identifiantContact"])) {
			$coordinateur->setIdentifiantContact($coordinateurArray["identifiantContact"]);
		}
		if (isset($coordinateurArray["nomContact"])) {
			$coordinateur->setNomContact($coordinateurArray["nomContact"]);
		}
		if (isset($coordinateurArray["prenomContact"])) {
			$coordinateur->setPrenomContact($coordinateurArray["prenomContact"]);
		}
		if (isset($coordinateurArray["adresseMailContact"])) {
			$coordinateur->setAdresseMailContact($coordinateurArray["adresseMailContact"]);
		}
		if (isset($coordinateurArray["fonctionContact"])) {
			$coordinateur->setFonctionContact($coordinateurArray["fonctionContact"]);
		}
		return $coordinateur;
	}

	/**
	 * Constructeur ControleurCoordinateurs sans param�tres.
	 */
	public function __construct() {
		$this->stockageCoordinateurs = new StockageCoordinateurs(getVariableEnvironnement("DATASOURCENAME_BASEDEDONNEEPLATEFORME"), getVariableEnvironnement("USERNAME_BASEDEDONNEE"), getVariableEnvironnement("PASSWORD_BASEDEDONNEE"));
	}

	/**
	 * Ajouter un coordinateur.
	 * @param array $coordinateurArray Le tableau repr�snentant le coordinateur.
	 * @return Coordinateur Le coordinateur ajout�.
	 */
	public function ajouterCoordinateur(array $coordinateurArray): Coordinateur {
		$coordinateur = $this->creerCoordinateur($coordinateurArray);
		$this->stockageCoordinateurs->ajouterCoordinateur($coordinateur);
		return $coordinateur;
	}

	/**
	 * Supprimer un coordinateur.
	 * @param array $coordinateurArray Le tableau repr�snentant le coordinateur.
	 * @return Coordinateur Le coordinateur supprim�.
	 */
	public function supprimerCoordinateur(array $coordinateurArray): Coordinateur {
		$coordinateur = $this->creerCoordinateur($coordinateurArray);
		$this->stockageCoordinateurs->supprimerCoordinateur($coordinateur);
		return $coordinateur;
	}

	/**
	 * Modifier un coordinateur.
	 * @param array $coordinateurArray Le tableau repr�snentant le coordinateur.
	 * @return Coordinateur Le coordinateur modifi�.
	 */
	public function modifierCoordinateur(array $coordinateurArray): Coordinateur {
		$coordinateur = $this->creerCoordinateur($coordinateurArray);
		$this->stockageCoordinateurs->modifierCoordinateur($coordinateur);
		return $coordinateur;
	}

	/**
	 * Retourne rla liste des cooridnateurs.
	 * @return array La liste des coordianteurs.
	 */
	public function chargerListeCoordinateurs(): array {
		return $this->stockageCoordinateurs->chargerListeCoordinateurs();
	}
}
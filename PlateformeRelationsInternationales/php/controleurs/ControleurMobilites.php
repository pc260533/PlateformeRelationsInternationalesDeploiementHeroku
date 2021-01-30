<?php

/**
 *
 * ControleurMobilites est la classe repr�sentant un controleur de mobilit�s.
 * Elle impl�mente l'interface IControleurPlateforme.
 *
 * @version 1.0
 * @author Pierre-Nicolas
 */
class ControleurMobilites implements IControleurPlateforme {
	/**
	 * Le stockage de mobilit�s.
	 * @var StockageMobilites
	 */
	private $stockageMobilites;

	/**
	 * Cr�er une mobilit� � partir d'un tableau.
	 * @param array $mobiliteArray Le tableau repr�sentant une mobilit�.
	 * @return Mobilite La mobilit� cr��e.
	 */
	private function creerMobilite(array $mobiliteArray): Mobilite {
		$mobilite = new Mobilite();
		if (isset($mobiliteArray["identifiantMobilite"])) {
			$mobilite->setIdentifiantMobilite($mobiliteArray["identifiantMobilite"]);
		}
		if (isset($mobiliteArray["typeMobilite"])) {
			$mobilite->setTypeMobilite($mobiliteArray["typeMobilite"]);
		}
		return $mobilite;
	}

	/**
	 * Constructeur ControleurMobilites sans param�tres.
	 */
	public function __construct() {
		$this->stockageMobilites = new StockageMobilites(getVariableEnvironnement("DATASOURCENAME_BASEDEDONNEEPLATEFORME"), getVariableEnvironnement("USERNAME_BASEDEDONNEE"), getVariableEnvironnement("PASSWORD_BASEDEDONNEE"));
	}

	/**
	 * Ajouter une mobilit�.
	 * @param array $mobiliteArray Le tableau repr�sentant une mobilit�.
	 * @return Mobilite La mobilit� ajout�.
	 */
	public function ajouterMobilite(array $mobiliteArray): Mobilite {
		$mobilite = $this->creerMobilite($mobiliteArray);
		$this->stockageMobilites->ajouterMobilite($mobilite);
		return $mobilite;
	}

	/**
	 * Supprimer une mobilit�.
	 * @param array $mobiliteArray Le tableau repr�sentant une mobilit�.
	 * @return Mobilite La mobilit� supprim�.
	 */
	public function supprimerMobilite(array $mobiliteArray): Mobilite {
		$mobilite = $this->creerMobilite($mobiliteArray);
		$this->stockageMobilites->supprimerMobilite($mobilite);
		return $mobilite;
	}

	/**
	 * Modifier une mobilit�.
	 * @param array $mobiliteArray Le tableau repr�sentant une mobilit�.
	 * @return Mobilite La mobilit� modifi�.
	 */
	public function modifierMobilite(array $mobiliteArray): Mobilite {
		$mobilite = $this->creerMobilite($mobiliteArray);
		$this->stockageMobilites->modifierMobilite($mobilite);
		return $mobilite;
	}

	/**
	 * Retourner la liste des mobilit�s.
	 * @return array La liste des mobilit�s.
	 */
	public function chargerListeMobilites(): array {
		return  $this->stockageMobilites->chargerListeMobilites();
	}
}
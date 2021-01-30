<?php

/**
 *
 * ControleurAidesFinancieres est la classe repr�sentant un controleur d'aides financi�res.
 * Elle impl�mente l'interface IControleurPlateforme.
 *
 * @version 1.0
 * @author Pierre-Nicolas
 */
class ControleurAidesFinancieres implements IControleurPlateforme {
	/**
	 * Le stockage d'aides financi�res associ�s.
	 * @var StockageAidesFinancieres
	 */
	private $stockageAidesFinancieres;

	/**
	 * Cr�er une aide financi�re � partir d'un tableau.
	 * @param array $aideFinanciereArray Le tableau repr�sentant l'aide financi�re.
	 * @return AideFinanciere L'aide financi�re cr��e.
	 */
	private function creerAideFinanciere(array $aideFinanciereArray): AideFinanciere {
		$aideFinanciere = new AideFinanciere();
		if (isset($aideFinanciereArray["identifiantAideFinanciere"])) {
			$aideFinanciere->setIdentifiantAideFinanciere($aideFinanciereArray["identifiantAideFinanciere"]);
		}
		if (isset($aideFinanciereArray["nomAideFinanciere"])) {
			$aideFinanciere->setNomAideFinanciere($aideFinanciereArray["nomAideFinanciere"]);
		}
		if (isset($aideFinanciereArray["descriptionAideFinanciere"])) {
			$aideFinanciere->setDescriptionAideFinanciere($aideFinanciereArray["descriptionAideFinanciere"]);
		}
		if (isset($aideFinanciereArray["lienAideFinanciere"])) {
			$aideFinanciere->setLienAideFinanciere($aideFinanciereArray["lienAideFinanciere"]);
		}
		return $aideFinanciere;
	}

	/**
	 * Constructeur AideFinanciere sans param�tres.
	 */
	public function __construct() {
		$this->stockageAidesFinancieres = new StockageAidesFinancieres(getVariableEnvironnement("DATASOURCENAME_BASEDEDONNEEPLATEFORME"), getVariableEnvironnement("USERNAME_BASEDEDONNEE"), getVariableEnvironnement("PASSWORD_BASEDEDONNEE"));
	}

	/**
	 * Ajouter une aide financi�re.
	 * @param array $aideFinanciereArray Le tableau repr�sentant l'aide financi�re.
	 * @return AideFinanciere L'aide financi�re ajout�e.
	 */
	public function ajouterAideFinanciere(array $aideFinanciereArray): AideFinanciere {
		$aideFinanciere = $this->creerAideFinanciere($aideFinanciereArray);
		$this->stockageAidesFinancieres->ajouterAideFinanciere($aideFinanciere);
		return $aideFinanciere;
	}

	/**
	 * Supprimer une aide financi�re.
	 * @param array $aideFinanciereArray Le tableau repr�sentant l'aide financi�re.
	 * @return AideFinanciere L'aide financi�re supprim�e.
	 */
	public function supprimerAideFinanciere(array $aideFinanciereArray): AideFinanciere {
		$aideFinanciere = $this->creerAideFinanciere($aideFinanciereArray);
		$this->stockageAidesFinancieres->supprimerAideFinanciere($aideFinanciere);
		return $aideFinanciere;
	}

	/**
	 * Modifier une aide financi�re.
	 * @param array $aideFinanciereArray Le tableau repr�sentant l'aide financi�re.
	 * @return AideFinanciere L'aide financi�re modifi�e.
	 */
	public function modifierAideFinanciere(array $aideFinanciereArray): AideFinanciere {
		$aideFinanciere = $this->creerAideFinanciere($aideFinanciereArray);
		$this->stockageAidesFinancieres->modifierAideFinanciere($aideFinanciere);
		return $aideFinanciere;
	}

	/**
	 * Retourner la liste des aides financi�res.
	 * @return array La liste des aides financi�res.
	 */
	public function chargerListeAidesFinancieres(): array {
		return $this->stockageAidesFinancieres->chargerListeAidesFinancieres();
	}

}
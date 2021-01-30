<?php

/**
 *
 * ControleurSpecialites est la classe repr�sentant un controleur de sp�cialit�s.
 * Elle impl�mente l'interface IControleurPlateforme.
 *
 * @version 1.0
 * @author Pierre-Nicolas
 */
class ControleurSpecialites implements IControleurPlateforme {
	/**
	 * Le stockage de sp�cialit�s.
	 * @var StockageSpecialites
	 */
	private $stockageSpecialites;

	/**
	 * Cr�er une sp�cialit� � partir d'un tableau.
	 * @param array $specialiteArray Le tableau repr�sentant une sp�cialit�.
	 * @return Specialite La sp�cialit� cr��e.
	 */
	private function creerSpecialite(array $specialiteArray): Specialite {
		$specialite = new Specialite();
		if (isset($specialiteArray["identifiantSpecialite"])) {
			$specialite->setIdentifiantSpecialite($specialiteArray["identifiantSpecialite"]);
		}
		if (isset($specialiteArray["nomSpecialite"])) {
			$specialite->setNomSpecialite($specialiteArray["nomSpecialite"]);
		}
		if (isset($specialiteArray["couleurSpecialite"])) {
			$specialite->setCouleurSpecialite($specialiteArray["couleurSpecialite"]);
		}
		if (isset($specialiteArray["listeSousSpecialites"])) {
			foreach ($specialiteArray["listeDomainesDeCompetencesPartenaire"] as $sousSpecialiteArray) {
				$specialite->ajouterSousSpecialite($this->creerSousSpecialite($sousSpecialiteArray));
			}
		}
		return $specialite;
	}

	/**
	 * Cr�er une sous sp�cialit� � partir d'un tableau.
	 * @param array $sousSpecialiteArray Le tableau repr�sentant la sous sp�cialit�.
	 * @return SousSpecialite La sous sp�cialit� cr��e.
	 */
	private function creerSousSpecialite(array $sousSpecialiteArray): SousSpecialite {
		$sousSpecialite = new SousSpecialite();
		if (isset($sousSpecialiteArray["identifiantSousSpecialite"])) {
			$sousSpecialite->setIdentifiantSousSpecialite($sousSpecialiteArray["identifiantSousSpecialite"]);
		}
		if (isset($sousSpecialiteArray["nomSousSpecialite"])) {
			$sousSpecialite->setNomSousSpecialite($sousSpecialiteArray["nomSousSpecialite"]);
		}
		return $sousSpecialite;
	}

	/**
	 * Constructeur ControleurSpecialites sans param�tres.
	 */
	public function __construct() {
		$this->stockageSpecialites = new StockageSpecialites(getVariableEnvironnement("DATASOURCENAME_BASEDEDONNEEPLATEFORME"), getVariableEnvironnement("USERNAME_BASEDEDONNEE"), getVariableEnvironnement("PASSWORD_BASEDEDONNEE"));
	}

	/**
	 * Ajouter une sp�cialit�.
	 * @param array $specialiteArray Le tableau repr�sentant une sp�cialit�.
	 * @return Specialite La sp�cialit� ajout�e.
	 */
	public function ajouterSpecialite(array $specialiteArray): Specialite {
		$specialite = $this->creerSpecialite($specialiteArray);
		$this->stockageSpecialites->ajouterSpecialite($specialite);
		return $specialite;
	}

	/**
	 * Supprimer une sp�cialit�.
	 * @param array $specialiteArray Le tableau repr�sentant une sp�cialit�.
	 * @return Specialite La sp�cialit� supprim�e.
	 */
	public function supprimerSpecialite(array $specialiteArray): Specialite {
		$specialite = $this->creerSpecialite($specialiteArray);
		$this->stockageSpecialites->supprimerSpecialite($specialite);
		return $specialite;
	}

	/**
	 * Modifier une sp�cialit�.
	 * @param array $specialiteArray Le tableau repr�sentant une sp�cialit�.
	 * @return Specialite La sp�cialit� modifi�e.
	 */
	public function modifierSpecialite(array $specialiteArray): Specialite {
		$specialite = $this->creerSpecialite($specialiteArray);
		$this->stockageSpecialites->modifierSpecialite($specialite);
		return $specialite;
	}

	/**
	 * Ajouter une sous sp�cialit� dans une sp�cialit�.
	 * @param array $specialite Le tableau rep�sentant une sp�cialit�.
	 * @param array $sousSpecialiteArray Le tableau rep�sentant une sous sp�cialit�.
	 * @return SousSpecialite La sous sp�cialit� ajout�e.
	 */
	public function ajouterSousSpecialite(array $specialite, array $sousSpecialiteArray): SousSpecialite {
		$specialite = $this->creerSpecialite($specialite);
		$sousSpecialite = $this->creerSousSpecialite($sousSpecialiteArray);
		$this->stockageSpecialites->ajouterSousSpecialite($specialite, $sousSpecialite);
		return $sousSpecialite;
	}

	/**
	 * Supprimer une sous sp�cialit�.
	 * @param array $sousSpecialiteArray Le tableau repr�sentant une sous sp�cialit�.
	 * @return SousSpecialite La sous sp�cialit� supprim�e.
	 */
	public function supprimerSousSpecialite(array $sousSpecialiteArray): SousSpecialite {
		$sousSpecialite = $this->creerSousSpecialite($sousSpecialiteArray);
		$this->stockageSpecialites->supprimerSousSpecialite($sousSpecialite);
		return $sousSpecialite;
	}

	/**
	 * Supprimer une sous sp�cialit� dans une sp�cialit�.
	 * @param array $specialite Le tableau rep�sentant une sp�cialit�.
	 * @param array $sousSpecialiteArray Le tableau rep�sentant une sous sp�cialit�.
	 * @return SousSpecialite La sous sp�cialit� supprim�e.
	 */
	public function modifierSousSpecialite(array $specialite, array $sousSpecialiteArray): SousSpecialite {
		$specialite = $this->creerSpecialite($specialite);
		$sousSpecialite = $this->creerSousSpecialite($sousSpecialiteArray);
		$this->stockageSpecialites->modifierSousSpecialite($specialite, $sousSpecialite);
		return $sousSpecialite;
	}

	/**
	 * Retourner la liste des sp�cialit�s et des sous sp�cialit�s.
	 * @return array La liste des sp�cialit�s et des sous sp�cialit�s.
	 */
	public function chargerListeSpecialites(): array {
		return $this->stockageSpecialites->chargerListeSpecialites();
	}
}
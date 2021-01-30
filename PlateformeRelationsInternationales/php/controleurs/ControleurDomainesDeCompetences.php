<?php

/**
 *
 * ControleurDomainesDeCompetences est la classe repr�sentant un controleur de domaines de competences.
 * Elle impl�mente l'interface IControleurPlateforme.
 *
 * @version 1.0
 * @author Pierre-Nicolas
 */
class ControleurDomainesDeCompetences implements IControleurPlateforme {
	/**
	 * Le stockage de domaines de comp�tences.
	 * @var StockageDomainesDeCompetences
	 */
	private $stockageDomainesDeCompetences;

	/**
	 * Cr�er un domaine de comp�tence � partir d'un tableau.
	 * @param array $domaineDeCompetenceArray Le tableau repr�sentant un domaine de comp�tence.
	 * @return DomaineDeCompetence Le domaine de comp�tence cr��.
	 */
	private function creerDomaineDeCompetence(array $domaineDeCompetenceArray): DomaineDeCompetence {
		$domaineDeCompetence = new DomaineDeCompetence();
		if (isset($domaineDeCompetenceArray["identifiantDomaineDeCompetence"])) {
			$domaineDeCompetence->setIdentifiantDomaineDeCompetence($domaineDeCompetenceArray["identifiantDomaineDeCompetence"]);
		}
		if (isset($domaineDeCompetenceArray["nomDomaineDeCompetence"])) {
			$domaineDeCompetence->setNomDomaineDeCompetence($domaineDeCompetenceArray["nomDomaineDeCompetence"]);
		}
		return $domaineDeCompetence;
	}

	/**
	 * Constructeur ControleurDomainesDeCompetences sans param�tres.
	 */
	public function __construct() {
		$this->stockageDomainesDeCompetences = new StockageDomainesDeCompetences(getVariableEnvironnement("DATASOURCENAME_BASEDEDONNEEPLATEFORME"), getVariableEnvironnement("USERNAME_BASEDEDONNEE"), getVariableEnvironnement("PASSWORD_BASEDEDONNEE"));
	}

	/**
	 * Ajouter un domaine de comp�tence.
	 * @param array $domaineDeCompetenceArray Le tableau repr�sentant un doamine de comp�tence.
	 * @return DomaineDeCompetence Le domaine de comp�tence ajout�.
	 */
	public function ajouterDomaineDeCompetence(array $domaineDeCompetenceArray): DomaineDeCompetence {
		$domaineDeCompetence = $this->creerDomaineDeCompetence($domaineDeCompetenceArray);
		$this->stockageDomainesDeCompetences->ajouterDomaineDeCompetence($domaineDeCompetence);
		return $domaineDeCompetence;
	}

	/**
	 * Supprimer un domaine de comp�tence.
	 * @param array $domaineDeCompetenceArray Le tableau repr�sentant un doamine de comp�tence.
	 * @return DomaineDeCompetence Le domaine de comp�tence supprim�.
	 */
	public function supprimerDomaineDeCompetence(array $domaineDeCompetenceArray): DomaineDeCompetence {
		$domaineDeCompetence = $this->creerDomaineDeCompetence($domaineDeCompetenceArray);
		$this->stockageDomainesDeCompetences->supprimerDomaineDeCompetence($domaineDeCompetence);
		return $domaineDeCompetence;
	}

	/**
	 * Modifier un domaine de comp�tence.
	 * @param array $domaineDeCompetenceArray Le tableau repr�sentant un doamine de comp�tence.
	 * @return DomaineDeCompetence Le domaine de comp�tence modifi�.
	 */
	public function modifierDomaineDeCompetence(array $domaineDeCompetenceArray): DomaineDeCompetence {
		$domaineDeCompetence = $this->creerDomaineDeCompetence($domaineDeCompetenceArray);
		$this->stockageDomainesDeCompetences->modifierDomaineDeCompetence($domaineDeCompetence);
		return $domaineDeCompetence;
	}

	/**
	 * Retourner la liste des domaines de comp�tences.
	 * @return array La liste des domaines de comp�tences.
	 */
	public function chargerListeDomainesDeCompetences(): array {
		return  $this->stockageDomainesDeCompetences->chargerListeDomainesDeCompetences();
	}

}
<?php

/**
 *
 * ControleurCouts est la classe repr�sentant un controleur de couts.
 * Elle impl�mente l'interface IControleurPlateforme.
 *
 * @version 1.0
 * @author Pierre-Nicolas
 */
class ControleurCouts implements IControleurPlateforme {
	/**
	 * Le stockage de couts.
	 * @var StockageCouts
	 */
	private $stockageCout;

	/**
	 * Cr�er un cout � partir d'un tableau.
	 * @param array $coutArray Le tableau repr�sentant un cout.
	 * @return Cout Le cout cr��.
	 */
	private function creerCout(array $coutArray): Cout {
		$cout = new Cout();
		if (isset($coutArray["identifiantCout"])) {
			$cout->setIdentifiantCout($coutArray["identifiantCout"]);
		}
		if (isset($coutArray["nomPaysCout"])) {
			$cout->setNomPaysCout($coutArray["nomPaysCout"]);
		}
		if (isset($coutArray["coutMoyenParMois"])) {
			$cout->setCoutMoyenParMois($coutArray["coutMoyenParMois"]);
		}
		if (isset($coutArray["coutLogementParMois"])) {
			$cout->setCoutLogementParMois($coutArray["coutLogementParMois"]);
		}
		if (isset($coutArray["coutVieParMois"])) {
			$cout->setCoutVieParMois($coutArray["coutVieParMois"]);
		}
		if (isset($coutArray["coutInscriptionParMois"])) {
			$cout->setCoutInscriptionParMois($coutArray["coutInscriptionParMois"]);
		}
		return $cout;
	}

	/**
	 * Constructeur ControleurCouts sans parma�tres.
	 */
	public function __construct() {
		$this->stockageCout = new StockageCouts(getVariableEnvironnement("DATASOURCENAME_BASEDEDONNEEPLATEFORME"), getVariableEnvironnement("USERNAME_BASEDEDONNEE"), getVariableEnvironnement("PASSWORD_BASEDEDONNEE"));
	}

	/**
	 * Ajouter un cout.
	 * @param array $coutArray Le tableau repr�sentant un cout.
	 * @return Cout Le cout ajout�.
	 */
	public function ajouterCout(array $coutArray): Cout {
		$cout = $this->creerCout($coutArray);
		$this->stockageCout->ajouterCout($cout);
		return $cout;
	}

	/**
	 * Modifier un cout.
	 * @param array $coutArray Le tableau repr�sentant un cout.
	 * @return Cout Le cout modifie.
	 */
	public function modifierCout(array $coutArray): Cout {
		$cout = $this->creerCout($coutArray);
		$this->stockageCout->modifierCout($cout);
		return $cout;
	}

	/**
	 * Retourner la liste des couts.
	 * @return array La liste des couts.
	 */
	public function chargerListeCouts(): array {
		return $this->stockageCout->chargerListeCouts();
	}

}
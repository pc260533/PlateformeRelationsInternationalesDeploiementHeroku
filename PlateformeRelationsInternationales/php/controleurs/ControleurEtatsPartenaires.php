<?php

/**
 *
 * ControleurEtatsPartenaires est la classe repr�sentant un controleur d'�tats partenaire.
 * Elle impl�mente l'interface IControleurPlateforme.
 *
 * @version 1.0
 * @author Pierre-Nicolas
 */
class ControleurEtatsPartenaires implements IControleurPlateforme {
	/**
	 * Le stockage des �tats partenaires.
	 * @var StockageEtatsPartenaires
	 */
	private $stockageEtatsPartenaires;

	/**
	 * Cr�er un �tat partenaire � partir d'un tableau.
	 * @param array $etatPartenaireArray  Le tableau repr�sentant un �tat partenaire.
	 * @return EtatPartenaire L'�tat partenaire cr��.
	 */
	private function creerEtatPartenaire(array $etatPartenaireArray): EtatPartenaire {
		$etatPartenaire = new EtatPartenaire();
		if (isset($etatPartenaireArray["identifiantEtatPartenaire"])) {
			$etatPartenaire->setIdentifiantEtatPartenaire($etatPartenaireArray["identifiantEtatPartenaire"]);
		}
		if (isset($etatPartenaireArray["nomEtatPartenaire"])) {
			$etatPartenaire->setNomEtatPartenaire($etatPartenaireArray["nomEtatPartenaire"]);
		}
		return $etatPartenaire;
	}

	/**
	 * Constructeur ControleurEtatsPartenaires sans param�tres.
	 */
	public function __construct() {
		$this->stockageEtatsPartenaires = new StockageEtatsPartenaires(getVariableEnvironnement("DATASOURCENAME_BASEDEDONNEEPLATEFORME"), getVariableEnvironnement("USERNAME_BASEDEDONNEE"), getVariableEnvironnement("PASSWORD_BASEDEDONNEE"));
	}

	/**
	 * Ajouter un �tat partenaire.
	 * @param array $etatPartenaireArray Le tableau repr�sentnant un �tat partenaire.
	 * @return EtatPartenaire L'�tat partenaire ajout�.
	 */
	public function ajouterEtatPartenaire(array $etatPartenaireArray): EtatPartenaire {
		$etatPartenaire = $this->creerEtatPartenaire($etatPartenaireArray);
		$this->stockageEtatsPartenaires->ajouterEtatPartenaire($etatPartenaire);
		return $etatPartenaire;
	}

	/**
	 * Supprimer un �tat partenaire.
	 * @param array $etatPartenaireArray Le tableau repr�sentnant un �tat partenaire.
	 * @return EtatPartenaire L'�tat partenaire supprim�.
	 */
	public function supprimerEtatPartenaire(array $etatPartenaireArray): EtatPartenaire {
		$etatPartenaire = $this->creerEtatPartenaire($etatPartenaireArray);
		$this->stockageEtatsPartenaires->supprimerEtatPartenaire($etatPartenaire);
		return $etatPartenaire;
	}

	/**
	 * Modifier un �tat partenaire.
	 * @param array $etatPartenaireArray Le tableau repr�sentnant un �tat partenaire.
	 * @return EtatPartenaire L'�tat partenaire modifi�.
	 */
	public function modifierEtatPartenaire(array $etatPartenaireArray): EtatPartenaire {
		$etatPartenaire = $this->creerEtatPartenaire($etatPartenaireArray);
		$this->stockageEtatsPartenaires->modifierEtatPartenaire($etatPartenaire);
		return $etatPartenaire;
	}

	/**
	 * Retourner la liste des �tats partenaires.
	 * @return array La liste des �tats partenaires.
	 */
	public function chargerListeEtatsPartenaires(): array {
		return $this->stockageEtatsPartenaires->chargerListeEtatsPartenaires();
	}
}
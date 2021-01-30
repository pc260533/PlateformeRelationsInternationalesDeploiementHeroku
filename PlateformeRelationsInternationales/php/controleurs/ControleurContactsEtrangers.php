<?php

/**
 *
 * ControleurContactsEtrangers est la classe repr�sentant un controleur de contacts �trangers.
 * Elle impl�mente l'interface IControleurPlateforme.
 *
 * @version 1.0
 * @author Pierre-Nicolas
 */
class ControleurContactsEtrangers implements IControleurPlateforme {
	/**
	 * Le stockage de contacts �trangers.
	 * @var StockageContactsEtrangers
	 */
	private $stockageContactsEtrangers;

	/**
	 * Cr�er un contact �tranger � partir d'un tableau.
	 * @param array $contactEtrangerArray Le tablea repr�sentant le contact �tranger.
	 * @return ContactEtranger Le contact �tranger cr��.
	 */
	private function creerContactEtranger(array $contactEtrangerArray): ContactEtranger {
		$contactEtranger = new ContactEtranger();
		if (isset($contactEtrangerArray["identifiantContact"])) {
			$contactEtranger->setIdentifiantContact($contactEtrangerArray["identifiantContact"]);
		}
		if (isset($contactEtrangerArray["nomContact"])) {
			$contactEtranger->setNomContact($contactEtrangerArray["nomContact"]);
		}
		if (isset($contactEtrangerArray["prenomContact"])) {
			$contactEtranger->setPrenomContact($contactEtrangerArray["prenomContact"]);
		}
		if (isset($contactEtrangerArray["adresseMailContact"])) {
			$contactEtranger->setAdresseMailContact($contactEtrangerArray["adresseMailContact"]);
		}
		if (isset($contactEtrangerArray["fonctionContact"])) {
			$contactEtranger->setFonctionContact($contactEtrangerArray["fonctionContact"]);
		}
		return $contactEtranger;
	}

	/**
	 * Constructeur ControleurContactsEtrangers sans param�tres.
	 */
	public function __construct() {
		$this->stockageContactsEtrangers = new StockageContactsEtrangers(getVariableEnvironnement("DATASOURCENAME_BASEDEDONNEEPLATEFORME"), getVariableEnvironnement("USERNAME_BASEDEDONNEE"), getVariableEnvironnement("PASSWORD_BASEDEDONNEE"));
	}

	/**
	 * Ajouter un contact �tranger.
	 * @param array $contactEtrangerArray Le tableau repr�sentant le contact �tranger.
	 * @return ContactEtranger Le contatc �tranger ajout�.
	 */
	public function ajouterContactEtrange(array $contactEtrangerArray): ContactEtranger {
		$contactEtranger = $this->creerContactEtranger($contactEtrangerArray);
		$this->stockageContactsEtrangers->ajouterContactEtranger($contactEtranger);
		return $contactEtranger;
	}

	/**
	 * Supprimer un contact �tranger.
	 * @param array $contactEtrangerArray Le tableau repr�sentant le contact �tranger.
	 * @return ContactEtranger Le contatc �tranger supprim�.
	 */
	public function supprimerContactEtrange(array $contactEtrangerArray): ContactEtranger {
		$contactEtranger = $this->creerContactEtranger($contactEtrangerArray);
		$this->stockageContactsEtrangers->supprimerContactEtranger($contactEtranger);
		return $contactEtranger;
	}

	/**
	 * Modifier un contact �tranger.
	 * @param array $contactEtrangerArray Le tableau repr�sentant le contact �tranger.
	 * @return ContactEtranger Le contatc �tranger modifi�.
	 */
	public function modifierContactEtrange(array $contactEtrangerArray): ContactEtranger {
		$contactEtranger = $this->creerContactEtranger($contactEtrangerArray);
		$this->stockageContactsEtrangers->modifierContactEtranger($contactEtranger);
		return $contactEtranger;
	}

	/**
	 * Retourner la liste des contacts �trangers.
	 * @return array La liste des contacts �trangers.
	 */
	public function chargerListeContactsEtrangers(): array {
		return $this->stockageContactsEtrangers->chargerListeContactsEtrangers();
	}
}
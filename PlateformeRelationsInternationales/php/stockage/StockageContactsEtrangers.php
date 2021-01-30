<?php

/**
 *
 * StockageContactsEtrangers est la classe fournissant l'acc�s aux contacts �trangers de la base de donn�es Plateforme.
 * Elle h�rite de StockageContacts.
 *
 * @version 1.0
 * @author Pierre-Nicolas
 */
class StockageContactsEtrangers extends StockageContacts  {

	/**
	 * Constructeur StockageContactsEtrangers prenant en param�tre le dataSourceName, le nom d'utilisateur et le mot de passe de la base de donn�es.
	 * @param string $dataSourceName Le dataSourceName de la base de donn�es.
	 * @param string $username Le nom d'utilisateur de la base de donn�es.
	 * @param string $password Le mot de passe de la base de donn�es.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function __construct(string $dataSourceName, string $username, string $password) {
		parent::__construct($dataSourceName, $username, $password);
	}

	/**
	 * Ajouter un contact �tranger.
	 * @param ContactEtranger $contactEtranger Le contact �tranger � ajouter.
	 */
	public function ajouterContactEtranger(ContactEtranger $contactEtranger): void {
		$this->ajouterContact($contactEtranger, false);
	}

	/**
	 * Supprimer un contact �tranger.
	 * @param ContactEtranger $contactEtranger Le contact �tranger � supprimer.
	 */
	public function supprimerContactEtranger(ContactEtranger $contactEtranger): void {
		$this->supprimerContact($contactEtranger);
	}

	/**
	 * Modifier un contact �tranger.
	 * @param ContactEtranger $contactEtranger Le contact �tranger � modifier.
	 */
	public function modifierContactEtranger(ContactEtranger $contactEtranger): void {
		$this->modifierContact($contactEtranger);
	}

	/**
	 * Retourner la liste des contacts �trangers.
	 * @return array La liste des contacts �trangers.
	 */
	public function chargerListeContactsEtrangers(): array {
		return $this->chargerListeContactsContactsEtrangers();
	}

}
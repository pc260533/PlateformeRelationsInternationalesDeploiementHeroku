<?php

/**
 *
 * StockageCoordinateurs est la classe fournissant l'acc�s aux coordinateurs de la base de donn�es Plateforme.
 * Elle h�rite de StockageContacts.
 *
 * @version 1.0
 * @author Pierre-Nicolas
 */
class StockageCoordinateurs extends StockageContacts  {

	/**
	 * Constructeur StockageCoordinateurs prenant en param�tre le dataSourceName, le nom d'utilisateur et le mot de passe de la base de donn�es.
	 * @param string $dataSourceName Le dataSourceName de la base de donn�es.
	 * @param string $username Le nom d'utilisateur de la base de donn�es.
	 * @param string $password Le mot de passe de la base de donn�es.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function __construct(string $dataSourceName, string $username, string $password) {
		parent::__construct($dataSourceName, $username, $password);
	}

	/**
	 * Ajouter un coordinateur.
	 * @param Coordinateur $coordinateur Le coordinateur � ajouter.
	 */
	public function ajouterCoordinateur(Coordinateur $coordinateur): void {
		$this->ajouterContact($coordinateur, true);
	}

	/**
	 * Supprimer un coordinateur.
	 * @param Coordinateur $coordinateur Le coordinateur � supprimer.
	 */
	public function supprimerCoordinateur(Coordinateur $coordinateur): void {
		$this->supprimerContact($coordinateur);
	}

	/**
	 * Modifier un coordinateur.
	 * @param Coordinateur $coordinateur Le coordinateur � modifier.
	 */
	public function modifierCoordinateur(Coordinateur $coordinateur): void {
		$this->modifierContact($coordinateur);
	}

	/**
	 * Retoruner la liste des coordinateurs.
	 * @return array La liste des coordinateurs.
	 */
	public function chargerListeCoordinateurs(): array {
		return $this->chargerListeContactsCoordinateurs();
	}

}
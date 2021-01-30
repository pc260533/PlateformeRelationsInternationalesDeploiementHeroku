<?php

/**
 *
 * StockageAidesFinancieres est la classe fournissant l'acc�s aux aides financi�res de la base de donn�es Plateforme.
 * Elle h�rite de StockageBaseDeDonnees.
 *
 * @version 1.0
 * @author Pierre-Nicolas
 */
class StockageAidesFinancieres extends StockageBaseDeDonnees {

	/**
	 * Constructeur StockageAidesFinancieres prenant en param�tre le dataSourceName, le nom d'utilisateur et le mot de passe de la base de donn�es.
	 * @param string $dataSourceName Le dataSourceName de la base de donn�es.
	 * @param string $username Le nom d'utilisateur de la base de donn�es.
	 * @param string $password Le mot de passe de la base de donn�es.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function __construct(string $dataSourceName, string $username, string $password) {
		parent::__construct($dataSourceName, $username, $password);
	}

	/**
	 * Ajouter une aide financi�re.
	 * @param AideFinanciere $aideFinanciere L'aide financi�re � ajouter.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function ajouterAideFinanciere(AideFinanciere $aideFinanciere): void {
		try {
			$this->pdo->beginTransaction();
			$requete = "INSERT INTO AIDEFINANCIERE(NOMAIDEFINANCIERE, DESCRIPTIONAIDEFINANCIERE, LIENAIDEFINANCIERE) VALUES (:nomaidefinanciere, :descriptionaidefinanciere, :lienaidefinanciere);";
			$statement = $this->pdo->prepare($requete);
			$statement->bindValue(":nomaidefinanciere", $aideFinanciere->getNomAideFinanciere(), PDO::PARAM_STR);
			$statement->bindValue(":descriptionaidefinanciere", $aideFinanciere->getDescriptionAideFinanciere(), PDO::PARAM_STR);
			$statement->bindValue(":lienaidefinanciere", $aideFinanciere->getLienAideFinanciere(), PDO::PARAM_STR);
			$statement->execute();
			$aideFinanciere->setIdentifiantAideFinanciere(intval($this->pdo->lastInsertId()));
			$this->pdo->commit();
		}
		catch (PDOException $exception) {
			$this->pdo->rollBack();
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

	/**
	 * Supprimer une aide financi�re.
	 * @param AideFinanciere $aideFinanciere L'aide financi�re � supprimer.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function supprimerAideFinanciere(AideFinanciere $aideFinanciere): void {
		try {
			$this->pdo->beginTransaction();
			$requete = "DELETE FROM AIDEFINANCIERE " .
					   "WHERE IDENTIFIANTAIDEFINANCIERE= :identifiantaidefinanciere;";
			$statement = $this->pdo->prepare($requete);
			$statement->bindValue(":identifiantaidefinanciere", $aideFinanciere->getIdentifiantAideFinanciere(), PDO::PARAM_INT);
			$statement->execute();
			$this->pdo->commit();
		}
		catch (PDOException $exception) {
			$this->pdo->rollBack();
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

	/**
	 * Modifier une aide financi�re.
	 * @param AideFinanciere $aideFinanciere L'aide financi�re � modifier.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function modifierAideFinanciere(AideFinanciere $aideFinanciere): void {
		try {
			$this->pdo->beginTransaction();
			$requete = "UPDATE AIDEFINANCIERE " .
					   "SET NOMAIDEFINANCIERE = :nomaidefinanciere, DESCRIPTIONAIDEFINANCIERE = :descriptionaidefinanciere, LIENAIDEFINANCIERE = :lienaidefinanciere " .
					   "WHERE IDENTIFIANTAIDEFINANCIERE = :identifiantaidefinanciere;";
			$statement = $this->pdo->prepare($requete);
			$statement->bindValue(":nomaidefinanciere", $aideFinanciere->getNomAideFinanciere(), PDO::PARAM_STR);
			$statement->bindValue(":descriptionaidefinanciere", $aideFinanciere->getDescriptionAideFinanciere(), PDO::PARAM_STR);
			$statement->bindValue(":lienaidefinanciere", $aideFinanciere->getLienAideFinanciere(), PDO::PARAM_STR);
			$statement->bindValue(":identifiantaidefinanciere", $aideFinanciere->getIdentifiantAideFinanciere(), PDO::PARAM_INT);
			$statement->execute();
			$this->pdo->commit();
		}
		catch (PDOException $exception) {
			$this->pdo->rollBack();
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

	/**
	 * Retourner la liste des aides financi�res.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 * @return array[] La liste des aides financi�res.
	 */
	public function chargerListeAidesFinancieres(): array {
		try {
			$listeAidesFinancieres = array();
			$requete = "SELECT IDENTIFIANTAIDEFINANCIERE, NOMAIDEFINANCIERE, DESCRIPTIONAIDEFINANCIERE, LIENAIDEFINANCIERE ".
					   "FROM AIDEFINANCIERE;";
			$statement = $this->pdo->prepare($requete);
			$statement->execute();
			$donnees = $statement->fetchAll();
			foreach ($donnees as $ligne) {
				$aideFinanciere = new AideFinanciere();
				$aideFinanciere->setIdentifiantAideFinanciere($ligne["IDENTIFIANTAIDEFINANCIERE"]);
				$aideFinanciere->setNomAideFinanciere($ligne["NOMAIDEFINANCIERE"]);
				$aideFinanciere->setDescriptionAideFinanciere($ligne["DESCRIPTIONAIDEFINANCIERE"]);
				$aideFinanciere->setLienAideFinanciere($ligne["LIENAIDEFINANCIERE"]);
				$listeAidesFinancieres[] = $aideFinanciere->getObjetSerializable();
			}
			return $listeAidesFinancieres;
		}
		catch (PDOException $exception) {
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
		catch (TypeError $exception) {
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
		catch (Exception $exception) {
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
		catch (Throwable $exception) {
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

}
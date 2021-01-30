<?php

/**
 *
 * StockageMobilites est la classe fournissant l'acc�s aux mobilit�s de la base de donn�es Plateforme.
 * Elle h�rite de StockageBaseDeDonnees.
 *
 * @version 1.0
 * @author Pierre-Nicolas
 */
class StockageMobilites extends StockageBaseDeDonnees {

	/**
	 * Constructeur StockageMobilites prenant en param�tre le dataSourceName, le nom d'utilisateur et le mot de passe de la base de donn�es.
	 * @param string $dataSourceName Le dataSourceName de la base de donn�es.
	 * @param string $username Le nom d'utilisateur de la base de donn�es.
	 * @param string $password Le mot de passe de la base de donn�es.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function __construct(string $dataSourceName, string $username, string $password) {
		parent::__construct($dataSourceName, $username, $password);
	}

	/**
	 * Ajouter une mobilit�.
	 * @param Mobilite $mobilite La mobilit� � ajouter.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function ajouterMobilite(Mobilite $mobilite): void {
		try {
			$this->pdo->beginTransaction();
			$requete = "INSERT INTO MOBILITE(TYPEMOBILITE) VALUES (:typemobilite);";
			$statement = $this->pdo->prepare($requete);
			$statement->bindValue(":typemobilite", $mobilite->getTypeMobilite(), PDO::PARAM_STR);
			$statement->execute();
			$mobilite->setIdentifiantMobilite(intval($this->pdo->lastInsertId()));
			$this->pdo->commit();
		}
		catch (PDOException $exception) {
			$this->pdo->rollBack();
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

	/**
	 * Supprimer une mobilit�.
	 * @param Mobilite $mobilite La mobilit� � supprimer.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function supprimerMobilite(Mobilite $mobilite): void {
		try {
			$this->pdo->beginTransaction();
			$requete = "DELETE FROM MOBILITE " .
					   "WHERE IDENTIFIANTMOBILITE = :identifiantmobilite;";
			$statement = $this->pdo->prepare($requete);
			$statement->bindValue(":identifiantmobilite", $mobilite->getIdentifiantMobilite(), PDO::PARAM_INT);
			$statement->execute();
			$this->pdo->commit();
		}
		catch (PDOException $exception) {
			$this->pdo->rollBack();
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

	/**
	 * Modifier une mobilit�.
	 * @param Mobilite $mobilite La mobilit� � modifier.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function modifierMobilite(Mobilite $mobilite): void {
		try {
			$this->pdo->beginTransaction();
			$requete = "UPDATE MOBILITE " .
					   "SET TYPEMOBILITE = :typemobilite " .
					   "WHERE IDENTIFIANTMOBILITE = :identifiantmobilite;";
			$statement = $this->pdo->prepare($requete);
			$statement->bindValue(":typemobilite", $mobilite->getTypeMobilite(), PDO::PARAM_STR);
			$statement->bindValue(":identifiantmobilite", $mobilite->getIdentifiantMobilite(), PDO::PARAM_INT);
			$statement->execute();
			$this->pdo->commit();
		}
		catch (PDOException $exception) {
			$this->pdo->rollBack();
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

	/**
	 * Retourner la liste des mobilit�s.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 * @return array[] La liste des mobilit�s.
	 */
	public function chargerListeMobilites(): array {
		try {
			$listeMobilites = array();
			$requete = "SELECT IDENTIFIANTMOBILITE, TYPEMOBILITE ".
					   "FROM MOBILITE;";
			$statement = $this->pdo->prepare($requete);
			$statement->execute();
			$donnees = $statement->fetchAll();
			foreach ($donnees as $ligne) {
				$mobilite = new Mobilite();
				$mobilite->setIdentifiantMobilite($ligne["IDENTIFIANTMOBILITE"]);
				$mobilite->setTypeMobilite($ligne["TYPEMOBILITE"]);
				$listeMobilites[] = $mobilite->getObjetSerializable();
			}
			return $listeMobilites;
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
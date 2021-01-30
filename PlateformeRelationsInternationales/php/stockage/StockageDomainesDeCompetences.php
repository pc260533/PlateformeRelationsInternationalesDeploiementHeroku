<?php

/**
 *
 * StockageDomainesDeCompetences est la classe fournissant l'acc�s aux domaines de comp�tences de la base de donn�es Plateforme.
 * Elle h�rite de StockageBaseDeDonnees.
 *
 * @version 1.0
 * @author Pierre-Nicolas
 */
class StockageDomainesDeCompetences extends StockageBaseDeDonnees {

	/**
	 * Constructeur StockageDomainesDeCompetences prenant en param�tre le dataSourceName, le nom d'utilisateur et le mot de passe de la base de donn�es.
	 * @param string $dataSourceName Le dataSourceName de la base de donn�es.
	 * @param string $username Le nom d'utilisateur de la base de donn�es.
	 * @param string $password Le mot de passe de la base de donn�es.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function __construct(string $dataSourceName, string $username, string $password) {
		parent::__construct($dataSourceName, $username, $password);
	}

	/**
	 * Ajouter un domaine de comp�tence.
	 * @param DomaineDeCompetence $domaineDeCompetence Le domaine de comp�tence � ajouter.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function ajouterDomaineDeCompetence(DomaineDeCompetence $domaineDeCompetence): void {
		try {
			$this->pdo->beginTransaction();
			$requete = "INSERT INTO DOMAINEDECOMPETENCE(NOMDOMAINEDECOMPETENCE) VALUES (:nomdomainedecompetence);";
			$statement = $this->pdo->prepare($requete);
			$statement->bindValue(":nomdomainedecompetence", $domaineDeCompetence->getNomDomaineDeCompetence(), PDO::PARAM_STR);
			$statement->execute();
			$domaineDeCompetence->setIdentifiantDomaineDeCompetence(intval($this->pdo->lastInsertId()));
			$this->pdo->commit();
		}
		catch (PDOException $exception) {
			$this->pdo->rollBack();
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

	/**
	 * Supprimer un domaine de comp�tence.
	 * @param DomaineDeCompetence $domaineDeCompetence Le domaine de comp�tence � supprimer.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function supprimerDomaineDeCompetence(DomaineDeCompetence $domaineDeCompetence): void {
		try {
			$this->pdo->beginTransaction();
			$requete = "DELETE FROM DOMAINEDECOMPETENCE " .
					   "WHERE IDENTIFIANTDOMAINEDECOMPETENCE= :identifiantdomainedecompetence;";
			$statement = $this->pdo->prepare($requete);
			$statement->bindValue(":identifiantdomainedecompetence", $domaineDeCompetence->getIdentifiantDomaineDeCompetence(), PDO::PARAM_INT);
			$statement->execute();
			$this->pdo->commit();
		}
		catch (PDOException $exception) {
			$this->pdo->rollBack();
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

	/**
	 * Modifier un domaine de comp�tence.
	 * @param DomaineDeCompetence $domaineDeCompetence Le domaine de comp�tence � modifier.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function modifierDomaineDeCompetence(DomaineDeCompetence $domaineDeCompetence): void {
		try {
			$this->pdo->beginTransaction();
			$requete = "UPDATE DOMAINEDECOMPETENCE " .
					   "SET NOMDOMAINEDECOMPETENCE = :nomdomainedecompetence " .
					   "WHERE IDENTIFIANTDOMAINEDECOMPETENCE = :identifiantdomainedecompetence;";
			$statement = $this->pdo->prepare($requete);
			$statement->bindValue(":nomdomainedecompetence", $domaineDeCompetence->getNomDomaineDeCompetence(), PDO::PARAM_STR);
			$statement->bindValue(":identifiantdomainedecompetence", $domaineDeCompetence->getIdentifiantDomaineDeCompetence(), PDO::PARAM_INT);
			$statement->execute();
			$this->pdo->commit();
		}
		catch (PDOException $exception) {
			$this->pdo->rollBack();
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

	/**
	 * Retourner la liste des domaines de comp�tences.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 * @return array[] La liste des domaines de comp�tences.
	 */
	public function chargerListeDomainesDeCompetences(): array {
		try {
			$listeDomainesDeCompetences = array();
			$requete = "SELECT IDENTIFIANTDOMAINEDECOMPETENCE, NOMDOMAINEDECOMPETENCE ".
					   "FROM DOMAINEDECOMPETENCE;";
			$statement = $this->pdo->prepare($requete);
			$statement->execute();
			$donnees = $statement->fetchAll();
			foreach ($donnees as $ligne) {
				$domaineDeCompetence = new DomaineDeCompetence();
				$domaineDeCompetence->setIdentifiantDomaineDeCompetence($ligne["IDENTIFIANTDOMAINEDECOMPETENCE"]);
				$domaineDeCompetence->setNomDomaineDeCompetence($ligne["NOMDOMAINEDECOMPETENCE"]);
				$listeDomainesDeCompetences[] = $domaineDeCompetence->getObjetSerializable();
			}
			return $listeDomainesDeCompetences;
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
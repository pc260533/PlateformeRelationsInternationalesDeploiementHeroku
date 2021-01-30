<?php

/**
 *
 * StockageEtatsPartenaires est la classe fournissant l'acc�s aux �tats partenaires de la base de donn�es Plateforme.
 * Elle h�rite de StockageBaseDeDonnees.
 *
 * @version 1.0
 * @author Pierre-Nicolas
 */
class StockageEtatsPartenaires extends StockageBaseDeDonnees {

	/**
	 * Constructeur StockageEtatsPartenaires prenant en param�tre le dataSourceName, le nom d'utilisateur et le mot de passe de la base de donn�es.
	 * @param string $dataSourceName Le dataSourceName de la base de donn�es.
	 * @param string $username Le nom d'utilisateur de la base de donn�es.
	 * @param string $password Le mot de passe de la base de donn�es.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function __construct(string $dataSourceName, string $username, string $password) {
		parent::__construct($dataSourceName, $username, $password);
	}

	/**
	 * Ajouter un �tat partenaire.
	 * @param EtatPartenaire $etatPartenaire L'�tat partenaire � ajouter.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function ajouterEtatPartenaire(EtatPartenaire $etatPartenaire): void {
		try {
			$this->pdo->beginTransaction();
			$requete = "INSERT INTO ETATPARTENAIRE(NOMETATPARTENAIRE) VALUES (:nometatpartenaire);";
			$statement = $this->pdo->prepare($requete);
			$statement->bindValue(":nometatpartenaire", $etatPartenaire->getNomEtatPartenaire(), PDO::PARAM_STR);
			$statement->execute();
			$etatPartenaire->setIdentifiantEtatPartenaire(intval($this->pdo->lastInsertId()));
			$this->pdo->commit();
		}
		catch (PDOException $exception) {
			$this->pdo->rollBack();
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

	/**
	 * Supprimer un �tat partenaire.
	 * @param EtatPartenaire $etatPartenaire L'�tat partenaire � supprimer.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function supprimerEtatPartenaire(EtatPartenaire $etatPartenaire): void {
		try {
			$this->pdo->beginTransaction();
			$requete = "DELETE FROM ETATPARTENAIRE " .
					   "WHERE IDENTIFIANTETATPARTENAIRE = :identifiantetatpartenaire;";
			$statement = $this->pdo->prepare($requete);
			$statement->bindValue(":identifiantetatpartenaire", $etatPartenaire->getIdentifiantEtatPartenaire(), PDO::PARAM_INT);
			$statement->execute();
			$this->pdo->commit();
		}
		catch (PDOException $exception) {
			$this->pdo->rollBack();
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

	/**
	 * Modifier un �tat partenaire.
	 * @param EtatPartenaire $etatPartenaire L'�tat partenaire � modifier.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function modifierEtatPartenaire(EtatPartenaire $etatPartenaire): void {
		try {
			$this->pdo->beginTransaction();
			$requete = "UPDATE ETATPARTENAIRE " .
					   "SET NOMETATPARTENAIRE = :nometatpartenaire " .
					   "WHERE IDENTIFIANTETATPARTENAIRE = :identifiantetatpartenaire;";
			$statement = $this->pdo->prepare($requete);
			$statement->bindValue(":nometatpartenaire", $etatPartenaire->getNomEtatPartenaire(), PDO::PARAM_STR);
			$statement->bindValue(":identifiantetatpartenaire", $etatPartenaire->getIdentifiantEtatPartenaire(), PDO::PARAM_INT);
			$statement->execute();
			$this->pdo->commit();
		}
		catch (PDOException $exception) {
			$this->pdo->rollBack();
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

	/**
	 * Retourner la liste des �tats partenaires.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 * @return array[] La liste des �tats partenaires.
	 */
	public function chargerListeEtatsPartenaires(): array {
		try {
			$listeEtatsPartenaires = array();
			$requete = "SELECT IDENTIFIANTETATPARTENAIRE, NOMETATPARTENAIRE ".
					   "FROM ETATPARTENAIRE;";
			$statement = $this->pdo->prepare($requete);
			$statement->execute();
			$donnees = $statement->fetchAll();
			foreach ($donnees as $ligne) {
				$etatPartenaire = new EtatPartenaire();
				$etatPartenaire->setIdentifiantEtatPartenaire($ligne["IDENTIFIANTETATPARTENAIRE"]);
				$etatPartenaire->setNomEtatPartenaire($ligne["NOMETATPARTENAIRE"]);
				$listeEtatsPartenaires[] = $etatPartenaire->getObjetSerializable();
			}
			return $listeEtatsPartenaires;
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
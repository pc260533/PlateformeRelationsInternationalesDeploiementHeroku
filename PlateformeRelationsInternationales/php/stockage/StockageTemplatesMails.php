<?php

/**
 *
 * StockageTemplatesMails est la classe fournissant l'acc�s aux templates mails de la base de donn�es Plateforme.
 * Elle h�rite de StockageBaseDeDonnees.
 *
 * @version 1.0
 * @author Pierre-Nicolas
 */
class StockageTemplatesMails extends StockageBaseDeDonnees {

	/**
	 * Constructeur StockageTemplatesMails prenant en param�tre le dataSourceName, le nom d'utilisateur et le mot de passe de la base de donn�es.
	 * @param string $dataSourceName Le dataSourceName de la base de donn�es.
	 * @param string $username Le nom d'utilisateur de la base de donn�es.
	 * @param string $password Le mot de passe de la base de donn�es.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function __construct(string $dataSourceName, string $username, string $password) {
		parent::__construct($dataSourceName, $username, $password);
	}

	/**
	 * Ajouter un template mail
	 * @param TemplateMail $templateMail Le template mail � ajouter.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function ajouterTemplateMail(TemplateMail $templateMail): void {
		try {
			$this->pdo->beginTransaction();
			$requete = "INSERT INTO TEMPLATEMAIL(NOMTEMPLATEMAIL, SUJETTEMPLATEMAIL, MESSAGEHTMLTEMPLATEMAIL) VALUES (:nomtemplatemail, :sujettemplatemail, :messagehtmltemplatemail);";
			$statement = $this->pdo->prepare($requete);
			$statement->bindValue(":nomtemplatemail", $templateMail->getNomTemplateMail(), PDO::PARAM_STR);
			$statement->bindValue(":sujettemplatemail", $templateMail->getSujetTemplateMail(), PDO::PARAM_STR);
			$statement->bindValue(":messagehtmltemplatemail", $templateMail->getMessageHtmlTemplateMail(), PDO::PARAM_STR);
			$statement->execute();
			$templateMail->setIdentifiantTemplateMail(intval($this->pdo->lastInsertId()));
			$this->pdo->commit();
		}
		catch (PDOException $exception) {
			$this->pdo->rollBack();
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

	/**
	 * Supprimer un template mail
	 * @param TemplateMail $templateMail Le template mail � supprimer.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function supprimerTemplateMail(TemplateMail $templateMail): void {
		try {
			$this->pdo->beginTransaction();
			$requete = "DELETE FROM TEMPLATEMAIL " .
					   "WHERE IDENTIFIANTTEMPLATEMAIL= :identifianttemplatemail;";
			$statement = $this->pdo->prepare($requete);
			$statement->bindValue(":identifianttemplatemail", $templateMail->getIdentifiantTemplateMail(), PDO::PARAM_INT);
			$statement->execute();
			$this->pdo->commit();
		}
		catch (PDOException $exception) {
			$this->pdo->rollBack();
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

	/**
	 * Modifier un template mail
	 * @param TemplateMail $templateMail Le template mail � modifier.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function modifierTemplateMail(TemplateMail $templateMail): void {
		try {
			$this->pdo->beginTransaction();
			$requete = "UPDATE TEMPLATEMAIL " .
					   "SET NOMTEMPLATEMAIL = :nomtemplatemail, SUJETTEMPLATEMAIL = :sujettemplatemail, MESSAGEHTMLTEMPLATEMAIL = :messagehtmltemplatemail " .
					   "WHERE IDENTIFIANTTEMPLATEMAIL = :identifianttemplatemail;";
			$statement = $this->pdo->prepare($requete);
			$statement->bindValue(":nomtemplatemail", $templateMail->getNomTemplateMail(), PDO::PARAM_STR);
			$statement->bindValue(":sujettemplatemail", $templateMail->getSujetTemplateMail(), PDO::PARAM_STR);
			$statement->bindValue(":messagehtmltemplatemail", $templateMail->getMessageHtmlTemplateMail(), PDO::PARAM_STR);
			$statement->bindValue(":identifianttemplatemail", $templateMail->getIdentifiantTemplateMail(), PDO::PARAM_INT);
			$statement->execute();
			$this->pdo->commit();
		}
		catch (PDOException $exception) {
			$this->pdo->rollBack();
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

	/**
	 * Charger le tempalte mail avec l'identifiant du template mail.
	 * @param TemplateMail $templateMail  Le tempalte mail � charger.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function chargerTemplateMailAvecIdentifiant(TemplateMail $templateMail): void {
		try {
			$requete = "SELECT IDENTIFIANTTEMPLATEMAIL, NOMTEMPLATEMAIL, SUJETTEMPLATEMAIL, MESSAGEHTMLTEMPLATEMAIL ".
					   "FROM TEMPLATEMAIL ".
					   "WHERE IDENTIFIANTTEMPLATEMAIL = :identifianttemplatemail";
			$statement = $this->pdo->prepare($requete);
			$statement->bindValue(":identifianttemplatemail", $templateMail->getIdentifiantTemplateMail(), PDO::PARAM_INT);
			$statement->execute();
			$donnees = $statement->fetchAll();
			foreach ($donnees as $ligne) {
				$templateMail->setIdentifiantTemplateMail($ligne["IDENTIFIANTTEMPLATEMAIL"]);
				$templateMail->setNomTemplateMail($ligne["NOMTEMPLATEMAIL"]);
				$templateMail->setSujetTemplateMail($ligne["SUJETTEMPLATEMAIL"]);
				$templateMail->setMessageHtmlTemplateMail($ligne["MESSAGEHTMLTEMPLATEMAIL"]);
			}
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

	/**
	 * Retourner la liste des templates mails.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 * @return array[] La liste des templates mails.
	 */
	public function chargerListeTemplatesMails(): array {
		try {
			$listeTemplatesMails = array();
			$requete = "SELECT IDENTIFIANTTEMPLATEMAIL, NOMTEMPLATEMAIL, SUJETTEMPLATEMAIL, MESSAGEHTMLTEMPLATEMAIL ".
					   "FROM TEMPLATEMAIL;";
			$statement = $this->pdo->prepare($requete);
			$statement->execute();
			$donnees = $statement->fetchAll();
			foreach ($donnees as $ligne) {
				$templateMail = new TemplateMail();
				$templateMail->setIdentifiantTemplateMail($ligne["IDENTIFIANTTEMPLATEMAIL"]);
				$templateMail->setNomTemplateMail($ligne["NOMTEMPLATEMAIL"]);
				$templateMail->setSujetTemplateMail($ligne["SUJETTEMPLATEMAIL"]);
				$templateMail->setMessageHtmlTemplateMail($ligne["MESSAGEHTMLTEMPLATEMAIL"]);
				$listeTemplatesMails[] = $templateMail->getObjetSerializable();
			}
			return $listeTemplatesMails;
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
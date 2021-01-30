<?php

/**
 *
 * StockagePartenaires est la classe fournissant l'acc�s aux partenaires de la base de donn�es Plateforme.
 * Elle h�rite de StockageBaseDeDonnees.
 *
 * @version 1.0
 * @author Pierre-Nicolas
 */
class StockagePartenaires extends StockageBaseDeDonnees {

	/**
	 * Ajouter une localisation de partenaire.
	 * @param Localisation $localisation La localisation � ajouter.
	 */
	private function ajouterLocalisation(Localisation $localisation) {
		$requete = "INSERT INTO LOCALISATION(LATITUDELOCALISATION, LONGITUDELOCALISATION, NOMLOCALISATION, NOMPAYSLOCALISATION, CODEPAYSLOCALISATION) VALUES (:latitudelocalisation, :longitudelocalisation, :nomlocalisation, :nompayslocalisation, :codepayslocalisation);";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":latitudelocalisation", $localisation->getLatitudeLocalisation(), PDO::PARAM_STR);
		$statement->bindValue(":longitudelocalisation", $localisation->getLongitudeLocalisation(), PDO::PARAM_STR);
		$statement->bindValue(":nomlocalisation", $localisation->getNomLocalisation(), PDO::PARAM_STR);
		$statement->bindValue(":nompayslocalisation", $localisation->getNomPaysLocalisation(), PDO::PARAM_STR);
		$statement->bindValue(":codepayslocalisation", $localisation->getCodePaysLocalisation(), PDO::PARAM_STR);
		$statement->execute();
		$localisation->setIdentifiantLocalisation(intval($this->pdo->lastInsertId()));
	}

	/**
	 * Supprimer une localisation de partenaire.
	 * @param Localisation $localisation La localisation � supprimer.
	 */
	private function supprimerLocalisation(Localisation $localisation) {
		$requete = "DELETE FROM LOCALISATION " .
				   "WHERE IDENTIFIANTLOCALISATION = :identifiantlocalisation";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantlocalisation", $localisation->getIdentifiantLocalisation(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Modifier une localisation de partenaire.
	 * @param Localisation $localisation La localisation � modifier.
	 */
	private function modifierLocalisation(Localisation $localisation) {
		$requete = "UPDATE LOCALISATION " .
				   "SET LATITUDELOCALISATION = :latitudelocalisation, LONGITUDELOCALISATION = :longitudelocalisation, NOMLOCALISATION = :nomlocalisation, NOMPAYSLOCALISATION = :nompayslocalisation, CODEPAYSLOCALISATION = :codepayslocalition " .
				   "WHERE IDENTIFIANTLOCALISATION = :identifiantlocalisation;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":latitudelocalisation", $localisation->getLatitudeLocalisation(), PDO::PARAM_STR);
		$statement->bindValue(":longitudelocalisation", $localisation->getLongitudeLocalisation(), PDO::PARAM_STR);
		$statement->bindValue(":nomlocalisation", $localisation->getNomLocalisation(), PDO::PARAM_STR);
		$statement->bindValue(":nompayslocalisation", $localisation->getNomPaysLocalisation(), PDO::PARAM_STR);
		$statement->bindValue(":codepayslocalition", $localisation->getCodePaysLocalisation(), PDO::PARAM_STR);
		$statement->bindValue(":identifiantlocalisation", $localisation->getIdentifiantLocalisation(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Charger la localisation d'un partenaire.
	 * @param Localisation $localisation La localisaiton � charger.
	 */
	private function chargerLocalisationPartenaire(Localisation $localisation): void {
		$requete = "SELECT LATITUDELOCALISATION, LONGITUDELOCALISATION, NOMLOCALISATION, NOMPAYSLOCALISATION, CODEPAYSLOCALISATION ".
				   "FROM LOCALISATION ".
				   "WHERE IDENTIFIANTLOCALISATION = :identifiantlocalisation;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantlocalisation", $localisation->getIdentifiantLocalisation(), PDO::PARAM_INT);
		$statement->execute();
		$donnees = $statement->fetchAll();
		foreach ($donnees as $ligne) {
			$localisation->setLatitudeLocalisation($ligne["LATITUDELOCALISATION"]);
			$localisation->setLongitudeLocalisation($ligne["LONGITUDELOCALISATION"]);
			$localisation->setNomLocalisation($ligne["NOMLOCALISATION"]);
			$localisation->setNomPaysLocalisation($ligne["NOMPAYSLOCALISATION"]);
			$localisation->setCodePaysLocalisation($ligne["CODEPAYSLOCALISATION"]);
		}
	}

	/**
	 * Charger les domaines de comp�tence d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 */
	private function chargerDomainesDeCompetencesDansPartenaire(Partenaire $partenaire): void {
		$requete = "SELECT IDENTIFIANTDOMAINEDECOMPETENCE ".
				   "FROM CORRESPONDANCE_PARTENAIRE_DOMAINEDECOMPETENCE ".
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->execute();
		$donnees = $statement->fetchAll();
		foreach ($donnees as $ligne) {
			$domaineDeCompetence = new DomaineDeCompetence();
			$domaineDeCompetence->setIdentifiantDomaineDeCompetence($ligne["IDENTIFIANTDOMAINEDECOMPETENCE"]);
			$partenaire->ajouterDomaineDeCompetence($domaineDeCompetence);
		}
	}

	/**
	 * Charger les sous sp�cialit�s d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 */
	private function chargerSousSpecialitesDansPartenaire(Partenaire $partenaire): void {
		$requete = "SELECT IDENTIFIANTSOUSSPECIALITE ".
				   "FROM CORRESPONDANCE_PARTENAIRE_SOUSSPECIALITE ".
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->execute();
		$donnees = $statement->fetchAll();
		foreach ($donnees as $ligne) {
			$sousSpecialite = new SousSpecialite();
			$sousSpecialite->setIdentifiantSousSpecialite($ligne["IDENTIFIANTSOUSSPECIALITE"]);
			$partenaire->ajouterSousSpecialite($sousSpecialite);
		}
	}

	/**
	 * Charger les mobilit�s d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 */
	private function chargerMobilitesDansPartenaire(Partenaire $partenaire): void {
		$requete = "SELECT IDENTIFIANTMOBILITE ".
				   "FROM CORRESPONDANCE_PARTENAIRE_MOBILITE ".
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->execute();
		$donnees = $statement->fetchAll();
		foreach ($donnees as $ligne) {
			$mobilite = new Mobilite();
			$mobilite->setIdentifiantMobilite($ligne["IDENTIFIANTMOBILITE"]);
			$partenaire->ajouterMobilite($mobilite);
		}
	}

	/**
	 * Charger les aides financi�res d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 */
	private function chargerAidesFinancieresDansPartenaire(Partenaire $partenaire): void {
		$requete = "SELECT IDENTIFIANTAIDEFINANCIERE ".
				   "FROM CORRESPONDANCE_PARTENAIRE_AIDEFINANCIERE ".
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->execute();
		$donnees = $statement->fetchAll();
		foreach ($donnees as $ligne) {
			$aideFinanciere = new AideFinanciere();
			$aideFinanciere->setIdentifiantAideFinanciere($ligne["IDENTIFIANTAIDEFINANCIERE"]);
			$partenaire->ajouterAideFinanciere($aideFinanciere);
		}
	}

	/**
	 * Charger les contacts �trangers d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 */
	private function chargerContactsEtrangersDansPartenaire(Partenaire $partenaire): void {
		$requete = "SELECT IDENTIFIANTCONTACT ".
				   "FROM CORRESPONDANCE_PARTENAIRE_CONTACTETRANGER ".
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->execute();
		$donnees = $statement->fetchAll();
		foreach ($donnees as $ligne) {
			$contactEtranger = new ContactEtranger();
			$contactEtranger->setIdentifiantContact($ligne["IDENTIFIANTCONTACT"]);
			$partenaire->ajouterContactEtranger($contactEtranger);
		}
	}

	/**
	 * Charger les coordinateurs d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 */
	private function chargerCoordinateursDansPartenaire(Partenaire $partenaire): void {
		$requete = "SELECT IDENTIFIANTCONTACT ".
				   "FROM CORRESPONDANCE_PARTENAIRE_COORDINATEUR ".
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->execute();
		$donnees = $statement->fetchAll();
		foreach ($donnees as $ligne) {
			$coordinateur = new Coordinateur();
			$coordinateur->setIdentifiantContact($ligne["IDENTIFIANTCONTACT"]);
			$partenaire->ajouterCoordinateur($coordinateur);
		}
	}

	/**
	 * Charger les voeux d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 */
	private function chargerVoeuxDansPartenaire(Partenaire $partenaire): void {
		$requete = "SELECT IDENTIFIANTVOEU ".
				   "FROM CORRESPONDANCE_PARTENAIRE_VOEU ".
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->execute();
		$donnees = $statement->fetchAll();
		foreach ($donnees as $ligne) {
			$voeu = new Voeu();
			$voeu->setIdentifiantVoeu($ligne["IDENTIFIANTVOEU"]);
			$partenaire->ajouterVoeu($voeu);
		}
	}

	/**
	 * Charger les images partenaire d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 */
	private function chargerImagesPartenaireDansPartenaire(Partenaire $partenaire): void {
		$requete = "SELECT CORRESPONDANCE_PARTENAIRE_IMAGEPARTENAIRE.IDENTIFIANTIMAGEPARTENAIRE, IMAGEPARTENAIRE.CHEMINIMAGEPARTENAIRESERVEUR ".
				   "FROM CORRESPONDANCE_PARTENAIRE_IMAGEPARTENAIRE INNER JOIN IMAGEPARTENAIRE ON (CORRESPONDANCE_PARTENAIRE_IMAGEPARTENAIRE.IDENTIFIANTIMAGEPARTENAIRE = IMAGEPARTENAIRE.IDENTIFIANTIMAGEPARTENAIRE)".
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->execute();
		$donnees = $statement->fetchAll();
		foreach ($donnees as $ligne) {
			$imagePartenaire = new ImagePartenaire();
			$imagePartenaire->setIdentifiantImagePartenaire($ligne["IDENTIFIANTIMAGEPARTENAIRE"]);
			$imagePartenaire->setCheminImagePartenaireServeur($ligne["CHEMINIMAGEPARTENAIRESERVEUR"]);
			$partenaire->ajouterImagePartenaire($imagePartenaire);
		}
	}

	/**
	 * Ajouter un domainde de comp�tence dans un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 * @param DomaineDeCompetence $domaineDeCompetence Le domaine de comp�tence � ajouter.
	 */
	private function ajouterDomaineDeCompetenceDansPartenaire(Partenaire $partenaire, DomaineDeCompetence $domaineDeCompetence) {
		$requete = "INSERT INTO CORRESPONDANCE_PARTENAIRE_DOMAINEDECOMPETENCE(IDENTIFIANTPARTENAIRE, IDENTIFIANTDOMAINEDECOMPETENCE) VALUES (:identifiantpartenaire, :identifiantdomainedecompetence);";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->bindValue(":identifiantdomainedecompetence", $domaineDeCompetence->getIdentifiantDomaineDeCompetence(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Supprimer un doamine de comp�tence d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 * @param DomaineDeCompetence $domaineDeCompetence Le domaine de comp�tence � suppprimer.
	 */
	private function supprimerDomaineDeCompetenceDansPartenaire(Partenaire $partenaire, DomaineDeCompetence $domaineDeCompetence) {
		$requete = "DELETE FROM CORRESPONDANCE_PARTENAIRE_DOMAINEDECOMPETENCE " .
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire AND IDENTIFIANTDOMAINEDECOMPETENCE = :identifiantdomainedecompetence;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->bindValue(":identifiantdomainedecompetence", $domaineDeCompetence->getIdentifiantDomaineDeCompetence(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Supprimer tous les domaines de comp�tences d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 */
	private function supprimerTousDomainesDeCompetencesDansPartenaire(Partenaire $partenaire) {
		$requete = "DELETE FROM CORRESPONDANCE_PARTENAIRE_DOMAINEDECOMPETENCE " .
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Ajouter une sous sp�cialit� dans un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 * @param SousSpecialite $sousSpecialite La sous sp�cialit� � ajouter.
	 */
	private function ajouterSousSpecialiteDansPartenaire(Partenaire $partenaire, SousSpecialite $sousSpecialite) {
		$requete = "INSERT INTO CORRESPONDANCE_PARTENAIRE_SOUSSPECIALITE(IDENTIFIANTPARTENAIRE, IDENTIFIANTSOUSSPECIALITE) VALUES (:identifiantpartenaire, :identifiantsousspecialite);";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->bindValue(":identifiantsousspecialite", $sousSpecialite->getIdentifiantSousSpecialite(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Supprimer une sous sp�cialit� d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 * @param SousSpecialite $sousSpecialite La sous sp�cialit� � supprimer.
	 */
	private function supprimerSousSpecialiteDansPartenaire(Partenaire $partenaire, SousSpecialite $sousSpecialite) {
		$requete = "DELETE FROM CORRESPONDANCE_PARTENAIRE_SOUSSPECIALITE " .
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire AND IDENTIFIANTSOUSSPECIALITE = :identifiantsousspecialite;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->bindValue(":identifiantsousspecialite", $sousSpecialite->getIdentifiantSousSpecialite(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Supprimer toutes les sous sp�cialit�s d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 */
	private function supprimerToutesSousSpecialitesDansPartenaire(Partenaire $partenaire) {
		$requete = "DELETE FROM CORRESPONDANCE_PARTENAIRE_SOUSSPECIALITE " .
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Ajouter une mobilit� dans un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 * @param Mobilite $mobilite La mobilit� � ajouter.
	 */
	private function ajouterMobiliteDansPartenaire(Partenaire $partenaire, Mobilite $mobilite) {
		$requete = "INSERT INTO CORRESPONDANCE_PARTENAIRE_MOBILITE(IDENTIFIANTPARTENAIRE, IDENTIFIANTMOBILITE) VALUES (:identifiantpartenaire, :identifiantmobilite);";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->bindValue(":identifiantmobilite", $mobilite->getIdentifiantMobilite(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Supprimer une mobilit� d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 * @param Mobilite $mobilite La mobilit� � supprimer.
	 */
	private function supprimerMobiliteDansPartenaire(Partenaire $partenaire, Mobilite $mobilite) {
		$requete = "DELETE FROM CORRESPONDANCE_PARTENAIRE_MOBILITE " .
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire AND IDENTIFIANTMOBILITE = :identifiantmobilite;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->bindValue(":identifiantmobilite", $mobilite->getIdentifiantMobilite(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Supprimer toutes les mobilit�s d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 */
	private function supprimerToutesMobilitesDansPartenaire(Partenaire $partenaire) {
		$requete = "DELETE FROM CORRESPONDANCE_PARTENAIRE_MOBILITE " .
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Ajouter un contact �tranger dans un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 * @param ContactEtranger $contactEtranger Le contact �tranger � ajouter.
	 */
	private function ajouterContactEtrangerDansPartenaire(Partenaire $partenaire, ContactEtranger $contactEtranger) {
		$requete = "INSERT INTO CORRESPONDANCE_PARTENAIRE_CONTACTETRANGER(IDENTIFIANTPARTENAIRE, IDENTIFIANTCONTACT) VALUES (:identifiantpartenaire, :identifiantcontact);";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->bindValue(":identifiantcontact", $contactEtranger->getIdentifiantContact(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Supprimer un contact �tranger d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 * @param ContactEtranger $contactEtranger Le contact �tranger � ajouter.
	 */
	private function supprimerContactEtrangerDansPartenaire(Partenaire $partenaire, ContactEtranger $contactEtranger) {
		$requete = "DELETE FROM CORRESPONDANCE_PARTENAIRE_CONTACTETRANGER " .
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire AND IDENTIFIANTCONTACT = :identifiantcontact;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->bindValue(":identifiantcontact", $contactEtranger->getIdentifiantContact(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Supprimer tous les contacts �trangers d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 */
	private function supprimerTousContactsEtrangerDansPartenaire(Partenaire $partenaire) {
		$requete = "DELETE FROM CORRESPONDANCE_PARTENAIRE_CONTACTETRANGER " .
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Ajouter un coordinateur dans un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 * @param Coordinateur $coordinateur Le coordianteur � ajouter.
	 */
	private function ajouterCoordinateurDansPartenaire(Partenaire $partenaire, Coordinateur $coordinateur) {
		$requete = "INSERT INTO CORRESPONDANCE_PARTENAIRE_COORDINATEUR(IDENTIFIANTPARTENAIRE, IDENTIFIANTCONTACT) VALUES (:identifiantpartenaire, :identifiantcontact);";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->bindValue(":identifiantcontact", $coordinateur->getIdentifiantContact(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Supprimer un coordinateur d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 * @param Coordinateur $coordinateur Le cooridnateur � supprimer.
	 */
	private function supprimerCoordinateurDansPartenaire(Partenaire $partenaire, Coordinateur $coordinateur) {
		$requete = "DELETE FROM CORRESPONDANCE_PARTENAIRE_COORDINATEUR " .
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire AND IDENTIFIANTCONTACT = :identifiantcontact;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->bindValue(":identifiantcontact", $coordinateur->getIdentifiantContact(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Supprimer tous les coordinateurs d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 */
	private function supprimerTousCoordinateurDansPartenaire(Partenaire $partenaire) {
		$requete = "DELETE FROM CORRESPONDANCE_PARTENAIRE_COORDINATEUR " .
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Ajouter une aide financi�re dans un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 * @param AideFinanciere $aideFinanciere L'aide financi�re � ajouter.
	 */
	private function ajouterAideFinanciereDansPartenaire(Partenaire $partenaire, AideFinanciere $aideFinanciere) {
		$requete = "INSERT INTO CORRESPONDANCE_PARTENAIRE_AIDEFINANCIERE(IDENTIFIANTPARTENAIRE, IDENTIFIANTAIDEFINANCIERE) VALUES (:identifiantpartenaire, :identifiantaidefinanciere);";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->bindValue(":identifiantaidefinanciere", $aideFinanciere->getIdentifiantAideFinanciere(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Supprimer une aide financi�re d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 * @param AideFinanciere $aideFinanciere L'aide financi�re � ajouter.
	 */
	private function supprimerAideFinanciereDansPartenaire(Partenaire $partenaire, AideFinanciere $aideFinanciere) {
		$requete = "DELETE FROM CORRESPONDANCE_PARTENAIRE_AIDEFINANCIERE " .
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire AND IDENTIFIANTAIDEFINANCIERE = :identifiantaidefinanciere;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->bindValue(":identifiantaidefinanciere", $aideFinanciere->getIdentifiantAideFinanciere(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Supprimer toutes les aides financi�res d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 */
	private function supprimerToutesAidesFinancieresDansPartenaire(Partenaire $partenaire) {
		$requete = "DELETE FROM CORRESPONDANCE_PARTENAIRE_AIDEFINANCIERE " .
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->execute();
	}


	/**
	 * Ajouter un voeu dans un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 * @param Voeu $voeu Le voeu � ajouter.
	 */
	private function ajouterVoeuDansPartenaire(Partenaire $partenaire, Voeu $voeu) {
		$requete = "INSERT INTO CORRESPONDANCE_PARTENAIRE_VOEU(IDENTIFIANTPARTENAIRE, IDENTIFIANTVOEU) VALUES (:identifiantpartenaire, :identifiantvoeu);";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->bindValue(":identifiantvoeu", $voeu->getIdentifiantVoeu(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Suprimer un voeu d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 * @param Voeu $voeu Le voeu � supprimer.
	 */
	private function supprimerVoeuDansPartenaire(Partenaire $partenaire, Voeu $voeu) {
		$requete = "DELETE FROM CORRESPONDANCE_PARTENAIRE_VOEU " .
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire AND IDENTIFIANTVOEU = :identifiantvoeu;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->bindValue(":identifiantvoeu", $voeu->getIdentifiantVoeu(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Suprimer tous les voeux d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 */
	private function supprimerTousVoeuDansPartenaire(Partenaire $partenaire) {
		$requete = "DELETE FROM CORRESPONDANCE_PARTENAIRE_VOEU " .
				   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Ajouter une image partenaire.
	 * @param ImagePartenaire $imagePartenaire L'image partenaire � ajouter.
	 */
	private function ajouterImagePartenaire(ImagePartenaire $imagePartenaire) {
		$requete = "INSERT INTO IMAGEPARTENAIRE(CHEMINIMAGEPARTENAIRESERVEUR) VALUES (:cheminimagepartenaireserveur);";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":cheminimagepartenaireserveur", $imagePartenaire->getCheminImagePartenaireServeur(), PDO::PARAM_STR);
		$statement->execute();
		$imagePartenaire->setIdentifiantImagePartenaire(intval($this->pdo->lastInsertId()));
	}

	/**
	 * Supprimer une image partenaire.
	 * @param ImagePartenaire $imagePartenaire L'image partenaire � supprimer.
	 */
	private function supprimerImagePartenaire(ImagePartenaire $imagePartenaire) {
		$requete = "DELETE FROM IMAGEPARTENAIRE " .
				   "WHERE IDENTIFIANTIMAGEPARTENAIRE = :identifiantimagepartenaire";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantimagepartenaire", $imagePartenaire->getIdentifiantImagePartenaire(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Ajouter une image partenaire dans un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 * @param ImagePartenaire $imagePartenaire L'image partenaire � ajotuer.
	 */
	private function ajouterImagePartenaireDansPartenaire(Partenaire $partenaire, ImagePartenaire $imagePartenaire) {
		$requete = "INSERT INTO CORRESPONDANCE_PARTENAIRE_IMAGEPARTENAIRE(IDENTIFIANTPARTENAIRE, IDENTIFIANTIMAGEPARTENAIRE) VALUES (:identifiantpartenaire, :identifiantimagepartenaire);";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->bindValue(":identifiantimagepartenaire", $imagePartenaire->getIdentifiantImagePartenaire(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Supprimer une image partenaire d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 * @param ImagePartenaire $imagePartenaire L'image partenaire � supprimer.
	 */
	private function supprimerImagePartenaireDansPartenaire(Partenaire $partenaire, ImagePartenaire $imagePartenaire) {
		$requete = "DELETE FROM CORRESPONDANCE_PARTENAIRE_IMAGEPARTENAIRE " .
				   "WHERE IDENTIFIANTIMAGEPARTENAIRE = :identifiantpartenaire AND IDENTIFIANTIMAGEPARTENAIRE = :identifiantimagepartenaire;";
		$statement = $this->pdo->prepare($requete);
		$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
		$statement->bindValue(":identifiantimagepartenaire", $imagePartenaire->getIdentifiantImagePartenaire(), PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 * Constructeur StockagePartenaires prenant en param�tre le dataSourceName, le nom d'utilisateur et le mot de passe de la base de donn�es.
	 * @param string $dataSourceName Le dataSourceName de la base de donn�es.
	 * @param string $username Le nom d'utilisateur de la base de donn�es.
	 * @param string $password Le mot de passe de la base de donn�es.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function __construct(string $dataSourceName, string $username, string $password) {
		parent::__construct($dataSourceName, $username, $password);
	}

	/**
	 * Ajouter un partenaire.
	 * @param Partenaire $partenaire Le partenaire � ajouter.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function ajouterPartenaire(Partenaire $partenaire): void {
		try {
			$this->pdo->beginTransaction();

			$this->ajouterLocalisation($partenaire->getLocalisationPartenaire());

			$requete = "INSERT INTO PARTENAIRE(NOMPARTENAIRE, LIENPARTENAIRE, INFORMATIONLOGEMENTPARTENAIRE, INFORMATIONCOUTPARTENAIRE, IDENTIFIANTLOCALISATION, IDENTIFIANTCOUT, IDENTIFIANTETATPARTENAIRE) VALUES (:nompartenaire, :lienpartenaire, :informationlogementpartenaire, :informationcoutpartenaire, :identifiantlocalisation, :identifiantcout, :identifiantetatpartenaire);";
			$statement = $this->pdo->prepare($requete);
			$statement->bindValue(":nompartenaire", $partenaire->getNomPartenaire(), PDO::PARAM_STR);
			$statement->bindValue(":lienpartenaire", $partenaire->getLienPartenaire(), PDO::PARAM_STR);
			$statement->bindValue(":informationlogementpartenaire", $partenaire->getInformationLogementPartenaire(), PDO::PARAM_STR);
			$statement->bindValue(":informationcoutpartenaire", $partenaire->getInformationCoutPartenaire(), PDO::PARAM_STR);
			$statement->bindValue(":identifiantlocalisation", $partenaire->getLocalisationPartenaire()->getIdentifiantLocalisation(), PDO::PARAM_INT);
			$statement->bindValue(":identifiantcout", $partenaire->getCoutPartenaire()->getIdentifiantCout(), PDO::PARAM_INT);
			$statement->bindValue(":identifiantetatpartenaire", $partenaire->getEtatPartenaire()->getIdentifiantEtatPartenaire(), PDO::PARAM_INT);
			$statement->execute();
			$partenaire->setIdentifiantPartenaire(intval($this->pdo->lastInsertId()));

			foreach ($partenaire->getListeDomainesDeComeptencesPartenaire() as $domaineDeCompetence) {
				$this->ajouterDomaineDeCompetenceDansPartenaire($partenaire, $domaineDeCompetence);
			}
			foreach ($partenaire->getListeSousSpecialitesPartenaire() as $sousSpecialite) {
				$this->ajouterSousSpecialiteDansPartenaire($partenaire, $sousSpecialite);
			}
			foreach ($partenaire->getListeMobilitesPartenaire() as $mobilite) {
				$this->ajouterMobiliteDansPartenaire($partenaire, $mobilite);
			}
			foreach ($partenaire->getListeAidesFinancieresPartenaire() as $aideFinanciere) {
				$this->ajouterAideFinanciereDansPartenaire($partenaire, $aideFinanciere);
			}
			foreach ($partenaire->getListeContactsEtrangersPartenaire() as $contactEtranger) {
				$this->ajouterContactEtrangerDansPartenaire($partenaire, $contactEtranger);
			}
			foreach ($partenaire->getListeCoordinateursPartenaire() as $coordinateur) {
				$this->ajouterCoordinateurDansPartenaire($partenaire, $coordinateur);
			}
			foreach ($partenaire->getListeVoeuxPartenaire() as $voeu) {
				$this->ajouterVoeuDansPartenaire($partenaire, $voeu);
			}
			/*foreach ($partenaire->getListeImagesPartenaire() as $imagePartenaire) {
			$this->ajouterImagePartenaire($imagePartenaire);
			$this->ajouterImagePartenaireDansPartenaire($partenaire, $imagePartenaire);
			}*/

			$this->pdo->commit();

		}
		catch (PDOException $exception) {
			$this->pdo->rollBack();
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

	/**
	 * Ajouter la liste des images partenaires d'un partenaire.
	 * @param Partenaire $partenaire Le partenaire.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function ajouterListeImagesPartenaire(Partenaire $partenaire): void {
		try {
			$this->pdo->beginTransaction();
			foreach ($partenaire->getListeImagesPartenaire() as $imagePartenaire) {
				$this->ajouterImagePartenaire($imagePartenaire);
				$this->ajouterImagePartenaireDansPartenaire($partenaire, $imagePartenaire);
			}
			$this->pdo->commit();
		}
		catch (PDOException $exception) {
			$this->pdo->rollBack();
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

	/**
	 * Ajouter la liste des voeux dans la listes des partenaires correspondant.
	 * @param array $listeVoeux La liste des coeux � ajouter.
	 * @param array $listePartenaires La liste des partenaires correspondant.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function ajouterListeVoeuxDansListePartenaires(array $listeVoeux, array $listePartenaires): void {
		try {
			$this->pdo->beginTransaction();
			foreach ($listeVoeux as $index => $voeu) {
				$this->ajouterVoeuDansPartenaire($listePartenaires[$index], $voeu);
			}
			$this->pdo->commit();
		}
		catch (PDOException $exception) {
			$this->pdo->rollBack();
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

	/**
	 * Supprimer un partenaire.
	 * @param Partenaire $partenaire Le partenaire � supprimer.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function supprimerPartenaire(Partenaire $partenaire): void {
		try {
			$this->pdo->beginTransaction();
			$requete = "DELETE FROM PARTENAIRE " .
					   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire;";
			$statement = $this->pdo->prepare($requete);
			$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
			$statement->execute();

			$this->supprimerLocalisation($partenaire->getLocalisationPartenaire());

			foreach ($partenaire->getListeImagesPartenaire() as $imagePartenaire) {
				$this->supprimerImagePartenaire($imagePartenaire);
			}

			$this->pdo->commit();
		}
		catch (PDOException $exception) {
			$this->pdo->rollBack();
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

	/**
	 * Modifier un partenaire.
	 * @param Partenaire $partenaire Le partenaire � modifier.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 */
	public function modifierPartenaire(Partenaire $partenaire): void {
		try {
			$this->pdo->beginTransaction();
			$requete = "UPDATE PARTENAIRE " .
					   "SET NOMPARTENAIRE = :nompartenaire, LIENPARTENAIRE = :lienpartenaire, INFORMATIONLOGEMENTPARTENAIRE = :informationlogementpartenaire, INFORMATIONCOUTPARTENAIRE = :informationcoutpartenaire, IDENTIFIANTLOCALISATION = :identifiantlocalisation, IDENTIFIANTCOUT = :identifiantcout, IDENTIFIANTETATPARTENAIRE = :identifiantetatpartenaire " .
					   "WHERE IDENTIFIANTPARTENAIRE = :identifiantpartenaire;";
			$statement = $this->pdo->prepare($requete);
			$statement->bindValue(":nompartenaire", $partenaire->getNomPartenaire(), PDO::PARAM_STR);
			$statement->bindValue(":lienpartenaire", $partenaire->getLienPartenaire(), PDO::PARAM_STR);
			$statement->bindValue(":informationlogementpartenaire", $partenaire->getInformationLogementPartenaire(), PDO::PARAM_STR);
			$statement->bindValue(":informationcoutpartenaire", $partenaire->getInformationCoutPartenaire(), PDO::PARAM_STR);
			$statement->bindValue(":identifiantlocalisation", $partenaire->getLocalisationPartenaire()->getIdentifiantLocalisation(), PDO::PARAM_INT);
			$statement->bindValue(":identifiantcout", $partenaire->getCoutPartenaire()->getIdentifiantCout(), PDO::PARAM_INT);
			$statement->bindValue(":identifiantetatpartenaire", $partenaire->getEtatPartenaire()->getIdentifiantEtatPartenaire(), PDO::PARAM_INT);
			$statement->bindValue(":identifiantpartenaire", $partenaire->getIdentifiantPartenaire(), PDO::PARAM_INT);
			$statement->execute();

			$this->modifierLocalisation($partenaire->getLocalisationPartenaire());
			$this->supprimerTousDomainesDeCompetencesDansPartenaire($partenaire);
			$this->supprimerToutesSousSpecialitesDansPartenaire($partenaire);
			$this->supprimerToutesMobilitesDansPartenaire($partenaire);
			$this->supprimerToutesAidesFinancieresDansPartenaire($partenaire);
			$this->supprimerTousContactsEtrangerDansPartenaire($partenaire);
			$this->supprimerTousCoordinateurDansPartenaire($partenaire);
			$this->supprimerTousVoeuDansPartenaire($partenaire);
			foreach ($partenaire->getListeDomainesDeComeptencesPartenaire() as $domaineDeCompetence) {
				$this->ajouterDomaineDeCompetenceDansPartenaire($partenaire, $domaineDeCompetence);
			}
			foreach ($partenaire->getListeSousSpecialitesPartenaire() as $sousSpecialite) {
				$this->ajouterSousSpecialiteDansPartenaire($partenaire, $sousSpecialite);
			}
			foreach ($partenaire->getListeMobilitesPartenaire() as $mobilite) {
				$this->ajouterMobiliteDansPartenaire($partenaire, $mobilite);
			}
			foreach ($partenaire->getListeAidesFinancieresPartenaire() as $aideFinanciere) {
				$this->ajouterAideFinanciereDansPartenaire($partenaire, $aideFinanciere);
			}
			foreach ($partenaire->getListeContactsEtrangersPartenaire() as $contactEtranger) {
				$this->ajouterContactEtrangerDansPartenaire($partenaire, $contactEtranger);
			}
			foreach ($partenaire->getListeCoordinateursPartenaire() as $coordinateur) {
				$this->ajouterCoordinateurDansPartenaire($partenaire, $coordinateur);
			}
			foreach ($partenaire->getListeVoeuxPartenaire() as $voeu) {
				$this->ajouterVoeuDansPartenaire($partenaire, $voeu);
			}

			$listeImagesPartenairesASupprimer = array();
			foreach ($partenaire->getListeImagesPartenaire() as $imagePartenaire) {
				if ($imagePartenaire->getIdentifiantImagePartenaire() == 0) {
					$this->ajouterImagePartenaire($imagePartenaire);
					$this->ajouterImagePartenaireDansPartenaire($partenaire, $imagePartenaire);
				}
				else {
					$this->supprimerImagePartenaire($imagePartenaire);
					$listeImagesPartenairesASupprimer[] = $imagePartenaire;
				}
			}
			foreach ($listeImagesPartenairesASupprimer as $imagePartenaire) {
				$partenaire->supprimerImagePartenaire($imagePartenaire);
			}

			$this->pdo->commit();
		}
		catch (PDOException $exception) {
			$this->pdo->rollBack();
			throw new ExceptionBaseDeDonneesPlateforme($exception);
		}
	}

	/**
	 * Retourner la liste des partenaire.
	 * @throws ExceptionBaseDeDonneesPlateforme L'exception du service de base de donn�es.
	 * @return array[] La liste des partenaires.
	 */
	public function chargerListePartenaires(): array {
		try {
			$listePartenaires = array();
			$requete = "SELECT IDENTIFIANTPARTENAIRE, NOMPARTENAIRE, LIENPARTENAIRE, INFORMATIONLOGEMENTPARTENAIRE, INFORMATIONCOUTPARTENAIRE, IDENTIFIANTLOCALISATION, IDENTIFIANTCOUT, IDENTIFIANTETATPARTENAIRE ".
					   "FROM PARTENAIRE;";
			$statement = $this->pdo->prepare($requete);
			$statement->execute();
			$donnees = $statement->fetchAll();
			foreach ($donnees as $ligne) {
				$partenaire = new Partenaire();
				$partenaire->setIdentifiantPartenaire($ligne["IDENTIFIANTPARTENAIRE"]);
				$partenaire->setNomPartenaire($ligne["NOMPARTENAIRE"]);
				$partenaire->setLienPartenaire($ligne["LIENPARTENAIRE"]);
				$partenaire->setInformationLogementPartenaire($ligne["INFORMATIONLOGEMENTPARTENAIRE"]);
				$partenaire->setInformationCoutPartenaire($ligne["INFORMATIONCOUTPARTENAIRE"]);
				$localisation = new Localisation();
				$localisation->setIdentifiantLocalisation($ligne["IDENTIFIANTLOCALISATION"]);
				$partenaire->setLocalisationPartenaire($localisation);
				$cout = new Cout();
				$cout->setIdentifiantCout($ligne["IDENTIFIANTCOUT"]);
				$partenaire->setCoutPartenaire($cout);
				$etatPartenaire = new EtatPartenaire();
				$etatPartenaire->setIdentifiantEtatPartenaire($ligne["IDENTIFIANTETATPARTENAIRE"]);
				$partenaire->setEtatPartenaire($etatPartenaire);

				$this->chargerLocalisationPartenaire($localisation);
				$this->chargerDomainesDeCompetencesDansPartenaire($partenaire);
				$this->chargerSousSpecialitesDansPartenaire($partenaire);
				$this->chargerMobilitesDansPartenaire($partenaire);
				$this->chargerAidesFinancieresDansPartenaire($partenaire);
				$this->chargerContactsEtrangersDansPartenaire($partenaire);
				$this->chargerCoordinateursDansPartenaire($partenaire);
				$this->chargerVoeuxDansPartenaire($partenaire);
				$this->chargerImagesPartenaireDansPartenaire($partenaire);

				$listePartenaires[] = $partenaire->getObjetSerializable();
			}
			return $listePartenaires;
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
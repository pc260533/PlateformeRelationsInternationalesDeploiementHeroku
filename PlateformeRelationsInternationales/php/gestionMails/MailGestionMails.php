<?php

/**
 *
 * MailGestionMails est la classe repr�sentant un mail envoy� par GestionMail.
 *
 * @version 1.0
 * @author Pierre-Nicolas
 */
class MailGestionMails {
	/**
	 * L'exp�diteur du mail.
	 * @var ContactMailGestionMails
	 */
	private $expediteur;
	/**
	 * La liste des destinataires du mail.
	 * @var array
	 */
	private $listeDestinataire;
	/**
	 * La liste des copies carbones du mail.
	 * @var array
	 */
	private $listeCopieCarbones;
	/**
	 * La liste des copies carbones invisibles du mail.
	 * @var array
	 */
	private $listeCopiesCarbonesInvisibles;
	/**
	 * Le sujet du mail.
	 * @var string
	 */
	private $sujetMail;
	/**
	 * Le message Html du mail.
	 * @var string
	 */
	private $messageHtml;

	/**
	 * Retourner l'exp�diteur du mail.
	 * @return ContactMailGestionMails|null L'exp�diteur du mail.
	 */
	public function getExpediteur(): ContactMailGestionMails {
		return $this->expediteur;
	}

	/**
	 * Modifier l'exp�diteur du mail.
	 * @param ContactMailGestionMails $expediteur L'exp�diteur du mail.
	 */
	public function setExpediteur(ContactMailGestionMails $expediteur): void {
		$this->expediteur = $expediteur;
	}

	/**
	 * Retourner le sujet du mail.
	 * @return null|string Le sujet du mail.
	 */
	public function getSujetMail(): string {
		return $this->sujetMail;
	}

	/**
	 * Modifier le sujet du mail.
	 * @param string $sujetMail Le sujet du mail.
	 */
	public function setSujetMail(string $sujetMail): void {
		$this->sujetMail = $sujetMail;
	}

	/**
	 * Retourner le message Html du mail.
	 * @return null|string Le message Html du mail.
	 */
	public function getMessageHtml(): string {
		return $this->messageHtml;
	}

	/**
	 * Modifier le message Html du mail.
	 * @param string $messageHtml Le message Html du mail.
	 */
	public function setMessageHtml(string $messageHtml): void {
		$this->messageHtml = $messageHtml;
	}

	/**
	 * Retourner la liste des destinataires du mail.
	 * @return array|null La liste des destinatiares du mail.
	 */
	public function getListeDestinataire(): array {
		return $this->listeDestinataire;
	}

	/**
	 * Retourner la liste des copies carbones du mail.
	 * @return array|null La liste des copies carbones du mail.
	 */
	public function getListeCopieCarbones(): array {
		return $this->listeCopieCarbones;
	}

	/**
	 * Retourner la liste des copies carbones du mail.
	 * @return array|null La liste des copies carbones du mail.
	 */
	public function getListeCopiesCarbonesInvisibles(): array {
		return $this->listeCopiesCarbonesInvisibles;
	}

	/**
	 * Constructeur MailGestionMails sans param�tres.
	 */
	public function __construct() {
		$this->expediteur = null;
		$this->listeDestinataire = array();
		$this->listeCopieCarbones = array();
		$this->listeCopiesCarbonesInvisibles = array();
		$this->sujetMail = "";
		$this->messageHtml = "";
	}

	/**
	 * Ajouter un destinataire dans la liste.
	 * @param ContactMailGestionMails $destinataire Le destinataire � ajouter.
	 */
	public function ajouterDestinataire(ContactMailGestionMails $destinataire) {
		$this->listeDestinataire[] = $destinataire;
	}

	/**
	 * Ajouter une copie carbone dans la liste.
	 * @param ContactMailGestionMails $copieCarbone La copie carbone � ajouter.
	 */
	public function ajouterCopieCarbone(ContactMailGestionMails $copieCarbone) {
		$this->listeCopieCarbones[] = $copieCarbone;
	}

	/**
	 * Ajouter une copie carbone invisible dans la liste.
	 * @param ContactMailGestionMails $copieCarboneInvisible La copie carbone invisible � ajouter.
	 */
	public function ajouterCopieCarboneInvisible(ContactMailGestionMails $copieCarboneInvisible) {
		$this->listeCopiesCarbonesInvisibles[] = $copieCarboneInvisible;
	}

}
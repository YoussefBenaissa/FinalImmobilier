<?php

class User{

	private $_id;
	private $_nom;
	private $_prenom;
	private $_mail;
	private $_pass;
	private $_tel;
	private $_role;
	private $_confirme;
	private $_actif;
	private $_token;
	



    // Getter / Setter
	public function getId() {
		return $this->_id;
	}

	public function getNom() {
		return $this->_nom;
	}

	public function getPrenom() {
		return $this->_prenom;
	}

	public function setId($_id) {
		$this->_id = $_id;
	}

	public function setNom($_nom) {
		$this->_nom = $_nom;
	}

	public function setPrenom($_prenom) {
		$this->_prenom = $_prenom;
	}

	public function getMail() {
		return $this->_mail;
	}

    public function setMail($_mail) {
		$this->_mail = $_mail;
	}

	public function getTel() {
		return $this->_tel;
	}

    public function setTel($_tel) {
		$this->_tel = $_tel;
	}

    public function getRole() {
		return $this->_role;
	}

    public function setRole($_role) {
		$this->_role = $_role;
	}

    public function getToken() {
		return $this->_token;
	}

    public function setToken($_token) {
		$this->_token = $_token;
	}

    public function getConfirme() {
		return $this->_confirme;
	}

    public function setConfirme($_confirme) {
		$this->_confirme = $_confirme;
	}

    public function getActif() {
		return $this->_actif;
	}
    public function setActif($_actif) {
		$this->_actif = $_actif;
	}

    public function getPass() {
		return $this->_pass;
	}
    
    public function setPass($_pass) {
		$this->_pass = $_pass;
	}
    

	// Constructeur
	public function __construct(array $options = [])
	{ 
		if (!empty($options))
		{
			$this->hydrate($options);
		}
	}
	public function hydrate($data)
	{
		foreach ($data as $key => $value)
		{
			$method = 'set'.ucfirst($key);
			
			if (is_callable([$this, $method]))
			{
				$this->$method($value);
			}
		}
	}
}
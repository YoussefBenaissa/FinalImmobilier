<?php

class Annonce
{

	private $_id;
	private $_titre;
	private $_description;
	private $_surface;
	private $_photos;
	private $_adresse;
	private $_ville;
	private $_codpost;
	private $_prix;
	private $_type;
	private $_type_bien_id;




	// Getter / Setter
	public function getId()
	{
		return $this->_id;
	}
	public function setId($_id)
	{
		$this->_id = $_id;
	}

	public function getTitre()
	{
		return $this->_titre;
	}
	public function setTitre($_titre)
	{
		$this->_titre = $_titre;
	}

	public function getDescription()
	{
		return $this->_description;
	}
	public function setDescription($_description)
	{
		$this->_description = $_description;
	}

	public function getSurface()
	{
		return $this->_surface;
	}
	public function setSurface($_surface)
	{
		$this->_surface = $_surface;
	}
	public function getPhotos()
	{
		return $this->_photos;
	}
	public function setPhotos($_photos)
	{
		$this->_photos = $_photos;
	}
	public function getAdresse()
	{
		return $this->_adresse;
	}
	public function setAdresse($_adresse)
	{
		$this->_adresse = $_adresse;
	}
	public function getVille()
	{
		return $this->_ville;
	}
	public function setVille($_ville)
	{
		$this->_ville = $_ville;
	}
	public function getCodpost()
	{
		return $this->_codpost;
	}
	public function setCodpost($_codpost)
	{
		$this->_codpost = $_codpost;
	}
	public function getPrix()
	{
		return $this->_prix;
	}
	public function setPrix($_prix)
	{
		$this->_prix = $_prix;
	}
	public function getType()
	{
		return $this->_type;
	}
	public function setType($_type)
	{
		$this->_type = $_type;
	}
	public function getType_bien_id()
	{
		return $this->_type_bien_id;
	}
	public function setType_bien_id($_type_bien_id)
	{
		$this->_type_bien_id = $_type_bien_id;
	}



	// Constructeur
	public function __construct(array $options = [])
	{
		if (!empty($options)) {
			$this->hydrate($options);
		}
	}
	public function hydrate($data)
	{
		foreach ($data as $key => $value) {
			$method = 'set' . ucfirst($key);

			if (is_callable([$this, $method])) {
				$this->$method($value);
			}
		}
	}
}

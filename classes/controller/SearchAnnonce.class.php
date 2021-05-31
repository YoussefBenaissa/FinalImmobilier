<?php

class SearchAnnonce{


	private $_surface;
	private $_ville;
	private $_prix_min;
	private $_prix_max;
	private $_type;
	private $_type_bien_id;



	public function getPrix_min()
	{
		return $this->_prix_min;
	}
	public function setPrix_min($_prix_min)
	{
		$this->_prix_min = $_prix_min;
	}
	public function getPrix_max()
	{
		return $this->_prix_max;
	}
	public function setPrix_max($_prix_max)
	{
		$this->_prix_max = $_prix_max;
	}
	

	public function getSurface()
	{
		return $this->_surface;
	}
	public function setSurface($_surface)
	{
		$this->_surface = $_surface;
	}

	
	public function getVille()
	{
		return $this->_ville;
	}
	public function setVille($_ville)
	{
		$this->_ville = $_ville;
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
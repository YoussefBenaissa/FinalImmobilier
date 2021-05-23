<?php
class Type_Bien
{
    private $_id;
    private $_libelle;

    public function getId()
    {
        return $this->_id;
    }
    public function setId($_id)
    {
        $this->_id = $_id;
    }
    public function getLibelle()
    {
        return $this->_libelle;
    }
    public function setLibelle($_libelle)
    {
        $this->_libelle = $_libelle;
    }
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

<?php

class funcionarios
{


    private $user;
    private $id;
    private $rol;
    private $login;

    public function __construct()
    {
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUser($user)
    {

        $this->user = $user;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
    }



    public function getRol()
    {
        return $this->rol;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }
}

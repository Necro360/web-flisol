<?php

/**
 * Created by @RodMoreno_.
 * User: Rodrigo Moreno
 * Date: 22/07/13
 * Time: 00:15 PM
 */

class MySQL
{
	private $servidor;
	private $usuario;
	private $password;
	private $bd;
	private $puerto;
	private $enlace;

	public function __construct($_servidor, $_usuario, $_password, $_bd, $_puerto = 3306)
	{
		$this->setServidor($_servidor);
		$this->setUsuario($_usuario);
		$this->setPassword($_password);
		$this->setBD($_bd);
		$this->setPuerto($_puerto);
	}

	public function conectar()
	{
		$enlace = new mysqli($this->getServidor(), $this->getUsuario(), $this->getPassword(), $this->getBD(), $this->getPuerto());

		$this->setEnlace($enlace);

		mysqli_query($this->getEnlace(), "SET NAMES 'utf8'");

		if (mysqli_connect_error())
			return false;
		return true;
	}

	public function desconectar()
	{
		$this->getEnlace()->close();
	}

	public function seleccionarBD()
	{
		$this->conectar();
		if (!mysqli_select_db($this->getEnlace(), $this->getBD()))
			return false;
		$this->desconectar();
		return true;
	}

	public function ejecutar($consulta)
	{
		$this->conectar();

		if (!$resultado = mysqli_query($this->getEnlace(), $consulta))
			return false;

		$this->desconectar();
		return $resultado;
	}

	public function blindar($parametro)
	{
		$this->conectar();

		$parametro = $this->getEnlace()->real_escape_string($parametro);

		$this->desconectar();

		return $parametro;
	}

	/* Seters */
	public function setServidor($_x)		{ $this->servidor = $_x; }
	public function setUsuario($_x)			{ $this->usuario = $_x; }
	public function setPassword($_x)		{ $this->password = $_x; }
	public function setBD($_x)				{ $this->bd = $_x; }
	public function setPuerto($_x)			{ $this->puerto = $_x; }
	public function setEnlace($_x)			{ $this->enlace = $_x; }

	/* Geters */
	public function getServidor()			{ return $this->servidor; }
	public function getUsuario()			{ return $this->usuario; }
	public function getPassword()			{ return $this->password; }
	public function getBD()					{ return $this->bd; }
	public function getPuerto()				{ return $this->puerto; }
	public function getEnlace()				{ return $this->enlace; }
}
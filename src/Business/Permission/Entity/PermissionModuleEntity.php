<?php

namespace AnexusPHP\Business\Permission\Entity;

use AnexusPHP\Core\DatabaseEntity;

class PermissionModuleEntity extends DatabaseEntity
{
	const TABLE = 'permission_module';
	private $id;
	private $nome;
	private $events;
	private $posicao;
	private $trash;
	private $app;
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}
	public function getId()
	{
		return $this->id;
	}
	public function setNome($nome)
	{
		$this->nome = $nome;
		return $this;
	}
	public function getNome()
	{
		return $this->nome;
	}
	public function setEvents($events)
	{
		$this->events = $events;
		return $this;
	}
	public function getEvents()
	{
		return $this->events;
	}
	public function setPosicao($posicao)
	{
		$this->posicao = $posicao;
		return $this;
	}
	public function getPosicao()
	{
		return $this->posicao;
	}
	public function setTrash($trash)
	{
		$this->trash = $trash;
		return $this;
	}
	public function getTrash()
	{
		return $this->trash;
	}
	public function setApp($app)
	{
		$this->app = $app;
		return $this;
	}
	public function getApp()
	{
		return $this->app;
	}
	public function toArray()
	{
		return array(
			'nome' => $this->getNome(),
			'events' => $this->getEvents(),
			'posicao' => $this->getPosicao(),
			'trash' => $this->getTrash(),
			'app' => $this->getApp()
		);
	}
}

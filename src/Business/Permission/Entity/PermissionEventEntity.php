<?php

namespace AnexusPHP\Business\Permission\Entity;

use AnexusPHP\Core\DatabaseEntity;

class PermissionEventEntity extends DatabaseEntity
{
	const TABLE = 'permission_event';
	protected $id;
	protected $description;
	protected $trash;
	protected $app;
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}
	public function getId()
	{
		return $this->id;
	}
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}
	public function getDescription()
	{
		return $this->description;
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
			'description' => $this->getDescription(),
			'trash' => $this->getTrash(),
			'app' => $this->getApp()
		);
	}
}

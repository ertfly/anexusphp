<?php

namespace AnexusPHP\Business\Permission\Entity;

use AnexusPHP\Core\MongoEntity;

class PermissionEventEntity extends MongoEntity
{
	const TABLE = 'permission_event';
	protected $_id;
	protected $description;
	protected $app;
	protected $trash;
	public function setId($id)
	{
		$this->_id = intval($id);
		return $this;
	}
	public function getId()
	{
		if (!is_null($this->_id)) {
			$this->_id = intval($this->_id);
		}
		return $this->_id;
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
	public function setApp($app)
	{
		$this->app = intval($app);
		return $this;
	}
	public function getApp()
	{
		if (!is_null($this->app)) {
			$this->app = intval($this->app);
		}
		return $this->app;
	}
	public function setTrash($trash)
	{
		$this->trash = boolval($trash);
		return $this;
	}
	public function getTrash()
	{
		if (is_null($this->trash)) {
			$this->trash = false;
		}
		return boolval($this->trash);
	}
	public function toArray()
	{
		return array(
			'_id' => $this->getId(),
			'description' => $this->getDescription(),
			'app' => $this->getApp(),
			'trash' => $this->getTrash(),
		);
	}
}

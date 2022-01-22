<?php

namespace AnexusPHP\Business\Permission\Entity;

use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Number;
use AnexusPHP\Core\Tools\Strings;
use AnexusPHP\Core\Tools\Boolean;

class PermissionEventEntity extends MongoEntity
{
	const TABLE = 'permission_event';
	protected $_id;
	protected $description;
	protected $level;
	protected $position;
	protected $app;
	protected $trash;
	public function setId($id)
	{
		$this->_id = Number::intNull($id);
		return $this;
	}
	public function getId()
	{
		return $this->_id;
	}
	public function setDescription($description)
	{
		$this->description = Strings::null($description);
		return $this;
	}
	public function getDescription()
	{
		return $this->description;
	}
	public function getLevel()
	{
		if (is_null($this->level)) {
			$this->level = 1;
		}
		return $this->level;
	}
	public function setLevel($level)
	{
		$this->level = Number::intNull($level);
		return $this;
	}
	public function getPosition()
	{
		return $this->position;
	}
	public function setPosition($position)
	{
		$this->position = Number::intNull($position);

		return $this;
	}
	public function setApp($app)
	{
		$this->app = Number::intNull($app);
		return $this;
	}
	public function getApp()
	{
		return $this->app;
	}
	public function setTrash($trash)
	{
		$this->trash = Boolean::null($trash);
		return $this;
	}
	public function getTrash()
	{
		if (is_null($this->trash)) {
			$this->trash = false;
		}
		return $this->trash;
	}
	public function toArray()
	{
		return array(
			'_id' => $this->getId(),
			'description' => $this->getDescription(),
			'level' => $this->getLevel(),
			'position' => $this->getPosition(),
			'app' => $this->getApp(),
			'trash' => $this->getTrash(),
		);
	}
}

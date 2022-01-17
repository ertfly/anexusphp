<?php

namespace AnexusPHP\Business\Permission\Entity;

use AnexusPHP\Business\Permission\Repository\PermissionEventRepository;
use AnexusPHP\Core\MongoEntity;

class PermissionModuleEntity extends MongoEntity
{
	const TABLE = 'permission_module';
	protected $_id;
	protected $name;
	protected $events;
	protected $position;
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
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}
	public function getName()
	{
		return $this->name;
	}
	public function setEvents($events)
	{
		$this->events = $events;
		return $this;
	}
	public function getEvents($arrayFormat = false)
	{
		if ($arrayFormat) {
			$idArr = strlen($this->events > 0) ? explode(',', $this->events) : [];
			$arr = [];
			foreach ($idArr as $value) {
				$arr[$value] = PermissionEventRepository::byId($value)->getDescription();
			}
			return $arr;
		}
		return $this->events;
	}
	public function setPosition($position)
	{
		$this->position = intval($position);
		return $this;
	}
	public function getPosition()
	{
		if (!is_null($this->position)) {
			$this->position = intval($this->position);
		}
		return $this->position;
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
			'name' => $this->getName(),
			'events' => $this->getEvents(),
			'position' => $this->getPosition(),
			'app' => $this->getApp(),
			'trash' => $this->getTrash(),
		);
	}
}

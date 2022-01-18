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
	protected $level;
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

	public function getEvents($arrayFormat = false, $level = 1)
	{
		if ($arrayFormat) {
			$idArr = strlen($this->events > 0) ? explode(',', $this->events) : [];
			$arr = [];
			foreach ($idArr as $value) {
				/**
				 * @var PermissionEventEntity
				 */
				$event = PermissionEventRepository::byId($value, PermissionEventEntity::class);
				if (!$event->getId()) {
					continue;
				}
				if ($event->getLevel() >= $level) {
					$arr[$value] = $event->getDescription();
				}
			}
			return $arr;
		}
		return $this->events;
	}
	public function getLevel()
	{
		if (!is_null($this->level)) {
			$this->level = intval($this->level);
		}
		return $this->level;
	}
	public function setLevel($level)
	{
		$this->level = intval($level);

		return $this;
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
			'level' => $this->getLevel(),
			'position' => $this->getPosition(),
			'app' => $this->getApp(),
			'trash' => $this->getTrash(),
		);
	}
}

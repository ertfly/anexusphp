<?php

namespace AnexusPHP\Business\Permission\Entity;

use AnexusPHP\Business\Permission\Repository\PermissionEventRepository;
use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Number;
use AnexusPHP\Core\Tools\Strings;
use AnexusPHP\Core\Tools\Boolean;

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
		$this->_id = Number::intNull($id);
		return $this;
	}
	public function getId()
	{
		return Number::intNull($this->_id);
	}
	public function setName($name)
	{
		$this->name = Strings::null($name);
		return $this;
	}
	public function getName()
	{
		return Strings::null($this->name);
	}
	public function setEvents(array $events)
	{
		$this->events = $events;
		return $this;
	}

	public function getEvents($objects = false, $level = 1)
	{
		if (is_null($this->events)) {
			$this->events = [];
		}
		if ($objects) {
			$arr = [];
			foreach ($this->events as $eventId) {
				$event = PermissionEventRepository::byId($eventId);
				if (!$event->getId()) {
					continue;
				}
				if ($event->getLevel() >= $level) {
					$arr[] = $event;
				}
			}
			return $arr;
		}
		return $this->events;
	}
	public function getLevel()
	{
		return Number::intNull($this->level);
	}
	public function setLevel($level)
	{
		$this->level = Number::intNull($level);

		return $this;
	}
	public function setPosition($position)
	{
		$this->position = Number::intNull($position);
		return $this;
	}
	public function getPosition()
	{
		return Number::intNull($this->position);
	}
	public function setApp($app)
	{
		$this->app = Number::intNull($app);
		return $this;
	}
	public function getApp()
	{
		return Number::intNull($this->app);
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
		return Boolean::null($this->trash);
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

	public function isEvents(PermissionEventEntity $event, $level = 1)
	{
		if (in_array($event->getId(), $this->getEvents(false, $level))) {
			return true;
		}

		return false;
	}
}

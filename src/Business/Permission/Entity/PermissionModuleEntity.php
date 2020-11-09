<?php

namespace AnexusPHP\Business\Permission\Entity;

use AnexusPHP\Business\Permission\Repository\PermissionEventRepository;
use AnexusPHP\Core\DatabaseEntity;

class PermissionModuleEntity extends DatabaseEntity
{
	const TABLE = 'permission_module';
	private $id;
	private $name;
	private $events;
	private $position;
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
		if($arrayFormat) {
			$idArr = strlen($this->events > 0) ? explode(',', $this->events) : [];
			$arr = [];
			foreach($idArr as $value) {
				$arr[$value] = PermissionEventRepository::byId($value)->getDescription();
			}
			return $arr;
		}
		return $this->events;
	}
	public function setPosition($position)
	{
		$this->position = $position;
		return $this;
	}
	public function getPosition()
	{
		return $this->position;
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
			'name' => $this->getName(),
			'events' => $this->getEvents(),
			'position' => $this->getPosition(),
			'trash' => $this->getTrash(),
			'app' => $this->getApp()
		);
	}
}

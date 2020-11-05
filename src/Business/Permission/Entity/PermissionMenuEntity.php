<?php

namespace AnexusPHP\Business\Permission\Entity;

use AnexusPHP\Core\DatabaseEntity;

class PermissionMenuEntity extends DatabaseEntity
{
	const TABLE = 'permission_menu';
	private $id;
	private $category_id;
	private $module_id;
	private $description;
	private $link;
	private $target;
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
	public function setCategoryId($categoryId)
	{
		$this->category_id = $categoryId;
		return $this;
	}
	public function getCategoryId()
	{
		return $this->category_id;
	}
	public function setModuleId($moduleId)
	{
		$this->module_id = $moduleId;
		return $this;
	}
	public function getModuleId()
	{
		return $this->module_id;
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
	public function setLink($link)
	{
		$this->link = $link;
		return $this;
	}
	public function getLink()
	{
		return $this->link;
	}
	public function setTarget($target)
	{
		$this->target = $target;
		return $this;
	}
	public function getTarget()
	{
		return $this->target;
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
			'category_id' => $this->getCategoryId(),
			'module_id' => $this->getModuleId(),
			'description' => $this->getDescription(),
			'link' => $this->getLink(),
			'target' => $this->getTarget(),
			'trash' => $this->getTrash(),
			'app' => $this->getApp()
		);
	}
}

<?php

namespace AnexusPHP\Business\Permission\Entity;

use AnexusPHP\Business\Permission\Constant\PermissionMenuTargetConstant;
use AnexusPHP\Business\Permission\Repository\PermissionCategoryMenuRepository;
use AnexusPHP\Business\Permission\Repository\PermissionModuleRepository;
use AnexusPHP\Core\MongoEntity;

class PermissionMenuEntity extends MongoEntity
{
	const TABLE = 'permission_menu';
	private $_id;
	private $category_id;
	private $module_id;
	private $description;
	private $icon;
	private $link;
	private $target;
	private $trash;
	private $app;
	public function setId($id)
	{
		$this->_id = $id;
		return $this;
	}
	public function getId()
	{
		return $this->_id;
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
	public function setIcon($icon)
	{
		$this->icon = $icon;
		return $this;
	}
	public function getIcon()
	{
		return $this->icon;
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
	public function getTarget(bool $format = false)
	{
		if ($format) {
			return PermissionMenuTargetConstant::getOption($this->target);
		}
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
			'_id' => $this->getId(),
			'category_id' => $this->getCategoryId(),
			'module_id' => $this->getModuleId(),
			'description' => $this->getDescription(),
			'icon' => $this->getIcon(),
			'link' => $this->getLink(),
			'target' => $this->getTarget(),
			'trash' => $this->getTrash(),
			'app' => $this->getApp()
		);
	}

	private $module;

	/**
	 * @return PermissionModuleEntity
	 */
	public function getModule()
	{
		if (!$this->module) {
			$this->module = PermissionModuleRepository::byId($this->getModuleId());
		}

		return $this->module;
	}

	private $category;

	/**
	 * @return PermissionCategoryMenuEntity
	 */
	public function getCategory()
	{
		if (!$this->category) {
			$this->category = PermissionCategoryMenuRepository::byId($this->getCategoryId());
		}

		return $this->category;
	}
}

<?php

namespace AnexusPHP\Business\Permission\Entity;

use AnexusPHP\Business\Permission\Constant\PermissionMenuTargetConstant;
use AnexusPHP\Business\Permission\Repository\PermissionCategoryMenuRepository;
use AnexusPHP\Business\Permission\Repository\PermissionModuleRepository;
use AnexusPHP\Core\MongoEntity;

class PermissionMenuEntity extends MongoEntity
{
	const TABLE = 'permission_menu';
	protected $_id;
	protected $category_id;
	protected $module_id;
	protected $description;
	protected $icon;
	protected $link;
	protected $target;
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
	public function setCategoryId($categoryId)
	{
		$this->category_id = intval($categoryId);
		return $this;
	}
	public function getCategoryId()
	{
		if (!is_null($this->category_id)) {
			$this->category_id = intval($this->category_id);
		}
		return $this->category_id;
	}
	public function setModuleId($moduleId)
	{
		$this->module_id = intval($moduleId);
		return $this;
	}
	public function getModuleId()
	{
		if (!is_null($this->module_id)) {
			$this->module_id = intval($this->module_id);
		}
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
			'category_id' => $this->getCategoryId(),
			'module_id' => $this->getModuleId(),
			'description' => $this->getDescription(),
			'icon' => $this->getIcon(),
			'link' => $this->getLink(),
			'target' => $this->getTarget(),
			'app' => $this->getApp(),
			'trash' => $this->getTrash(),
		);
	}

	/**
	 * Undocumented variable
	 *
	 * @var PermissionModuleEntity
	 */
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

	/**
	 * Undocumented variable
	 *
	 * @var PermissionCategoryMenuEntity
	 */
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

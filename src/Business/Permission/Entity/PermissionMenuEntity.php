<?php

namespace AnexusPHP\Business\Permission\Entity;

use AnexusPHP\Business\Permission\Constant\PermissionMenuTargetConstant;
use AnexusPHP\Business\Permission\Repository\PermissionCategoryMenuRepository;
use AnexusPHP\Business\Permission\Repository\PermissionModuleRepository;
use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Number;
use AnexusPHP\Core\Tools\Strings;
use AnexusPHP\Core\Tools\Boolean;

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
	public function setCategoryId($categoryId)
	{
		$this->category_id = Number::intNull($categoryId);
		return $this;
	}
	public function getCategoryId()
	{
		return $this->category_id;
	}
	public function setModuleId($moduleId)
	{
		$this->module_id = Number::intNull($moduleId);
		return $this;
	}
	public function getModuleId()
	{
		return $this->module_id;
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
	public function setIcon($icon)
	{
		$this->icon = Strings::null($icon);
		return $this;
	}
	public function getIcon()
	{
		return $this->icon;
	}
	public function setLink($link)
	{
		$this->link = Strings::null($link);
		return $this;
	}
	public function getLink()
	{
		return $this->link;
	}
	public function setTarget($target)
	{
		$this->target = Strings::null($target);
		return $this;
	}
	public function getTarget(bool $format = false)
	{
		if ($format) {
			return PermissionMenuTargetConstant::getOption($this->target);
		}
		return $this->target;
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
			'category_id' => $this->getCategoryId(),
			'module_id' => $this->getModuleId(),
			'description' => $this->getDescription(),
			'icon' => $this->getIcon(),
			'link' => $this->getLink(),
			'target' => $this->getTarget(),
			'position' => $this->getPosition(),
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

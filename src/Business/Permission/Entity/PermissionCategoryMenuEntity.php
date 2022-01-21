<?php

namespace AnexusPHP\Business\Permission\Entity;

use AnexusPHP\Business\Permission\Repository\PermissionMenuRepository;
use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Number;
use AnexusPHP\Core\Tools\Strings;
use AnexusPHP\Core\Tools\Boolean;

class PermissionCategoryMenuEntity extends MongoEntity
{
	const TABLE = 'permission_category_menu';
	protected $_id;
	protected $description;
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
	public function setDescription($description)
	{
		$this->description = Strings::null($description);
		return $this;
	}
	public function getDescription()
	{
		return Strings::null($this->description);
	}
	public function getPosition()
	{
		return Number::intNull($this->position);
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
			'_id' => $this->getId(),
			'description' => $this->getDescription(),
			'position' => $this->getPosition(),
			'app' => $this->getApp(),
			'trash' => $this->getTrash(),
		);
	}

	private $menu;

	public function getMenu(array $allows = null)
	{
		if (is_null($this->menu)) {
			if (!is_null($allows)) {
				$this->menu = PermissionMenuRepository::all(['category_id' => $this->getId(), 'menu_in' => $allows]);
			} else {
				$this->menu = PermissionMenuRepository::byCategoryId($this->getId());
			}
		}
		return $this->menu;
	}
}

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
	protected $icon;
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
	public function getIcon()
	{
		return $this->icon;
	}
	public function setIcon($icon)
	{
		$this->icon = Strings::null($icon);

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
			'icon' => $this->getIcon(),
			'position' => $this->getPosition(),
			'app' => $this->getApp(),
			'trash' => $this->getTrash(),
		);
	}

	/**
	 * Undocumented variable
	 *
	 * @var PermissionMenuEntity[]
	 */
	private $menu;

	/**
	 * Undocumented function
	 *
	 * @param array|null $allows
	 * @return PermissionMenuEntity[]
	 */
	public function getMenu(?array $allows = null)
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

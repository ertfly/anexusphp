<?php

namespace AnexusPHP\Business\Permission\Entity;

use AnexusPHP\Business\Permission\Repository\PermissionMenuRepository;
use AnexusPHP\Core\DatabaseEntity;

class PermissionCategoryMenuEntity extends DatabaseEntity
{
	const TABLE = 'permission_category_menu';
	private $id;
	private $description;
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
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}
	public function getDescription()
	{
		return $this->description;
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
			'description' => $this->getDescription(),
			'trash' => $this->getTrash(),
			'app' => $this->getApp()
		);
	}

	private $menu;
	
	public function getMenu(?array $menu = null) {
		if (!is_null($menu)) {
			$this->menu = [];
			foreach ($menu as $value) {
				if ($value->getCategoryId() == $this->getId()) {
					$this->menu[] = $value;
				}
			}
		}

		if (!$this->menu) {
			$this->menu = PermissionMenuRepository::byCategoryId($this->getId());
		}

		return $this->menu;
	}
}

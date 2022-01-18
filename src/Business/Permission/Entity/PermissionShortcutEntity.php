<?php

namespace AnexusPHP\Business\Permission\Entity;

use AnexusPHP\Business\Permission\Repository\PermissionShortcutRepository;
use AnexusPHP\Business\Permission\Rule\PermissionShortcutRule;
use AnexusPHP\Core\MongoEntity;

class PermissionShortcutEntity extends MongoEntity
{
	const TABLE = 'permission_shortcut';
	private $_id;
	private $description;
	private $icon;
	private $link;
	private $position;
	private $principal;
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
	public function getTarget()
	{
		return $this->target;
	}
	public function setPosition($position)
	{
		$this->position = intval($position);
		return $this;
	}
	public function getPosition()
	{
		if (is_null($this->position) && $this->_id) {
			$this->position = (PermissionShortcutRepository::getLastPosition()) + 1;
			PermissionShortcutRule::update($this);
		}
		return intval($this->position);
	}
	public function setPrincipal($principal)
	{
		$this->principal = boolval($principal);
		return $this;
	}
	public function getPrincipal()
	{
		if (is_null($this->principal)) {
			$this->principal = false;
		}
		return boolval($this->principal);
	}
	public function toArray()
	{
		return array(
			'_id' => $this->getId(),
			'description' => $this->getDescription(),
			'icon' => $this->getIcon(),
			'link' => $this->getLink(),
			'position' => $this->getPosition(),
			'principal' => $this->getPrincipal(),
		);
	}
}

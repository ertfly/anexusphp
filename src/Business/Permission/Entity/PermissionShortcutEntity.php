<?php

namespace AnexusPHP\Business\Permission\Entity;

use AnexusPHP\Business\Permission\Repository\PermissionShortcutRepository;
use AnexusPHP\Business\Permission\Rule\PermissionShortcutRule;
use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Number;
use AnexusPHP\Core\Tools\Strings;
use AnexusPHP\Core\Tools\Boolean;

class PermissionShortcutEntity extends MongoEntity
{
	const TABLE = 'permission_shortcut';
	protected $_id;
	protected $description;
	protected $icon;
	protected $link;
	protected $position;
	protected $principal;
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
	public function getTarget()
	{
		return $this->target;
	}
	public function setPosition($position)
	{
		$this->position = Number::intNull($position);
		return $this;
	}
	public function getPosition()
	{
		if (is_null($this->position) && $this->_id) {
			$this->position = (PermissionShortcutRepository::getLastPosition()) + 1;
			PermissionShortcutRule::update($this);
		}
		return $this->position;
	}
	public function setPrincipal($principal)
	{
		$this->principal = Boolean::null($principal);
		return $this;
	}
	public function getPrincipal()
	{
		if (is_null($this->principal)) {
			$this->principal = false;
		}
		return $this->principal;
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

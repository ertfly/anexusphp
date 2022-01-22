<?php

namespace AnexusPHP\Business\Authfast\Entity;

use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Number;

class AuthfastShortcutEntity extends MongoEntity
{
	const TABLE = 'authfast_shortcut';
	protected $_id;
	protected $authfast_id;
	protected $shortcut;
	public function setId($id)
	{
		$this->_id = Number::intNull($id);
		return $this;
	}
	public function getId()
	{
		return $this->_id;
	}
	public function setAuthfastId($authfastId)
	{
		$this->authfast_id = Number::intNull($authfastId);
		return $this;
	}
	public function getAuthfastId()
	{
		return $this->authfast_id;
	}
	public function setShortcut($shortcut)
	{
		$this->shortcut = Number::intNull($shortcut);
		return $this;
	}
	public function getShortcut()
	{
		return $this->shortcut;
	}
	public function toArray()
	{
		return array(
			'_id' => $this->getId(),
			'authfast_id' => $this->getAuthfastId(),
			'shortcut' => $this->getShortcut()
		);
	}
}

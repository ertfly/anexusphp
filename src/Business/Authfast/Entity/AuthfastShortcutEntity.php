<?php

namespace AnexusPHP\Business\Authfast\Entity;

use AnexusPHP\Core\MongoEntity;

class AuthfastShortcutEntity extends MongoEntity
{
	const TABLE = 'authfast_shortcut';
	private $_id;
	private $authfast_id;
	private $shortcut;
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
	public function setAuthfastId($authfastId)
	{
		$this->authfast_id = intval($authfastId);
		return $this;
	}
	public function getAuthfastId()
	{
		if (!is_null($this->authfast_id)) {
			$this->authfast_id = intval($this->authfast_id);
		}
		return $this->authfast_id;
	}
	public function setShortcut($shortcut)
	{
		$this->shortcut = intval($shortcut);
		return $this;
	}
	public function getShortcut()
	{
		if (!is_null($this->shortcut)) {
			$this->shortcut = intval($this->shortcut);
		}
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

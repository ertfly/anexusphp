<?php

namespace AnexusPHP\Business\Authfast\Entity;

use AnexusPHP\Core\DatabaseEntity;

class AuthfastPermissionEntity extends DatabaseEntity {
	const TABLE = 'authfast_permission';
	private $id;
	private $authfast_id;
	private $module_id;
	private $events;
	public function setId($id){
		$this->id = $id;
		return $this;
	}
	public function getId(){
		return $this->id;
	}
	public function setAuthfastId($authfastId){
		$this->authfast_id = $authfastId;
		return $this;
	}
	public function getAuthfastId(){
		return $this->authfast_id;
	}
	public function setModuleId($moduleId){
		$this->module_id = $moduleId;
		return $this;
	}
	public function getModuleId(){
		return $this->module_id;
	}
	public function setEvents($events){
		$this->events = $events;
		return $this;
	}
	public function getEvents(){
		return $this->events;
	}
	public function toArray(){
		return array(
'id' => $this->getId(),
'authfast_id' => $this->getAuthfastId(),
'module_id' => $this->getModuleId(),
'events' => $this->getEvents()
		);
	}
}
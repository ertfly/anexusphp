<?php

namespace AnexusPHP\Business\Authfast\Entity;

use AnexusPHP\Core\DatabaseEntity;

class AuthfastActivityEntity extends DatabaseEntity {
	const TABLE = 'authfast_activity';
	private $id;
	private $activity;
	private $authfast_id;
	private $module;
	private $bind_id;
	private $description;
	private $created_at;
	public function setId($id){
		$this->id = $id;
		return $this;
	}
	public function getId(){
		return $this->id;
	}
	public function setActivity($activity){
		$this->activity = $activity;
		return $this;
	}
	public function getActivity(){
		return $this->activity;
	}
	public function setAuthfastId($authfastId){
		$this->authfast_id = $authfastId;
		return $this;
	}
	public function getAuthfastId(){
		return $this->authfast_id;
	}
	public function setModule($module){
		$this->module = $module;
		return $this;
	}
	public function getModule(){
		return $this->module;
	}
	public function setBindId($bindId){
		$this->bind_id = $bindId;
		return $this;
	}
	public function getBindId(){
		return $this->bind_id;
	}
	public function setDescription($description){
		$this->description = $description;
		return $this;
	}
	public function getDescription(){
		return $this->description;
	}
	public function setCreatedAt($createdAt){
		$this->created_at = $createdAt;
		return $this;
	}
	public function getCreatedAt(){
		return $this->created_at;
	}
	public function toArray(){
		return array(
			'activity' => $this->getActivity(),
			'authfast_id' => $this->getAuthfastId(),
			'module' => $this->getModule(),
			'bind_id' => $this->getBindId(),
			'description' => $this->getDescription(),
			'created_at' => $this->getCreatedAt()
		);
	}
}
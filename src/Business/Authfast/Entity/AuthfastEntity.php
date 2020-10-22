<?php

namespace AnexusPHP\Business\Authfast\Entity;

use AnexusPHP\Core\DatabaseEntity;

class AuthfastEntity extends DatabaseEntity
{
	const TABLE = 'authfast';
	private $id;
	private $code;
	private $firstname;
	private $lastname;
	private $username;
	private $email;
	private $created_at;
	private $updated_at;
	private $expired_at;
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}
	public function getId()
	{
		return $this->id;
	}
	public function setCode($code)
	{
		$this->code = $code;
		return $this;
	}
	public function getCode()
	{
		return $this->code;
	}
	public function setFirstname($firstname)
	{
		$this->firstname = $firstname;
		return $this;
	}
	public function getFirstname()
	{
		return $this->firstname;
	}
	public function setLastname($lastname)
	{
		$this->lastname = $lastname;
		return $this;
	}
	public function getLastname()
	{
		return $this->lastname;
	}
	public function setUsername($username)
	{
		$this->username = $username;
		return $this;
	}
	public function getUsername()
	{
		return $this->username;
	}
	public function setEmail($email)
	{
		$this->email = $email;
		return $this;
	}
	public function getEmail()
	{
		return $this->email;
	}
	public function setCreatedAt($createdAt)
	{
		$this->created_at = $createdAt;
		return $this;
	}
	public function getCreatedAt()
	{
		return $this->created_at;
	}
	public function setUpdatedAt($updatedAt)
	{
		$this->updated_at = $updatedAt;
		return $this;
	}
	public function getUpdatedAt()
	{
		return $this->updated_at;
	}
	public function setExpiredAt($expiredAt)
	{
		$this->expired_at = $expiredAt;
		return $this;
	}
	public function getExpiredAt()
	{
		return $this->expired_at;
	}
	public function toArray()
	{
		return array(
			'code' => $this->getCode(),
			'firstname' => $this->getFirstname(),
			'lastname' => $this->getLastname(),
			'username' => $this->getUsername(),
			'email' => $this->getEmail(),
			'created_at' => $this->getCreatedAt(),
			'updated_at' => $this->getUpdatedAt(),
			'expired_at' => $this->getExpiredAt()
		);
	}
}

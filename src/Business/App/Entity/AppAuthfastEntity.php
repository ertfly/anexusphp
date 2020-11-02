<?php

namespace AnexusPHP\Business\App\Entity;

use AnexusPHP\Business\Authfast\Repository\AuthfastRepository;
use AnexusPHP\Core\DatabaseEntity;

class AppAuthfastEntity extends DatabaseEntity
{
	const TABLE = 'app_authfast';
    protected $id;
	private $app_id;
	private $authfast_id;
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getId()
    {
        return $this->id;
    }
	public function setAppId($appId)
	{
		$this->app_id = $appId;
		return $this;
	}
	public function getAppId()
	{
		return $this->app_id;
	}
	public function setAuthfastId($authfastId)
	{
		$this->authfast_id = $authfastId;
		return $this;
	}
	public function getAuthfastId()
	{
		return $this->authfast_id;
	}
	public function toArray()
	{
		return array(
			'app_id' => $this->getAppId(),
			'authfast_id' => $this->getAuthfastId()
		);
	}

	private $person;

	public function getPerson()
	{
		if(!$this->person){
			$this->person = AuthfastRepository::byCode($this->authfast_id);
		}

		return $this->person;
	}
}

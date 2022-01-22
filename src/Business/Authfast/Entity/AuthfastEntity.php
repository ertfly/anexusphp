<?php

namespace AnexusPHP\Business\Authfast\Entity;

use AnexusPHP\Business\App\Entity\AppEntity;
use AnexusPHP\Business\App\Repository\AppAuthfastRepository;
use AnexusPHP\Business\Permission\Entity\PermissionLevelEntity;
use AnexusPHP\Business\Region\Entity\RegionCountryEntity;
use AnexusPHP\Business\Region\Repository\RegionCountryRepository;
use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Number;
use AnexusPHP\Core\Tools\Strings;

class AuthfastEntity extends MongoEntity
{
	const TABLE = 'authfast';
	protected $_id;
	protected $type;
	protected $code;
	protected $firstname;
	protected $lastname;
	protected $document;
	protected $username;
	protected $email;
	protected $photo;
	protected $banner;
	protected $created_at;
	protected $updated_at;
	protected $expired_at;
	protected $region_country_id;
	public function setId($id)
	{
		$this->_id = Number::intNull($id);
		return $this;
	}
	public function getId()
	{
		return $this->_id;
	}
	public function getType($format = false)
	{
		if ($format && $this->type) {
			switch ($this->type) {
				case 'F':
					return 'Pessoa';
					break;
				case 'J':
					return 'Empresa';
					break;
				default:
					return 'Não informado';
			}
		}
		return $this->type;
	}
	public function setType($type)
	{
		$this->type = Strings::null($type);

		return $this;
	}
	public function setCode($code)
	{
		$this->code = Strings::null($code);
		return $this;
	}
	public function getCode()
	{
		return $this->code;
	}
	public function setFirstname($firstname)
	{
		$this->firstname = Strings::null($firstname);
		return $this;
	}
	public function getFirstname()
	{
		return $this->firstname;
	}
	public function setLastname($lastname)
	{
		$this->lastname = Strings::null($lastname);
		return $this;
	}
	public function getLastname()
	{
		return $this->lastname;
	}
	public function getDocument()
	{
		return $this->document;
	}
	public function setDocument($document)
	{
		$this->document = Strings::null($document);

		return $this;
	}
	public function setUsername($username)
	{
		$this->username = Strings::null($username);
		return $this;
	}
	public function getUsername()
	{
		return $this->username;
	}
	public function setEmail($email)
	{
		$this->email = Strings::null($email);
		return $this;
	}
	public function getEmail()
	{
		return $this->email;
	}
	public function setPhoto($photo)
	{
		$this->photo = Strings::null($photo);
		return $this;
	}
	public function getPhoto()
	{
		return $this->photo;
	}
	public function setBanner($banner)
	{
		$this->banner = Strings::null($banner);
		return $this;
	}
	public function getBanner()
	{
		return $this->banner;
	}
	public function setCreatedAt($createdAt)
	{
		if (is_string($createdAt)) {
			$createdAt = strtotime($createdAt);
		}
		$this->created_at = Number::intNull($createdAt);
		return $this;
	}
	public function getCreatedAt()
	{
		if (is_null($this->created_at)) {
			$this->created_at = strtotime(date('Y-m-d H:i:s'));
		}

		if (is_string($this->created_at)) {
			$this->created_at = strtotime($this->created_at);
		}

		return $this->created_at;
	}
	public function setUpdatedAt($updatedAt)
	{
		if (is_string($updatedAt)) {
			$updatedAt = strtotime($updatedAt);
		}
		$this->updated_at = Number::intNull($updatedAt);
		return $this;
	}
	public function getUpdatedAt()
	{
		if (!is_null($this->updated_at)) {
			if (is_string($this->updated_at)) {
				$this->updated_at = strtotime($this->updated_at);
			}
		}

		return $this->updated_at;
	}
	public function setExpiredAt($expiredAt)
	{
		if (is_string($expiredAt)) {
			$expiredAt = strtotime($expiredAt);
		}
		$this->expired_at = Number::intNull($expiredAt);
		return $this;
	}
	public function getExpiredAt()
	{
		if (!is_null($this->expired_at)) {
			if (is_string($this->expired_at)) {
				$this->expired_at = strtotime($this->expired_at);
			}
		}

		return $this->expired_at;
	}
	public function getRegionCountryId()
	{
		return $this->region_country_id;
	}
	public function setRegionCountryId($regionCountryId)
	{
		$this->region_country_id = Number::intNull($regionCountryId);
		return $this;
	}
	public function toArray()
	{
		return array(
			'_id' => $this->getId(),
			'type' => $this->getType(),
			'code' => $this->getCode(),
			'firstname' => $this->getFirstname(),
			'lastname' => $this->getLastname(),
			'document' => $this->getDocument(),
			'username' => $this->getUsername(),
			'email' => $this->getEmail(),
			'photo' => $this->getPhoto(),
			'banner' => $this->getBanner(),
			'created_at' => $this->getCreatedAt(),
			'updated_at' => $this->getUpdatedAt(),
			'expired_at' => $this->getExpiredAt(),
			'region_country_id' => $this->getRegionCountryId(),
		);
	}

	public function inCountry($code)
	{
		if ($this->getRegionCountry()->getCode() == $code) {
			return true;
		}

		return false;
	}

	/**
	 * Undocumented variable
	 *
	 * @var RegionCountryEntity
	 */
	private $regionCountry;

	/**
	 * Get undocumented variable
	 *
	 * @return  RegionCountryEntity
	 */
	public function getRegionCountry($refresh = false, $cls = RegionCountryEntity::class)
	{
		if (!$this->regionCountry || $refresh) {
			$this->regionCountry = RegionCountryRepository::byId($this->region_country_id, $cls);
		}
		return $this->regionCountry;
	}

	/**
	 * Undocumented variable
	 *
	 * @var PermissionLevelEntity
	 */
	private $permissionLevel;

	/**
	 * Get undocumented variable
	 *
	 * @return  PermissionLevelEntity
	 */
	public function getPermissionLevel(AppEntity $app)
	{
		if (is_null($this->permissionLevel)) {
			$this->permissionLevel = AppAuthfastRepository::byAppAuthfast($app, $this);
		}
		return $this->permissionLevel;
	}
}

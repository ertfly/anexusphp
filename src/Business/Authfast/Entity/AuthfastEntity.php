<?php

namespace AnexusPHP\Business\Authfast\Entity;

use AnexusPHP\Business\Authfast\Rule\AuthfastRule;
use AnexusPHP\Business\Region\Constant\RegionCountryCodeConstant;
use AnexusPHP\Business\Region\Entity\RegionCountryEntity;
use AnexusPHP\Business\Region\Repository\RegionCountryRepository;
use AnexusPHP\Core\DatabaseEntity;

class AuthfastEntity extends DatabaseEntity
{
	const TABLE = 'authfast';
	protected $id;
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
	public function getDocument()
	{
		if (!$this->document && $this->id) {
			$countryCode = substr($this->getCode(), -3);
			$this->document = substr($this->getCode(), 0, strrpos($this->getCode(), $countryCode));
			AuthfastRule::update($this);
		}
		return $this->document;
	}
	public function setDocument($document)
	{
		$this->document = $document;

		return $this;
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
	public function setPhoto($photo)
	{
		$this->photo = $photo;
		return $this;
	}
	public function getPhoto()
	{
		return $this->photo;
	}
	public function setBanner($banner)
	{
		$this->banner = $banner;
		return $this;
	}
	public function getBanner()
	{
		return $this->banner;
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
	public function getRegionCountryId()
	{
		if (!$this->region_country_id && $this->getCode()) {
			$countryCode = substr($this->getCode(), -3);
			$country = RegionCountryRepository::byCode($countryCode);
			$this->region_country_id = $country->getId();
			if ($this->getId()) {
				AuthfastRule::update($this);
			}
		}
		return $this->region_country_id;
	}
	public function setRegionCountryId($regionCountryId)
	{
		$this->region_country_id = $regionCountryId;
		return $this;
	}
	public function toArray()
	{
		return array(
			'code' => $this->getCode(),
			'firstname' => $this->getFirstname(),
			'lastname' => $this->getLastname(),
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

	/* private $document;

	public function getDocument()
	{
		if (!$this->document) {
			$countryCode = substr($this->getCode(), -3);
			$this->document = substr($this->getCode(), 0, strrpos($this->getCode(), $countryCode));
		}
		return $this->document;
	} */

	public function inCountry($initials)
	{
		if ($this->getRegionCountry()->getInitials() == $initials) {
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
	public function getRegionCountry()
	{
		if (!$this->regionCountry) {
			$this->regionCountry = RegionCountryRepository::byId($this->region_country_id, RegionCountryEntity::class);
		}
		return $this->regionCountry;
	}
}

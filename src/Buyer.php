<?php

declare(strict_types=1);

namespace RKocak\Vallet;

use Illuminate\Contracts\Support\Arrayable;
use RKocak\Vallet\Exceptions\InvalidArgumentException;

class Buyer implements Arrayable
{
    protected ?string $name = null;

    protected ?string $surname = null;

    protected ?string $email = null;

    protected ?string $phoneNumber = null;

    protected ?string $address = null;

    protected ?string $city = null;

    protected ?string $country = null;

    protected ?string $district = null;

    protected ?string $ipAddress = null;

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setEmail(string $email): self
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(__('vallet::vallet.invalidEmail'));
        }

        $this->email = $email;

        return $this;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function setIp(string $ip): self
    {
        if (! filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException(__('vallet::vallet.invalidIpAddress'));
        }

        $this->ipAddress = $ip;

        return $this;
    }

    public function setDistrict(string $district): self
    {
        $this->district = $district;

        return $this;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getDistrict(): ?string
    {
        return $this->district;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getIpAddress(): string
    {
        if (empty($this->ipAddress)) {
            return request()->ip();
        }

        return $this->ipAddress;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function toArray(): array
    {
        return [
            'buyerName'     => $this->getName(),
            'buyerSurName'  => $this->getSurname(),
            'buyerGsmNo'    => $this->getPhoneNumber(),
            'buyerEmail'    => $this->getEmail(),
            'buyerIp'       => $this->getIpAddress(),
            'buyerAdress'   => $this->getAddress(),
            'buyerCity'     => $this->getCity(),
            'buyerCountry'  => $this->getCountry(),
            'buyerDistrict' => $this->getDistrict(),
        ];
    }
}

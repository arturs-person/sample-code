<?php

namespace App\Entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('transactions')]
class Transaction
{
    #[Id, Column(type: Types::INTEGER), GeneratedValue]
    protected int $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    #[Column(name: 'card_number')]
    private string $cardNumber;

    #[Column(name: 'vehicle_number')]
    private string $vehicleNumber;

    #[Column]
    private string $product;

    /**
     * Quick Notice: storing monetary values as a float type is not a safe way, and should be used as string
     * in production, but for simplicity for this task I put it to be in use as float.
     */
    #[Column]
    private float $amount;

    #[Column]
    private float $total;

    #[Column]
    private string $currency;

    #[Column(name: 'fuel_station')]
    private string $fuelStation;

    #[Column]
    private string $country;

    #[Column(name: 'countryIso')]
    private string $countryIso;

    #[Column(name: 'product_category')]
    private string $productCategory;

    #[Column]
    private \DateTime $date;

    #[Column(nullable: true)]
    private string $vehicleOdometer;

    #[Column(nullable: true)]
    private string $vehicleCanOdometer;

    #[Column(nullable: true)]
    private string $position;

    #[ManyToOne(inversedBy: 'transactions')]
    private User $user;

    /**
     * @return string
     */
    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    /**
     * @param string $cardNumber
     */
    public function setCardNumber(string $cardNumber): self
    {
        $this->cardNumber = $cardNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getVehicleNumber(): string
    {
        return $this->vehicleNumber;
    }

    /**
     * @param string $vehicleNumber
     */
    public function setVehicleNumber(string $vehicleNumber): self
    {
        $this->vehicleNumber = $vehicleNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getProduct(): string
    {
        return $this->product;
    }

    /**
     * @param string $product
     */
    public function setProduct(string $product): self
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }

    /**
     * @param float $total
     */
    public function setTotal(float $total): self
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return string
     */
    public function getFuelStation(): string
    {
        return $this->fuelStation;
    }

    /**
     * @param string $fuelStation
     */
    public function setFuelStation(string $fuelStation): self
    {
        $this->fuelStation = $fuelStation;
        return $this;
    }

    /**
     * @return string
     */
    public function getProductCategory(): string
    {
        return $this->productCategory;
    }

    /**
     * @param string $productCategory
     */
    public function setProductCategory(string $productCategory): self
    {
        $this->productCategory = $productCategory;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date): self
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
{
    return $this->user;
}

    /**
     * @param User $user
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryIso(): string
    {
        return $this->countryIso;
    }

    /**
     * @param string $countryIso
     */
    public function setCountryIso(string $countryIso): self
    {
        $this->countryIso = $countryIso;
        return $this;
    }

    /**
     * @return string
     */
    public function getVehicleOdometer(): string
    {
        return $this->vehicleOdometer;
    }

    /**
     * @param string $vehicleOdometer
     */
    public function setVehicleOdometer(string $vehicleOdometer): self
    {
        $this->vehicleOdometer = $vehicleOdometer;
        return $this;
    }

    /**
     * @return string
     */
    public function getVehicleCanOdometer(): string
    {
        return $this->vehicleCanOdometer;
    }

    /**
     * @param string $vehicleCanOdometer
     */
    public function setVehicleCanOdometer(string $vehicleCanOdometer): self
    {
        $this->vehicleCanOdometer = $vehicleCanOdometer;
        return $this;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->position;
    }

    /**
     * @param string $position
     */
    public function setPosition(string $position): self
    {
        $this->position = $position;
        return $this;
    }
}
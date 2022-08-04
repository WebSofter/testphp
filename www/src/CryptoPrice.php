<?php


namespace App;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package BlackScorp\ORM\Entity
 * @ORM\Entity
 * @ORM\Table(name="crypto_price")
 */
class CryptoPrice
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected int $id;
    
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, length=32)
     */
    protected string $crypto;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, length=13)
     */
    protected string $fiat;
    /**
     * @var float
     * @ORM\Column(type="decimal", nullable=true, precision=7, scale=2)
     */
    protected float $price;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true, length=11)
     */
    protected string $time;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCrypto(): string
    {
        return $this->crypto;
    }

    /**
     * @param string $crypto
     */
    public function setCrypto(string $crypto): void
    {
        $this->crypto = $crypto;
    }

    /**
     * @return string
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getFiat(): string
    {
        return $this->fiat;
    }

    /**
     * @param string $fiat
     */
    public function setFiat(string $fiat): void
    {
        $this->fiat = $fiat;
    }

    /**
     * @return string
     */
    public function getTime(): int
    {
        return $this->time;
    }

    /**
     * @param string $time
     */
    public function setTime(string $time): void
    {
        $this->time = $time;
    }

}
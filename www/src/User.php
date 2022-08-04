<?php


namespace App;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package BlackScorp\ORM\Entity
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
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
     * @ORM\Column(type="string",nullable=false)
     */
    protected string $username;
    /**
     * @var string
     * @ORM\Column(type="string",nullable=false)
     */
    protected string $password;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=false,unique=true)
     */
    protected string $email;


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
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }


}
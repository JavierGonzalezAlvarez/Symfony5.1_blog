<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
    
    //definimos constantes    
    const REGISTRO_EXITOSO = 'Se ha registrado exitosamente';    

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**     
     * @ORM\Column(type="boolean")
     */
    private $baneado;

    /**     
     * @ORM\Column(type="string")
     */
    private $nombre;

    /*
    Creamos los settesr y los getters de los campos creados manualmente
    */
    public function getBaneado(): ?boolean
    {
        return $this->baneado;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setBaneado(string $baneado): self
    {
        $this->baneado = $baneado;

        return $this;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    /*  ------------------------------------------------------
    colocamos la relacion 1 a muchos con tablas:
    -comentarios
    -post
    -profesion
    -
    */

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comentarios", mappedBy="user")
     */
    private $comentarios;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="user")
     */
    private $post;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Profesion", mappedBy="user")
     */
    private $profesion;


    //constructor
    public function __construct()
    {
        $this->baneado = false;
        $this->roles =['ROLE_USER'];        
    }



}

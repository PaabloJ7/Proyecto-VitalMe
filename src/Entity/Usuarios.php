<?php

namespace App\Entity;

use App\Repository\UsuariosRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

#[ORM\Entity(repositoryClass: UsuariosRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Usuarios implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 180, unique: true, name: 'email')]
    private ?string $email;

    #[ORM\Column(type: 'string', length: 255, unique: true, name: 'username', nullable: true)]
    private ?string $username;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(type: 'string', name: 'password')]
    private string $password;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $genero;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $altura;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $peso;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $edad;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $intensidadFisica;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
private ?string $avatar;

#[ORM\Column(type: 'float', nullable: true, name: 'objetivo_calorias')]
private ?float $objetivoCalorias;

#[ORM\Column(type: 'string', nullable: true, name: 'calorias_deficit')]

private ?float $caloriasDeficit;

#[ORM\Column(type: 'float', nullable: true, name: 'calorias_mantenimiento')]
private ?float $caloriasMantenimiento;

#[ORM\Column(type: 'float', nullable: true, name: 'calorias_superavit')]
private ?float $caloriasSuperavit;


#[ORM\OneToMany(mappedBy: "usuario", targetEntity: RegistroPeso::class, cascade: ["remove"])]
private Collection $registroPesos;

#[ORM\OneToMany(mappedBy: "usuario", targetEntity: Publicacion::class, cascade: ['persist', 'remove'])]
private Collection $publicaciones;

public function __construct()
{
    $this->registroPesos = new ArrayCollection();
    $this->publicaciones = new ArrayCollection();
    $this->objetivoCalorias = 2000;
}


// Getters y Setters

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

public function getUsername(): ?string
{
    return $this->username;
}

public function setUsername(?string $username): self
{
    $this->username = $username;
    return $this;
}

public function getUserIdentifier(): string
{
    return (string) $this->email;
}

public function getRoles(): array
{
    $roles = $this->roles;
    $roles[] = 'ROLE_USER';
    return array_unique($roles);
}

public function setRoles(array $roles): self
{
    $this->roles = $roles;
    return $this;
}

public function getPassword(): string
{
    return $this->password;
}

public function setPassword(string $password): self
{
    $this->password = $password;
    return $this;
}

public function getGenero(): ?string
{
    return $this->genero;
}

public function setGenero(?string $genero): self
{
    $this->genero = $genero;
    return $this;
}

public function getAltura(): ?int
{
    return $this->altura;
}

public function setAltura(?int $altura): self
{
    $this->altura = $altura;
    return $this;
}

public function getPeso(): ?float
{
    return $this->peso;
}

public function setPeso(?float $peso): self
{
    $this->peso = $peso;
    return $this;
}

public function getEdad(): ?int
{
    return $this->edad;
}

public function setEdad(?int $edad): self
{
    $this->edad = $edad;
    return $this;
}

public function getIntensidadFisica(): ?string
{
    return $this->intensidadFisica;
}

public function setIntensidadFisica(?string $intensidadFisica): self
{
    $this->intensidadFisica = $intensidadFisica;
    return $this;
}

public function eraseCredentials(): void
{
}

public function getRegistroPesos(): Collection
{
    return $this->registroPesos;
}

public function addRegistroPeso(RegistroPeso $registroPeso): self
{
    if (!$this->registroPesos->contains($registroPeso)) {
        $this->registroPesos[] = $registroPeso;
        $registroPeso->setUsuario($this);
    }
    return $this;
}

public function removeRegistroPeso(RegistroPeso $registroPeso): self
{
    if ($this->registroPesos->removeElement($registroPeso)) {
        if ($registroPeso->getUsuario() === $this) {
            $registroPeso->setUsuario(null);
        }
    }
    return $this;
}

public function getLastWeight(): ?float
{
    $registroPesos = $this->getRegistroPesos()->toArray();
    if (!empty($registroPesos)) {
        /** @var RegistroPeso $ultimoRegistro */
        $ultimoRegistro = end($registroPesos);
        return $ultimoRegistro->getPeso();
    }
    return null;
}

public function getPublicaciones(): Collection
{
    return $this->publicaciones;
}

public function addPublicacion(Publicacion $publicacion): self
{
    if (!$this->publicaciones->contains($publicacion)) {
        $this->publicaciones[] = $publicacion;
        $publicacion->setUsuario($this);
    }
    return $this;
}

public function removePublicacion(Publicacion $publicacion): self
{
    if ($this->publicaciones->removeElement($publicacion)) {
        if ($publicacion->getUsuario() === $this) {
            $publicacion->setUsuario(null);
        }
    }
    return $this;
}

public function getAvatar(): ?string
{
    return $this->avatar;
}

public function setAvatar(?string $avatar): self
{
    $this->avatar = $avatar;
    return $this;
}

public function getCaloriasDeficit(): ?float
{
    return $this->caloriasDeficit;
}

public function setCaloriasDeficit(?float $caloriasDeficit): self
{
    $this->caloriasDeficit = $caloriasDeficit;
    return $this;
}

public function getCaloriasMantenimiento(): ?float
{
    return $this->caloriasMantenimiento;
}

public function setCaloriasMantenimiento(?float $caloriasMantenimiento): self
{
    $this->caloriasMantenimiento = $caloriasMantenimiento;
    return $this;
}

public function getCaloriasSuperavit(): ?float
{
    return $this->caloriasSuperavit;
}

public function setCaloriasSuperavit(?float $caloriasSuperavit): self
{
    $this->caloriasSuperavit = $caloriasSuperavit;
    return $this;
}

public function getObjetivoCalorias(): ?float
{
    return $this->objetivoCalorias;
}

public function setObjetivoCalorias(?float $objetivoCalorias): self
{
    $this->objetivoCalorias = $objetivoCalorias;
    return $this;
}


}

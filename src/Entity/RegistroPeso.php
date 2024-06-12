<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\RegistroPesoRepository")]
class RegistroPeso
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\ManyToOne(targetEntity: "App\Entity\Usuarios", inversedBy: "registroPesos")]
    #[ORM\JoinColumn(nullable: false)]
    private $usuario;

    #[ORM\Column(type: "float")]
    private $peso;

    #[ORM\Column(type: "datetime")]
    private $fechapeso;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuario(): ?Usuarios
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuarios $usuario): self
    {
        $this->usuario = $usuario;
        return $this;
    }

    public function getPeso(): ?float
    {
        return $this->peso;
    }

    public function setPeso(float $peso): self
    {
        $this->peso = $peso;
        return $this;
    }

    public function getFechapeso(): ?\DateTimeInterface
    {
        return $this->fechapeso;
    }

    public function setFechapeso(\DateTimeInterface $fechapeso): self
    {
        $this->fechapeso = $fechapeso;
        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\RegistroEjercicioRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegistroEjercicioRepository::class)]
class RegistroEjercicio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $fecha;

    #[ORM\Column(type: 'integer')]
    private int $duracionMinutos;

    #[ORM\ManyToOne(targetEntity: Ejercicio::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ejercicio $ejercicio;

    #[ORM\ManyToOne(targetEntity: Usuarios::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuarios $usuario;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getDuracionMinutos(): ?int
    {
        return $this->duracionMinutos;
    }

    public function setDuracionMinutos(int $duracionMinutos): self
    {
        $this->duracionMinutos = $duracionMinutos;

        return $this;
    }

    public function getEjercicio(): ?Ejercicio
    {
        return $this->ejercicio;
    }

    public function setEjercicio(?Ejercicio $ejercicio): self
    {
        $this->ejercicio = $ejercicio;

        return $this;
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
}

<?php

namespace App\Entity;

use App\Repository\EjercicioRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EjercicioRepository::class)]
class Ejercicio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nombre;

    #[ORM\Column(type: 'float')]
    private float $caloriasPorMinuto;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCaloriasPorMinuto(): ?float
    {
        return $this->caloriasPorMinuto;
    }

    public function setCaloriasPorMinuto(float $caloriasPorMinuto): self
    {
        $this->caloriasPorMinuto = $caloriasPorMinuto;

        return $this;
    }
}

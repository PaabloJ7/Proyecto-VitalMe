<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PublicacionRepository;

#[ORM\Entity(repositoryClass: PublicacionRepository::class)]
class Publicacion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'text')]
    private string $contenido;

    #[ORM\ManyToOne(targetEntity: Usuarios::class, inversedBy: 'publicaciones')]
    #[ORM\JoinColumn(nullable: false)]
    private Usuarios $usuario;

    #[ORM\Column(type: 'integer')]
private int $likes = 0;

    
     #[ORM\Column(type: "datetime")]
     
    private \DateTimeInterface $createdAt;

    // Getters y Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenido(): ?string
    {
        return $this->contenido;
    }

    public function setContenido(string $contenido): self
    {
        $this->contenido = $contenido;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getLikes(): int
{
    return $this->likes;
}

public function setLikes(int $likes): self
{
    $this->likes = $likes;
    return $this;
}

public function incrementLikes(): self
{
    $this->likes++;
    return $this;
}

public function decrementLikes(): self
{
    $this->likes--;
    return $this;
}
}

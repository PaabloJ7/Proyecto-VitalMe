<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


 #[ORM\Entity(repositoryClass: "App\Repository\RegistroAlimentoRepository")]

class RegistroAlimento
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
     
    private $id;

    
    #[ORM\ManyToOne(targetEntity: "App\Entity\Usuarios", inversedBy: "registroAlimento", cascade: ["remove"])]
    #[ORM\JoinColumn(nullable: false)]
    
    private $usuario;

    
     #[ORM\Column(type:"string", length: 255)]
     
    private $nombreAlimento;

    
     #[ORM\Column(type: "integer")]
     
    private $cantidad;

    
     #[ORM\Column(type: "integer")]
     
    private $calorias;

    #[ORM\Column(type: "datetime")]
     
    private $fecha;

    public function __construct()
    {
        $this->fecha = new \DateTime(); 
    }

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

    public function getNombreAlimento(): ?string
    {
        return $this->nombreAlimento;
    }

    public function setNombreAlimento(string $nombreAlimento): self
    {
        $this->nombreAlimento = $nombreAlimento;

        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getCalorias(): ?int
    {
        return $this->calorias;
    }

    public function setCalorias(int $calorias): self
    {
        $this->calorias = $calorias;

        return $this;
    }

    public function getFecha(): ?\DateTime
    {
        return $this->fecha;
    }

    public function setFecha(\DateTime $fecha): self
    {
        $this->fecha = $fecha;
        return $this;
    }
}

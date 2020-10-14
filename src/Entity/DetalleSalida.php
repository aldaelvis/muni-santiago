<?php

namespace App\Entity;

use App\Repository\DetalleSalidaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DetalleSalidaRepository::class)
 */
class DetalleSalida
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Salida::class, inversedBy="detalleSalidas")
     */
    private $salida;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="detalleSalidas")
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSalida(): ?Salida
    {
        return $this->salida;
    }

    public function setSalida(?Salida $salida): self
    {
        $this->salida = $salida;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}

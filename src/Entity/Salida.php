<?php

namespace App\Entity;

use App\Repository\SalidaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SalidaRepository::class)
 */
class Salida
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $total;

    /**
     * @ORM\OneToMany(targetEntity=DetalleSalida::class, mappedBy="salida")
     */
    private $detalleSalidas;

    public function __construct()
    {
        $this->detalleSalidas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return Collection|DetalleSalida[]
     */
    public function getDetalleSalidas(): Collection
    {
        return $this->detalleSalidas;
    }

    public function addDetalleSalida(DetalleSalida $detalleSalida): self
    {
        if (!$this->detalleSalidas->contains($detalleSalida)) {
            $this->detalleSalidas[] = $detalleSalida;
            $detalleSalida->setSalida($this);
        }

        return $this;
    }

    public function removeDetalleSalida(DetalleSalida $detalleSalida): self
    {
        if ($this->detalleSalidas->contains($detalleSalida)) {
            $this->detalleSalidas->removeElement($detalleSalida);
            // set the owning side to null (unless already changed)
            if ($detalleSalida->getSalida() === $this) {
                $detalleSalida->setSalida(null);
            }
        }

        return $this;
    }
}

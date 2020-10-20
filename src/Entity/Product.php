<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 *
 */
class Product
{
    /**
     * @Groups("normal")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("normal")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $code;

    /**
     * @Groups("normal")
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @Groups("normal")
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @Groups("normal")
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price_unit;

    /**
     * @ORM\OneToMany(targetEntity=DetailEntry::class, mappedBy="product")
     */
    private $detailEntries;

    /**
     * @ORM\OneToMany(targetEntity=DetalleSalida::class, mappedBy="product")
     */
    private $detalleSalidas;

    /**
     * @ORM\ManyToOne(targetEntity=Medida::class, inversedBy="products")
     */
    private $medida;

    public function __construct()
    {
        $this->detailEntries = new ArrayCollection();
        $this->detalleSalidas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getPriceUnit(): ?string
    {
        return $this->price_unit;
    }

    public function setPriceUnit(string $price_unit): self
    {
        $this->price_unit = $price_unit;

        return $this;
    }

    /**
     * @return Collection|DetailEntry[]
     */
    public function getDetailEntries(): Collection
    {
        return $this->detailEntries;
    }

    public function addDetailEntry(DetailEntry $detailEntry): self
    {
        if (!$this->detailEntries->contains($detailEntry)) {
            $this->detailEntries[] = $detailEntry;
            $detailEntry->setProduct($this);
        }

        return $this;
    }

    public function removeDetailEntry(DetailEntry $detailEntry): self
    {
        if ($this->detailEntries->contains($detailEntry)) {
            $this->detailEntries->removeElement($detailEntry);
            // set the owning side to null (unless already changed)
            if ($detailEntry->getProduct() === $this) {
                $detailEntry->setProduct(null);
            }
        }

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
            $detalleSalida->setProduct($this);
        }

        return $this;
    }

    public function removeDetalleSalida(DetalleSalida $detalleSalida): self
    {
        if ($this->detalleSalidas->contains($detalleSalida)) {
            $this->detalleSalidas->removeElement($detalleSalida);
            // set the owning side to null (unless already changed)
            if ($detalleSalida->getProduct() === $this) {
                $detalleSalida->setProduct(null);
            }
        }

        return $this;
    }

    public function getMedida(): ?Medida
    {
        return $this->medida;
    }

    public function setMedida(?Medida $medida): self
    {
        $this->medida = $medida;

        return $this;
    }
}

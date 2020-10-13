<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $measurement;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price_unit;

    /**
     * @ORM\OneToMany(targetEntity=DetailEntry::class, mappedBy="product")
     */
    private $detailEntries;

    public function __construct()
    {
        $this->detailEntries = new ArrayCollection();
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

    public function getMeasurement(): ?string
    {
        return $this->measurement;
    }

    public function setMeasurement(string $measurement): self
    {
        $this->measurement = $measurement;

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
}

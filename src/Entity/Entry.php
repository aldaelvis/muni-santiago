<?php

namespace App\Entity;

use App\Repository\EntryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntryRepository::class)
 * @ORM\Table(name="entries")
 */
class Entry
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
     * @ORM\OneToMany(targetEntity=DetailEntry::class, mappedBy="entry")
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
            $detailEntry->setEntry($this);
        }

        return $this;
    }

    public function removeDetailEntry(DetailEntry $detailEntry): self
    {
        if ($this->detailEntries->contains($detailEntry)) {
            $this->detailEntries->removeElement($detailEntry);
            // set the owning side to null (unless already changed)
            if ($detailEntry->getEntry() === $this) {
                $detailEntry->setEntry(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\SpecificationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SpecificationsRepository::class)]
class Specifications
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getCities", "getSpecifications"])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(["getCities", "getSpecifications"])]
    private ?int $size = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getCities", "getSpecifications"])]
    private ?string $first_lang = null;

    #[ORM\OneToMany(mappedBy: 'specifications', targetEntity: Cities::class)]
    #[Groups(["getSpecifications"])]
    private Collection $Cities;

    public function __construct()
    {
        $this->Cities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getFirstLang(): ?string
    {
        return $this->first_lang;
    }

    public function setFirstLang(string $first_lang): static
    {
        $this->first_lang = $first_lang;

        return $this;
    }

    /**
     * @return Collection<int, Cities>
     */
    public function getCities(): Collection
    {
        return $this->Cities;
    }

    public function addCity(Cities $city): static
    {
        if (!$this->Cities->contains($city)) {
            $this->Cities->add($city);
            $city->setSpecifications($this);
        }

        return $this;
    }

    public function removeCity(Cities $city): static
    {
        if ($this->Cities->removeElement($city)) {
            // set the owning side to null (unless already changed)
            if ($city->getSpecifications() === $this) {
                $city->setSpecifications(null);
            }
        }

        return $this;
    }
}

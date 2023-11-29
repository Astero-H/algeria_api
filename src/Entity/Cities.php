<?php

namespace App\Entity;

use App\Repository\CitiesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CitiesRepository::class)]
class Cities
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getCities", "getSpecifications"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getCities", "getSpecifications"])]
    private ?string $city = null;

    #[ORM\Column]
    #[Groups(["getCities", "getSpecifications"])]
    private ?float $lat = null;

    #[ORM\Column]
    #[Groups(["getCities", "getSpecifications"])]
    private ?float $lng = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getCities", "getSpecifications"])]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getCities", "getSpecifications"])]
    private ?string $iso2 = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getCities", "getSpecifications"])]
    private ?string $admin_name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getCities", "getSpecifications"])]
    private ?string $capital = null;

    #[ORM\Column]
    #[Groups(["getCities", "getSpecifications"])]
    private ?int $population = null;

    #[ORM\Column]
    #[Groups(["getCities", "getSpecifications"])]
    private ?int $population_proper = null;

    #[ORM\ManyToOne(inversedBy: 'Cities')]
    #[Groups(["getCities"])]
    private ?Specifications $specifications = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): static
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(float $lng): static
    {
        $this->lng = $lng;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getIso2(): ?string
    {
        return $this->iso2;
    }

    public function setIso2(string $iso2): static
    {
        $this->iso2 = $iso2;

        return $this;
    }

    public function getAdminName(): ?string
    {
        return $this->admin_name;
    }

    public function setAdminName(string $admin_name): static
    {
        $this->admin_name = $admin_name;

        return $this;
    }

    public function getCapital(): ?string
    {
        return $this->capital;
    }

    public function setCapital(string $capital): static
    {
        $this->capital = $capital;

        return $this;
    }

    public function getPopulation(): ?int
    {
        return $this->population;
    }

    public function setPopulation(int $population): static
    {
        $this->population = $population;

        return $this;
    }

    public function getPopulationProper(): ?int
    {
        return $this->population_proper;
    }

    public function setPopulationProper(int $population_proper): static
    {
        $this->population_proper = $population_proper;

        return $this;
    }

    public function getSpecifications(): ?Specifications
    {
        return $this->specifications;
    }

    public function setSpecifications(?Specifications $specifications): static
    {
        $this->specifications = $specifications;

        return $this;
    }
}

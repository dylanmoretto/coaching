<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FoodRepository")
 */
class Food
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $protein;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $glucide;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $kcal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getProtein(): ?string
    {
        return $this->protein;
    }

    public function setProtein(string $protein): self
    {
        $this->protein = $protein;

        return $this;
    }

    public function getGlucide(): ?string
    {
        return $this->glucide;
    }

    public function setGlucide(string $glucide): self
    {
        $this->glucide = $glucide;

        return $this;
    }

    public function getFat(): ?string
    {
        return $this->fat;
    }

    public function setFat(string $fat): self
    {
        $this->fat = $fat;

        return $this;
    }

    public function getKcal(): ?string
    {
        return $this->kcal;
    }

    public function setKcal(string $kcal): self
    {
        $this->kcal = $kcal;

        return $this;
    }
}

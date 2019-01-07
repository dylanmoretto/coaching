<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DietItemRepository")
 */
class DietItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $FoodId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\Column(type="float")
     */
    private $qte;

    /**
     * @ORM\Column(type="float")
     */
    private $protein;

    /**
     * @ORM\Column(type="float")
     */
    private $Carb;

    /**
     * @ORM\Column(type="float")
     */
    private $Fat;

    /**
     * @ORM\Column(type="float")
     */
    private $kcal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idDiet;

    /**
     * @ORM\Column(type="integer")
     */
    private $repas;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFoodId(): ?int
    {
        return $this->FoodId;
    }

    public function setFoodId(int $FoodId): self
    {
        $this->FoodId = $FoodId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getQte(): ?float
    {
        return $this->qte;
    }

    public function setQte(float $qte): self
    {
        $this->qte = $qte;

        return $this;
    }

    public function getProtein(): ?float
    {
        return $this->protein;
    }

    public function setProtein(float $protein): self
    {
        $this->protein = $protein;

        return $this;
    }

    public function getCarb(): ?float
    {
        return $this->Carb;
    }

    public function setCarb(float $Carb): self
    {
        $this->Carb = $Carb;

        return $this;
    }

    public function getFat(): ?float
    {
        return $this->Fat;
    }

    public function setFat(float $Fat): self
    {
        $this->Fat = $Fat;

        return $this;
    }

    public function getKcal(): ?float
    {
        return $this->kcal;
    }

    public function setKcal(float $kcal): self
    {
        $this->kcal = $kcal;

        return $this;
    }

    public function getIdDiet(): ?string
    {
        return $this->idDiet;
    }

    public function setIdDiet(string $idDiet): self
    {
        $this->idDiet = $idDiet;

        return $this;
    }

    public function getRepas(): ?int
    {
        return $this->repas;
    }

    public function setRepas(int $repas): self
    {
        $this->repas = $repas;

        return $this;
    }
}

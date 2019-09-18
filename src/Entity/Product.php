<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ean;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\Column(type="blob")
     */
    private $imagelong;

    /**
     * @ORM\Column(type="integer")
     */
    private $buyprice;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $artnr;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordernr;

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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

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

    public function getEan(): ?string
    {
        return $this->ean;
    }

    public function setEan(string $ean): self
    {
        $this->ean = $ean;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getImagelong()
    {
        return $this->imagelong;
    }

    public function setImagelong($imagelong): self
    {
        $this->imagelong = $imagelong;

        return $this;
    }

    public function getBuyprice(): ?int
    {
        return $this->buyprice;
    }

    public function setBuyprice(int $buyprice): self
    {
        $this->buyprice = $buyprice;

        return $this;
    }

    public function getArtnr(): ?string
    {
        return $this->artnr;
    }

    public function setArtnr(string $artnr): self
    {
        $this->artnr = $artnr;

        return $this;
    }

    public function getOrdernr(): ?int
    {
        return $this->ordernr;
    }

    public function setOrdernr(int $ordernr): self
    {
        $this->ordernr = $ordernr;

        return $this;
    }
}

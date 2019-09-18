<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order
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
    private $product_ean;

    /**
     * @ORM\Column(type="integer")
     */
    private $product_price;

    /**
     * @ORM\Column(type="integer")
     */
    private $product_buyin;

    /**
     * @ORM\Column(type="integer")
     */
    private $product_amount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cust_mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $order_time;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordernr;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductEan(): ?string
    {
        return $this->product_ean;
    }

    public function setProductEan(string $product_ean): self
    {
        $this->product_ean = $product_ean;

        return $this;
    }

    public function getProductPrice(): ?int
    {
        return $this->product_price;
    }

    public function setProductPrice(int $product_price): self
    {
        $this->product_price = $product_price;

        return $this;
    }

    public function getProductBuyin(): ?int
    {
        return $this->product_buyin;
    }

    public function setProductBuyin(int $product_buyin): self
    {
        $this->product_buyin = $product_buyin;

        return $this;
    }

    public function getProductAmount(): ?int
    {
        return $this->product_amount;
    }

    public function setProductAmount(int $product_amount): self
    {
        $this->product_amount = $product_amount;

        return $this;
    }

    public function getCustMail(): ?string
    {
        return $this->cust_mail;
    }

    public function setCustMail(string $cust_mail): self
    {
        $this->cust_mail = $cust_mail;

        return $this;
    }

    public function getOrderTime(): ?string
    {
        return $this->order_time;
    }

    public function setOrderTime(string $order_time): self
    {
        $this->order_time = $order_time;

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

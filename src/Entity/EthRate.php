<?php

namespace App\Entity;

use App\Repository\EthRateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EthRateRepository::class)]
class EthRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $rateDate = null;

    #[ORM\Column]
    private ?float $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRateDate(): ?\DateTimeInterface
    {
        return $this->rateDate;
    }

    public function setRateDate(\DateTimeInterface $rateDate): static
    {
        $this->rateDate = $rateDate;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): static
    {
        $this->value = $value;

        return $this;
    }
}

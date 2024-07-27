<?php

namespace App\Entity;

use App\Repository\TypesEquipmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypesEquipmentRepository::class)]
class TypesEquipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_type = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_creetion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomType(): ?string
    {
        return $this->nom_type;
    }

    public function setNomType(string $nom_type): static
    {
        $this->nom_type = $nom_type;

        return $this;
    }

    public function getDateCreetion(): ?\DateTimeInterface
    {
        return $this->date_creetion;
    }

    public function setDateCreetion(\DateTimeInterface $date_creetion): static
    {
        $this->date_creetion = $date_creetion;

        return $this;
    }
}

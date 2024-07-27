<?php

namespace App\Entity;

use App\Repository\MantonanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MantonanceRepository::class)]
class Mantonance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'numeroMnt',type:'integer')]
    private ?int $id = null;

    
    #[ORM\ManyToOne(targetEntity: Equipment::class)]
    #[ORM\JoinColumn(name:"numeroEqp", referencedColumnName:"numeroEqp")]
    private Collection $numeroEqp;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_entre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_sorte = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $detail = null;

    public function __construct()
    {
        $this->numeroEqp = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, equipment>
     */
    public function getNumeroEqp(): Collection
    {
        return $this->numeroEqp;
    }

    public function addNumeroEqp(equipment $numeroEqp): static
    {
        if (!$this->numeroEqp->contains($numeroEqp)) {
            $this->numeroEqp->add($numeroEqp);
        }

        return $this;
    }

    public function removeNumeroEqp(equipment $numeroEqp): static
    {
        $this->numeroEqp->removeElement($numeroEqp);

        return $this;
    }

    public function getDateEntre(): ?\DateTimeInterface
    {
        return $this->date_entre;
    }

    public function setDateEntre(\DateTimeInterface $date_entre): static
    {
        $this->date_entre = $date_entre;

        return $this;
    }

    public function getDateSorte(): ?\DateTimeInterface
    {
        return $this->date_sorte;
    }

    public function setDateSorte(?\DateTimeInterface $date_sorte): static
    {
        $this->date_sorte = $date_sorte;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(?string $detail): static
    {
        $this->detail = $detail;

        return $this;
    }
}

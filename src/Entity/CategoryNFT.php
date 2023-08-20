<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CategoryNFTRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoryNFTRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'category:read', 'nft:read'],
)] class CategoryNFT
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['nft:read', 'category:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['nft:read', 'category:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['nft:read', 'category:read'])]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: NFT::class, inversedBy: 'categoryNFTs')]
    #[Groups(['category:read'])]
    private Collection $NFT;

    public function __construct()
    {
        $this->NFT = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, NFT>
     */
    public function getNFT(): Collection
    {
        return $this->NFT;
    }

    public function addNFT(NFT $nFT): static
    {
        if (!$this->NFT->contains($nFT)) {
            $this->NFT->add($nFT);
        }

        return $this;
    }

    public function removeNFT(NFT $nFT): static
    {
        $this->NFT->removeElement($nFT);

        return $this;
    }
}

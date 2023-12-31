<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CollectionNFTRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CollectionNFTRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'collection:read'],
)]

class CollectionNFT
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['collection:read', 'nft:read', 'nft:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['collection:read', 'nft:read', 'nft:write'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'collectionNFT', targetEntity: NFT::class)]
    #[Groups(['nft:read', 'collection:read'])]
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
            $nFT->setCollectionNFT($this);
        }

        return $this;
    }

    public function removeNFT(NFT $nFT): static
    {
        if ($this->NFT->removeElement($nFT)) {
            // set the owning side to null (unless already changed)
            if ($nFT->getCollectionNFT() === $this) {
                $nFT->setCollectionNFT(null);
            }
        }

        return $this;
    }
}

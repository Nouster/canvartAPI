<?php

namespace App\Entity;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\NFTRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NFTRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'nft:read'],
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'ipartial'])]

class NFT
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['category:read', 'nft:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['category:read', 'nft:read'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['category:read', 'nft:read'])]
    private ?string $img = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['nft:read'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['nft:read'])]
    private ?\DateTimeInterface $launchDate = null;

    #[ORM\Column]
    #[Groups(['nft:read'])]
    private ?float $launchPriceEth = null;

    #[ORM\Column]
    #[Groups(['nft:read'])]
    private ?float $launchPriceEuro = null;

    #[ORM\ManyToOne(inversedBy: 'NFT')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['nft:read'])]
    private ?CollectionNFT $collectionNFT = null;

    #[ORM\ManyToMany(targetEntity: CategoryNFT::class, mappedBy: 'NFT')]
    #[Groups(['nft:read'])]
    private Collection $categoryNFTs;

    // #[ORM\OneToMany(mappedBy: 'nFT', targetEntity: User::class)]
    // #[Groups('nft:read')]
    // private Collection $User;

    #[ORM\ManyToOne(inversedBy: 'nFT')]
    #[Groups(['nft:read'])]
    private ?User $User = null;

    #[ORM\Column(length: 255)]
    #[Groups(['nft:read'])]
    private ?string $creator = null;

    public function __construct()
    {
        $this->categoryNFTs = new ArrayCollection();
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

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

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

    public function getLaunchDate(): ?\DateTimeInterface
    {
        return $this->launchDate;
    }

    public function setLaunchDate(\DateTimeInterface $launchDate): static
    {
        $this->launchDate = $launchDate;

        return $this;
    }

    public function getLaunchPriceEth(): ?float
    {
        return $this->launchPriceEth;
    }

    public function setLaunchPriceEth(float $launchPriceEth): static
    {
        $this->launchPriceEth = $launchPriceEth;

        return $this;
    }

    public function getLaunchPriceEuro(): ?float
    {
        return $this->launchPriceEuro;
    }

    public function setLaunchPriceEuro(float $launchPriceEuro): static
    {
        $this->launchPriceEuro = $launchPriceEuro;

        return $this;
    }

    public function getCollectionNFT(): ?CollectionNFT
    {
        return $this->collectionNFT;
    }

    public function setCollectionNFT(?CollectionNFT $collectionNFT): static
    {
        $this->collectionNFT = $collectionNFT;

        return $this;
    }

    /**
     * @return Collection<int, CategoryNFT>
     */
    public function getCategoryNFTs(): Collection
    {
        return $this->categoryNFTs;
    }

    public function addCategoryNFT(CategoryNFT $categoryNFT): static
    {
        if (!$this->categoryNFTs->contains($categoryNFT)) {
            $this->categoryNFTs->add($categoryNFT);
            $categoryNFT->addNFT($this);
        }

        return $this;
    }

    public function removeCategoryNFT(CategoryNFT $categoryNFT): static
    {
        if ($this->categoryNFTs->removeElement($categoryNFT)) {
            $categoryNFT->removeNFT($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $user): static
    {
        $this->User = $user;

        return $this;
    }



    public function getCreator(): ?string
    {
        return $this->creator;
    }

    public function setCreator(string $creator): static
    {
        $this->creator = $creator;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\NFTRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NFTRepository::class)]
class NFT
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $launchDate = null;

    #[ORM\Column]
    private ?float $launchPriceEth = null;

    #[ORM\Column]
    private ?float $launchPriceEuro = null;

    #[ORM\ManyToOne(inversedBy: 'NFT')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CollectionNFT $collectionNFT = null;

    #[ORM\ManyToMany(targetEntity: CategoryNFT::class, mappedBy: 'NFT')]
    private Collection $categoryNFTs;

    #[ORM\OneToMany(mappedBy: 'nFT', targetEntity: User::class)]
    private Collection $User;

    public function __construct()
    {
        $this->categoryNFTs = new ArrayCollection();
        $this->User = new ArrayCollection();
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
    public function getUser(): Collection
    {
        return $this->User;
    }

    public function addUser(User $user): static
    {
        if (!$this->User->contains($user)) {
            $this->User->add($user);
            $user->setNFT($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->User->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getNFT() === $this) {
                $user->setNFT(null);
            }
        }

        return $this;
    }
}
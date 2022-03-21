<?php

namespace App\Entity;

use App\Repository\ParentEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ParentEntityRepository::class)
 */
class ParentEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prop1;

    /**
     * @ORM\OneToMany(targetEntity=ChildEntity::class, mappedBy="parentEntity", cascade={"persist","remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $childEntities;

    public function __construct()
    {
        $this->childEntities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProp1(): ?string
    {
        return $this->prop1;
    }

    public function setProp1(?string $prop1): self
    {
        $this->prop1 = $prop1;

        return $this;
    }

    /**
     * @return Collection<int, ChildEntity>
     */
    public function getChildEntities(): Collection
    {
        return $this->childEntities;
    }

    public function addChildEntity(ChildEntity $childEntity): self
    {
        if (!$this->childEntities->contains($childEntity)) {
            $this->childEntities[] = $childEntity;
            $childEntity->setParentEntity($this);
        }

        return $this;
    }

    public function removeChildEntity(ChildEntity $childEntity): self
    {
        if ($this->childEntities->removeElement($childEntity)) {
            // set the owning side to null (unless already changed)
            if ($childEntity->getParentEntity() === $this) {
                $childEntity->setParentEntity(null);
            }
        }

        return $this;
    }
}

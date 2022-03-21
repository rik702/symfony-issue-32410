<?php

namespace App\Entity;

use App\Repository\ChildEntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ChildEntityRepository::class)
 */
class ChildEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    private $childProp1;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank
     */
    private $childProp2;

    /**
     * @ORM\ManyToOne(targetEntity=ParentEntity::class, inversedBy="childEntities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $parentEntity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChildProp1(): ?string
    {
        return $this->childProp1;
    }

    public function setChildProp1(?string $childProp1): self
    {
        $this->childProp1 = $childProp1;

        return $this;
    }

    public function getChildProp2(): ?int
    {
        return $this->childProp2;
    }

    public function setChildProp2(?int $childProp2): self
    {
        $this->childProp2 = $childProp2;

        return $this;
    }

    public function getParentEntity(): ?ParentEntity
    {
        return $this->parentEntity;
    }

    public function setParentEntity(?ParentEntity $parentEntity): self
    {
        $this->parentEntity = $parentEntity;

        return $this;
    }
}

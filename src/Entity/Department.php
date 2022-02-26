<?php

namespace App\Entity;

use App\Repository\DepartmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartmentRepository::class)]
class Department
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $color;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'department')]
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getUsers()
    {
        return $this -> users;
    }

    public function addUser(User $user){
        if(!$this->users->contains($user)){
            $this->users->add($user);
        }
    }

    public function removeUser(User $user){
        if($this->users->contains($user)){
            $this->users->removeElement($user);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }
    public function __toString(){
        return $this->name;
    }
}

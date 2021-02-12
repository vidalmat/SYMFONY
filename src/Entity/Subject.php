<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubjectRepository::class)
 */
class Subject
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=POST::class, mappedBy="subject", orphanRemoval=true)
     */
    private $pOSTs;

    public function __construct()
    {
        $this->pOSTs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|POST[]
     */
    public function getPOSTs(): Collection
    {
        return $this->pOSTs;
    }

    public function addPOST(POST $pOST): self
    {
        if (!$this->pOSTs->contains($pOST)) {
            $this->pOSTs[] = $pOST;
            $pOST->setSubject($this);
        }

        return $this;
    }

    public function removePOST(POST $pOST): self
    {
        if ($this->pOSTs->removeElement($pOST)) {
            // set the owning side to null (unless already changed)
            if ($pOST->getSubject() === $this) {
                $pOST->setSubject(null);
            }
        }

        return $this;
    }


    
}

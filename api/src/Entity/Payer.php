<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Payer
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column]
    public string $entity_type = 'individual';

    #[ORM\Column]
    public string $type = 'customer';

    #[ORM\Column]
    public string $email = '';

    #[OneToOne(targetEntity: PayerIdentification::class)]
    #[JoinColumn(name: 'identification_id', referencedColumnName: 'id')]
    public ?PayerIdentification $identification = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}

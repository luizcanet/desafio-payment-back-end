<?php
namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
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

    #[Groups(['postWrite'])]
    #[ORM\Column]
    public string $email = '';

    #[Groups(['postWrite'])]
    #[ORM\OneToOne(targetEntity: PayerIdentification::class)]
    #[ORM\JoinColumn(name: 'identification_id', referencedColumnName: 'id')]
    public PayerIdentification $identification;
}

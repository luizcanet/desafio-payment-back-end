<?php
namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Payer
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column]
    public string $entity_type = 'individual';

    #[ORM\Column]
    public string $type = 'customer';

    #[Groups(['PostRequest'])]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[ORM\Column]
    public string $email = '';

    #[Groups(['PostRequest'])]
    #[Assert\Valid]
    #[ORM\OneToOne(targetEntity: PayerIdentification::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'identification_id', referencedColumnName: 'id', nullable: false)]
    public PayerIdentification $identification;
}

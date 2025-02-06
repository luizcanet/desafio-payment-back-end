<?php
namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class PayerIdentification
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private ?int $id = null;

    #[Groups(['PostRequest'])]
    #[Assert\NotBlank()]
    #[ORM\Column]
    public string $type = '';

    #[Groups(['PostRequest'])]
    #[Assert\NotBlank()]
    #[ORM\Column]
    public string $number = '';
}

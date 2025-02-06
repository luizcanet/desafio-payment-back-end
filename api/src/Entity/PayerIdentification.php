<?php
namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class PayerIdentification
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private ?int $id = null;

    #[Groups(['postWrite'])]
    #[ORM\Column]
    public string $type = '';

    #[Groups(['postWrite'])]
    #[ORM\Column]
    public string $number = '';
}

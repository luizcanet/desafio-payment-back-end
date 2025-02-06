<?php
namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ApiResource]
#[Get]
#[GetCollection]
#[Post(
    normalizationContext: ['groups' => ['postRead']],
    denormalizationContext: ['groups' => ['postWrite']]
)]
#[Patch(
    denormalizationContext: ['groups' => ['patchWrite']]
)]
#[Delete]
class Payment
{
    #[Groups(['postRead'])]
    #[ORM\Id]
    #[ORM\Column(type: "uuid")]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator('doctrine.uuid_generator')]
    public $id;

    #[Groups(['postWrite'])]
    #[ORM\Column(type: "float")]
    public float $transaction_amount = 0.0;

    #[Groups(['postWrite'])]
    #[ORM\Column(type: "integer")]
    public int $installments = 0;

    #[Groups(['postWrite'])]
    #[ORM\Column]
    public string $token = '';

    #[Groups(['postWrite'])]
    #[ORM\Column]
    public string $payment_method_id = '';

    #[Groups(['postWrite'])]
    #[OneToOne(targetEntity: Payer::class)]
    #[JoinColumn(name: 'payer_id', referencedColumnName: 'id')]
    public Payer $payer;

    #[Groups(['postWrite'])]
    #[ORM\Column]
    public string $notification_url = 'https://webhook.site/dd00c411-14b5-4110-a25b-177836964162';

    #[Groups(['postRead'])]
    #[ORM\Column(type: "date_immutable")]
    public ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: "date")]
    public ?\DateTime $updated_at = null;

    #[Groups(['patchWrite'])]
    #[ORM\Column]
    public string $status = '';
}

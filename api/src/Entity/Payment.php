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
use App\State\PaymentPostProcessor;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource]
#[Get]
#[GetCollection]
#[Post(
    processor: PaymentPostProcessor::class,
    normalizationContext: ['groups' => ['PostResponse']],
    denormalizationContext: ['groups' => ['PostRequest']]
)]
#[Patch(
    denormalizationContext: ['groups' => ['PatchRequest']]
)]
#[Delete]
class Payment
{
    #[Groups(['PostResponse'])]
    #[ORM\Id]
    #[ORM\Column(type: "uuid")]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator('doctrine.uuid_generator')]
    public $id;

    #[Groups(['PostRequest'])]
    #[Assert\Positive]
    #[ORM\Column(type: "float")]
    public float $transaction_amount = 0.0;

    #[Groups(['PostRequest'])]
    #[Assert\Positive]
    #[ORM\Column(type: "integer")]
    public int $installments = 0;

    #[Groups(['PostRequest'])]
    #[Assert\NotBlank]
    #[ORM\Column]
    public string $token = '';

    #[Groups(['PostRequest'])]
    #[Assert\NotBlank]
    #[ORM\Column]
    public string $payment_method_id = '';

    #[Groups(['PostRequest'])]
    #[ORM\OneToOne(targetEntity: Payer::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'payer_id', referencedColumnName: 'id', nullable: false)]
    public Payer $payer;

    #[ORM\Column]
    public string $notification_url = 'https://webhook.site/dd00c411-14b5-4110-a25b-177836964162';

    #[Groups(['PostResponse'])]
    #[ORM\Column(type: "date_immutable")]
    public ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: "date")]
    public ?\DateTime $updated_at = null;

    #[Groups(['PatchRequest'])]
    #[ORM\Column]
    public string $status = 'PENDING';
}

<?php
namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\State\PaymentDeleteProcessor;
use App\State\PaymentPatchProcessor;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\ConversionException;
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
    status: 204,
    processor: PaymentPatchProcessor::class,
    exceptionToStatus: [ConversionException::class => 404],
    denormalizationContext: ['groups' => ['PatchRequest']]
)]
#[Delete(
    processor: PaymentDeleteProcessor::class,
    exceptionToStatus: [ConversionException::class => 404]
)]
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
    #[Assert\Valid]
    #[ORM\OneToOne(targetEntity: Payer::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'payer_id', referencedColumnName: 'id', nullable: false)]
    public Payer $payer;

    #[ORM\Column]
    public string $notification_url = 'https://webhook.site/dd00c411-14b5-4110-a25b-177836964162';

    #[Groups(['PostResponse'])]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    #[ORM\Column(type: "date_immutable")]
    public ?\DateTimeImmutable $created_at = null;

    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    #[ORM\Column(type: "date")]
    public ?\DateTime $updated_at = null;

    #[Groups(['PatchRequest'])]
    #[ORM\Column]
    public string $status = 'PENDING';
}

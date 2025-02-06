<?php
namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ApiResource]
class Payment
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid")]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator('doctrine.uuid_generator')]
    public $id;

    #[ORM\Column(type: "float")]
    public float $transaction_amount = 0.0;

    #[ORM\Column(type: "integer")]
    public int $installments = 0;

    #[ORM\Column]
    public string $token = '';

    #[ORM\Column]
    public string $payment_method_id = '';

    #[OneToOne(targetEntity: Payer::class)]
    #[JoinColumn(name: 'payer_id', referencedColumnName: 'id')]
    public ?Payer $payer = null;

    #[ORM\Column]
    public string $notification_url = '';

    #[ORM\Column(type: "date_immutable")]
    public ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: "date")]
    public ?\DateTime $updated_at = null;

    #[ORM\Column]
    public string $status = '';
}

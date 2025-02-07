<?php

namespace App\Factory;

use App\Entity\Payment;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Payment>
 */
final class PaymentFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Payment::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'created_at' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'installments' => self::faker()->numberBetween(1, 48),
            'notification_url' => "https://webhook.site/dd00c411-14b5-4110-a25b-177836964162",
            'payer' => PayerFactory::new(),
            'payment_method_id' => self::faker()->creditCardType(),
            'status' => self::faker()->randomElement(['PENDING', 'PAID', 'CANCELED']),
            'token' => self::faker()->md5(),
            'transaction_amount' => self::faker()->randomFloat(2),
            'updated_at' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Payment $payment): void {})
        ;
    }
}

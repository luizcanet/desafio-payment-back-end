<?php
namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Payment;
use App\Factory\PaymentFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;
use Faker;

class PaymentTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    public function testCreateInvalidPayment(): void
    {
        static::createClient()->request('POST', '/rest/payments', [
            'headers' => [
                'Accept' => 'application/json'
            ],
            'json' => []
        ]);

        $this->assertResponseStatusCodeSame(422);
        $this->assertResponseHeaderSame('content-type', 'application/problem+json; charset=utf-8');
    }

    public function testCreatePaymentWithNoBody(): void
    {
        static::createClient()->request('POST', '/rest/payments', [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'json' => [
                'transaction_amount' => 245.90,
                'installments' => 3,
                'token' => 'ae4e50b2a8f3h6d9f2c3a4b5d6e7f8g9',
                'payment_method_id' => 'master'
            ]
        ]);

        $this->assertResponseStatusCodeSame(400);
        $this->assertResponseHeaderSame('content-type', 'application/problem+json; charset=utf-8');
    }

    public function testCreatePayment(): void
    {
        static::createClient()->request('POST', '/rest/payments', [
            'headers' => [
                'Accept' => 'application/json'
            ],
            'json' => [
                'transaction_amount' => 245.90,
                'installments' => 3,
                'token' => 'ae4e50b2a8f3h6d9f2c3a4b5d6e7f8g9',
                'payment_method_id' => 'master',
                'payer' => [
                    'email' => 'example_random@gmail.com',
                    'identification' => [
                        'type' => 'CPF',
                        'number' => '12345678909'
                    ]
                ]
            ]
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/json; charset=utf-8');
    }

    public function testGetCollection(): void
    {
        PaymentFactory::createMany(100);

        $response = static::createClient()->request('GET', '/rest/payments', [
            'headers' => [
                    'Accept' => 'application/json'
                ]
            ]
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json; charset=utf-8');
        $this->assertMatchesResourceCollectionJsonSchema(Payment::class);
    }

    public function testGetItem(): void
    {
        $paymentCreated = PaymentFactory::createOne();

        static::createClient()->request('GET', '/rest/payments/' . $paymentCreated->id, [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json; charset=utf-8');
        $this->assertMatchesResourceItemJsonSchema(Payment::class);
    }

    public function testPatchNotFound(): void
    {
        $faker = Faker\Factory::create();

        static::createClient()->request('PATCH', '/rest/payments/' . $faker->md5(), [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testPatch(): void
    {
        $paymentCreated = PaymentFactory::createOne(['status' => 'PENDING']);

        static::createClient()->request('PATCH', '/rest/payments/' . $paymentCreated->id, [
            'headers' => [
                'Accept' => 'application/json'
            ],
            'json' => [
                'status' => 'PAID'
            ]
        ]);

        $this->assertResponseStatusCodeSame(204);
    }

    public function testDeleteNotFound(): void
    {
        $faker = Faker\Factory::create();

        static::createClient()->request('DELETE', '/rest/payments/' . $faker->md5(), [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testDelete(): void
    {
        $paymentCreated = PaymentFactory::createOne();

        static::createClient()->request('DELETE', '/rest/payments/' . $paymentCreated->id, [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        $this->assertResponseStatusCodeSame(204);
    }
}

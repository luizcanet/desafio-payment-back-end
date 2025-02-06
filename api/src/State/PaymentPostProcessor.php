<?php
namespace App\State;

use App\Entity\Payment;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class PaymentPostProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Payment
    {
        $data->created_at = new \DateTimeImmutable();
        $data->updated_at = new \DateTime();

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}

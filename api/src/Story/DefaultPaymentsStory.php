<?php

namespace App\Story;

use Zenstruck\Foundry\Story;
use App\Factory\PaymentFactory;

final class DefaultPaymentsStory extends Story
{
    public function build(): void
    {
        PaymentFactory::createMany(100);
    }
}

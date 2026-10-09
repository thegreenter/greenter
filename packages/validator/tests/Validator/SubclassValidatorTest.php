<?php

declare(strict_types=1);

namespace Tests\Greenter\Validator;

use Greenter\Model\Sale\Invoice;
use Greenter\Validator\Metadata\CustomMetadataFactory;
use Greenter\Validator\SymfonyValidator;
use PHPUnit\Framework\TestCase;

class SubclassValidatorTest extends TestCase
{
    /**
     * @dataProvider versionProvider
     */
    public function testSubclassUsesParentConstraints(?string $version): void
    {
        $validator = new SymfonyValidator();
        $validator->setVersion($version);

        $invoice = new CustomInvoice();
        $errors = $validator->validate($invoice);
        $expected = $validator->validate(new Invoice());

        $this->assertGreaterThan(0, count($errors));
        $this->assertCount(count($expected), $errors);
    }

    public function versionProvider(): array
    {
        return [['2.0'], ['2.1']];
    }

    public function testMetadataIsReused(): void
    {
        $factory = new CustomMetadataFactory();
        $factory->setVersion('2.1');

        $metadata = $factory->getMetadataFor(new Invoice());
        $this->assertSame($metadata, $factory->getMetadataFor(Invoice::class));
        $this->assertTrue($factory->hasMetadataFor(CustomInvoice::class));
        $this->assertSame(CustomInvoice::class, $factory->getMetadataFor(new CustomInvoice())->getClassName());

        $factory->setVersion('2.0');
        $this->assertNotSame($metadata, $factory->getMetadataFor(new Invoice()));
    }
}

class CustomInvoice extends Invoice
{
}

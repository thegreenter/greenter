<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/02/2019
 * Time: 21:33
 */

declare(strict_types=1);

namespace Tests\Greenter\Report\Resolver;

use Exception;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Perception\Perception;
use Greenter\Model\Retention\Retention;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Note;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Reversion;
use Greenter\Model\Voided\Voided;
use Greenter\Report\Resolver\DefaultTemplateResolver;
use Greenter\Report\Resolver\InvalidDocumentException;
use Greenter\Report\Resolver\TemplateResolverInterface;
use PHPUnit\Framework\TestCase;

class ResolverTemplateTest extends TestCase
{
    /**
     * @var TemplateResolverInterface
     */
    private $resolver;

    protected function setUp(): void
    {
        $this->resolver = new DefaultTemplateResolver();
    }

    /**
     * @dataProvider getParameters
     */
    public function testGetTemplate($document, $expectTemplate)
    {
        $template = $this->resolver->getTemplate($document);

        $this->assertEquals($expectTemplate, $template);
    }

    /**
     * @throws InvalidDocumentException
     */
    public function testNotFoundTemplate()
    {
        $stub = $this->createMock(DocumentInterface::class);
        $stub->method('getName')
             ->willReturn('TestDocument');

        $this->expectException(Exception::class);
        $this->resolver->getTemplate($stub);
    }

    public function getParameters()
    {
        return [
          'Invoice'  => [new Invoice(), 'invoice.html.twig'],
          'Note' => [new Note(), 'invoice.html.twig'],
          [new Retention(), 'retention.html.twig'],
          [new Perception(), 'perception.html.twig'],
          [new Despatch(), 'despatch.html.twig'],
          [new Summary(), 'summary.html.twig'],
          [new Voided(), 'voided.html.twig'],
          'Reversion' => [new Reversion(), 'voided.html.twig'],
        ];
    }
}
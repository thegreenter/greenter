<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/02/2019
 * Time: 21:33
 */

namespace Report\Resolver;

use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Perception\Perception;
use Greenter\Model\Retention\Retention;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Note;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Reversion;
use Greenter\Model\Voided\Voided;
use Greenter\Report\Resolver\DefaultTemplateResolver;
use Greenter\Report\Resolver\TemplateResolverInterface;

class ResolverTemplateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TemplateResolverInterface
     */
    private $resolver;

    protected function setUp()
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
     * @expectedException \Exception
     */
    public function testNotFoundTemplate()
    {
        $this->resolver->getTemplate(new \stdClass());
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
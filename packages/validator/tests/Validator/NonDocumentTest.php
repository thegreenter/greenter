<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/10/2017
 * Time: 21:27
 */

namespace Tests\Greenter\Validator;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use PHPUnit\Framework\TestCase;

/**
 * Class NonDocumentTest
 * @package Tests\Greenter\Validator
 */
class NonDocumentTest extends TestCase
{
    use CustomValidator;

    public function testClientValidator()
    {
        $client = $this->getClient();
        $errors = $this->getValidator()->validate($client);

        $this->assertEquals(0, count($errors));
    }

    public function testClientInvalidValidator()
    {
        $client = $this->getClient();
        $client->setTipoDoc('123');
        $client->getAddress()->setUbigueo('232131231');
        $errors = $this->getValidator()->validate($client);

        $this->assertEquals(2, count($errors));
    }

    private function getClient()
    {
        $client = new Client();
        $client->setNumDoc('23112233')
            ->setTipoDoc('1')
            ->setRznSocial('PERSON')
            ->setAddress((new Address())
                ->setCodigoPais('PE')
                ->setDepartamento('LIMA')
                ->setUbigueo('231331'));

        return $client;
    }
}
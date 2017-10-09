<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/10/2017
 * Time: 12:50 PM
 */

namespace Tests\Greenter\Validator;

use Greenter\Model\Client\Client;
use Greenter\Validator\SymValidator;

/**
 * Class SymValidatorTests
 * @package Tests\Greenter\Validator
 */
class SymValidatorTests extends \PHPUnit_Framework_TestCase
{
    public function testClientValidatorLoader()
    {
        $client = new Client();
        $client->setNumDoc('23112233')
            ->setTipoDoc('1')
            ->setRznSocial('PERSON');

        $validator = new SymValidator();
        $errors = $validator->validate($client);

        var_dump($errors);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 27/01/2018
 * Time: 20:50.
 */

namespace Greenter\Validator;

use Symfony\Component\Translation\Exception\InvalidArgumentException;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class MessageTranslator.
 */
class MessageTranslator implements TranslatorInterface
{
    /**
     * @var string
     */
    private $locale;

    /**
     * @var ErrorCodeProviderInterface
     */
    private $provider;

    /**
     * @var array
     */
    private $items = [];

    /**
     * MessageTranslator constructor.
     *
     * @param ErrorCodeProviderInterface $provider
     */
    public function __construct(ErrorCodeProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Add extra resources.
     *
     * @param array $items
     */
    public function addResource(array $items)
    {
        $this->items = array_merge($this->items, $items);
    }

    /**
     * Translates the given message.
     *
     * @param string      $id         The message id (may also be an object that can be cast to string)
     * @param array       $parameters An array of parameters for the message
     * @param string|null $domain     The domain for the message or null to use the default
     * @param string|null $locale     The locale or null to use the default
     *
     * @return string The translated string
     *
     * @throws InvalidArgumentException If the locale contains invalid characters
     */
    public function trans($id, array $parameters = array(), $domain = null, $locale = null)
    {
        return $this->getValue($id);
    }

    /**
     * Translates the given choice message by choosing a translation according to a number.
     *
     * @param string      $id         The message id (may also be an object that can be cast to string)
     * @param int         $number     The number to use to find the indice of the message
     * @param array       $parameters An array of parameters for the message
     * @param string|null $domain     The domain for the message or null to use the default
     * @param string|null $locale     The locale or null to use the default
     *
     * @return string The translated string
     *
     * @throws InvalidArgumentException If the locale contains invalid characters
     */
    public function transChoice($id, $number, array $parameters = array(), $domain = null, $locale = null)
    {
        return $this->getValue($id);
    }

    /**
     * Sets the current locale.
     *
     * @param string $locale The locale
     *
     * @throws InvalidArgumentException If the locale contains invalid characters
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Returns the current locale.
     *
     * @return string The locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    private function getValue($id)
    {
        $value = $this->provider->getValue($id);
        if ($value) {
            return $value;
        }

        if (isset($this->items[$id])) {
            return $this->items[$id];
        }

        return $id;
    }
}

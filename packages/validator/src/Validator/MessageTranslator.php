<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 27/01/2018
 * Time: 20:50.
 */

declare(strict_types=1);

namespace Greenter\Validator;

use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class MessageTranslator.
 */
class MessageTranslator implements TranslatorInterface
{
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
     * @throws \InvalidArgumentException If the locale contains invalid characters
     */
    public function trans(string $id, array $parameters = [], string $domain = null, string $locale = null): string
    {
        return $this->getValue($id);
    }

    /**
     * Returns the default locale.
     *
     * @return string The locale
     */
    public function getLocale(): string
    {
        return "en";
    }

    private function getValue(string $id)
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

<?php

declare(strict_types=1);

namespace Greenter\Zip;

use Exception;

class ZipDecompressDecorator implements DecompressInterface
{
    /**
     * @var DecompressInterface
     */
    private $decompressor;

    /**
     * ZipDecompressDecorator constructor.
     * @param DecompressInterface $decompressor
     */
    public function __construct(DecompressInterface $decompressor)
    {
        $this->decompressor = $decompressor;
    }

    /**
     * @inheritDoc
     */
    public function decompress(?string $content, callable $filter = null): ?array
    {
        if (empty($content)) {
            return [];
        }

        try {
            return $this->decompressor->decompress($content, $filter);
        } catch (Exception $e) {
            return [];
        }
    }
}
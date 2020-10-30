<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\File;

use App\Shared\Domain\Parser\File\File as DomainFile;
use App\Shared\Infrastructure\Symfony\Exception\SymfonyException;

final class FromXmlExtension extends File
{
    private \SimpleXMLElement $xml;

    public function __construct(DomainFile $file)
    {
        parent::__construct($file);

        $this->xml = simplexml_load_string(
            $this->file()->content()->value(),
            "SimpleXMLElement",
            LIBXML_NOCDATA
        );
    }

    public function toObject(): object
    {
        return $this->xml;
    }

    /**
     * @return array
     * @throws SymfonyException
     */
    public function __toArray(): array
    {
        $result = [];
        $cont = 0;

        try {
            foreach ($this->xml as $items) {
                foreach ($items->attributes() as $attribute => $value) {
                    $result[$cont][$attribute] = (string) $value;
                }
                $result[$cont][$items->getName()] = (string) $items;
                ++$cont;
            }

            return $result;
        } catch (\Exception $e) {
            throw new SymfonyException($e->getMessage(), $e->getTrace());
        }
    }
}
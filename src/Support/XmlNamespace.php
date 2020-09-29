<?php
declare(strict_types=1);

namespace NGT\Ewus\Support;

use InvalidArgumentException;

final class XmlNamespace
{
    private const XML_NAMESPACES = [
        'env'  => 'http://schemas.xmlsoap.org/soap/envelope/',
        'xsi'  => 'http://www.w3.org/2001/XMLSchema-instance',
        'com'  => 'http://xml.kamsoft.pl/ws/common',
        'brok' => 'http://xml.kamsoft.pl/ws/broker',
        'auth' => 'http://xml.kamsoft.pl/ws/kaas/login_types',
        'ewus' => 'https://ewus.nfz.gov.pl/ws/broker/ewus/status_cwu/v5',
    ];

    /**
     * Get namespace URI by its short name.
     *
     * @param   string  $namespace
     * @return  string
     * @throws  InvalidArgumentException
     */
    public static function get(string $namespace): string
    {
        if (array_key_exists($namespace, self::XML_NAMESPACES)) {
            return self::XML_NAMESPACES[$namespace];
        }

        throw new InvalidArgumentException("Missing \"{$namespace}\" namespace.");
    }
}

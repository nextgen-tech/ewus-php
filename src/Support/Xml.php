<?php
declare(strict_types=1);

namespace NGT\Ewus\Support;

use DOMDocument;
use DOMElement;
use DOMNodeList;
use DOMXPath;
use Exception;

final class Xml
{
    /**
     * The text version of XML.
     *
     * @var  string
     */
    private $xml;

    /**
     * The DOM version of XML.
     *
     * @var  DOMXPath
     */
    private $dom;

    public function __construct(string $xml)
    {
        $this->xml = $xml;
        $this->dom = $this->toDom();

        $this->registerBaseNamespaces();
    }

    public function getXml(): string
    {
        return $this->xml;
    }

    public function getDom(): DOMXPath
    {
        return $this->dom;
    }

    private function toDom(): DOMXPath
    {
        $dom = new DOMDocument();
        $dom->loadXML($this->xml);

        return new DOMXPath($dom);
    }

    private function registerBaseNamespaces(): void
    {
        $this->registerNamespace('env');
        $this->registerNamespace('xsi');
        $this->registerNamespace('com');
    }

    public function registerNamespace(string $namespace): void
    {
        $this->dom->registerNamespace($namespace, XmlNamespace::get($namespace));
    }

    public function get(string $path): ?DOMElement
    {
        $nodes = $this->query($path);

        if ($nodes->length === 0) {
            return null;
        }

        return $nodes->item(0);
    }

    /**
     * Query DOM tree.
     *
     * @param   string  $path
     * @return  DOMNodeList<DOMElement>
     */
    public function query(string $path): DOMNodeList
    {
        $nodes = $this->dom->query($path);

        if ($nodes === false) {
            throw new Exception();
        }

        return $nodes;
    }

    /**
     * Check whether XML contains error or not.
     *
     * @return  bool
     */
    public function hasError(): bool
    {
        $nodes = $this->query('//env:Fault');

        return $nodes->length !== 0;
    }

    /**
     * Magic call method.
     *
     * @param   string   $method
     * @param   mixed[]  $arguments
     * @return  mixed
     */
    public function __call(string $method, array $arguments = [])
    {
        $this->dom->{$method}(...$arguments);
    }
}

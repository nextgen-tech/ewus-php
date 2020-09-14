<?php
declare(strict_types=1);

namespace Etermed\Ewus\Connections;

use Etermed\Ewus\Contracts\Connection as ConnectionContract;
use Etermed\Ewus\Exceptions\ResponseException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\RequestOptions;
use Throwable;

class HttpConnection extends Connection implements ConnectionContract
{
    /**
     * The client instance.
     *
     * @var  \GuzzleHttp\Client|null
     */
    protected $client;

    /**
     * Get the SOAP client for current service.
     *
     * @return  \GuzzleHttp\Client
     */
    public function getClient(): Client
    {
        if ($this->client === null) {
            $this->client = new Client();
        }

        return $this->client;
    }

    /**
     * @inheritDoc
     */
    public function send(string $data): string
    {
        try {
            $response = $this->getClient()->post($this->getServiceUrl(), [
                RequestOptions::BODY    => $data,
                RequestOptions::HEADERS => [
                    'Content-Type' => 'text/xml',
                ],
            ]);
        } catch (BadResponseException $e) {
            return $e->getResponse()->getBody()->getContents();
        } catch (Throwable $e) {
            throw new ResponseException('Unknown error.');
        }

        return $response->getBody()->getContents();
    }
}

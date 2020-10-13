<?php
declare(strict_types=1);

namespace NGT\Ewus\Connections;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\RequestOptions;
use NGT\Ewus\Contracts\Connection as ConnectionContract;
use NGT\Ewus\Exceptions\ResponseException;
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
     * Get the HTTP client.
     *
     * @return  \GuzzleHttp\Client
     */
    public function getClient(): Client
    {
        if ($this->client === null) {
            $this->client = $this->makeClient();
        }

        return $this->client;
    }

    /**
     * Make the HTTP client.
     *
     * @return  \GuzzleHttp\Client
     * @codeCoverageIgnore
     */
    protected function makeClient(): Client
    {
        return new Client($this->getConfig());
    }

    /**
     * Get client configuration.
     *
     * @return  mixed[]
     */
    protected function getConfig(): array
    {
        $config = [];

        if (isset($this->config['timeout'])) {
            $config[RequestOptions::TIMEOUT] = (int) $this->config['timeout'];
        }

        return $config;
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

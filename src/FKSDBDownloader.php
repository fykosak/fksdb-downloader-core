<?php

declare(strict_types=1);

namespace Fykosak\FKSDBDownloaderCore;

use Fykosak\FKSDBDownloaderCore\Requests\Request;

class FKSDBDownloader
{

    private \SoapClient $client;
    private array $params;

    public function __construct(string $wsdl, string $username, string $password)
    {
        $this->params = [$wsdl, $username, $password];
    }

    /**
     * Client lazy loading
     * @return \SoapClient
     * @throws \SoapFault
     */
    public function getClient(): \SoapClient
    {
        if (!isset($this->client)) {
            [$wsdl, $username, $password] = $this->params;
            $this->client = new \SoapClient(
                $wsdl,
                [
                    'trace' => true,
                    'exceptions' => true,
                    'stream_context' => stream_context_create(
                        [
                            'ssl' => [
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                            ],
                        ],
                    ),
                ],
            );

            $credentials = new \stdClass();
            $credentials->username = $username;
            $credentials->password = $password;

            $header = new \SoapHeader('http://fykos.cz/xml/ws/service', 'AuthenticationCredentials', $credentials);
            $headers = [$header];
            $this->client->__setSoapHeaders($headers);
        }
        return $this->client;
    }

    /**
     * @param Request $request
     * @return string
     * @throws \SoapFault
     */
    public function download(Request $request): string
    {
        $this->getClient()->{$request->getMethod()}($request->getParams());
        return $this->client->__getLastResponse();
    }
}

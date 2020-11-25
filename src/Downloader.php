<?php

namespace Fykosak\FKSDBDownloaderCore;

use Fykosak\FKSDBDownloaderCore\Request\IRequest;
use SoapClient;
use SoapFault;
use SoapHeader;
use stdClass;

class Downloader {

    private SoapClient $client;

    /**
     * Downloader constructor.
     * @param string $wsdl
     * @param string $username
     * @param string $password
     * @throws SoapFault
     */
    public function __construct(string $wsdl, string $username, string $password) {

        $this->client = new SoapClient($wsdl, [
            'trace' => true,
            'exceptions' => true,
            'stream_context' => stream_context_create(
                [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ]),
        ]);

        $credentials = new stdClass();
        $credentials->username = $username;
        $credentials->password = $password;

        $header = new SoapHeader('http://fykos.cz/xml/ws/service', 'AuthenticationCredentials', $credentials);
        $headers = [$header];
        $this->client->__setSoapHeaders($headers);
    }

    /**
     * @param IRequest $request
     * @return string
     */
    public function download(IRequest $request): string {
        $this->client->{$request->getMethod()}($request->getParams());
        return $this->client->__getLastResponse();
    }
}

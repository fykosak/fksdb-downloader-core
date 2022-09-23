<?php

declare(strict_types=1);

namespace Fykosak\FKSDBDownloaderCore;

use Fykosak\FKSDBDownloaderCore\Requests\Request;

class FKSDBDownloader
{
    private \SoapClient $client;
    private array $params;
    private string $jsonApi;

    public function __construct(string $wsdl, string $username, string $password, string $jsonApi)
    {
        $this->params = [$wsdl, $username, $password];
        $this->jsonApi = $jsonApi;
    }

    /**
     * Client lazy loading
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

            $header = new \SoapHeader('https://fykos.cz/xml/ws/service', 'AuthenticationCredentials', $credentials);
            $headers = [$header];
            $this->client->__setSoapHeaders($headers);
        }
        return $this->client;
    }

    /**
     * @throws \SoapFault
     */
    public function download(Request $request): string
    {
        $this->getClient()->{$request->getMethod()}($request->getParams());
        return $this->client->__getLastResponse();
    }

    public function downloadJSON(Request $request): string
    {
        [, $username, $password] = $this->params;
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n" .
                    "Authorization: Basic " . base64_encode($username . ':' . $password),
                'method' => 'GET',
                'content' => http_build_query($request->getParams()),
            ],
        ];
        $context = stream_context_create($options);
        $data = [];
        foreach ($request->getParams() as $key => $value) {
            $data[$this->pascalToSnakeCase($key)] = $value;
        }

        $result = file_get_contents(
            $this->jsonApi .
            $request->getMethod() .
            '?' .
            http_build_query($data),
            false,
            $context
        );
        restore_error_handler();
        if ($result === false) {
            $result = error_get_last()['message'];
        }
        return $result;
    }

    private function pascalToSnakeCase(string $string): string
    {
        return implode(
            '_',
            array_map(
                fn($part) => lcfirst($part),
                preg_split('/(?=[A-Z])/', $string, -1, PREG_SPLIT_NO_EMPTY)
            )
        );
    }

    private function pascalToKebabCase(string $string): string
    {
        return implode(
            '-',
            array_map(
                fn($part) => lcfirst($part),
                preg_split('/(?=[A-Z])/', $string, -1, PREG_SPLIT_NO_EMPTY)
            )
        );
    }
}

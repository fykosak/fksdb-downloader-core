<?php

namespace Fykosak\FKSDBDownloaderCore;

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

    public function createExportRequest(string $qid, array $parameters, int $formatVersion = 2): string {
        $parametersXML = [];
        foreach ($parameters as $name => $value) {
            $parametersXML[] = [
                'name' => $name,
                '_' => $value,
            ];
        }
        $request = [
            'qid' => $qid,
            'parameter' => $parametersXML,
        ];
        $request['format-version'] = $formatVersion;
        return $this->download('GetExport', $request);
    }

    public function createResultsDetailRequest(int $contest, int $year, int $series): string {
        return $this->download('GetResults', [
            'contest' => $contest,
            'year' => $year,
            'detail' => $series,
        ]);
    }

    public function createResultsCummulativeRequest(int $contest, int $year, array $series): string {
        return $this->download('GetResults', [
            'contest' => $contest,
            'year' => $year,
            'cumulatives' => [
                'cumulative' => implode(' ', $series),
            ],
        ]);
    }

    public function createTeamList(int $eventId): string {
        return $this->download('GetEvent', [
            'teamList' => '',
            'eventId' => $eventId,
        ]);
    }

    public function createEventList(int $eventTypeId): string {
        return $this->download('GetEvent', [
            'eventList' => '',
            'eventTypeId' => $eventTypeId,
        ]);
    }

    /**
     * @param string $methodName
     * @param mixed $request
     * @return string response XML
     */
    public function download(string $methodName, array $request): string {
        $this->client->{$methodName}($request);
        return $this->client->__getLastResponse();
    }
}

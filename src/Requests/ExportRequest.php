<?php

namespace Fykosak\FKSDBDownloaderCore\Requests;

class ExportRequest implements Request {

    private string $qid;
    private array $parameters;
    private int $formatVersion;

    public function __construct(string $qid, array $parameters, int $formatVersion = 2) {
        $this->qid = $qid;
        $this->parameters = $parameters;
        $this->formatVersion = $formatVersion;
    }

    public function getCacheKey(): string {
        return 'export.' . $this->qid . '.' . md5(join(':', $this->parameters));
    }

    public function getParams(): array {
        $parametersXML = [];
        foreach ($this->parameters as $name => $value) {
            $parametersXML[] = [
                'name' => $name,
                '_' => $value,
            ];
        }
        $request = [
            'qid' => $this->qid,
            'parameter' => $parametersXML,
        ];
        $request['format-version'] = $this->formatVersion;
        return $request;
    }

    public function getMethod(): string {
        return 'GetExport';
    }
}

<?php

namespace Fykosak\FKSDBDownloaderCore\Request;

class ExportRequest extends Request {
    public function __construct(string $qid, array $parameters, int $formatVersion = 2) {
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
        parent::__construct('export.' . $qid . '.' . md5(join(':', $parameters)), 'GetExport', $request);
    }
}

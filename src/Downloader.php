<?php

declare(strict_types=1);

namespace Fykosak\FKSDBDownloaderCore;

use JsonSchema\Constraints\Constraint;
use JsonSchema\Validator;

class Downloader
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @throws DownloaderException
     */
    public function download(string $app, string $source, array $arguments): array
    {
        $config = $this->config[$app];
        $this->validateRequest($arguments, $app, $source);

        $options = [
            'http' => [
                'header' => "Content-type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Basic " . base64_encode($config['username'] . ':' . $config['password']),
                'method' => 'GET',
                'content' => json_encode($arguments),
            ],
        ];
        $context = stream_context_create($options);

        $result = file_get_contents(
            $this->config[$app]['url'] . $source,
            false,
            $context
        );
        if ($result === false) {
            restore_error_handler();
            throw new DownloaderException(error_get_last()['message']);
        }
        $data = json_decode($result, true);
        $this->validateResponse($data, $app, $source);
        return $data;
    }

    /**
     * @throws DownloaderException
     */
    public function validateRequest(array $arguments, string $app, string $source): void
    {
        $this->validate($this->resolveDir($app, $source) . '/request.json', $arguments);
    }

    private function resolveDir(string $app, string $source): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR .
            $app . DIRECTORY_SEPARATOR .
            $source;
    }

    /**
     * @throws DownloaderException
     */
    private function validate(string $schemaFile, array $arguments): void
    {
        try {
            $validator = new Validator();
            $validator->validate($arguments, (object)[
                '$ref' => 'file://' . $schemaFile,
            ], Constraint::CHECK_MODE_TYPE_CAST);

            if ($validator->isValid()) {
                return;
            } else {
                $errors = '';
                foreach ($validator->getErrors() as $error) {
                    var_dump($error);
                    $errors .= join(', ', $error);
                }
                throw new DownloaderException($errors);
            }
        } catch (\Throwable$exception) {
            throw new DownloaderException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @throws DownloaderException
     */
    public function validateResponse(array $arguments, string $app, string $source): void
    {
        $this->validate($this->resolveDir($app, $source) . '/response.json', $arguments);
    }
}

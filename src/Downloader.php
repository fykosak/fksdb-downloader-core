<?php

declare(strict_types=1);

namespace Fykosak\FKSDBDownloaderCore;

use JsonSchema\Constraints\Constraint;
use JsonSchema\Validator;

require __DIR__ . '/../vendor/autoload.php';

class Downloader
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     * @throws DownloaderException
     */
    public function download(string $app, string $source, array $arguments)
    {
        $config = $this->config[$app];
        $this->validateRequest($arguments, $app, $source);

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n" .
                    "Authorization: Basic " . base64_encode($config['username'] . ':' . $config['password']),
                'method' => 'GET',
                'content' => http_build_query($arguments),
            ],
        ];
        $context = stream_context_create($options);

        $result = file_get_contents(
            $this->config[$app]['url'] . $source
            . '?' . http_build_query($arguments),
            false,
            $context
        );
        if ($result === false) {
            restore_error_handler();
            throw new DownloaderException(error_get_last()['message']);
        }
        $this->validateResponse(json_decode($result), $app, $source);
        return $result;
    }

    /**
     * @throws DownloaderException
     */
    private function validateRequest(array $arguments, string $app, string $source): void
    {
        $this->validate(__DIR__ . DIRECTORY_SEPARATOR .
            $app . DIRECTORY_SEPARATOR .
            $source . DIRECTORY_SEPARATOR . 'request.json', $arguments);
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
    private function validateResponse(array $arguments, string $app, string $source): void
    {
        $this->validate(__DIR__ . DIRECTORY_SEPARATOR .
            $app . DIRECTORY_SEPARATOR .
            $source . DIRECTORY_SEPARATOR . 'response.json', $arguments);
    }
}

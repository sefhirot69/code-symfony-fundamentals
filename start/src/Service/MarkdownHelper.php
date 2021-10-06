<?php

declare(strict_types=1);

namespace App\Service;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;

final class MarkdownHelper
{

    /**
     * @var CacheInterface
     */
    private $cache;
    /**
     * @var MarkdownParserInterface
     */
    private $markdownParser;
    /**
     * @var bool
     */
    private $isDebug;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        CacheInterface $cache,
        MarkdownParserInterface $markdownParser,
        bool $isDebug,
        LoggerInterface $markdownLogger
    ) {

        $this->cache = $cache;
        $this->markdownParser = $markdownParser;
        $this->isDebug = $isDebug;
        $this->logger = $markdownLogger;
    }

    public function parse(string $source): string
    {

        if(stripos($source, 'cat') !== false){
            $this->logger->info('Meow!');
        }

        if ($this->isDebug) {
            return $this->markdownParser->transformMarkdown($source);
        }

        return $this->cache->get('markdown_' . md5($source), function () use (
            $source
        ) {

            return $this->markdownParser->transformMarkdown($source);
        });
    }

}
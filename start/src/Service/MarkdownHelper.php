<?php

declare(strict_types=1);

namespace App\Service;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
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

    public function __construct(CacheInterface $cache, MarkdownParserInterface $markdownParser, bool $isDebug)
    {

        $this->cache = $cache;
        $this->markdownParser = $markdownParser;
        $this->isDebug = $isDebug;
    }

    public function parse(string $source) : string {

        if($this->isDebug) {
            return $this->markdownParser->transformMarkdown($source);
        }

        return  $this->cache->get('markdown_' . md5($source), function () use (
            $source
        ) {

            return $this->markdownParser->transformMarkdown($source);
        });
    }
}
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

    public function __construct(CacheInterface $cache, MarkdownParserInterface $markdownParser)
    {

        $this->cache = $cache;
        $this->markdownParser = $markdownParser;
    }

    public function parse(string $source) : string {

        return  $this->cache->get('markdown_' . md5($source), function () use (
            $source
        ) {

            return $this->markdownParser->transformMarkdown($source);
        });
    }
}
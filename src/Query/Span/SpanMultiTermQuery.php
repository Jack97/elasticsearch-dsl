<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Query\Span;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Elasticsearch span multi term query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-multi-term-query.html
 */
class SpanMultiTermQuery implements SpanQueryInterface
{
    use ParametersTrait;

    /**
     * Accepts one of fuzzy, prefix, term range, wildcard, regexp query.
     */
    public function __construct(private readonly BuilderInterface $query, array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException
     */
    public function toArray(): array|\stdClass
    {
        $query = [];
        $query['match'] = $this->query->toArray();
        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'span_multi';
    }
}

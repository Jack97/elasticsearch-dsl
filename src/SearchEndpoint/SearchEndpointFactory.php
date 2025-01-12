<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\SearchEndpoint;

/**
 * Factory for search endpoints.
 */
class SearchEndpointFactory
{
    /**
     * @var array Holds namespaces for endpoints.
     */
    private static array $endpoints = [
        'query' => QueryEndpoint::class,
        'post_filter' => PostFilterEndpoint::class,
        'sort' => SortEndpoint::class,
        'highlight' => HighlightEndpoint::class,
        'aggregations' => AggregationsEndpoint::class,
        'suggest' => SuggestEndpoint::class,
        'inner_hits' => InnerHitsEndpoint::class,
    ];

    /**
     * Returns a search endpoint instance.
     * @throws \RuntimeException Endpoint does not exist.
     */
    public static function get(string $type): SearchEndpointInterface
    {
        if (!array_key_exists($type, self::$endpoints)) {
            throw new \RuntimeException('Endpoint does not exist.');
        }

        return new self::$endpoints[$type]();
    }
}

<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Aggregation\Bucketing;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\BucketingTrait;
use ONGR\ElasticsearchDSL\BuilderInterface;

/**
 * Class representing composite aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-composite-aggregation.html
 */
class CompositeAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * @var BuilderInterface[]
     */
    private array $sources = [];

    private ?int $size = null;
    private ?array $after = null;

    /**
     * Inner aggregations container init.
     */
    public function __construct(string $name, array $sources = [])
    {
        parent::__construct($name);

        foreach ($sources as $agg) {
            $this->addSource($agg);
        }
    }

    /**
     * @throws \LogicException
     */
    public function addSource(AbstractAggregation $agg): static
    {
        $array = $agg->getArray();

        $array = is_array($array) ? array_merge($array, $agg->getParameters()) : $array;

        $this->sources[] = [
            $agg->getName() => [ $agg->getType() => $array ]
        ];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray(): array|\stdClass
    {
        $array = [
            'sources' => $this->sources,
        ];

        if ($this->size !== null) {
            $array['size'] = $this->size;
        }

        if (!empty($this->after)) {
            $array['after'] = $this->after;
        }

        return $array;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'composite';
    }

    public function setSize(int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setAfter(array $after): static
    {
        $this->after = $after;

        return $this;
    }

    public function getAfter(): ?array
    {
        return $this->after;
    }
}

<?php

namespace App\Services\Search\Elastic;


use App\Services\Search\SearchServiceAbstract;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Illuminate\Support\Facades\Log;

class Elastic extends SearchServiceAbstract
{

    private Client $client;
    private string $index;
    private array $fields;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }


    public static function name(): string
    {
        return 'elastic';
    }


    public function setIndex(string $index): static
    {
        $this->index = $index;
        return $this;
    }

    public function setFields(array $fields): static
    {
        $this->fields = $fields;
        return $this;
    }

    public function search(string $q): array
    {
        try {
            $params = [
                'index' => $this->index,
                'body' => [
                    'query' => [
                        'bool' => [
                            'should' => [
                                [
                                    'query_string' => [
                                        'query' => '*' . $q . '*',
                                        'fields' => $this->fields
                                    ]
                                ]
                            ],
                            'must' => count($this->filters['range']) > 0 ? $this->filters : []
                        ]
                    ],
                    'sort' => $this->sort
                ]
            ];
            $res = $this->client->search($params);
            return $this->cleanResult($res);
        } catch (\Exception $exception) {
            Log::error($exception);
            return [];
        }
    }

    public function searchWhen(bool $condition, string $q): array
    {
        if ($condition) {
            return $this->search($q);
        }
        return [];
    }

    public function index(array $data): bool
    {
        try {
            $this->client = ClientBuilder::create()->build();
            $params = [
                'index' => $this->index,
                'id' => $data['id'],
                'body' => $data
            ];
            $result = $this->client->index($params);
            return !!$result;
        } catch (\Exception $exception) {
            Log::error($exception);
            return false;
        }
    }

    public function delete(string|int $id): void
    {
        try {
            $this->client->delete([
                'index' => $this->index,
                'id' => $id
            ]);
        } catch (\Exception $exception) {
            Log::error($exception);
        }
    }

    private function cleanResult($res): array
    {
        $cleanedData = [];
        foreach ($res->asArray()['hits']['hits'] as $hit) {
            $cleanedData[] = $hit['_source'];
        };
        return $cleanedData;
    }
}


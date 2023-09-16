<?php


namespace App\Services\Search;


abstract class  SearchServiceAbstract
{

    public array $sort = [];
    public array $filters = ['range' => []];

    abstract public static function name(): string;

    abstract public function setIndex(string $index);

    abstract public function setFields(array $fields);

    abstract public function search(string $q): array;

    abstract public function index(array $data): bool;

    public function filterWhen(bool $condition, ?string $field, ?string $operator, string|int|null $val): static
    {
        if ($condition) {
            $operator = substr($operator, -1, 1);
            $operator = str_replace('>', 'gt', $operator);
            $operator = str_replace('<', 'lte', $operator);
            $operator = str_replace('=', 'eq', $operator);
            $this->filters['range'][$field] = [$operator => $val];
        }
        return $this;
    }

    public function sortByWhen(bool $condition, ?string $field, ?string $dir): static
    {
        $dir = in_array($dir, ['asc', 'desc']) ? $dir : 'asc';
        if ($condition) {
            $this->sort = [...$this->sort, [$field => ['order' => $dir]]];
        }
        return $this;
    }

}

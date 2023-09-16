<?php

namespace App\Services\Search;

interface SearchAbleInterFace
{
    public static function setSearchableFields(): void;

    public function index(bool $shouldBeSync = false): void;

    public function reIndex(): bool;

    public function deleteIndex(): void;

    public function searchWildcard(): void;

    public static function search(string|int $q): array;
}

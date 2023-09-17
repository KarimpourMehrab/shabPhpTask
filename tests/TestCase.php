<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    readonly public string $url;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->createApplication();
        $this->url = config('app.api_url');
    }
}

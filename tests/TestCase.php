<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use phpDocumentor\Reflection\Types\Void_;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): Void
    {
        parent::setUp();
    }
}

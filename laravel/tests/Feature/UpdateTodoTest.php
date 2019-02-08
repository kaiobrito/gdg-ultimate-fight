<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTodoTest extends TestCase
{
    use RefreshDatabase;

    public function testCanUpdateTitleAndPermission()
    {
    }

    public function testTitleIsRequired()
    {
    }

    public function testDescriptionCanBeNull()
    {
    }
}

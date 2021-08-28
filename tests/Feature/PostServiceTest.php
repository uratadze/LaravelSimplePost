<?php

namespace Tests\Feature;

use Tests\TestCase;

class PostServiceTest extends TestCase
{
    /**
     * @return void
     */
    public function test_all_post()
    {
        $response = $this->get('/post/2');

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_per_post()
    {
        $response = $this->get('/post');

        $response->assertStatus(200);
    }

}

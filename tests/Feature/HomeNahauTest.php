<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeNahauTest extends TestCase
{
    public function test_home_renders_new_design_sections(): void
    {
        $html = $this->get('/')->assertOk()->getContent();
        foreach (['African stories. Told in our voices.', 'Explore our sections', 'Latest stories', 'A good story is worth making time for.'] as $needle) {
            $this->assertStringContainsString($needle, $html);
        }
    }

    public function test_classic_homes_still_available(): void
    {
        $this->get('/home-one')->assertOk();
        $this->get('/home-two')->assertOk();
        $this->get('/about-us')->assertOk();
    }

    public function test_subscribe_rejects_invalid_email(): void
    {
        $this->getJson('/subscribe/ajax?email=nope')->assertStatus(422);
    }
}

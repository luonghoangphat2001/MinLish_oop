<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    public function test_landing_page_returns_success(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_landing_page_contains_brand_name(): void
    {
        $response = $this->get('/');

        $response->assertSee('MinLish');
    }

    public function test_landing_page_contains_cta_links(): void
    {
        $response = $this->get('/');

        $response->assertSee('Bắt đầu miễn phí');
        $response->assertSee('Đăng nhập');
    }

    public function test_landing_page_contains_features_section(): void
    {
        $response = $this->get('/');

        $response->assertSee('Tính năng nổi bật');
    }

    public function test_landing_page_contains_how_it_works_section(): void
    {
        $response = $this->get('/');

        $response->assertSee('Cách học hiệu quả');
    }
}

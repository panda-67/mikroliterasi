<?php

namespace Tests\Feature;

use App\Support\HtmlSanitizer;
use Tests\TestCase;

class HtmlSanitizerTest extends TestCase
{
    private HtmlSanitizer $sanitizer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sanitizer = app(HtmlSanitizer::class);
    }

    public function test_it_preserves_allowed_html(): void
    {
        $html = '<p>Hello <strong>world</strong>.</p>';

        $result = $this->sanitizer->clean(
            $html,
            'rich_text'
        );

        $this->assertStringContainsString(
            '<p>',
            $result
        );

        $this->assertStringContainsString(
            '<strong>world</strong>',
            $result
        );
    }

    public function test_it_removes_script_tags(): void
    {
        $html = '<p>Hello</p><script>alert("XSS")</script>';

        $result = $this->sanitizer->clean(
            $html,
            'rich_text'
        );

        $this->assertStringContainsString(
            '<p>Hello</p>',
            $result
        );

        $this->assertStringNotContainsString(
            '<script>',
            $result
        );

        $this->assertStringNotContainsString(
            'alert("XSS")',
            $result
        );
    }

    public function test_it_removes_event_handler_attributes(): void
    {
        $html = '<p onclick="alert(\'XSS\')">Hello</p>';

        $result = $this->sanitizer->clean(
            $html,
            'rich_text'
        );

        $this->assertStringContainsString(
            'Hello',
            $result
        );

        $this->assertStringNotContainsString(
            'onclick',
            $result
        );

        $this->assertStringNotContainsString(
            'alert',
            $result
        );
    }

    public function test_it_preserves_allowed_link_attributes(): void
    {
        $html = '<a href="https://example.com" target="_blank" rel="noopener">Example</a>';

        $result = $this->sanitizer->clean(
            $html,
            'rich_text'
        );

        $this->assertStringContainsString(
            'href="https://example.com"',
            $result
        );

        $this->assertStringContainsString(
            'target="_blank"',
            $result
        );

        $this->assertStringContainsString(
            'noopener',
            $result
        );
    }

    public function test_it_removes_disallowed_attributes(): void
    {
        $html = '<p style="color:red" onclick="alert(1)">Hello</p>';

        $result = $this->sanitizer->clean(
            $html,
            'rich_text'
        );

        $this->assertStringContainsString(
            'Hello',
            $result
        );

        $this->assertStringNotContainsString(
            'style=',
            $result
        );

        $this->assertStringNotContainsString(
            'onclick',
            $result
        );
    }

    public function test_it_returns_null_for_null_input(): void
    {
        $result = $this->sanitizer->clean(
            null,
            'rich_text'
        );

        $this->assertNull($result);
    }

    public function test_it_sanitizes_multiple_fields(): void
    {
        $data = [
            'title' => 'Research Project',
            'description' => '<p>Valid <strong>content</strong></p><script>alert(1)</script>',
            'short_description' => '<p>Short description</p>',
        ];

        $result = $this->sanitizer->cleanMany(
            $data,
            [
                'description',
                'short_description',
            ],
            'rich_text'
        );

        $this->assertSame(
            'Research Project',
            $result['title']
        );

        $this->assertStringContainsString(
            '<strong>content</strong>',
            $result['description']
        );

        $this->assertStringNotContainsString(
            '<script>',
            $result['description']
        );

        $this->assertSame(
            '<p>Short description</p>',
            $result['short_description']
        );
    }

    public function test_it_does_not_modify_fields_not_selected_for_sanitization(): void
    {
        $data = [
            'title' => '<strong>Research</strong>',
            'description' => '<p>Description</p>',
        ];

        $result = $this->sanitizer->cleanMany(
            $data,
            ['description'],
            'rich_text'
        );

        $this->assertSame(
            '<strong>Research</strong>',
            $result['title']
        );

        $this->assertSame(
            '<p>Description</p>',
            $result['description']
        );
    }
}

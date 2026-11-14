<?php

namespace Tests\Unit;

use Tests\TestCase;

class SecurityTest extends TestCase
{
    public function test_svg_with_script_is_rejected(): void
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'svg_test');
        file_put_contents($tmpFile, '<svg xmlns="http://www.w3.org/2000/svg"><script>alert("xss")</script></svg>');

        $file = new \Illuminate\Http\UploadedFile($tmpFile, 'bad.svg', 'image/svg+xml', null, true);

        $this->expectException(\Illuminate\Validation\ValidationException::class);
        media_put($file, 'public/uploads/images/test/', 'bad.svg');
    }

    public function test_svg_with_onload_is_rejected(): void
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'svg_test2');
        file_put_contents($tmpFile, '<svg xmlns="http://www.w3.org/2000/svg" onload="alert(1)"><circle r="10"/></svg>');

        $file = new \Illuminate\Http\UploadedFile($tmpFile, 'bad_onload.svg', 'image/svg+xml', null, true);

        $this->expectException(\Illuminate\Validation\ValidationException::class);
        media_put($file, 'public/uploads/images/test/', 'bad_onload.svg');
    }

    public function test_nclean_strips_dangerous_tags_and_handlers(): void
    {
        $input = '<p>Hello <script>alert(1)</script><a href="javascript:alert(2)" onclick="alert(3)">link</a></p>';
        $cleaned = nclean($input);

        $this->assertStringNotContainsString('<script>', $cleaned);
        $this->assertStringNotContainsString('javascript:', $cleaned);
        $this->assertStringNotContainsString('onclick', $cleaned);
        $this->assertStringContainsString('<p>Hello ', $cleaned);
        $this->assertStringContainsString('link</a>', $cleaned);
    }
}

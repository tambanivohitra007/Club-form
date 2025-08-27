<?php
use PHPUnit\Framework\TestCase;

class Step3ValidationTest extends TestCase {
    private string $url = "http://localhost:8000/public/register.php";

    private function postForm($data) {
        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
                'content' => http_build_query($data)
            ]
        ];
        return file_get_contents($this->url, false, stream_context_create($opts));
    }

    public function testEmptyFormShowsError() {
        $output = $this->postForm([
            'student_id' => '',
            'first_name' => '',
            'last_name'  => '',
            'email'      => '',
            'club'       => '',
        ]);
        $this->assertStringContainsString('This field is required', $output);
    }

    public function testValidFormAcceptsData() {
        $output = $this->postForm([
            'student_id' => '12345',
            'first_name' => 'Jane',
            'last_name'  => 'Doe',
            'email'      => 'jane@example.com',
            'club'       => 'Music',
            'agree_to_rules' => 'on',
        ]);
        $this->assertStringContainsString('Jane', $output);
    }
}

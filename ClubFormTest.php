<?php
use PHPUnit\Framework\TestCase;

class ClubFormTest extends TestCase
{
    public function testIndexFileExists()
    {
        $this->assertFileExists('index.php', "index.php is missing");
    }
}

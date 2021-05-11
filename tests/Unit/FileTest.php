<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\File;

class FileTest extends TestCase
{

    public function test_example()
    {
        $file = new File;

        $this->assertInstanceOf(File::class, $file);
    }
}

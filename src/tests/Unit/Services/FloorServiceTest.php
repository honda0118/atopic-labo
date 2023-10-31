<?php

namespace Tests\Unit\Services;

use App\Services\FloorService;
use Tests\TestCase;

class FloorServiceTest extends TestCase
{
    /**
     * @access public
     * @return void
     */
    public function test_roundDown_小数点第2位以下を切り捨てること(): void
    {
        $actual = FloorService::roundDown(1, 10.22);

        $this->assertSame(10.2, $actual);
    }
}

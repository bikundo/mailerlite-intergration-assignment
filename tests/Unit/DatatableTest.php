<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use Tests\TestCase;

class DatatableTest extends TestCase
{
    public function testDatatablesReturnsCorrectDataFormat()
    {

        $request = new Request(['length' => 10]);


        $response = $this->get('/datatables/subscribers', $request->all());
        $response->assertOk();
        $response->assertJsonStructure(['data', 'recordsTotal', 'recordsFiltered']);
        $response->assertJsonCount(10, 'data');
    }
}

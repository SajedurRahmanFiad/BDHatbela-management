<?php

namespace Tests\Unit;

use Tests\TestCase;

class SearchStringTest extends TestCase
{
    public function test_colon_operator_returns_single_value()
    {
        $obj = new class {
            use \App\Traits\SearchString;
            public function call($name, $input) {
                return $this->getSearchStringValue($name, '', $input);
            }
        };

        $this->assertEquals('6', $obj->call('created_by', 'created_by:6'));
        $this->assertEquals('picked', $obj->call('status', 'status:picked'));
    }

    public function test_quoted_full_string_is_parsed()
    {
        $obj = new class {
            use \App\Traits\SearchString;
            public function call($name, $input) {
                return $this->getSearchStringValue($name, '', $input);
            }
        };

        $this->assertEquals('6', $obj->call('created_by', '"created_by:6"'));
        $this->assertEquals('Fiad2', $obj->call('created_by', '"created_by:Fiad2"'));
    }

    public function test_range_operators_return_array()
    {
        $obj = new class {
            use \App\Traits\SearchString;
            public function call($name, $input) {
                return $this->getSearchStringValue($name, '', $input);
            }
        };

        $result = $obj->call('issued_at', 'issued_at>=2021-02-01 issued_at<=2021-02-10');

        $this->assertIsArray($result);
        $this->assertEquals(['2021-02-01', '2021-02-10'], $result);
    }

    public function test_status_and_created_by_distinct()
    {
        $obj = new class {
            use \App\Traits\SearchString;
            public function call($name, $input) {
                return $this->getSearchStringValue($name, '', $input);
            }
        };

        $this->assertEquals('picked', $obj->call('status', 'status:picked created_by:6'));
        $this->assertEquals('6', $obj->call('created_by', 'status:picked created_by:6'));
    }
}

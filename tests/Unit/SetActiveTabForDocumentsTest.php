<?php

namespace Tests\Unit;

use Tests\TestCase;

class SetActiveTabForDocumentsTest extends TestCase
{
    public function test_does_not_override_search_when_only_non_status_filter_present()
    {
        // Ensure the request has a non-status search filter
        request()->merge(['search' => 'created_by:6']);

        $controller = new class extends \App\Abstracts\Http\Controller {
            public $type = 'invoice';
            public function exposeSetActive()
            {
                $this->setActiveTabForDocuments();
            }
        };

        $controller->exposeSetActive();

        $this->assertEquals('created_by:6', request()->get('search'));
        $this->assertFalse(request()->has('programmatic'));
    }

    public function test_sets_default_unpaid_when_no_search_provided()
    {
        // Clear any existing request data
        request()->replace([]);

        $controller = new class extends \App\Abstracts\Http\Controller {
            public $type = 'invoice';
            public function exposeSetActive()
            {
                $this->setActiveTabForDocuments();
            }
        };

        $controller->exposeSetActive();

        $expected = config('type.document.invoice.route.params.unpaid.search');

        $this->assertEquals($expected, request()->get('search'));
        $this->assertEquals('1', request()->get('programmatic'));
    }

    public function test_unrecognized_status_sets_list_records_all()
    {
        request()->replace(['search' => 'status:foo']);

        $controller = new class extends \App\Abstracts\Http\Controller {
            public $type = 'invoice';
            public function exposeSetActive()
            {
                $this->setActiveTabForDocuments();
            }
        };

        $controller->exposeSetActive();

        $this->assertEquals('all', request()->get('list_records'));
    }
}

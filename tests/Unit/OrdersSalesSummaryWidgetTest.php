<?php

namespace Tests\Unit;

use App\Widgets\OrdersSalesSummary;
use Tests\TestCase;

class OrdersSalesSummaryWidgetTest extends TestCase
{
    public function test_widget_properties()
    {
        $widget = new OrdersSalesSummary();

        $this->assertEquals('widgets.orders_sales_summary', $widget->getDefaultName());
        $this->assertEquals('widgets.description.orders_sales_summary', $widget->getDescription());
        $this->assertEquals(['width' => '100'], $widget->getDefaultSettings());
    }

    public function test_widget_filter_logic()
    {
        $widget = new OrdersSalesSummary();

        // Test different period types
        $widget->setFilter();
        $this->assertNotNull($widget->start_date);
        $this->assertNotNull($widget->end_date);
        $this->assertNotNull($widget->period_type);
    }
}

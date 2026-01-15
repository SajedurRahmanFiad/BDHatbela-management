<?php

namespace App\View\Components\Documents\Form;

use App\Abstracts\View\Component;
use App\Models\Common\Item;

class ItemButton extends Component
{
    public function render()
    {
        $price_type = request()->segment(1) === 'revenues' ? 'sale' : 'purchase';

        $items = Item::with('media')->priceType($price_type)->enabled()->orderBy('name')->take(setting('default.select_limit'))->get();

        // Add other logic as needed

        return view('components.documents.form.item-button', compact('items'));
    }
}
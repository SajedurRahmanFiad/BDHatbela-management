<?php

namespace App\Traits;

trait SearchString
{
    /**
     * Get the value of a name in search string
     * Example: search=type:customer year:2020 account_id:20
     * Example: issued_at>=2021-02-01 issued_at<=2021-02-10 account_id:49
     */
    public function getSearchStringValue(string $name, string $default = '', string $input = ''): string|array
    {
        $value = $default;

        $input = $input ?: request('search', '');

        // Trim surrounding quotes if the full search string was quoted by the frontend
        $input = trim($input);
        if ((str_starts_with($input, '"') && str_ends_with($input, '"')) || (str_starts_with($input, "'") && str_ends_with($input, "'"))) {
            $input = substr($input, 1, -1);
        }

        // Match patterns like key:val, key>=val, key<=val, key>val, key<val, key!=val, key=val
        $pattern = '/(?P<key>[^\s:><!=]+)\s*(?P<op>:|>=|<=|>|<|!=|=)\s*(?P<value>"[^"]*"|\'[^\']*\'|[^\s]+)/';

        preg_match_all($pattern, $input, $matches, PREG_SET_ORDER);

        $values = [];

        foreach ($matches as $m) {
            $key = $m['key'] ?? null;
            $op = $m['op'] ?? ':';
            $val = $m['value'] ?? '';

            // Remove surrounding quotes from value
            $val = trim($val, '"\'');

            if ($key !== $name) {
                continue;
            }

            if ($op === ':') {
                // Single value operator
                return $val;
            }

            // Range operators / others -> collect values in array
            $values[] = $val;
        }

        if (! empty($values)) {
            return $values;
        }

        return $value;
    }
}

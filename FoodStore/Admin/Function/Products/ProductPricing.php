<?php

function normalize_numeric_price($value)
{
    $value = trim((string) $value);
    if ($value === '') {
        return 0.0;
    }

    $value = preg_replace('/[^0-9,\.\-]/u', '', $value);
    if ($value === '' || $value === '-' || $value === '.' || $value === '-.') {
        return 0.0;
    }

    if (strpos($value, ',') !== false && strpos($value, '.') !== false) {
        if (preg_match('/^\d{1,3}(?:,\d{3})+\.\d+$/u', $value)) {
            $value = str_replace(',', '', $value);
        } elseif (preg_match('/^\d{1,3}(?:\.\d{3})+,\d+$/u', $value)) {
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
        }
    } elseif (strpos($value, ',') !== false) {
        if (preg_match('/^\d+(?:,\d{3})+$/u', $value)) {
            $value = str_replace(',', '', $value);
        } else {
            $value = str_replace(',', '.', $value);
        }
    }

    return (float) $value;
}

function split_size_price_entries($rawValue)
{
    $rawValue = trim((string) $rawValue);
    if ($rawValue === '') {
        return [];
    }

    $entries = [];
    $buffer = '';
    $length = mb_strlen($rawValue, 'UTF-8');

    for ($index = 0; $index < $length; $index++) {
        $char = mb_substr($rawValue, $index, 1, 'UTF-8');

        if (in_array($char, [',', ';', '|', "\n"], true)) {
            $previous = '';
            for ($j = $index - 1; $j >= 0; $j--) {
                $current = mb_substr($rawValue, $j, 1, 'UTF-8');
                if (!preg_match('/\s/u', $current)) {
                    $previous = $current;
                    break;
                }
            }

            $next = '';
            for ($j = $index + 1; $j < $length; $j++) {
                $current = mb_substr($rawValue, $j, 1, 'UTF-8');
                if (!preg_match('/\s/u', $current)) {
                    $next = $current;
                    break;
                }
            }

            $isThousandsSeparator = preg_match('/\d/u', $previous) === 1 && preg_match('/\d/u', $next) === 1;
            if ($isThousandsSeparator) {
                $buffer .= $char;
                continue;
            }

            $entry = trim($buffer);
            if ($entry !== '') {
                $entries[] = $entry;
            }
            $buffer = '';
            continue;
        }

        $buffer .= $char;
    }

    $entry = trim($buffer);
    if ($entry !== '') {
        $entries[] = $entry;
    }

    return $entries;
}

function parse_size_price_map($rawValue, $fallbackPrice = 0)
{
    $rawValue = trim((string) $rawValue);
    if ($rawValue === '') {
        return [];
    }

    $items = split_size_price_entries($rawValue);
    $priceMap = [];

    foreach ($items as $item) {
        $item = trim($item);
        if ($item === '') {
            continue;
        }

        if (preg_match('/^(.*?)(?:\s*(?:[:=]|-)\s*|\s+)(\d[\d.,]*)\s*(?:[đd]|vnd|vnđ)?$/iu', $item, $matches)) {
            $label = trim($matches[1]);
            $price = normalize_numeric_price($matches[2]);
        } else {
            $label = $item;
            $price = (float) $fallbackPrice;
        }

        if ($label !== '') {
            $priceMap[$label] = (int) round($price);
        }
    }

    if ($priceMap === []) {
        $priceMap[$rawValue] = (int) round((float) $fallbackPrice);
    }

    return $priceMap;
}

function get_selected_size_price($rawValue, $selectedSize, $fallbackPrice = 0)
{
    $options = parse_size_price_map($rawValue, $fallbackPrice);
    if ($options === []) {
        return (int) round((float) $fallbackPrice);
    }

    $selectedSize = trim((string) $selectedSize);
    if ($selectedSize === '') {
        return (int) current($options);
    }

    foreach ($options as $label => $price) {
        if (strcasecmp(trim($label), $selectedSize) === 0) {
            return (int) $price;
        }
    }

    return (int) round((float) $fallbackPrice ?: current($options));
}
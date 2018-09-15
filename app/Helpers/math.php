<?php

function int_bitmask_to_id_array(int $int) : array
{
    $mask_counter = $int;

    $bit_count = 0;
    while ($mask_counter) {
        $mask_counter >>= 1;
        $bit_count++;
    }

    $ids = [];

    for ($k = 0; $k < $bit_count; $k++) {
        if ((($int >> $k) & 1) === 1) {
            $ids[] = $k + 1;
        }
    }

    return $ids;
}

function id_array_to_int_bitmask(array $array_of_ids) : int
{
    $int = 0;
    foreach ($array_of_ids as $id) {
        $int += 2 ** ($id - 1);
    }
    
    return $int;
}

function is_id($var, $min = 1) : bool
{
    return filter_var($var, FILTER_VALIDATE_INT, ['options' => ['min_range' => $min]]);
}

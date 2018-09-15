<?php

function construct_list_data(array $all, array $selected, string $selectionFlag = 'selected') : array
{
    foreach ($all as $key => &$val) {
        $val = [
            'name' => $val,
            $selectionFlag => in_array($key, $selected)
        ];
    }

    return $all;
}


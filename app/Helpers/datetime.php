<?php

use Carbon\Carbon;

/*function get_years_since_date($date) {
    $date_object = new DateTime($date);
    $today_date_object   = new DateTime('today');
    $years = $date_object->diff($today_date_object)->y;
    return $years;
}*/

/**
 * @param Carbon $date
 * @return string|\Symfony\Component\Translation\TranslatorInterface
 */
function get_future_date_for_humans(Carbon $date)
{
    if ($date->isToday()) {
        return trans('date.today');
    } elseif ($date->isTomorrow()) {
        return trans('date.tomorrow');
    } elseif ($date->isFuture()) {
        return trans('date.starts_in', ['date' => $date->diffForHumans(null, true)]);
    } else {
        return trans('date.no_date');
    }
}

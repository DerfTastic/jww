<?php

/** getDateStr
 * @param $datestr A string like "2019.2". Two numbers separated by a ".", the first one being the year and the second one being the time period during the year relative to periods in school (see below)
 * 1 = January - April, 2nd semester of the old school year
 * 2 = May - August, Summer
 * 3 = September - December, 1st semester of the new school year
 */
function getDateStr($datestr) {
    $arr = explode(".", $datestr);
    $year = $arr[0];

    // The following takes the year and part of the year, and makes the $initgrade and $sem out of it.

    // $sem

    switch ($arr[1]) {
    case 1: $sem = 2; break; // 2nd semester, new year
    case 2: $sem = 0; break; // No semester: summer!
    case 3: $sem = 1; break; // 1st semester, year coming to end
    default: $sem = 0; break;
    }

    // $initgrade

    $initgrade = $year - 2009;
    if ($sem == 1) {
        $initgrade += 1;
    }

    // Up to this point, three vars are set: 
    // - $initgrade (14 = 2nd year BSc b/c I was in 2nd year when this date's year started)
    // - $sem (1 = 1st sem; 2 = 2nd sem)

    // To make $gradestr:

    if ($initgrade < 13) { // Before uni
        $gradestr = $initgrade."th grade"; // fix if you add projects from 3rd grade or earlier
    }
    else { // During / after uni
        switch ($initgrade) {
        case 13: $gradestr = "1st year of BSc"; break;
        case 14: $gradestr = "2nd year of BSc"; break;
        case 15: $gradestr = "3rd year of BSc"; break;
        case 16: $gradestr = "4th year of BSc"; break;
        case 17: $gradestr = "5th year of BSc"; break;
        default: $gradestr = "Post-university"; break;
        }
    }

    // To make final $timeofyear string

    if ($sem > 0) { // If sem is valid (if sem were 0, it would be summer, so not valid)
        switch ($sem) {
        case 1: 
            $semstr = "1st semester";
            return "<b>".$year."</b> - ".$gradestr.", ".$semstr;
            break;
        case 2: 
            $semstr = "2nd semester";
            return "<b>".$year."</b> - ".$gradestr.", ".$semstr;
            break;
        case 3:
            return "wait wtf code isn't working";
            break;
        }
    }
    else {
        return "<b>".$year."</b> - "."Summer after ".$gradestr;
    }
}


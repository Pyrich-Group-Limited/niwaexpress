<?php

function enum_payment_types()
{
    $option[0] = 'Registration Fee';
    $option[1] = 'Application Form Fee';
    $option[2] = 'Processing Fee';
    $option[3] = 'Inspection Fee';
    $option[4] = 'Application Form Fee + Processing Fee';
    $option[5] = 'Equipment and Monitoring Fee';

    return $option;
}

if (!function_exists('get_settings')) {
    function get_settings()
    {
        return \App\Models\Utility::settings();
    }
}


/* function enum_payment_types()
{
    $option[1] = 'Registration Fee';
    //$option[1] = 'Application Form Fee';
    //$option[2] = 'Processing Fee';
    $option[4] = 'Application Form Fee + Processing Fee';
    $option[5] = 'Inspection Fee';
    $option[6] = 'Equipment and Monitoring Fee';

    return $option;
} */


<?php


function mustHaveSession()
{
    $ci = &get_instance();

    if (!$ci->session->userdata('id') && !$ci->session->userdata('user')) {
        redirect(base_url('booking/index'));
    }
}

function haveSession()
{
    $ci = &get_instance();


    $costumers = $ci->db->get_where('costumers', ['id' => $ci->session->userdata('id'), 'account_id' => $ci->session->userdata('user')])->row();



    if (!$costumers) {

        return true;
    } else {
        redirect(base_url('booking/uploadImage'));
    }
}


function deleteImage($image, $dir)
{
    if (file_exists('./assets/images/' . $dir . '/' . $image)) {
        unlink('./assets/images/' . $dir . '/' . $image);
    }
}


function dropdown($table, $column)
{
    $ci = &get_instance();

    $query = $ci->db->select($column)->from($table)->get();

    if ($query->num_rows() >= 1) {
        $setOptionsFirst = ['' => '- Select -'];
        $setOptionsList  = array_column($query->result_array(), $column[1], $column[0]);

        $joinOptions     = $setOptionsFirst + $setOptionsList;

        return $joinOptions;
    }

    // if num_rows < 0

    return $joinOptions = ['' => '- Select -'];
}


function dropdownCond($table, $column, $cond, $setNull)
{
    $ci = &get_instance();

    $query = $ci->db->select($column)->from($table)->where($cond)->get();

    if ($query->num_rows() >= 1) {
        $setOptionsFirst = [$setNull => '- Select -'];
        $setOptionsList  = array_column($query->result_array(), $column[1], $column[0]);

        $joinOptions     = $setOptionsFirst + $setOptionsList;

        return $joinOptions;
    }

    // if num_rows < 0

    return $joinOptions = ['' => '- Select -'];
}

function dropdownExtra($table, $column, $cond, $setNull)
{
    $ci = &get_instance();

    $query = $ci->db->select($column)->from($table)->where($cond)->get();

    if ($query->num_rows() >= 1) {
        $setOptionsFirst = [$setNull => '- Select -'];
        $setOptionsList  = array_column($query->result_array(), $column[1], $column[0]);

        $joinOptions     = $setOptionsFirst + $setOptionsList;

        return $joinOptions;
    }

    // if num_rows < 0

    return $joinOptions = ['' => '- Select -'];
}





function price($data)
{
    return 'Rp ' . number_format($data, '0', ',', '.') . ',-';
}


function formatPriceIdr($price, $decimals = 1)
{
    if ($price < 900) {
        $formatNumber = number_format($price, $decimals);
        $unit         = '';
    } else if ($price < 900000) {
        $formatNumber = number_format($price / 1000, $decimals);
        $unit         = 'rb';
    } else if ($price < 900000000) {
        $formatNumber = number_format($price / 1000000, $decimals);
        $unit         = 'jt';
    } else if ($price < 900000000000) {
        $formatNumber = number_format($price / 1000000000, $decimals);
        $unit         = 'M';
    } else if ($price < 900000000000) {
        $formatNumber = number_format($price / 1000000000000, $decimals);
        $unit         = 'T';
    }

    if ($decimals > 0) {
        $seperate     = '.' . str_repeat(0, $decimals);
        $formatNumber = str_replace($seperate, '', $formatNumber);
    }

    return $formatNumber . $unit;
}


function calculateDiffDate($dateFrom, $dateTo)
{

    $start = strtotime($dateFrom);
    $end   = strtotime($dateTo);

    $count = ceil(abs($end - $start) / 86400);
    return $count;
}


function allSubtotal($dataCond, $column)
{
    return 'Rp ' . number_format(array_sum(array_column($dataCond, $column)), 0, ',', '.') . ',-';
}


function totalRooms($id)
{


    $ci = &get_instance();
    $query =  $ci->db->select('*')
        ->from('rooms')
        ->where('id_type_rooms', $id)
        ->where('status', 0)
        ->count_all_results();
    return $query;
}

function countCond($table, $cond)
{

    $ci = &get_instance();
    $query = $ci->db->select('*')
        ->from($table)
        ->where($cond)
        ->count_all_results();
    return $query;
}

function time_Ago($time)
{

    // Calculate difference between current 
    // time and given timestamp in seconds 
    $diff     = time() - $time;

    // Time difference in seconds 
    $sec     = $diff;

    // Convert time difference in minutes 
    $min     = round($diff / 60);

    // Convert time difference in hours 
    $hrs     = round($diff / 3600);

    // Convert time difference in days 
    $days     = round($diff / 86400);

    // Convert time difference in weeks 
    $weeks     = round($diff / 604800);

    // Convert time difference in months 
    $mnths     = round($diff / 2600640);

    // Convert time difference in years 
    $yrs     = round($diff / 31207680);

    // Check for seconds 
    if ($sec <= 60) {
        echo "$sec seconds ago";
    }

    // Check for minutes 
    else if ($min <= 60) {
        if ($min == 1) {
            echo "one minute ago";
        } else {
            echo "$min minutes ago";
        }
    }

    // Check for hours 
    else if ($hrs <= 24) {
        if ($hrs == 1) {
            echo "an hour ago";
        } else {
            echo "$hrs hours ago";
        }
    }

    // Check for days 
    else if ($days <= 7) {
        if ($days == 1) {
            echo "Yesterday";
        } else {
            echo "$days days ago";
        }
    }

    // Check for weeks 
    else if ($weeks <= 4.3) {
        if ($weeks == 1) {
            echo "a week ago";
        } else {
            echo "$weeks weeks ago";
        }
    }

    // Check for months 
    else if ($mnths <= 12) {
        if ($mnths == 1) {
            echo "a month ago";
        } else {
            echo "$mnths months ago";
        }
    }

    // Check for years 
    else {
        if ($yrs == 1) {
            echo "one year ago";
        } else {
            echo "$yrs years ago";
        }
    }

    // Initialize current time 
    // $curr_time = "2013-07-10 09:09:09"; 

    // // The strtotime() function converts 
    // // English textual date-time 
    // // description to a UNIX timestamp. 
    // $time_ago = strtotime($curr_time); 

    // // Display the time ago 
    // echo time_Ago($time_ago) . "\n"; 


    // // Initialize current time 
    // $curr_time="2019-01-05 09:09:09"; 

    // // The strtotime() function converts 
    // // English textual date-time 
    // // description to a UNIX timestamp. 
    // $time_ago =strtotime($curr_time); 

    // // Display the time ago 
    // echo time_Ago($time_ago); 
}



function indoDate($date)
{
    $mount = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $date);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $mount[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}


function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

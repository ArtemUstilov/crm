<?php

function display_data($data, $title)
{
    $output = "<div id='wrapper'><h1>$title</h1><table id='keywords'><thead>";
    foreach ($data as $key => $var) {
        $currentCol = '';
        if ($key === 0) {
            $output .= '<tr>';
            foreach ($var as $col => $val) {
                $output .= "<th>" . $col . '<span></span></th>';
                $currentCol = $val;
            }
            $output .= '</tr></thead><tbody id="tbody">';
            $output .= '<tr>';
            foreach ($var as $col => $val) {
                $output .= '<td title=' . $val . '>' . $val . '</td>';
            }
            $output .= '</tr>';
        } else {
            $output .= '<tr>';
            foreach ($var as $col => $val) {
                $output .= '<td title="' . $val . '">' . $val . '</td>';
            }
            $output .= '</tr>';
        }
    }
    $output .= '</tbody></table></div>';
    return $output;
}

function clean($value = "")
{
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    return $value;
}

function isAuthorized()
{
    session_start();
    if (isset($_SESSION['id']) && isset($_SESSION['login']) && isset($_SESSION['password'])) return true;
    return false;
}

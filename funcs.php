<?php

function display_data($data, $title) {
    $output = "<div id='wrapper'><h1>$title</h1><table id='keywords'><thead>";
    foreach($data as $key => $var) {
        $currentCol = '';
        if($key===0) {
            $output .= '<tr>';
            foreach($var as $col => $val) {
                $output .= "<th>" . $col . '<span></span></th>';
                $currentCol = $val;
            }
            $output .= '</tr></thead><tbody>';
            $output .= '<tr>';
            foreach($var as $col => $val) {
                $output .= '<td title='.$val.'>' . $val . '</td>';
            }
            $output .= '</tr>';
        }
        else {
            $output .= '<tr>';
            foreach($var as $col => $val) {
                $output .= '<td title="'.$val.'">' . $val . '</td>';
            }
            $output .= '</tr>';
        }
    }
    $output .= '</tbody></table></div>';
    return $output;
}
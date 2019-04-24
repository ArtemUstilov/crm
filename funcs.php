<?php
function display_data($data, $title) {

    $output = "<div id='wrapper'><h1>$title</h1><table id='keywords'><thead>";
    foreach ($data as $key => $var) {
        $currentCol = '';
        $index = 0;
        if($key===0) {
            $output .= '<tr>';
            foreach($var as $col => $val) {
                $output .= "<th><div class='col-wrap'><p>" . $col . "</p><span></span></div><input id=$index-i>
</th>";
                $currentCol = $val;
                $index++;
            }
            $index = 0;
            $output .= '</tr></thead><tbody id="tbody">';
            $output .= '<tr>';
            foreach($var as $col => $val) {
                $output .= '<td class='.$index.'-f title="'.$val.'">' . $val . '</td>';
                $index++;
            }
            $output .= '</tr>';
        }
        else {
            $index = 0;
            $output .= '<tr>';
            foreach($var as $col => $val) {
                $output .= '<td class='.$index.'-f title="'.$val.'">' . $val . '</td>';
                $index++;
            }
            $output .= '</tr>';
        }
    }
    $output .= '</tbody></table><button type="button" id="add-btn">Добавить</button></div>';
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

<?php
function display_data($data, $add)
{

    $output = "<div id='wrapper'><div class='table-menu'><a href='./components/main/add" . $add . ".php' id='add-btn'>Добавить</a></div>
<div class='table-wrapper'>
<table id='table-container'><thead>";
    foreach ($data as $key => $var) {
        $index = 0;
        if ($key === 0) {
            $output .= '<tr>';
            foreach ($var as $col => $val) {
                $output .= "<th><div class='col-wrap'><p>" . $col . "</p><span></span></div><input id=$index-i>
</th>";
                $currentCol = $val;
                $index++;
            }
            $index = 0;
            $output .= '</tr></thead><tbody id="tbody">';
            $output .= '<tr>';
            foreach ($var as $col => $val) {
                $output .= '<td class=' . $index . '-f title="' . $val . '">' . $val . '</td>';
                $index++;
            }
            $output .= '</tr>';
        } else {
            $index = 0;
            $output .= '<tr>';
            foreach ($var as $col => $val) {
                $output .= '<td class=' . $index . '-f title="' . $val . '">' . $val . '</td>';
                $index++;
            }
            $output .= '</tr>';
        }
    }
    $output .= '</tbody></table></div></div>';
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

<?php
function display_data($data, $type, $text, $addition_data = NULL)
{
    switch ($type) {
        case"Debt":
        case "Debtor":
            $add_btn_text = "Погасить";
            break;
        case"Rollback":
        case"RollbackMain":
            $add_btn_text = "Выплатить";
            break;
        case"Order":
            $add_btn_text = "Создать";
            break;
        default:
            $add_btn_text = "Добавить";
            break;
    }
    session_start();
    $data = mysqliToArray($data);
    $output = "<div class='table-menu'><h2>$text</h2>";
    $class = $type == 'Debtor' ? 'Debt' : ($type=='RollbackMain' ? 'Rollback' : $type);
    if ($type == "User" || $type == "VG") {
        if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'sub-admin' || $_SESSION['role'] == 'moder')
            $output .= "<p><a id='add-btn' href=\"#$class-Modal\" rel=\"modal:open\">$add_btn_text</a></p>";
    } else {
        $output .= "<p><a id='add-btn' href=\"#$class-Modal\" rel=\"modal:open\">$add_btn_text</a></p>";
    }
    $output .= "</div><div class='table-wrapper' id='table-wrapper'>" . makeTable($data, $type =='Debtor' || $type=='RollbackMain' ? "#$class-Modal" : false) . "</div>";
    $output .= chooseAddModal($type, $data, $addition_data);
    return $output;
}

function makeTable($data, $delLine = false)
{
    $role = $_SESSION['role'];
    $output = "<table class='table-container' class='table table-fixed'><thead id='table-head'>";
    if (!$data || count($data) === 0) {
        $output .= '<h2>Пусто</h2>';
    } else {
        foreach ($data as $key => $var) {
            $index = 0;
            if ($key === 0) {
                $output .= '<tr>';
                foreach ($var as $col => $val) {
                    if (is_numeric($col)) continue;
                    $output .= "<th><div class='col-wrap'><p>" . $col . "</p><span></span></div><input id=$index-i>
</th>";
                    $index++;
                }
                $index = 0;
                $output .= '</tr></thead><div></div><tbody id="tbody">';
                $output .= '<tr  defaultVal = "'.$var[1].'">';
                foreach ($var as $col => $val) {
                    if (is_numeric($col)) continue;
                    if($col == 0 && $index == 0 && $delLine){
                        $output .= '<td class=' . $index . '-f title="' . $val . '" style="text-align: left">' . '<i class="fas fa-coins" modal="'.$delLine.'"></i>' .$val . '</td>';
                    }else if($col == 0 && $index == 0 && $role !== 'agent'){
                        $output .= '<td class=' . $index . '-f title="' . $val . '" style="text-align: left">' . '<i class="fas fa-edit" modal="tbd"></i>' .$val . '</td>';
                    }else
                    $output .= '<td class=' . $index . '-f title="' . $val . '">' . $val . '</td>';
                    $index++;
                }
                $output .= '</tr>';
            } else {
                $index = 0;
                $output .= '<tr  defaultVal = "'.$var[1].'">';
                foreach ($var as $col => $val) {
                    if (is_numeric($col)) continue;
                    if($col == 0 && $index == 0 && $delLine){
                        $output .= '<td class=' . $index . '-f title="' . $val . '" style="text-align: left">' . '<i class="fas fa-coins" modal="'.$delLine.'"></i>' .$val . '</td>';
                    }else if($col == 0 && $index == 0 && $role !== 'agent'){
                        $output .= '<td class=' . $index . '-f title="' . $val . '" style="text-align: left">' . '<i class="fas fa-edit" modal="tbd"></i>' .$val . '</td>';
                    }else
                        $output .= '<td class=' . $index . '-f title="' . $val . '">' . $val . '</td>';
                    $index++;
                }
                $output .= '</tr>';
            }
        }
    }

    $output .= '</tbody></table>';
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
    return isset($_SESSION['id']) && isset($_SESSION['login']) && isset($_SESSION['password']);
}

function mysqliToArray($mysqli_result)
{
    $i = 0;
    $data = null;
    while ($new = $mysqli_result->fetch_array()) $data[$i++] = $new;
    return $data;
}

function chooseAddModal($name, $data, $more_data = NULL)
{
    foreach (glob("./components/modals/*.php") as $filename) {
        include_once $filename;
    }
    switch ($name) {
        case "User":
            return userAddModal($data, $more_data);
        case "Client":
            return clientAddModal($data);
        case "Outgo":
            return outgoModal($data, $more_data);
        case "Order":
            return orderAddModal($data, $more_data).''.clientAddModal($data);
        case "VG":
            return vgAddModal($data);
        case "Rollback":
        case"RollbackMain":
            return rollbackModal($more_data);
        case "Debt":
        case "Debtor":
            return debtModal($more_data);
        case "Head":
            return headAddModal($more_data);
        case "Branch":
            return branchAddModal($data);
        default:
            return null;
    }
}






















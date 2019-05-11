<?php
function display_data($data, $options, $addition_data = NULL)
{
    session_start();
    $data = mysqliToArray($data);
    return
        ("
        <div class='table-menu' " . (iCan($options['range']) ? 'style = "justify-content: left;"' : '') . ">
            <h2 type=" . $options['type'] . ">" . $options['text'] . "</h2>"
            . (iCan($options['btn']) && iCanMax($options['btn-max']) ? "
            <p><a 
                    id='add-btn' 
                    href=\"#" . $options['type'] . "-Modal\" 
                    rel=\"modal:open\">" . $options['btn-text'] . "
            </a></p>
            " : '') .
            (iCan($options['range']) ? "
            <div id='reportrange'>
    <i class='fa fa-calendar'></i>&nbsp;
    <span></span> <i class='fa fa-caret-down'></i>
</div>
            " : '') .
            "
        </div>
        <div class='table-wrapper " . $options['type'] . "' id='table-wrapper'>
            <a 
                    class='display-none' 
                    href=\"#" . $options['type'] . "-edit-Modal\" 
                    rel=\"modal:open\">
            </a>
            " . makeTable($data, $options) . "
        </div>
        " . chooseAddModal($options['type'], $data, $addition_data)
        );
}

function makeTable($data, $options)
{
    if (!$data || count($data) === 0) {
        return '<h2>Пусто</h2>';
    }
    $output = "<table class='table-container table table-fixed'>";
    foreach ($data as $key => $var) {
        $index = 0;
        if ($key === 0) {
            $output .= '<thead id="table-head"><tr>';
            foreach ($var as $col => $val) {
                if ($col == 'id') continue;
                $output .= "<th><div class='col-wrap'><p>" . $col . "</p><span></span></div><input id=$index-i></th>";
                $index++;
            }
            $output .= '</tr></thead><tbody id="tbody">';
        }
        $index = 0;
        $output .= '<tr  defaultVal = "' . $var['Имя'] . '" itemId = "' . $var['id'] . '">';
        foreach ($var as $col => $val) {
            if ($col == 'id') continue;
            $actions = '';
            if ($index == 0) {
                $actions .= $options['coins'] ? '<i class="fas fa-coins" modal="#' . $options['modal'] . '"></i>' : '';
                $actions .= $options['info'] ? '<i class="fas fa-info-circle" modal="info"></i>' : '';
                $actions .= ($options['edit'] && iCan($options['edit'])) ? '<i class="fas fa-edit"  modal="' . $options['type'] . '-edit"></i>' : '';
            }
            if ($col == 'статус') {
                $output .= '<td class=' . $index . '-f title="' . $val . '"><p style="display: none">'.$val.'</p>
                <div class="button b2" id="button-10">
                <input type="checkbox" class="checkbox" ' . ($val == 0 ? 'checked' : '') . '>
                <div class="knobs"></div>
                </div>
            </td>';
            } else {
                $output .= '<td class=' . $index . '-f title="' . $val . '">' . $actions . ($val == '' || $val === null ? '-' : $val) . '</td>';
            }
            $index++;
        }
        $output .= '</tr>';
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
    while ($new = mysqli_fetch_assoc($mysqli_result)) $data[$i++] = $new;
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
            return orderAddModal($data, $more_data) . '' . clientAddModal($data);
        case "VG":
            return vgAddModal($more_data);
        case "Rollback":
            return rollbackModal($more_data);
        case "Debt":
            return debtModal($more_data);
        case "Head":
            return headAddModal($more_data);
        case "Branch":
            return branchAddModal($data);
        case "Fiat":
            return fiatAddModal($data);
        default:
            return null;
    }
}

function accessLevel($role = false)
{
    $r = $role ? $role : $_SESSION['role'];
    switch ($r) {
        case 'agent':
            return 1;
        case 'admin':
            return 2;
        case 'moder':
            return 3;
    }
}

function iCan($actionLvl)
{
    return !is_null($actionLvl) && $actionLvl <= accessLevel();
}
function iCanMax($actionLvl)
{
    return is_null($actionLvl) || $actionLvl >= accessLevel();
}
function heCan($role, $actionLvl)
{
    return !is_null($actionLvl) && $actionLvl <= accessLevel($role);
}


















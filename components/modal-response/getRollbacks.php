<?php
if (isset($_POST['client_id'])) {
    include_once("../../db.php");
    include_once("../../funcs.php");
    $client_id = clean($_POST['client_id']);
    session_start();
    $user_id = $_SESSION['id'];
    $user_data = mysqli_fetch_assoc($connection->query("
        SELECT * 
        FROM users 
        WHERE user_id='$user_id'"));
    if (!$user_data) return false;
    $client_data = mysqli_fetch_assoc($connection->query("
        SELECT * 
        FROM clients 
        WHERE client_id='$client_id'"));

    if (is_numeric($client_data['callmaster'])) {
        echo '<div class="orders-modal-owners-list">
<p>
  <input id="rollback1Field" placeholder="Откат 1 %" type="number" name="rollback-1" step="0.01">
  </p>
  <p>
  <input id="rollback2Field"  placeholder="Откат 2 %" type="number" name="rollback-2" step="0.01">
  </p>
  </div>';
    } else {
        return false;
    }
}

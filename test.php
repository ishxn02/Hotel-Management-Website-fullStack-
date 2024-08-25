<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Received POST data:";
    print_r($_POST);
} else {
    echo "This is a POST request test script";
}
?>

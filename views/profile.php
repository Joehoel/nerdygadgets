<?php
include __DIR__ . "/connect.php";
include __DIR__ . "/header.php";

if (!isset($_SESSION["User"])) {
    echo '<script>window.location.href = "'.base_url.'inloggen"</script>';
}
?>
<div class="payments-container">
    <a href="<?php echo base_url; ?>uitloggen"><h1>uitloggen</h1></a>
</div>
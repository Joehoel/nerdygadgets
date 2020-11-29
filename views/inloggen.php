<?php
include __DIR__ . "/connect.php";
include __DIR__ . "/header.php";

if (isset($_SESSION["User"])) {
    echo '<script>window.location.href = "'.base_url.'browse"</script>';
}
?>
<div class="pop-up" id="pop-up"></div>
<?php if (isset($_GET['error'])) {
    echo '<script> popup("' . $_GET['error'] . '", true); </script>';
} 
if (isset($_GET["newuser"])) {
    echo '<script> popup("Je bent geregistreerd", false); </script>';
}
?>
<div class="inloggen-container">
    <h1>Inloggen</h1>
    <a href="<?php echo base_url ?>registreren">heb je nog geen account?</a>
    <form method="POST" action="<?php echo base_url; ?>login">
        <input type=" text" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input id="button" type="submit" value="inloggen">
    </form>
</div>
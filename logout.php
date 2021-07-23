<?php
session_start();
unset($_SESSION["id"]);
unset($_SESSION["username"]);
session_destroy();
echo "<script>alert('Logout successful')
		window.location.href='index.html'
</script>";

?>
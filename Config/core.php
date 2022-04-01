<?php
extract(parse_ini_file(ROOT . "Config/config.ini")); // Load configs

require(ROOT . "Config/db.php");
require(ROOT . "Core/Controller.php");
require(ROOT . "Core/Model.php");

?>
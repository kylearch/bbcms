<?php

// Timezone
// Find your timezone string here
// http://php.net/manual/en/timezones.php
$config["timezone"] = "America/Chicago";

// Uploads Directory
$config["uploads"] = "public/uploads/";

// Routes
$config["routes"] = array(
	"default_controller" => "root",
);

// DB Config
$config["db"] = array(
	"host" => "localhost",
	"user" => "root",
	"pass" => "root",
	"database" => "joust"
);
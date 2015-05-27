<?php

class File
{

	public static $dir;

	public function __construct()
	{
		$this->Config = Booster::get("Config");
		self::$dir = $this->Config->uploads;
	}

	public function node_file($data)
	{
		$dest_dir = $this->directory($data["node"]);
		$filename = date('Y-m-d_H-i-s') . $this->extension($data["file"]);
		$destination = $dest_dir . $filename;
		return (move_uploaded_file($data["file"]["tmp_name"], $destination)) ? $destination : FALSE ;
	}

	public static function directory($dir)
	{
		$dir = self::$dir . $dir;
		if ( ! is_dir($dir))
		{
			mkdir($dir, 0755, TRUE);
		}
		return rtrim($dir, "/") . "/";
	}

	public function extension($file)
	{
		$mime_types = $this->Config->load("application/config/mime_types.php");
		$ext = (is_array($mime_types) && array_key_exists($file["type"], $mime_types)) ? $mime_types[$file["type"]] : strtolower(pathinfo($file["name"], PATHINFO_EXTENSION)) ;
		return ".{$ext}";
	}



}
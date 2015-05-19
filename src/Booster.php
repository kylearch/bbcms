<?php

class Booster
{

	private static $registry;

	public static function find_class_file($name)
	{
		$matches = glob("{src/{$name}.php,application/controllers/{$name}.php,application/models/{$name}.php}", GLOB_BRACE);
		return (isset($matches[0])) ? $matches[0] : FALSE ;
	}

	public static function set($class, $name = NULL)
	{
		if ( ! isset(self::$registry[$class]))
		{
			if ($file = self::find_class_file($class))
			{
				require_once($file);
				$class_name = is_null($name) ? $class : $name ;
				$instance = new $class();
				self::$registry[$class_name] = $instance;
				return $instance;
			}
			else
			{
				echo "not found"; exit;
			}
			
		}
		else
		{
			return self::$registry[$class];
		}
	}

	public static function get($class)
	{
		return self::$registry[$class];
	}

	public static function update($class)
	{
		$reflector = new ReflectionClass($class);
		self::$registry[$reflector->name] = $class;
		return $class;
	}

}
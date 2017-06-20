<?php

namespace Core\Database;

use PDO;

class Connection
{
	function make()
	{
		try {
			return new PDO('sqlite::memory:', null, null, [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			]);
		} catch (\PDOException $e) {
			die($e->getMessage());
		}
	}
}
<?php

use Core\App;
use Core\Database\{Connection, QueryBuilder};

App::bind('database', 
	new QueryBuilder(Connection::make())
);
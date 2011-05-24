<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class DatabaseConnection extends PDO {
		public $driver	= '';
		public $host	= '';
		public $user	= '';
		public $pass	= '';
		public $name	= '';
		public $port	= '';
		
		private $dsn	= '';
		
		public function __construct($config) {
			$this->driver = $config['driver'];
			$this->host = $config['host'];
			$this->user = $config['user'];
			$this->pass = $config['pass'];
			$this->name = $config['name'];
			$this->port = $config['port'];
			
			switch(strtolower($this->driver)) {
				case 'mysql':
					$this->dsn = sprintf('mysql:host=%s;dbname=%s', $this->host, $this->name);
				break;
				
				case 'postgresql':
				case 'postgre':
				case 'pgsql':
					$this->dsn = sprintf('pgsql:host=%s;dbname=%s', $this->host, $this->name);
				break;
				
				case 'oracle':
				case 'oci':
				case 'ora':
					$this->dsn = sprintf('oci:dbname=%s/%s', $this->host, $this->name);
				break;
				
				case 'sqlserver':
				case 'mssql':
				case 'dblib':
					$this->dsn = sprintf('dblib:host=%s;dbname=%s', $this->host, $this->name);
				break;
				
				case 'sqlite':
					$this->dsn = sprintf('sqlite:%s', $this->host);
				break;
				
				case 'odbc':
					$this->dsn = sprintf('odbc:Driver={Microsoft Access Driver (*.mdb)};Dbq=%s', $this->host);
				break;
				
				case 'sybase':
					$this->dsn = sprintf('sybase:host=%s;dbname=%s', $this->host, $this->name);
				break;
				
				case 'ibm':
				case 'db2':
					$this->dsn = sprintf('ibm:DRIVER={IBM DB2 ODBC DRIVER};DATABASE=%s;HOSTNAME=%s;PORT=%s;PROTOCOL=TCPIP', $this->name, $this->host, $this->port);
				break;
			}
			
			parent::__construct($this->dsn, $this->user, $this->pass);
			
			$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	}
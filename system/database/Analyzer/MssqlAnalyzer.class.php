<?php
	class MssqlAnalyzer {
		const SP_COLUMN = 'sp_columns @table_name=%s';
		
		private $entity = NULL;
		private $column = NULL;
		
		public function __construct(Entity $entity) {
			$this->entity = $entity;
		}
		
		public function getColumn() {
			if(empty($this->column)) {
				$this->column = new DatabaseColumn;
				
				$db = Database::getInstance()->getConnection($this->entity->getConfigName());
				$statement = $db->query(sprintf(self::SP_COLUMN, $this->entity->getEntityName()));
				
				foreach($statement as $row) {
					$this->column->add($row['COLUMN_NAME'], $row['TYPE_NAME'], $row['LENGTH']);
				}
			}
						
			return $this->column;
		}
		
		public function getPrimaryKey() {
			return $this->column[0]['name'];
		}
	}
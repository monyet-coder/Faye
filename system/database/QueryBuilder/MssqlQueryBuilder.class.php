<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	final class MssqlQueryBuilder extends aQueryBuilder {
		const ORDER_ASC 	= 'ASC';
		const ORDER_DESC 	= 'DESC';
		const OPEN_QUOTE	= '';
		const CLOSE_QUOTE	= '';
		const TRUE			= '1 = 1';
		const FALSE			= '0 = 1';
		
		protected function buildCondition() {
			if(empty($this->where)) {
				return NULL;
			}
			
			$wheres = array();
			foreach($this->where as $where) {
				$wheres[] = sprintf(' %s %s %s (%s)', 
								$where['conjunction'], 
								self::OPEN_QUOTE . $this->stripOperator($where['field']) . self::CLOSE_QUOTE,
								$where['operator'], 
								$where['placeholder']);
			}
			
			return sprintf('WHERE %s %s ', self::TRUE, implode($wheres));
		}
		
		private function setQuote($query) {
			return sprintf("SET QUOTED_IDENTIFIER ON;%s", $query);
		}
		
		public function buildInsert($data = array()) {
			if(empty($this->from)) {
				throw new Exception('The entity name is not specified.');
			}
			
			if(empty($data)) {
				throw new Exception('There is no data to be inserted.');
			}
			
			$params = array();
			foreach($data as $field => $value) {
				$params[] = ':' . $field;
			}

			$this->query = sprintf('INSERT INTO "%s"(%s) VALUES (%s)', $this->from, implode(', ', array_keys($data)), implode(', ', $params));
			
			$this->reset();
			
			return $this->setQuote($this->query);
		}
		
		public function buildUpdate($data = array()) {
			if(empty($this->from)) {
				throw new Exception('The entity name is not specified.');
			}
			
			if(empty($data)) {
				throw new Exception('There is no data to be updated.');				
			}
			
			$setValues = array();
			foreach($data as $field => $value) {
				$setValues[] = sprintf('"%s" = :v_%s', $field, $field);
			}

			$this->query = sprintf('UPDATE "%s" SET %s %s', $this->from, implode(', ', $setValues), $this->buildCondition());
			
			return $this->setQuote($this->query);
		}
		
		public function buildDelete() {
			if(empty($this->from)) {
				throw new Exception('The entity name is not specified.');
			}
			
			$this->query = sprintf('DELETE FROM "%s" %s', $this->from, $this->buildCondition());
			
			return $this->setQuote($this->query);
		}
		
		private function buildFields() {
			$fields = array();
			if(empty($this->field)) {
				$fields[] = '*';
			} else {
				foreach($this->field as $field) {
					$f = $field['fieldName'];
					
					if(!empty($field['aggregate'])) {
						$f = sprintf('%s(%s) AS %s', $field['aggregate'], $f, $field['alias']);
					}
					
					$fields[] = $f;
				}
			}
			
			return implode(', ', $fields);
		}
		
		public function build() {			
			if(empty($this->from)) {
				throw new Exception('The entity name is not specified.');
			}			
			
			$this->query = sprintf('%s FROM %s %s ', $this->buildFields(), implode(', ', $this->from), $this->buildCondition());			
		
			if(!empty($this->groupBy)) {
				$this->query .= sprintf('GROUP BY %s', implode(', ', $this->groupBy));
			}
		
			if(empty($this->orderBy) and !empty($this->orderWay) and !empty($this->entity->primaryKey)) {
				$this->orderBy[] = $this->entity->primaryKey;				
			}
			
			if(!empty($this->orderBy)) {
				$this->query .= sprintf('ORDER BY %s %s ', implode(', ', $this->orderBy), $this->orderWay);
			}
			
			if(!empty($this->limit)) {
				if(empty($this->offset)) {
					$this->offset = 0;
				}
				
				$this->query = sprintf('SELECT TOP %d * FROM (SELECT TOP %d %s) LIMIT', $this->limit, $this->limit + $this->offset, $this->query);
			} else {
				$this->query = 'SELECT ' . $this->query;
			}
			
			#return $this->setQuote($this->query);
			return $this->query;
		}
	}
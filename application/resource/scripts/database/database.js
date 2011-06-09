FAYE.database = (function(undefined){
	var database	= undefined,
		name 		= 'db',
		version 	= '1.0',
		description = 'First database',
		size 		= 2 * 1024 * 1024;
		
	var open = function(n, v, d, s) {
			name 		= n || name;
			version		= v || version;
			description	= d || description;
			size		= s || size;
			
			database = window.openDatabase(name, version, description, size);
			
			return this;
		},
		close = function() {
			return this;
		},
		exec = function(SQLSyntax, param, callback) {
			if(typeof param === 'function' && !callback) {
				callback = param;
				param = [];
			}
			
			database.transaction(function(t) {
				t.executeSql(SQLSyntax, param || [], callback || function() {});
			});
			
			return this;
		},
		createTable = function(tableName, scheme) {
			var SQL = 'CREATE TABLE IF NOT EXISTS ' + tableName,
				field, 
				fields = [];
			
			for(field in scheme) {
				fields.push(field + ' ' + scheme[field].type);
			}
			
			SQL += '(' + fields.join(', ') + ')';
			
			return exec(SQL);
		},
		dropTable = function(tableName) {
			return exec('DROP TABLE IF EXISTS ' + tableName);
		};
	
	return {
		open 	: open,
		close 	: close,
		createTable : createTable,
		dropTable : dropTable,
		exec 	: exec,
		query 	: exec
	};
}.call({}));

FAYE.database.entity = function(__entityName, __primaryKey, __options) {
	if(this === FAYE.database) {
		return new FAYE.database.entity(__entityName, __primaryKey);
	}
	
	var db			= FAYE.database,
		result		= [],
		entityName	= __entityName,
		primaryKey	= __primaryKey,	
		fields		= [],
		conditions	= [],
		execParam	= [],
		orders		= [],
		orderWay	= 'ASC',
	
		// Methods
		construct 	= function() {
			for(key in __options || {}) {
				
			}
		},
		select = function() {
			var args = arguments, i;
			
			if(args.length === 1) {
				for(i = 0; i < args[0].length; ++i) {
					args.callee(args[0][i]);
				}
			} else {
				for(i = 0; i < args.length; ++i) {
					fields.push(args[i]);
				}
			}

			return this;
		},
		where = function() {
			var args = arguments;
			
			if(args.length === 0) {
				return this;
			}
			
			if(args[0] instanceof Object) {
				for(var key in args[0]) {
					conditions.push({ key : args[0][key]});
				}
			} else if(args.length === 2) {
				var condition = {};
				
				condition[args[0]] = args[1];
				conditions.push(condition);
			}

			return this;
		},
		orderBy = function() {
			var args = arguments;
			
			if(args.length === 0) {
				return this;
			}
			
			if(args[0] instanceof Array) {
				for(var i = 0; i < args[0].length; ++i) {
					args.callee(args[0][i]);
				}
			} else {
				for(var i = 0; i < args.length; ++i) {
					orders.push(args[i]);
				}
			}
			
			return this;
		},
		asc = function() {
			orderWay = 'ASC';
			
			return this;
		},
		desc = function() {
			orderWay = 'DESC';
			
			return this;
		},
		clear = function() {
			fields = conditions = orders = [];
			
			return this;
		},
		build = function() {
			var SQL = 'SELECT ',
				wheres = [];
			
			if(fields.length === 0) {
				fields.push('*');
			}
			
			SQL += fields.join(', ') + ' FROM ' + entityName;
			if(conditions.length > 0) {
				SQL += ' WHERE ';
				for(var i = 0; i < conditions.length; ++i) {
					for(var key in conditions[i]) {
						if(hasOperator(key)) {
							wheres.push(key + ' ?');
						} else {
							wheres.push(key + ' = ?');
						}					
	
						execParam.push(conditions[i][key]);
					}
				}
				SQL += wheres.join(' AND ');
			}
			
			if(orders.length > 0) {
				SQL += ' ORDER BY ' + orders.join(', ') + ' ' + orderWay;
			}
			
			clear();
			
			return SQL;
		}, 
		exec = function(callback) {
			var SQL = build(),
				self = this;

			db.exec(SQL, execParam, function(tx, results) {
				var len = results.rows.length;

				for(var i = 0; i < len; ++i) {					
					result.push(results.rows.item(i));
				}
				
				(callback || function(){}).call(self);
			});
			
			return this;
		}, 
		insert = function() {
			var args 	= arguments,
				keys	= [], 
				values	= [],
				dummy	= [];
			
			if(args.length === 0) {
				return this;
			}
			
			if(args.length > 1) {
				for(var i = 0; i < args.length; ++i) {
					args.callee(args[i]);
				}
			} else {
				if(args[0] instanceof Array) {
					for(var i = 0; i < args[0].length; ++i) {
						args.callee(args[0][i]);
					}
				} else {
					for(var key in args[0]) {
						keys.push(key);
						values.push(args[0][key]);
						dummy.push('?');
					}
					
					db.exec('INSERT INTO ' + entityName + ' (' + keys.join(', ') + ') VALUES (' + dummy.join(', ') + ')', values);
				}
			}
						
			return this;
		},
		update = function() {
			var args 	= arguments,
				keys	= [],
				values	= [],
				sets	= [];
				
			if(args.length === 0) {
				return this;
			}
			
			if(args.length > 1) {
				for(var i = 0; i < args.length; ++i) {
					
				}
			} else {
				if(args[0] instanceof Array) {
					for(var i = 0; i < args[0].length; ++i) {
						args.callee(args[0][i]);
					}
				} else {
					for(var key in args[0]) {
						sets.push(key + ' = ?');
					}

					db.exec('UPDATE ' + entityName + ' SET ' + sets.join(', ') + ' WHERE ');
				}
			}
			
			return this;
		},
		del = function() {
			var args = arguments, i;
			
			if(args.length === 0) {
				return this;
			}
			
			if(args.length === 1) {				
				if(args[0] instanceof Array) {
					for(i = 0; i < args[0].length; i++) {
						args.callee(args[0][i]);
					}
				} else {
					args[0] = parseInt(args[0]);
					
					if(typeof args[0] === 'number') {
						db.exec('DELETE FROM ' + entityName + ' WHERE ' + primaryKey + ' = ?', args);
					}
				}
			} else {
				for(i = 0; i < args.length; ++i) {
					args.callee(args[i]);
				}
			}
			
			return this;
		},
		hasOperator = function(SQL) {
			return /(<|>|!|=|is null|is not null|like)/i.test(SQL);
		},
		stripOperator = function(SQL) {
			return SQL.replace(/(<|>|!|=|is null|is not null|like)/i, '');
		};
	
	construct();
	
	this.select 	= select,
	this.where 		= where,
	this.orderBy 	= orderBy,
	this.asc		= asc,
	this.desc		= desc,
	this.clear 		= clear,
	this.exec 		= exec,
	this.insert		= insert,
	this.update		= update,
	this.delete		= del,
	this.result 	= result,
	this.relations	= [];
};

FAYE.database.entities = {};
FAYE.database.entities.Foo = function() {
	// Check in case developer is
	// calling this method without the 
	// new keyword.
	if(this === FAYE.database.entities) {
		return new FAYE.database.entities.Foo;
	}
	
	// Extending FAYE.database.entity
	// immediately calling the constructor
	// with table name and primary key name.
	this.__proto__ = FAYE.database.entity('foo', 'id');
	
	// Defining any entity which has
	// relationship with this entity.
	this.relations = [
		'bar'
	];
	
	return this;
};

FAYE.database.open();	
FAYE.database.createTable('bar', {
	BarID 			: {type : 'int PRIMARY KEY'},
	id				: {type : 'int'},
	BarDescription 	: {type : 'varchar(200)'}
});
var foo = new FAYE.database.entities.Foo;
foo.
	where('id % 2', 0).
	exec(function() {
	var i;

	$.map(this.result, function(value, key) {
		$('<li>').append(value.text).appendTo(document.body);
	});
});

/*	
foo.insert({
	id : 3,
	text : 'some text',
}, {
	id : 4,
	text : 'lala',
});
*/
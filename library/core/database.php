<?php
namespace Core;

class Database
{
    /**
     * 链接目标对象
     * @var string
     */
    protected $db_target = NULL;
    
    /**
     * 用户名
     * @var string
     */
    protected $user_name = NULL;
    
    /**
     * 密码
     * @var string
     */
    protected $password = NULL;
    
    /**
     * 参数
     * @var array
     */
    protected $params = array ();
    
    /**
     * PDO对象
     * @var PDO
     */
    protected $pdo = NULL;
    
    /**
     * 字段分隔符
     * @var string
     */
    public $i = '`';
    
    /**
     * 查询的申明
     * @var array
     */
    public $statements = array ();
    
    /**
     * 所有查询的SQL
     * @var array
     */
    public static $queries = array ();
    
    /**
     * 最后查询的SQL
     * @var string
     */
    public static $last_query = NULL;
    
    /**
     * 设置数据库连接参数
     * @param array $config
     * 
     * @code php
     * 
     * $db_target = 'host=127.0.0.1;port=3306;dbname=yuwenc';
     * $user_name = 'yuwenc';
     * $password = 'yuwenc';
     * $params = array (PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") ;
     * $mysql = new \Core\MySql($dbTarget, $userName, $password, $params);
     * @endcode
     */
    public function __construct($db_target, $user_name, $password, $params)
    {
        $this->db_target = $db_target;
        $this->user_name = $user_name;
        $this->password = $password;
        $this->params = $params;
    }
    
    /**
     * 延迟连接数据库，当需要使用数据库操作的时候才连接
     * @return \PDO
     */
    protected function connect()
    {
        if (is_null ( $this->pdo ))
        {
            try
            {
                $this->pdo = new \PDO ( $this->db_target, $this->user_name, $this->password, $this->params );
                $this->pdo->setAttribute ( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
            }
            catch (\PDOException $e )
            {
                exit ( "ERROR: failed to connect database: {$e->getMessage()}\n" );
            }
        }
        return $this->pdo;
    }
    
    /**
     * 开始事务
     */
    public function begin_transaction()
    {
        if (! $this->pdo) $this->connect ();
        return $this->pdo->beginTransaction ();
    }
    
    /**
     * 提交事务
     * @return
     */
    public function commit()
    {
        if (! $this->pdo) $this->connect ();
        return $this->pdo->commit ();
    }
    
    /**
     * 回滚事务
     */
    public function roll_back()
    {
        if (! $this->pdo) $this->connect ();
        return $this->pdo->rollBack ();
    }
    
    /**
     * 用引号引用内容
     *
     * @param mixed $value to quote
     * @return string
     */
    public function quote($value)
    {
        if (! $this->pdo) $this->connect ();
        return $this->pdo->quote ( $value );
    }

    /**
     * 执行sql入口
     *
     * @param string $sql query to run
     * @param array $params the prepared query params
     * @return PDOStatement
     */
    public function query($sql, array $params = NULL, $cache_statement = FALSE)
    {
        $time = microtime ( TRUE );
        self::$last_query = $sql;
        if (! $this->pdo) $this->connect ();
        if ($cache_statement)
        {
            $hash = md5 ( $sql );
            if (isset ( $this->statements [$hash] ))
            {
                $statement = $this->statements [$hash];
            }
            else
            {
                $statement = $this->statements [$hash] = $this->pdo->prepare ( $sql );
            }
        }
        else
        {
            $statement = $this->pdo->prepare ( $sql );
        }
        $statement->execute ( $params );
        self::$queries[] = array (microtime ( TRUE ) - $time, $sql );
        return $statement;
    }
    
    /**
     * 执行sql获取单列结果 (例如 COUNT(*) 查询)
     *
     * @param string $sql
     * @param array $params
     * @param int $column
     * @return mixed
     */
    public function column($sql, array $params = NULL, $column = 0)
    {
        return ($statement = $this->query ( $sql, $params )) ? $statement->fetchColumn ( $column ) : NULL;
    }
    
    /**
     * 获取单行数据
     *
     * @param string $sql
     * @param array $params
     * @param string $object 自定义对象
     * @return array
     */
    public function row($sql, array $params = NULL)
    {
        if (! $statement = $this->query ( $sql, $params ))
        { 
             return NULL;   
        }
        $row = $statement->fetch ( \PDO::FETCH_OBJ );
        return $row;
    }
    
    /**
     * Run a SQL query and return an array of row objects or an array
     * consisting of all values of a single column.
     *
     * @param string $sql
     * @param array $params
     * @param int $column
     * @return array
     */
    public function fetch($sql, array $params = NULL, $column = NULL)
    {
        if (! $statement = $this->query ( $sql, $params ))
        {
        	return;
        }
        // Return an array of records
        if ($column === NULL)
        {
        	return $statement->fetchAll ( \PDO::FETCH_OBJ );
        }
        // Fetch a certain column from all rows
        return $statement->fetchAll ( \PDO::FETCH_COLUMN, $column );
    }
    
    /**
     * 删除数据
     *
     * @param string $table
     * @param array $where 
     * @return int
     */
    public function delete($table, $where = NULL)
    {
        $i = $this->i;
        $sql = "DELETE FROM $i$table$i";
        list($where, $params) = $this->where($where);
		// If there are any conditions, append them
		if($where) $sql .= " WHERE $where";

        $statement = $this->query ( $sql, $params );
        if ($statement)
        {
            return $statement->rowCount ();
        }
    }
    
    /**
     * 写入数据
     *
     * @param string $table the table name
     * @param array $data the column => value pairs
     * @return int
     */
    public function insert($table, array $data, $cache_statement = TRUE)
    {
        $sql = $this->insert_sql ( $table, $data );
        return $this->query ( $sql, array_values ( $data ), $cache_statement ) ? $this->pdo->lastInsertId () : NULL;
    }
    
    /**
     * Create insert SQL
     *
     * @param array $data row data
     * @return string
     */
    public function insert_sql($table, $data)
    {
        $i = $this->i;
        // Column names come from the array keys
        $columns = implode ( "$i, $i", array_keys ( $data ) );
        // Build prepared statement SQL
        return "INSERT INTO $i$table$i ($i" . $columns . "$i) VALUES (" . rtrim ( str_repeat ( '?, ', count ( $data ) ), ', ' ) . ')';
    }
    
    /**
     * 更新数据
     *
     * @param string $table the table name
     * @param array $data the column => value pairs
     * @return int
     */
    public function replace($table, array $data, $cache_statement = TRUE)
    {
        $sql = $this->replace_sql ( $table, $data );
        return $this->query ( $sql, array_values ( $data ), $cache_statement ) ? $this->pdo->lastInsertId () : NULL;
    }
    
    /**
     * 更新数据
     *
     * @param array $data row data
     * @return string
     */
    public function replace_sql($table, $data)
    {
        $i = $this->i;
        // Column names come from the array keys
        $columns = implode ( "$i, $i", array_keys ( $data ) );
        // Build prepared statement SQL
        return "REPLACE INTO $i$table$i ($i" . $columns . "$i) VALUES (" . rtrim ( str_repeat ( '?, ', count ( $data ) ), ', ' ) . ')';
    }
    
    /**
     * Builds an UPDATE statement using the values provided.
     * Create a basic WHERE section of a query using the format:
     * array('column' => $value) or array("column = $value")
     *
     * @param string $table the table name
     * @param array $data the column => value pairs
     * @return int
     */
    public function update($table, $data, array $where, $cache_statement = TRUE)
    {
        $i = $this->i;
        // Column names come from the array keys
        $columns = implode ( "$i = ?, $i", array_keys ( $data ) );
        // Build prepared statement SQL
        $sql = "UPDATE $i$table$i SET $i" . $columns . "$i = ? WHERE ";
        // Process WHERE conditions
        list ( $where, $params ) = $this->where ( $where );
        // Append WHERE conditions to query and statement params
        $statement = $this->query ( $sql . $where, array_merge ( array_values ( $data ), $params ), $cache_statement );
        if ($statement)
        {
            return $statement->rowCount ();
        }
    }

    /**
     * Create a basic,  single-table SQL query
     *
     * @param string $columns
     * @param string $table
     * @param array $where array of conditions
     * @param int $limit
     * @param int $offset
     * @param array $order array of order by conditions
     * @return array
     */
    public function select($column, $table, $where = NULL, $limit = NULL, $offset = 0, $order = NULL)
    {
        $i = $this->i;
        $sql = "SELECT $column FROM $i$table$i";
        // Process WHERE conditions
        list ( $where, $params ) = $this->where ( $where );
        // If there are any conditions, append them
        if ($where)
        {
            $sql .= " WHERE $where";
        } 
        // Append optional ORDER BY sorting
        $sql .= $this->order_by ( $order );
        if ($limit)
        {
            $sql .= " LIMIT $offset, $limit";
        }
        return array ($sql, $params );
    }
    
    /**
     * 生成where条件sql部分
     *
     * @param array $where array of column => $value indexes
     * @return array
     */
    protected function where($where = NULL)
    {
        $a = $s = array ();
        if ($where)
        {
            $i = $this->i;
            foreach ( $where as $c => $v )
            {
                // Raw WHERE conditions are allowed array(0 => '"a" = NOW()')
                if (is_int ( $c ))
                {
                    $s [] = $v;
                }
                else
                {
                    // Column => Value
                    $s [] = "$i$c$i = ?";
                    $a [] = $v;
                }
            }
        }
        // Return an array with the SQL string + params
        return array (implode ( ' AND ', $s ), $a );
    }
    
    /**
     * @param array $fields to order by
     */
    protected function order_by($fields = NULL)
    {
        if (! $fields) return;
        $i = $this->i;
        $sql = ' ORDER BY ';
        // Add each order clause
        foreach ( $fields as $k => $v )
        {
            $sql .= "$i$k$i $v, ";
        }
        
        // Remove ending ", "
        return substr ( $sql, 0, - 2 );
    }
}
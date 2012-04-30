 <?php
 class Database  {

    private $dbHandle; 
    
    function __construct($db_file)  {
        $this->dbHandle = new PDO("sqlite:".$db_file);
        
        if ($this->dbHandle == null) die("Cannot get a connection to the database."); 
    }
    
    function createTable($tableName, $columns)  {
        $query =  "CREATE TABLE ".$tableName."(".$this->getTableCreateParameters($columns).")";
        return $this->runQuery($query);
    }
    
    private function getTableCreateParameters($params){
      $columnNames = array_keys($params);
      $toReturn = "";
      
      foreach($columnNames as $columnName)  
        $toReturn[] = $columnName." ".$params[$columnName];
      
      return join(",",$toReturn);
    } 
    
    function hasTable($tableName) {
       $tableExists = $this->runSingleQuery('SELECT 1 FROM sqlite_master WHERE type=\'table\' AND name=\''.$tableName.'\';');
       return ($tableExists == "1");
    }
    
    function runQuery($query){
        return $this->dbHandle->query($query);
    }
    
    function runSingleQuery($query) {
        return $this->dbHandle->singleQuery($query);
    }
    
    function insert($tableName, $columnsAndValues){
        $columns = join(",",array_keys($columnsAndValues));
        $values = join(",",array_map('StringUtils::quote',array_values($columnsAndValues)));
        $query = "INSERT INTO ".$tableName."(".$columns.") VALUES(".$values.");";
        return $this->runQuery($query);
    }
 }
 
 class StringUtils  {
    public static function quote($string){
      return '\''.$string.'\'';
    }
 }
?>


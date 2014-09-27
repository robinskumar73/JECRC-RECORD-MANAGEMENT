<?

function writeMsg() {
  $sql = "SELECT * FROM department";
  try 
	{
        $db = getConnection();
        $stmt = $db->query($sql);
        $dept = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo  json_encode($dept);
    }
}
?>
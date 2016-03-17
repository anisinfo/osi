<?php
class db{
      var $sid, $connection;
      var $query; 
      var $total_record;
      var $total_fields;
      /*This function connect to the dataSCHEMA . This function is called
      whenever object is created. */

        function db_connect(){
                $this->connection = oci_connect(SCHEMA_LOGIN, SCHEMA_PASS,HOST.':'.PORT.'/'.BASE,'AL32UTF8') or die ($this->get_error_msg($this->connection,"Problem while connecting to ".$this->sid." server..."));//username,password,sid
           }


       /*This function query at dataSCHEMA */
       function db_query($query_str="")
       {
           if($this->connection)
           {

            $this->sid = @oci_parse($this->connection, $query_str);
            $this->query=$query_str;
            oci_execute($this->sid) or "erreur:<b>".$query_str."</b>";
           }
           
       }

       function db_fetch_array(){
        $r=array();
        while (($row = oci_fetch_row($this->sid)) != false) {
          array_push($r, $row);
        }
        return $r;
      }


       function total_record(){
        $nrows = oci_fetch_all($this->sid,$results);
          return $nrows;
       }


      function select_data($req)
      {
        $stmt = oci_parse($this->connection, $req);
        oci_execute($stmt, OCI_DEFAULT);
        while (oci_fetch($stmt)) {
          echo oci_result($stmt, "TEST") . "<br>\n";
        }
      }

      function close()
      {
           oci_close ($this->connection);
      }

       function get_error_msg($msg="")
       {
          $log_msg=NULL;
          $error_msg="<b>Erreur de Requette:</b> <pre><font color=red>".$msg."</font></pre>";
          return $error_msg;
       }
}
?>
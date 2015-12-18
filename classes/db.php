<?php
class db{
      var $sid, $connection;
      var $query;
 
      var $total_record,$rec_position;
      var $total_fields, $field_name;
      /*This function connect to the dataSCHEMA . This function is called
      whenever object is created. */

        function db_connect(){
                $this->connection = oci_connect(SCHEMA_LOGIN, SCHEMA_PASS,HOST.':'.PORT.'/') or die ($this->get_error_msg($this->connection,"Problem while connecting to ".$this->sid." server..."));//username,password,sid
           }


       /*This function query at dataSCHEMA */
       function db_query($query_str="")
       {
           if($this->connection)
           {
            $this->sid = @oci_parse($this->connection, $query_str);
            $this->query=$query_str;
            oci_execute($this->sid) or die($this->get_error_msg($query_str,"Erreur requette".$query_str));
           }
           
       }

       function db_fetch_array(){
        $r=array();
        while (($row = oci_fetch_row($this->sid)) != false) {
          array_push($r, $row);
        }
     //   oci_free_statement($this->sid);
      //  oci_close($this->connection);
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

       function get_error_msg($error_no,$msg=""){
          $log_msg=NULL;
          $error_msg="<b>Custom Error :</b> <pre><font color=red>\n\t".ereg_replace(",",",\n\t",$msg)."</font></pre>";
          $error_msg.="<b><i>System generated Error :</i></b>";
          $error_msg.="<font color=red><pre>";
                foreach(ocierror($error_no) as $key=>$val){
                        $log_msg.="$key :  ".$val."\n";
                        $error_msg.="$key : $val \n";
                }

                $error_msg.="</pre></font>";
                return $error_msg;
       }

       function get_error_msg_array($error_no){
          return ocierror($error_no);
       }
}
?>
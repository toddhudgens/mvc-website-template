<?php

function dbHandle() {
  if (isset($GLOBALS['dbh'])) { return $GLOBALS['dbh']; }
  else {
    $GLOBALS['dbh'] = new PDO($GLOBALS['_SERVER']['PDOCONNSTR'],
         		      $GLOBALS['_SERVER']['DBUN'],
     	   	              $GLOBALS['_SERVER']['DBPW']);
    return $GLOBALS['dbh'];
  }
}

?>
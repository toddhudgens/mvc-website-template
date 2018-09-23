<?php

function routeRequest() {

  global $controller, $action, $pageId, $applyView, $queryString, $title, $loginRequired;

  $uri = $_SERVER['REQUEST_URI'];

  // process query string, put into $_GET array            
  $qMarkPos = strpos($uri, "?");
  $qs = '';
  if (is_int($qMarkPos)) {
    $qs = substr($uri, $qMarkPos+1);
    $uri = substr($uri, 0, $qMarkPos);
  }

  try {
    $dbh = dbHandle();
    $stmt = $dbh->prepare('SELECT * FROM pages WHERE uri=?');
    $stmt->execute(array($uri));
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $controller = ''; $action = ''; $applyView = '';
    if (count($results) > 0) {
      $row = $results[0];
      //print_r($row);
      $pageId = $row['id'];
      if ($row['controller'] != "") {
        include "controller/".$row['controller'].'Controller.php';
        $controller = $row['controller'];
        $action = $row['action']; //print $controller; print $action;
        $title = $row['title'];
        $applyView = $row['applyView'];
        $loginRequired = $row['loginRequired'];

        foreach ($_GET as $key => $value) {
          if ($key != "path") { $queryString .= $key . '=' . $value . '&'; }
        }

        if ($row['queryString'] != "") {
         $queryString .= $row['queryString'];
         parse_str($queryString, $_GET);
        }
        return;
      }
    }
  }
  catch (PDOException $e) {
    die($e->getMessage());
  }
}


?>
<?php

if (isset($_POST['action']) and $_POST['action'] == 'creategame')
{
  $exp = (isset( $_POST['exp'] )) ? $_POST['exp'] : 0;
  $parray = (isset( $_POST['players']) ) ? $_POST['players'] : NULL;
  $pcount = sizeof( $parray );
  if ($pcount < 3) {
    exit ('not enough players');
  }
  for ($i = $pcount; $i < 5; $i++) {
    $parray[$i] = NULL;
  }

  $dbuser = 'test00';
  $pass = 'test00';
  $DBH = new PDO('mysql:host=localhost;dbname=temptest', $dbuser, $pass);

  $stmt = $DBH->prepare( 'INSERT INTO hansagamesrecord '
    . '(players, player1, player2, player3, player4, player5, expansion) '
    . 'VALUES (?, ?, ?, ?, ?, ?, ?);' );
  if (!$stmt->execute( array( $pcount, $parray[0], $parray[1], $parray[2], $parray[3], $parray[4], $exp ) )) {
    exit ('INSERT failed');
  }
  $id = $DBH->lastInsertID();
  $stmt = $DBH->prepare( 'SELECT timestamp FROM hansagamesrecord WHERE id = ?' );
  $stmt->execute( array( $id ) );
  $rows = $stmt->fetchAll();

  exit (json_encode( array( $id, $rows[0]['timestamp'] ) ));
}

if (isset($_POST['action']) and $_POST['action'] == 'setwinners')
{
  $gameid = (isset($_POST['gameid'])) ? $_POST['gameid'] : 0;
  $warray = (isset( $_POST['winners']) ) ? $_POST['winners'] : NULL;
  $wcount = sizeof( $warray );
  if ($wcount < 1) {
    exit ('no winner');
  }
  for ($i = $wcount; $i < 5; $i++) {
    $warray[$i] = NULL;
  }

  $dbuser = 'test00';
  $pass = 'test00';
  $DBH = new PDO('mysql:host=localhost;dbname=temptest', $dbuser, $pass);

  $stmt = $DBH->prepare( 'UPDATE hansagamesrecord '
    . 'SET winner1 = ?, winner2 = ?, winner3 = ?, winner4 = ?, winner5 = ? WHERE id = ?;' );
  if (!$stmt->execute( array( $warray[0], $warray[1], $warray[2], $warray[3], $warray[4], $gameid ) )) {
    exit ('UPDATE failed');
  }
  exit ('setwinners success!');
}

if (isset($_GET['action']) and $_GET['action'] == 'getstats')
{
  $player = (isset($_GET['player'])) ? $_GET['player'] : 0;

  $dbuser = 'test00';
  $pass = 'test00';
  $DBH = new PDO('mysql:host=localhost;dbname=temptest', $dbuser, $pass);

  $stmt = $DBH->prepare( 'SELECT COUNT(*) FROM hansagamesrecord WHERE '
    . 'winner1 = ? OR winner2 = ? OR winner3 = ? OR winner4 = ? OR winner5 = ?;' );
  if (!$stmt->execute( array( $player, $player, $player, $player, $player ) )) {
    exit ('GET wins failed');
  }
  $rows = $stmt->fetchAll();
  $wins = $rows[0][0];

  $stmt = $DBH->prepare( 'SELECT COUNT(*) FROM hansagamesrecord WHERE player1 = ?;' );
  if (!$stmt->execute( array( $player ) )) {
    exit ('GET player1 failed');
  }
  $rows = $stmt->fetchAll();
  $p1 = $rows[0][0];

  $stmt = $DBH->prepare( 'SELECT COUNT(*) FROM hansagamesrecord WHERE player2 = ?;' );
  if (!$stmt->execute( array( $player ) )) {
    exit ('GET player2 failed');
  }
  $rows = $stmt->fetchAll();
  $p2 = $rows[0][0];

  $stmt = $DBH->prepare( 'SELECT COUNT(*) FROM hansagamesrecord WHERE player3 = ?;' );
  if (!$stmt->execute( array( $player ) )) {
    exit ('GET player3 failed');
  }
  $rows = $stmt->fetchAll();
  $p3 = $rows[0][0];

  $stmt = $DBH->prepare( 'SELECT COUNT(*) FROM hansagamesrecord WHERE player4 = ?;' );
  if (!$stmt->execute( array( $player ) )) {
    exit ('GET player4 failed');
  }
  $rows = $stmt->fetchAll();
  $p4 = $rows[0][0];

  $stmt = $DBH->prepare( 'SELECT COUNT(*) FROM hansagamesrecord WHERE player5 = ?;' );
  if (!$stmt->execute( array( $player ) )) {
    exit ('GET player5 failed');
  }
  $rows = $stmt->fetchAll();
  $p5 = $rows[0][0];

  exit (json_encode( array( $wins, $p1, $p2, $p3, $p4, $p5 ) ));
}

?>
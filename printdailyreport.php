<?php
  // start php session
  session_start();
  // check if user is logged in
  if(!isset($_SESSION['uname'])) {
    header('Location: login.php');
  }
  // get POST from printrange.php
  if(isset($_POST['date_from']) && isset($_POST['date_to'])) {
    $date_from = $_POST['date_from'];
    $date_to = $_POST['date_to'];
  } 
  // check the date range date_to >= date_from
  if($date_to < $date_from) {
    $date_to = $date_from;
  }
  // $date_from add time 00:00:00
  $date_from = $date_from.' 00:00:00';
  // $date_to add time 23:59:59
  $date_to = $date_to.' 23:59:59';
  // include dbconfig.php
  include_once("include/dbconfig.php");
  // get the carparking records where parking = 0 and time_in >= date_from and time_in <= date_to
  $query = "SELECT *,TIMESTAMPDIFF(SECOND, time_in, time_out) / 60 as time_stay ".
  "FROM carparking where parking = 0 and time_in >= '$date_from' and time_in <= '$date_to' order by time_in desc";
  $result = mysqli_query($conn, $query);
  $rows = mysqli_num_rows($result);

  require_once('tcpdf.php');
  // generate a pdf report
  $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

  // set the title of pdf
  $pdf->SetTitle('泊車紀錄');
  // set the author of pdf
  $pdf->SetAuthor('Denver Jen');
  // set the subject of pdf
  $pdf->SetSubject('泊車紀錄');
  // 設定頁首
  $pdf->setPrintHeader(false);
  // 設定頁尾
  $pdf->setPrintFooter(false);
  // add a page
  $pdf->AddPage('L');
  // set the line break space
  $lineNo = 0 ;
  $CarTotal = 0 ;
  $OverdueTotal = 0 ;

  // print the header
  printheader($pdf);
  // print the records in $result
  while ( $row = mysqli_fetch_assoc($result) ) {
    $lineNo++ ;
    if ($lineNo > 16) {
      $pdf->AddPage('L');
      printheader($pdf);
      $lineNo = 0 ;
    }
    $pdf->Cell(30, 8, $row['carno'], 1, 0, 'C');
    $pdf->Cell(40, 8, $row['cartype'], 1, 0, 'C');
    $pdf->Cell(45, 8, $row['time_in'], 1, 0, 'C');
    $pdf->Cell(45, 8, $row['time_out'], 1, 0, 'C');
    // if 'time_stay' > 30 change color to red
    if ($row['time_stay'] > 30) {
      $pdf->SetTextColor(255, 0, 0);
      $OverdueTotal = $OverdueTotal + 1 ;
    }
    $pdf->Cell(35, 8, round( $row['time_stay'] ), 1, 0, 'C');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(40, 8, $row['code'], 1, 0, 'C');
    $pdf->Cell(30, 8, $row['blk'].$row['room'], 1, 0, 'C');
    $CarTotal = $CarTotal + 1 ;
    $pdf->Ln() ;
    
  }

  $pdf->Cell(0, 10, '共'.$CarTotal.'車，'.$OverdueTotal.'逾時車', 0, 1, 'C');

  $pdf->Output($tmp_file, 'I');

  function printheader($pdf) {
    $currentPageNumber = '第'.strval($pdf->PageNo()).'頁' ;
    $pdf->SetFont('msungstdlight', '', 12, '', true);
    $pdf->Cell(10, 6, $currentPageNumber ,0,0,'C' );
    $pdf->Ln() ;
    $pdf->SetFont('msungstdlight', '', 14, '', true);
    $pdf->Cell(0, 10, '泊車紀錄', 0, 1, 'C');
    $pdf->SetFont('msungstdlight', '', 12, '', true);
    // print the date range
    $pdf->Cell(0, 10, '日期區間：'. $_POST['date_from']. '至'. $_POST['date_to'], 0, 1, 'C');
    // print the table header
    $pdf->Cell(30, 8, '車牌', 1, 0, 'C');
    $pdf->Cell(40, 8, '車輛類型', 1, 0, 'C');
    $pdf->Cell(45, 8, '入車時間', 1, 0, 'C');
    $pdf->Cell(45, 8, '出車時間', 1, 0, 'C');
    $pdf->Cell(35, 8, '停留時間(分鍾)', 1, 0, 'C');
    $pdf->Cell(40, 8, '停車原因', 1, 0, 'C');
    $pdf->Cell(30, 8, '座/室', 1, 0, 'C');
    // New line
    $pdf->Ln();
  }
  
?>





    
            

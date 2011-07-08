<?php 
  $masConfig=array();

 function Quotes($psLine) {
    return "\"{$psLine}\"";
  }

  function loadIniFile($psConfigName) {
    global $masConfig;
    //echo "*** $psConfigName ***<br>";
    $masConfig=parse_ini_file($psConfigName,TRUE); 
  }

  function readIniKey($psSection,$psParam) {
    global $masConfig;
    //echo "&&&& $psSection  $psParam &&&& <br>";
    return $masConfig[$psSection][$psParam]; 
  }

  function isIniKey($psSection,$psKey) {
    global $masConfig;
    return array_key_exists($psKey,$masConfig[$psSection]);  }
  
//***** Config - параметры head'а. в config.php 
  function getHead($pasConfig) {
    $lsHead="\n<head> \n";
    $lsHead=$lsHead."<title>".$pasConfig["title"]."</title> \n";
    $lsHead=$lsHead."<meta http-equiv=\"Content-Type\" content=\"text/html; charset=".$pasConfig["charset"]."\" /> \n";
    $lsHead=$lsHead."<meta name=\"Author\" lang=\"en\" content=".Quotes($pasConfig["author_en"])." /> \n";
    $lsHead=$lsHead."<meta name=\"Author\" lang=\"ru\" content=".Quotes($pasConfig["author_ru"])." /> \n";
    $lsHead=$lsHead."<link rel=\"stylesheet\" type=\"text/css\" href=".Quotes($pasConfig["theme"])." > \n";
    /*echo('  <!--link rel="shortcut icon" href="FILE_NAME.ico"-->");*/
    $lsHead=$lsHead."</head>\n";
    return $lsHead;
  }


//***** Style - стиль таблицы. в config.php
  function getTableHead($pasStyle) {
    $lsTableHead="<table class=".Quotes($pasStyle["class"]);
    if($pasStyle["tablesubclass"]) {
      $lsTableHead=$lsTableHead." id=".Quotes($pasStyle["tablesubclass"]);
    }
    $lsTableHead=$lsTableHead." align=".Quotes($pasStyle["align"]);
    //$lsTableHead=$lsTableHead." valign=\"top\"";
    $lsTableHead=$lsTableHead." width=".Quotes($pasStyle["width"]);
    $lsTableHead=$lsTableHead." summary=".Quotes($pasStyle["summary"]);
    $lsTableHead=$lsTableHead.">\n";
    return $lsTableHead;
  }

  function getTableHeadEx($psClass,$piWidth) {
    $lsTableHead="<table class=".Quotes($psClass);
    //$lsTableHead=$lsTableHead." align=".Quotes($pasStyle["align"]);
    //$lsTableHead=$lsTableHead." valign=\"top\"";
    $lsTableHead=$lsTableHead." width=".Quotes($piWidth);
    //$lsTableHead=$lsTableHead." summary=".Quotes($pasStyle["summary"]);
    $lsTableHead=$lsTableHead.">\n";
    return $lsTableHead;
  }

//***** Cols - количество столбцов. Widths - массив ширин столбцов
  function getTableColgroup($piCols,$pasWidthes) {
    $lsTableColGroup="<colgroup> \n";
    for($liIdx=1;$liIdx<=$piCols;$liIdx++) {
      $lsTableColGroup=$lsTableColGroup."<col width=".Quotes($pasWidthes[$liIdx])."> \n";
    }
    $lsTableColGroup=$lsTableColGroup."</colgroup> \n";
    return $lsTableColGroup;
  }


//***** Style - стиль таблицы. в config.php. Header - заголовок таблицы. Span - на сколько столбцов.
  function getTableHeader($pasStyle,$psHeader,$piSpan) {
    $lsTableHeader="<thead id=".Quotes($pasStyle["header_id"])."> \n";
    $lsTableHeader=$lsTableHeader." <tr><td colspan=".$piSpan."  background=".Quotes($pasStyle["header_img"]).">"; 
    $lsTableHeader=$lsTableHeader." {$psHeader}</td></tr> \n";
    $lsTableHeader=$lsTableHeader."</thead> \n";
    return $lsTableHeader;
  }


  function getTableHeaderEx($psHeader,$piSpan,$psHeaderImg) {
    $lsTableHeader="<thead id=\"tableheader\"> \n";
    $lsTableHeader=$lsTableHeader." <tr><td colspan=".$piSpan."  background=".Quotes($psHeaderImg).">"; 
    $lsTableHeader=$lsTableHeader." {$psHeader}</td></tr> \n";
    $lsTableHeader=$lsTableHeader."</thead> \n";
    return $lsTableHeader;
  }


  function getLink($psURL,$psText) {
    return "<a href=".Quotes($psURL).">".$psText."</a>";
  }


  function getTableSubHeader($psSubHeader) {
    $lsContent="<tr id=\"tablesubheader\"><th>".$psSubHeader."</th></tr>\n";
    return $lsContent;
  }
  
  function getTableSubHeaderEx($psSubHeader) {
    return "<th id=\"tablesubheader\">".$psSubHeader."</th>\n";
  }

  
    function getTableRowText($psText,$psAnchor) {
      if($psAnchor) {
        $lsContent="<tr id=".$psAnchor.">".$psText."</tr>\n";
      } else {
        $lsContent="<tr valign=\"top\" >".$psText."</tr>\n";
      }  
    return $lsContent;
  }

  function getTableCellText($psText) {
    $lsContent="<td>".$psText."</td>";
    return $lsContent;
  }
  
  function calcEqualWidthes($piColumnsCount) {
    $lasWidthes=array();
    for($liIdx=1;$liIdx<=$piColumnsCount;$liIdx++) {
      $lasWidthes[$liIdx]=(int)100/$piColumnsCount."%";
    }
    return $lasWidthes;   
  }
  
?>

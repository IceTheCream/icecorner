<?php 

define("TEXTSECTION","0");
define("SOFTSECTION","1");
define("LINKSECTION","2");
define("FILESECTION","3");

require("primitives.php");

  function readEmptyItem() {
      $lsContent=getTableCellText("&nbsp");
      return $lsContent;
  }


  function readTextItemHeader($psSection,$psItemPrefix) {
      $lsSubHeader=readIniKey($psSection,$psItemPrefix."_head","no head");   
      return $lsSubHeader;    
  }

  
  function readTextItemContent($psSection,$psItemPrefix) {
      $lsText=readIniKey($psSection,$psItemPrefix."_text","no text");   
      return getTableCellText($lsText);
  }


  function readTextItem($psSection,$psItemPrefix) {
      $lsSubHeader=readIniKey($psSection,$psItemPrefix."_head","no head");   
      $lsText=readIniKey($psSection,$psItemPrefix."_text","no text");   
      $lsContent=getTableRowText(getTableCellText($lsText),"T_");
      return getTableSubHeader($lsSubHeader).$lsContent;
  }


  function readSoftItem($psSection,$psItemPrefix) {
    $lsURL=readIniKey($psSection,$psItemPrefix."_url","http://www.icecorner.ru");   
    $lsText=readIniKey($psSection,$psItemPrefix."_name","Some software");   
    $lsContent=getTableCellText(getLink($lsURL,$lsText));
    $lsPortable=readIniKey($psSection,$psItemPrefix."_portable","");
    if($lsPortable) {  
      $lsContent=$lsContent.getTableCellText(getLink($lsPortable,"portable"));
    } else {
      $lsContent=$lsContent.getTableCellText("");
    }
    $lsVersion=readIniKey($psSection,$psItemPrefix."_version","0.0"); 
    $lsContent=$lsContent.getTableCellText($lsVersion);
    $lsLicense=readIniKey($psSection,$psItemPrefix."_license","no license"); 
    $lsContent=$lsContent.getTableCellText($lsLicense);
    $lsAnchor=$psItemPrefix;
    return getTableRowText($lsContent,$lsAnchor);
  }

  function readSoftItemV3($psSection,$psItem,$psDelimiter) {
    $lsItem=readIniKey($psSection,$psItem);   
    $lasElements=explode($psDelimiter,$lsItem);
    //***** 0 - название и 3 - ссылка на сайт
    $lsContent=getTableCellText(getLink($lasElements[3],$lasElements[0]));
    //***** 4 - ссылка на портабельную версию
    $lsPortLine=trim($lasElements[4]);
    if(strlen($lsPortLine)) {
      //$lsContent=$lsContent.getTableCellText($lsPortLine);
      $lsContent=$lsContent.getTableCellText(getLink($lsPortLine,"portable"));
    } else {
      $lsContent=$lsContent.getTableCellText(" ");
    }
    //***** 1 - версия 
    $lsContent=$lsContent.getTableCellText($lasElements[1]);
    //***** 2 - лицензия 
    $lsContent=$lsContent.getTableCellText($lasElements[2]);

    return getTableRowText($lsContent,"");
  }



  function readLinkItem($psSection,$psItemPrefix) {
      $lsLink=readIniKey($psSection,$psItemPrefix."_link");   
      $lsText=readIniKey($psSection,$psItemPrefix."_text");   
      return getTableRowText(getTableCellText(getLink($lsLink,$lsText)),"");
  }


  function readFileItem($psFileName) {
    return getTableRowText(getTableCellText(file_get_contents($psFileName)),"");
  }


  function readSectionParams($psSectionName) {
    //+++++ Обязательные параметры секции
    //***** Количество элементов
    $lasConfig["items"]=readIniKey($psSectionName,"items","0");    

    //***** Заголовок секции
    $lasConfig["header"]=readIniKey($psSectionName,"header");    

   
    //+++++ Опциональные параметры секции
    //***** Читаем тип секции
    
    if(isIniKey($psSectionName,"sectiontype")) {
      $lasConfig["type"]=readIniKey($psSectionName,"sectiontype",0);    
    } else {  
      $lasConfig["type"]=readIniKey("default","sectiontype",0);    
    }
    
    
    //***** Читаем количество столбцов представления элемента 
    if(isIniKey($psSectionName,"columns")) {
      $lasConfig["columns"]=readIniKey($psSectionName,"columns",1);    
    } else {  
      $lasConfig["columns"]=readIniKey("default","columns",1);    
    }
    
    //***** Количество элементов в строке
    if(isIniKey($psSectionName,"itemsperline")) {
      $lasConfig["itemsperline"]=readIniKey($psSectionName,"itemsperline");    
    } else {
      $lasConfig["itemsperline"]=readIniKey("default","itemsperline");    
    }
    
    //***** Считаем стиль секции
    if(isIniKey($psSectionName,"style")) {
      $lasConfig["style"]=readIniKey($psSectionName,"style");
    } else {
      $lasConfig["style"]=readIniKey("default","style");
    }
    
    //***** Считаем версию секции
    if(isIniKey($psSectionName,"version")) {
      $lasConfig["version"]=readIniKey($psSectionName,"version");
    } else {
      $lasConfig["version"]=readIniKey("default","version");
    }
    
    //***** Считаем разделитель элемментов
    if(isIniKey($psSectionName,"delimiter")) {
      $lasConfig["delimiter"]=readIniKey($psSectionName,"delimiter");
    } else {
      $lasConfig["delimiter"]=readIniKey("default","delimiter");
    }
    //echo "!!!!!!!!!!! {$lasConfig["delimiter"]} <br>";
    
    return $lasConfig;
  }


  function readSectionEx($psSection,$pasConfig,$piMaxItems) {

    $lsSectionContent="";

    //***** Читаем секцию
    $liIdx=1;
    while($liIdx<=$pasConfig["items"]) {
      //***** В зависимости от типа контента вызываем подходящую функцию
      switch((int)$pasConfig["type"]) {
        case TEXTSECTION: 
          if($pasConfig["itemsperline"]==1) {
            $lsItemPrefix=readIniKey($psSection,"item".$liIdx);    
            $lsSectionContent=$lsSectionContent.readTextItem("data",$lsItemPrefix,"_");
          } else {
            
            $lsSection="";
            $lsSectionSubHeader="";
            for($liJdx=1;$liJdx<=$pasConfig["itemsperline"];$liJdx++) {
              
              if(($liIdx+$liJdx)-1<=$pasConfig["items"]) {
                $lsItemPrefix=readIniKey($psSection,"item".(($liIdx+$liJdx)-1));    
                $lsSubHeader=getTableSubHeaderEx(readTextItemHeader("data",$lsItemPrefix,"_"));
                $lsSectionSubHeader=$lsSectionSubHeader.$lsSubHeader;
                $lsSection=$lsSection.readTextItemContent("data",$lsItemPrefix,"_");
              } else {

              }  
            }
            $lsSectionContent=$lsSectionContent.getTableRowText($lsSectionSubHeader,"").getTableRowText($lsSection,"");
            //file_put_contents ('logs.txt', file_get_contents('logs.txt')."\n".$lsSectionContent);
            
            $liIdx+=2;
          }
          break;
        
        case SOFTSECTION: 
          if($pasConfig["version"]==2) {
            $lsItemPrefix=readIniKey($psSection,"item".$liIdx);    
            $lsSectionContent=$lsSectionContent.readSoftItem("data",$lsItemPrefix);
          } else {
            //$lsItemPrefix=readIniKey($psSection,"item".$liIdx);    
            $lsSectionContent=$lsSectionContent.readSoftItemV3($psSection,"item".$liIdx,$pasConfig["delimiter"]);
          }  
          break;

        case LINKSECTION: 
          $lsItemPrefix=readIniKey($psSection,"item".$liIdx);    
          $lsSectionContent=$lsSectionContent.readLinkItem("data",$lsItemPrefix);
          break;

        case FILESECTION: 
          //echo "*****$lsItemPrefix <br>";
          $lsItemPrefix=readIniKey($psSection,"item".$liIdx);    
          $lsSectionContent=$lsSectionContent.readFileItem(readIniKey("data",$lsItemPrefix."_file"));
          break;
      } 
      $liIdx++;
    }
    
    if($pasConfig["items"]<$piMaxItems) {
      for($liIdx=$pasConfig["items"];$liIdx<$piMaxItems;$liIdx++) {
        $lsSectionContent=$lsSectionContent.getTableRowText(readEmptyItem(),"E_");
      }
    }
    
    return $lsSectionContent;
  }


  function manageSectionEx($psSectionName,$piMaxItems,$psHeaderImage) {
    //***** Читаем параметры секции
    $lasConfig=readSectionParams($psSectionName);

    //echo "!!!!!!!!!!! {$lasConfig["delimiter"]} <br>";
    //***** Начинаем формировать секцию 
    $lsSectionContent=getTableHeadEx($lasConfig["style"],"100%");

    //***** Разберемся с ширинами столбцов
    $lasWidthes=array();
    for($liIdx=1;$liIdx<=$lasConfig["columns"];$liIdx++) {
      if(isIniKey($psSectionName,"width".$liIdx)) {
        $lasWidthes[$liIdx]=readIniKey($psSectionName,"width".$liIdx,(int)100/$lasConfig["columns"]."%");
      } else {
        $lasWidthes[$liIdx]=readIniKey("default","width".$liIdx,(int)100/$lasConfig["columns"]."%");
      }  
    }

    //***** Продолжаем формировать секцию 
    $lsSectionContent=$lsSectionContent.getTableColgroup($lasConfig["columns"],$lasWidthes);
    if($lasConfig["header"]) {
      $lsSectionContent=$lsSectionContent.getTableHeaderEx($lasConfig["header"],$lasConfig["columns"],$psHeaderImage);
    }
    $lsSectionContent=$lsSectionContent."<tbody> \n";
    
    $lsSectionContent=$lsSectionContent.readSectionEx($psSectionName,$lasConfig,$piMaxItems);
    $lsSectionContent=$lsSectionContent."</tbody>\n</table>\n";
    
    return $lsSectionContent;
  }


  function calcMaxItems($piSectionRows,$piSections,$piSection) {
    $liMaxItems=0;
    for($liIdx=1;$liIdx<=$piSectionRows;$liIdx++) {
     
      //***** Прочтем имя следующей секции
      $liOffset=($piSection+$liIdx)-1;
      if($liOffset<=$piSections) {
        $lsSectionName=readIniKey("layout","section".$liOffset);
    
        //***** Посмотрим егo MaxItems
        $liItemsCount=readIniKey($lsSectionName,"items");    
        $liMaxItems=max($liMaxItems,$liItemsCount);
      }  
    }
    return $liMaxItems;
  }


  function readLayoutParams() {
    //***** Считаем класс layout'а
    $lasConfig["style"]=readIniKey("layout","style");
  
    //***** Считаем ширину layout'а
    $lasConfig["width"]=readIniKey("layout","width");

    //***** Считаем количество секций контента
    $lasConfig["sections"]=readIniKey("layout","sections");
    
    //***** Считаем количество столбцов секций
    $lasConfig["columns"]=readIniKey("layout","columns");    

    //***** Считаем имя картинки в заголовке окна. Все это перенести в обработчик секции.
    $lasConfig["headerimg"]=readIniKey("layout","headerimage");    
    return $lasConfig;
  }


  function manageLayout($psContentFile) {
 
    if(substr($psContentFile,0,1)==".") {
      loadIniFile($psContentFile);
    } else {  
      loadIniFile("data/".$psContentFile);
    }  
    $lasConfig=readLayoutParams();   

    //***** Подсчитаем, во сколько строк у нас лягут секции
    $liSectionRows=(int)$lasConfig["sections"]/$lasConfig["columns"];
    $liSectionRows++;
    
    //***** Подсчитаем, какая ширина будет у каждой секции
    $lasWidthes=calcEqualWidthes($lasConfig["columns"]);
    
    //***** Создадим заголовок таблицы 
    echo getTableHeadEx($lasConfig["style"],$lasConfig["width"]);

    //***** Создадим группу столбцов
    echo getTableColgroup($lasConfig["columns"],$lasWidthes); 
    echo "<tbody> \n";
    
    //***** Обрабатываем секции 
    $liSection=1;
    for($liIdx=1;$liIdx<=$liSectionRows;$liIdx++) {
      //echo "**** $liIdx <br>";
      $lsRow="";
      for($liJdx=1;$liJdx<=$lasConfig["columns"];$liJdx++) {
        //echo "##### $liJdx <br>";

        if($liJdx==1) {
          $liMaxItems=calcMaxItems($lasConfig["columns"],$lasConfig["sections"],$liSection);
        }
        
        if($liSection<=$lasConfig["sections"]) {
          
          //***** Прочтем имя следующей секции
          $lsSectionName=readIniKey("layout","section".$liSection,"");

          //***** Обработаем секцию
          //echo "/////  <br>";
          $lsRow=$lsRow.getTableCellText(manageSectionEx($lsSectionName,$liMaxItems,$lasConfig["headerimg"]));
          //echo ";;;;;  <br>";
          
          $liSection++;
        } else {

          $lsRow=$lsRow.getTableCellText("");    
        }
      }  
      $lsRow=getTableRowText($lsRow,"");       
      echo "$lsRow \n";
    }
    
    echo "</tbody> \n";
    echo "</table> \n";
  }

?>

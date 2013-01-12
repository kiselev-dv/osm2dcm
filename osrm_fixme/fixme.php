<?php
//==========================================================================================
//Почини меня - недоступные ребра. Пьявка к валидатору OSRM
// (c) Zkir, 2012. 
//==========================================================================================
session_start();

//Получим параметры

//Кампания
//Начальная точка
if ($_GET['campaign']!="")
{
  $campaign=$_GET['campaign'];
}
else
{
  $campaign="001";
}


//Начальная точка
if ($_GET['p0']!="")
{
  $coord0 = explode(",", $_GET['p0']);
  $campaign="off";
  $blnP0=true;
}
else
{  $blnP0=false;
}


//Пермалинк
if ($_GET['permalink']!="")
{
  $blnPermalink=True;
  $coord = explode(",", $_GET['permalink']);
}
else
{
	$blnPermalink=False;
}

//Язык
if( trim($_GET['setlang'])!="")
{
  $_SESSION['lan_code']=$_GET['setlang'];
}

$lan_code=$_SESSION['lan_code'];
if ($lan_code=="")
{
$lan_code="en";	
}
	
// Получим "lan" файл со строками на нужно языке.
 $lan =  file ("001.".$lan_code.".lan");



//Вывод страницы
echo
	'<html>
	<head>
	<title>'.$lan[0].'</title>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	   
	  <script type="text/javascript" src="http://tile.cloudmade.com/wml/latest/web-maps-lite.js"></script> 
		   
	  <script type="text/javascript" src="/2/fixme-map.js"> </script>'; 
	  	  
if (!$blnPermalink){
  if (!$blnP0){
    echo(' <script type="text/javascript" src="http://openstreetmap.by/?request=osrm_error_to_josm&format=json&campaign='.$campaign.'&rnd='.time().'"> </script> ');
  }
  else {
  	echo(' <script type="text/javascript" src="http://openstreetmap.by/?request=osrm_error_to_josm&format=json&campaign=off&lat='.$coord0[0].'&lon='.$coord0[1].'&span=1&rnd='.time().'"> </script> ');  
  }  
}


echo 	  
	'</head>
	<body>
	 
	  <div style="float:right">
	     <a href="?setlang=en">ENG</a> | <a href="?setlang=ru">RUS</a> | <a href="?setlang=uk">UKR</a> 
	  </div>
	  <h1>'.$lan[1].'</h1>
		<table>
			<tr>
			  <td><div id="cm-example" style="width: 400px; height: 400px"></div> </td> 
			  <td valign="top" width="550px" style="padding-left:15px;padding-right=5px" >
			     <p>
	               <b>'.$lan[2].'</b><br />
	               '.$lan[3].'
	               '.$lan[4].' 
			     </p>
			     <p>
			       <b>'.$lan[5].'</b><br />
	               '.lan_match($lan[6],'{OSRM}','<a href="http://map.project-osrm.org/">OSRM</a>').' 
			        
			     </p>
			     <p>
			       <b>'.$lan[7].'</b><br />
			       '.$lan[8].'
			       '.$lan[9].'
			       '.$lan[10].'  
			       <br/><br/>
			         ';
		$str_tmp=$lan[11];
		$str_tmp=lan_match($str_tmp,'{[url=1]}', '<a href="http://wiki.openstreetmap.org/wiki/So_that_is_what_inaccessible_road_is!">');
		$str_tmp=lan_match($str_tmp,'{[/url]}', '</a>');
		echo $str_tmp;
		echo        '
			        <br/> <br/>
			       '.$lan[12].' 
			     </p>
			     
			  </td>
			  <td valign="top"  style="padding-left:15px;padding-right:5px;color:red;">
			  	  <div style="max-width:250px" >
			  	<b>Warning</b><br />   
			     * Not all routing issues displayed on this page are currently fixable, due to limited set of features in OSRM. <br />
			     * Not every problem can be fixed without local knowledge. To fix some problems properly survey can be necessary.
			       Please make only changes in which you are absolutely sure. <br />
			     * It\'s preferable to fix problems in area which your are familar with. Please refer to <a href="http://wiki.openstreetmap.org/wiki/So_that_is_what_inaccessible_road_is!"> wiki</a> how to get problems from your local area only.
			    </div>
			  </td>	  
		    </tr>
		    <tr>
		      <td>
		      	  <p align="center"><span id="josm_mlink"></span>  -- <span id="permalink"> </span> --  <span id="glagne_permalink"> </span> </p>
		      	  <p align="center"><a href="?next">'.$lan[16].'</a></p> 
		      </td>
		      <td style="padding-left:15px">';
if (!$blnPermalink){
  echo '   
		      	  <b>'.$lan[17].'</b><br /> 
		          '.lan_match(lan_match($lan[18],'{1}','<b><span id="total_segs">xxx</span></b>'),'{2}','<b><span id="shown_segs">yyy</span></b>').' </br>
		          '.lan_match(lan_match($lan[19],'{1}','<b><span id="total_segs1">xxx</span></b>'),'{2}','<b><span id="shown_segs1">yyy</span></b>').' </br>
	         ';
}
echo      ' </td>
		    </tr>
	        <tr>
	          <td></td>
	          <td></td>
	        </tr>
		</table>
		<iframe id="ttt" src="" style="display:none;"></iframe>
		<hr/>
		<p><small>
         	'.$lan[20].'
	        '.lan_match($lan[21],'{Openstreetmap}','<a href="http://openstreetmap.org">Openstreetmap</a>').'
	        
	       </small>
	    </p>
		<p>
		  <small>
		  	   <a href="http://openstreetmap.by/?request=osrm_error_to_josm">'.$lan[22].' </a>  --
		  	   <a href="http://wiki.openstreetmap.org/wiki/So_that_is_what_inaccessible_road_is!">'.$lan[23].' </a> --
		  	   <a href="http://forum.openstreetmap.org/viewtopic.php?id=18745">'.$lan[24].' </a> --
		  	   <a href="http://www.openstreetmap.org/user/Zkir/diary/17915">'.$lan[25].' </a>
		  </small>
		</p>
		
		  <script type="text/javascript">
		    var lat1,lon1,lat2,lon2;';
if (!$blnPermalink){
  echo '		  
		    
		    lat1=EdgeData.coordinates[0][0][1];
		    lon1=EdgeData.coordinates[0][0][0];
		    lat2=EdgeData.coordinates[0][1][1];
		    lon2=EdgeData.coordinates[0][1][0];';
		  }
else{		    
  echo	   'lat1='.$coord[0].';
		    lon1='.$coord[1].';
		    lat2='.$coord[2].'; 
		    lon2='.$coord[3].';';
}
echo '
		    
	        ProcessMap(lat1,lon1,lat2,lon2);
            
            Elem=document.getElementById(\'glagne_permalink\');
            Elem.innerHTML=\' <a href="http://www.openstreetmap.org/?lat=\'+(lat1+lat2)/2+\'&lon=\'+(lon1+lon2)/2+\'&zoom=18" target="_blank">'.trim($lan[15]).'</a>\';
            
            strPermalink="?permalink="+lat1+","+lon1+","+lat2+","+lon2;
            Elem=document.getElementById(\'permalink\');
            Elem.innerHTML=\'<a href="\'+strPermalink+\'">'.trim($lan[14]).'</a>\'; 	  

            
            var Elem=document.getElementById(\'total_segs\');
            Elem.innerHTML=EdgeData.properties.count_all;
             
            Elem=document.getElementById(\'shown_segs\');
            Elem.innerHTML=EdgeData.properties.count_fixed;
            
            var Elem=document.getElementById(\'total_segs1\');
            Elem.innerHTML=EdgeData.properties.count_campaign;
             
            Elem=document.getElementById(\'shown_segs1\');
            Elem.innerHTML=EdgeData.properties.fixed_campaign;
            
            
            
             	        
	   </script> 
	   	   
   	   <!-- Yandex.Metrika -->
			<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript"></script>
			<div style="display:none;"><script type="text/javascript">
			try { var yaCounter1224821 = new Ya.Metrika(1224821); } catch(e){}
			</script></div>
			<noscript><div style="position:absolute"><img src="//mc.yandex.ru/watch/1224821" alt="" /></div></noscript>
		<!-- /Yandex.Metrika -->
	</body>
	</html>';
	
 	
function lan_match($lan, $pattern, $value)
{
	$result=str_replace($pattern, $value,$lan);
	return $result;
}	
?>
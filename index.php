<?php 
	$page = $_GET['page'];
	//$subpage = $_GET['subpage'];
	//if ($page == 'order' && $subpage == 'list') {
	if ($page == 'order') {
		$groupCheckList = array("Administrators", "Users", "Wholesale");
	}
	include_once('security_check.php');

	if ($page!="" && $subpage!=""){
		include_once($page.'/'.$page.'_'.$subpage.'_logic.php');
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>Administrative tools</TITLE>
<? require ('header_script.php');?>
<? if ($page!="") { include_once($page.'/'.$page.'_js.php'); } ?>
<? if ($page!="") { include_once($page.'/'.$page.'_'.$subpage.'_js.php'); } ?>
<script type="text/javascript" src="calendarDateInput.js"></script>
<SCRIPT type="text/javascript" src="js/common.js"></script>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap.min.css">
	<script type="text/javascript" language="javascript" src="jquery-3.3.1.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
<!----<SCRIPT type="text/javascript" src="js/jquery-1.4.2.min.js"></script>//-->
<LINK href="style1.css" type=text/css rel=STYLESHEET>
</HEAD>
<BODY bgColor=#eeeeee leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <? include_once('page_header.php'); ?>
  <TR>
    <TD vAlign=top bgColor=#eefafc colSpan=11 height="100%"><TABLE cellSpacing=0 cellPadding=0 width="100%">
        <TBODY>
        <TR>
          <TD bgColor=#beddeb><? echo $tool_bar_array[$page]; ?></TD>
        </TR>
        <TR>
        <? 
		if ($page!=""){
			if ($subpage!=""){
				include_once($page.'/'.$page.'_'.$subpage.'.php'); 
			}
		}
		?>
          </TR>
          </TBODY>
        </TABLE>
       </TD>
     </TR>
   </TBODY>
</TABLE>
</BODY></HTML>

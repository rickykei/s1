<?php

//prevents caching
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: post-check=0, pre-check=0",false);
session_cache_limiter();
session_start();

require('config.php');  //this should the the absolute path to the config.php file 
                                    //(ie /home/website/yourdomain/login/config.php or 
                                    //the location in relationship to the page being protected - ie ../login/config.php )
require('functions.php'); //this should the the absolute path to the functions.php file - see the instrcutions for config.php above

if (allow_access(@Administrators) != "yes"){ //this is group name or username of the group or person that you wish to allow access to{                                                            // - please be advise that the Administrators Groups has access to all pages.
include ('no_access.html'); //this should the the absolute path to the no_access.html file - see above
exit;
}
?>
<? $sale_ref=$_GET['sale_ref'];
if (isset($_GET['check_print'])){
$print_check=$_GET['check_print'];
$sqla = "Update ben_check SET
check_print='1' where check_ref= '".$sale_ref."'";

sqlinsert($sqla);
}
?>


<html>

<HEAD>

<SCRIPT LANGUAGE="JavaScript">
<!-- Original:  Li  Weidong -->
<!-- Web Site:  http://www.saiweng.net -->

<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->

<!-- Begin
function myprint() {
window.top.frame1.focus();
window.top.frame1.print();

}
//  End -->
</script>

<? require ('header_script.php');?></HEAD>

<!-- STEP THREE: Copy this code into the BODY of your HTML document of the same frame  -->

<BODY>

<div align="center">
  <form name="form1" method="GET" action="<?= $_SERVER['PHP_SELF']; ?>">
    <input name="check_print" type=submit id="check_print" onClick="myprint()" value="Print">
	<input name="sale_ref" type="hidden" value="<? echo $sale_ref;?>">
  </form>
  
</div>
</body>
</html>
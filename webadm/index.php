<?php

require_once('vpopadm.inc.php');

if (isset($_SESSION['AdminID'])) {

	header("Refresh: 0;URL=frames.php");

	exit();

	
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>WMail�ʼ�����ϵͳ</TITLE>
<META http-equiv=content-type content="text/html; charset=gb2312">
<SCRIPT>

<!--//
var alertinput="�����������룺\n";

function login() 
{
	var mesg = "";
	
	if(document.logon.adminID.value == "") mesg += "����Ա�˺�\n";
	
	if(document.logon.password.value == "") mesg += "����\n";
	
	if(mesg != ""){
		
		mesg = alertinput + mesg;

		alert(mesg);

		return false;
	}
	
	return true;

}

//-->

</SCRIPT>
<style>
INPUT {
	FONT-SIZE: 12px; FONT-FAMILY: "simsun"
}
.mybtn {
	BORDER-RIGHT: #104a7b 1px solid; BORDER-TOP: #afc4d5 1px solid; BACKGROUND: #d6e7ef; BORDER-LEFT: #afc4d5 1px solid; CURSOR: hand; COLOR: #000066; BORDER-BOTTOM: #104a7b 1px solid; HEIGHT: 16px
}
.myinput {
	BORDER-RIGHT: #afc4d5 1px solid; BORDER-TOP: #afc4d5 1px solid; BACKGROUND: #d6e7ef; BORDER-LEFT: #afc4d5 1px solid; COLOR: #000066; BORDER-BOTTOM: #afc4d5 1px solid; HEIGHT: 16px
}
.csmtype {
	FONT-SIZE: 12px; FONT-FAMILY: "simsun"
}
.ctype {
	FONT-SIZE: 12px; FONT-FAMILY: "simsun"
}
</style>

<META content="MSHTML 6.00.2800.1141" name=GENERATOR></HEAD>
<BODY text=#000000 bgColor=#ffffff >
<TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <TR>
    <TD vAlign=center align=middle>
      <FORM name=logon onsubmit="return login();" action="login.php" method=post>
      <TABLE height=218 cellSpacing=0 cellPadding=0 width=324 background="/images/login.gif">
        <TBODY>
        <TR>
          <TD width="100%" height=20></TD></TR>
        <TR>
          <TD vAlign=center align=middle width="100%" height=35><BR>
            <TABLE class=csmtype cellSpacing=0 cellPadding=2 border=0>
              <TBODY>
              <TR>
                <TD  align=right><B>����Ա�˺�:</B> </TD>
                <TD><INPUT class = myinput style="FONT-FAMILY: tahoma" size=10 
                  name=adminID> &nbsp;&nbsp;<B>����:</B> 
                  <INPUT class = myinput style="FONT-FAMILY: tahoma" type=password 
                  size=10 name=password>
				  </TD></TR>
              <TR>
                <TD align=middle colSpan=2><INPUT class = mybtn type=submit value=��¼> 
                </TD></TR></TBODY></TABLE></TD></TR>
        <TR>
          <TD width="100%">
            <TABLE cellSpacing=0 cellPadding=0 width="100%">
              <TBODY>
              <TR>
                <TD height=20></TD></TR>
              <TR>
                <TD align=middle width=238 height=82>
                  <TABLE 
                  style="BORDER-RIGHT: #336699 1px solid; BORDER-TOP: #336699 1px solid; BORDER-LEFT: #336699 1px solid; BORDER-BOTTOM: #336699 1px solid" 
                  height="85%" cellSpacing=0 cellPadding=0 width="80%">
                    <TBODY>
                    <TR>
                      <TD class=csmtype vAlign=center align=middle 
                        width="100%">��ӭʹ��<a href="http://wmail.aka.cn/">WMail�ʼ�</a>����ϵͳ </TD></TR></TBODY></TABLE></TD></TR>
              <TR>
                <TD height=28></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE>
      <P class=ctype align=center>��Ȩ����:��<a href="http://www.aka.cn/">����������Ϣ�������޹�˾</a></P></FORM></TD></TR></TBODY></TABLE></BODY></HTML>

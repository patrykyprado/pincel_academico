<?php
require_once("vcl/vcl.inc.php");
//Inclusões
use_unit("comctrls.inc.php");
use_unit("actnlist.inc.php");
use_unit("menus.inc.php");
use_unit("dbgrids.inc.php");
use_unit("db.inc.php");
use_unit("dbtables.inc.php");
use_unit("forms.inc.php");
use_unit("extctrls.inc.php");
use_unit("stdctrls.inc.php");

//Definição de classe
class Unit1 extends Page
{
       public $MonthCalendar1 = null;
       public $ddlista1 = null;
       public $dslista1 = null;
       public $tblista1 = null;
       public $dbcedtec1 = null;
       function Button2Click($sender, $params)
       {



       }

}

global $application;

global $Unit1;

//Cria o formulário
$Unit1=new Unit1($application);

//Ler do arquivo de recursos
$Unit1->loadResource(__FILE__);

//Mostrar o formulário
$Unit1->show();

?>
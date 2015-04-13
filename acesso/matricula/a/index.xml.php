<?php
<object class="Unit1" name="Unit1" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">Unit1</property>
  <property name="DocType">dtNone</property>
  <property name="Height">2048</property>
  <property name="IsMaster">0</property>
  <property name="Name">Unit1</property>
  <property name="TemplateEngine">VCLTemplate</property>
  <property name="TemplateFilename">*.html</property>
  <property name="Width">2048</property>
  <object class="DBGrid" name="ddlista1" >
    <property name="Columns">a:0:{}</property>
    <property name="Datasource">dslista1</property>
    <property name="Height">200</property>
    <property name="Left">48</property>
    <property name="Name">ddlista1</property>
    <property name="Top">40</property>
    <property name="Width">826</property>
    <property name="jsOnRowChanged"></property>
    <property name="jsOnRowSaved"></property>
  </object>
  <object class="MonthCalendar" name="MonthCalendar1" >
    <property name="Height">200</property>
    <property name="Left">48</property>
    <property name="Name">MonthCalendar1</property>
    <property name="Top">240</property>
    <property name="Width">200</property>
  </object>
  <object class="Database" name="dbcedtec1" >
        <property name="Left">16</property>
        <property name="Top">16</property>
    <property name="Connected">1</property>
    <property name="DatabaseName">cedtec</property>
    <property name="Host">localhost</property>
    <property name="Name">dbcedtec1</property>
    <property name="UserName">root</property>
  </object>
  <object class="Table" name="tblista1" >
        <property name="Left">16</property>
        <property name="Top">56</property>
    <property name="Active">1</property>
    <property name="Database">dbcedtec1</property>
    <property name="LimitCount">10000</property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">tblista1</property>
    <property name="TableName">lista</property>
  </object>
  <object class="Datasource" name="dslista1" >
        <property name="Left">16</property>
        <property name="Top">96</property>
    <property name="Dataset">tblista1</property>
    <property name="Name">dslista1</property>
  </object>
</object>
?>

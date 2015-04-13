<?php

/*
 ************************************************************************
 PagSeguro Config File
 ************************************************************************
 */

$PagSeguroConfig = array();

$PagSeguroConfig['environment'] = "production"; // production, sandbox

$PagSeguroConfig['credentials'] = array();
$PagSeguroConfig['credentials']['email'] = "livraria.tecnica@cedtec.com.br";
$PagSeguroConfig['credentials']['token']['production'] = "3B364D50044745B08701F146C9F1B420";
$PagSeguroConfig['credentials']['token']['sandbox'] = "3B364D50044745B08701F146C9F1B420";

$PagSeguroConfig['application'] = array();
$PagSeguroConfig['application']['charset'] = "UTF-8"; // UTF-8, ISO-8859-1

$PagSeguroConfig['log'] = array();
$PagSeguroConfig['log']['active'] = false;
$PagSeguroConfig['log']['fileLocation'] = "";

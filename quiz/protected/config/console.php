<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
   'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
   'name'=>'My Console Application',
       'import' => array(
           'application.models.Settings',
       ),
       'components' => array(
           'db' => array(
               'connectionString' => 'mysql:host=localhost;dbname=quiz',
               'emulatePrepare'   => true,
               'username'         => 'root',
               'password'         => '1111',
               'charset'          => 'utf8',
               'tablePrefix'      => '',
           ),
       ),
       'commandMap'=>array(
           'migrate'=>array(
               'class'=>'system.cli.commands.MigrateCommand',
               'migrationPath'=>'application.migrations',
               'migrationTable'=>'migration',
               'connectionID'=>'db',
           ),
       ),
);
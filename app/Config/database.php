<?php
/**
 * This is core configuration file.
 *
 * Use it to configure core behaviour ofCake.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * In this file you set up your database connection details.
 *
 * @package       cake
 * @subpackage    cake.config
 */
/**
 * Database configuration class.
 * You can specify multiple configurations for production, development and testing.
 *
 * driver => The name of a supported driver; valid options are as follows:
 *		mysql 		- MySQL 4 & 5,
 *		mysqli 		- MySQL 4 & 5 Improved Interface (PHP5 only),
 *		sqlite		- SQLite (PHP5 only),
 *		postgres	- PostgreSQL 7 and higher,
 *		mssql		- Microsoft SQL Server 2000 and higher,
 *		db2			- IBM DB2, Cloudscape, and Apache Derby (http://php.net/ibm-db2)
 *		oracle		- Oracle 8 and higher
 *		firebird	- Firebird/Interbase
 *		sybase		- Sybase ASE
 *		adodb-[drivername]	- ADOdb interface wrapper (see below),
 *		odbc		- ODBC DBO driver
 *
 * You can add custom database drivers (or override existing drivers) by adding the
 * appropriate file to app/models/datasources/dbo.  Drivers should be named 'dbo_x.php',
 * where 'x' is the name of the database.
 *
 * persistent => true / false
 * Determines whether or not the database should use a persistent connection
 *
 * connect =>
 * ADOdb set the connect to one of these
 *	(http://phplens.com/adodb/supported.databases.html) and
 *	append it '|p' for persistent connection. (mssql|p for example, or just mssql for not persistent)
 * For all other databases, this setting is deprecated.
 *
 * host =>
 * the host you connect to the database.  To add a socket or port number, use 'port' => #
 *
 * prefix =>
 * Uses the given prefix for all the tables in this database.  This setting can be overridden
 * on a per-table basis with the Model::$tablePrefix property.
 *
 * schema =>
 * For Postgres and DB2, specifies which schema you would like to use the tables in. Postgres defaults to
 * 'public', DB2 defaults to empty.
 *
 * encoding =>
 * For MySQL, MySQLi, Postgres and DB2, specifies the character encoding to use when connecting to the
 * database.  Uses database default.
 */
 //updated by Orly
 switch (SITE_DB){
 	case "hashani":
		define ('DB_HOST','hashani21032013.db.10766768.hostedresource.com');
		define ('DB_LOGIN','hashani21032013');
		define ('DB_PSW','Hashani@@0313');
		define ('DB_NAME','hashani21032013');
		break;
	case "ortal2013":
		define ('DB_HOST','ortal2013.db.10766768.hostedresource.com');
		define ('DB_LOGIN','ortal2013');
		define ('DB_PSW','Ortal@@2013');
		define ('DB_NAME','ortal2013');
		break;
		
	case "croogobase":
		define ('DB_HOST','croogobasic.db.10766768.hostedresource.com');
		define ('DB_LOGIN','croogobasic');
		define ('DB_PSW','Blabla@@01');
		define ('DB_NAME','croogobasic');
		break;
	case "tmp123":
		define ('DB_HOST','tmp123.db.10766768.hostedresource.com');
		define ('DB_LOGIN','tmp123');
		define ('DB_PSW','Tmp@@123');
		define ('DB_NAME','tmp123');
		break;
	default:
		define ('DB_HOST','localhost');
		define ('DB_LOGIN','root');
		define ('DB_PSW','');
		define ('DB_NAME','default');
		break;
		
 }
 
class DATABASE_CONFIG {

	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'database' => DB_NAME,
		'host'=> DB_HOST,
		'login' =>DB_LOGIN,
		'password' =>DB_PSW,
		'prefix' => '',
		'encoding' => 'UTF8',
		'port' => '',
	);
 
	public $test = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'user',
		'password' => 'password',
		'database' => 'test_database_name',
		'prefix' => '',
		'encoding' => 'UTF8',
	);
}
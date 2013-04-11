<?php
/**
 * Simple MySQLi Class 0.2
 *
 * @author              JREAM
 * @link                http://www.jream.com
 * @copyright   2010 Jesse Boyer (contact@jream.com)
 * @license             GNU General Public License 3 (http://www.gnu.org/licenses/)
 *
 * This program is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details:
 * http://www.gnu.org/licenses/
 *
 * @uses        ----------------------------------------
 *
                // A Config array should be setup from a config file with these parameters:
                $config = array();
                $config['host'] = 'localhost';
                $config['user'] = 'root';
                $config['password'] = '';
				$config['port'] = '';
                $config['database'] = 'database';

                // Then simply connect to your DB this way:
                $DB = new DB($config);

                // Run a Query:
                $DB->Query('SELECT * FROM someplace');

                // Get an array of items:
                $DB->Get();

                // Get a single item:
                $DB->Get('field');

                What you do with displaying the array result is up to you!
                ----------------------------------------
 */

class DB
{

        /**
         * @desc Creates the MySQLi object for usage.
         *
         * @param  $db required connection params.
         */
		 
		public function prepareArray($dataArray) {
			while( list($key) = each($dataArray) ) {
				$key = $this->mysqli->real_escape_string($key);
				$retArray[$key] = $key;
			}
			return $retArray;
		}

        public function  __construct($db) {
                $this->mysqli = new mysqli($db['host'], $db['user'], $db['password'], $db['database'], $db['port']);

                if (mysqli_connect_errno()) {
                        printf("Connect failed: %s\n", mysqli_connect_error());
                        exit();
                }
        }

        /**
         * @desc Simple preparation to clean the SQL/Setup Result Object.
         *
         * @param  SQL statement
         * @return 
         */
        public function Query($SQL) {
                //$this->SQL = $this->mysqli->real_escape_string($SQL);
				$this->SQL = $SQL;
                $this->Result = $this->mysqli->query($SQL);

                if ($this->Result == true)
                return true;

                else
                die('Problem with Query: ' . $this->SQL);
        }

        /**
         * @desc Get the results
         *
         * @param  $field Select a single field, or leave blank to select all.
         * @return 
         */
        public function Get($field = NULL) {
                if ($field == NULL) {
                        $data = array();

                        while ($row = $this->Result->fetch_array(MYSQLI_BOTH)) {
                                $data[] = $row;
                        }
                }
                else {
                        $row = $this->Result->fetch_array(MYSQLI_BOTH);
                        $data = $row[$field];
                }

                /** Make sure to close the Result Set */
                $this->Result->close();

                return $data;

        }

        /**
         * @desc Automatically close the connection when finished with this object.
         */
        public function __destruct() {
                $this->mysqli->close();
        }

}
?>
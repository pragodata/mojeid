<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    auth_mojeid
 * @author Pragodata  {@link http://pragodata.cz}; Vlahovic
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2017032100;        // The current plugin version (Date: YYYYMMDDXX)
$plugin->release = '2.0';
$plugin->maturity = MATURITY_STABLE;
$plugin->requires  = 2013111800;        // Requires this Moodle version
$plugin->component = 'auth_mojeid';       // Full name of the plugin (used for diagnostics)

/**
 * 2. 0
 *		- 21.3.17 14:03
 *		- functionality for Moodle 2.6 - 3.1
 *				- replaced using of deprecated function \session_set_user()
 * 1.2
 *		- 22.9.14 9:24
 *		- base functionality for Moodle 2.5 - 2.7
 */
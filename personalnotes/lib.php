<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin version and other meta-data are defined here.
 *
 * @package     local_personalnotes
 * @copyright   2023 Ahmad Abeer <ahmad.abeer11@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function local_personalnotes_before_footer() {
    $myNotesLink = new moodle_url(url:'/local/personalnotes/mynotes.php');
    if(str_starts_with($_SERVER['REQUEST_URI'], "/my/")){
        echo "<a class='NotesLink' href='{$myNotesLink}'>View My Notes</a>";
        echo "<style>.NotesLink{
            background-color: rgb(130, 139, 0);
            color: white;
            padding: 1em 1.5em;
            text-decoration: none;
            text-transform: uppercase;
          }
          .NotesLink:hover{
            text-decoration: overline;
            font-weight: 900;
        }</style>";
    }
}
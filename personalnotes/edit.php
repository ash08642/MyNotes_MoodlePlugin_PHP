<?php

declare(strict_types=1);
/**
 * Plugin version and other meta-data are defined here.
 *
 * @package     local_personalnotes
 * @copyright   2023 Ahmad Abeer <ahmad.abeer11@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/local/personalnotes/classes/form/edit.php');
require_login();
global $DB;

$PAGE->set_url(new moodle_url(url: '/local/personalnotes/edit.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(title: 'Take Note');

if(isset($_GET['noteid'])){
    $noteForm = new edit(intval($_GET['noteid']));
    var_dump($_GET['noteid']);
}else{
    $noteForm = new edit(intval($_GET['noteid']));
    var_dump($_GET['noteid']);
}

//Form processing and displaying is done here
if ($noteForm->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
    //Go Back to My Notes
    redirect($CFG->wwwroot . "/local/personalnotes/mynotes.php",message:'You cancelled taking a Note');
} else if ($fromform = $noteForm->get_data()) {
    //Insert the data into the database
    $recordToInsert = new stdClass();
    $recordToInsert->course = $fromform->selectCourse;
    $recordToInsert->notetext = $fromform->note;
    $recordToInsert->notetype = $fromform->noteType;
    $recordToInsert->timeadded = time();
    
    $DB->insert_record('local_notes',$recordToInsert);
    
    redirect($CFG->wwwroot . "/local/personalnotes/mynotes.php",message:'Note Added succesfully');
}
echo $OUTPUT->header();
$noteForm->display();
echo $OUTPUT->footer();
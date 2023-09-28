<?php

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

$PAGE->set_url(new moodle_url(url: '/local/personalnotes/mynotes.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(title: 'My Notes');
$PAGE->requires->css('/local/personalnotes/css/notesForm.css');

if(isset($_POST['editid'])){
    $recordToUpdate = new stdClass();
    $recordToUpdate->id = intval($_POST['editid']);
    if(isset($_POST['notetext'])){
        $recordToUpdate->notetext = $_POST['notetext'];
    }
    if(isset($_POST['notetype'])){
        $recordToUpdate->notetype = $_POST['notetype'];
    }
    if(isset($_POST['course'])){
        $recordToUpdate->course = $_POST['course'];
    }
    $recordToUpdate->timeadded = time();
    var_dump($recordToUpdate);
    $DB->update_record('local_notes',$recordToUpdate);
}
if(isset($_GET['deleteid'])){
    $DB->delete_records('local_notes', array('id'=>$_GET['deleteid']));
}


$notes = $DB->get_records('local_notes');
$notes = array_values($notes);

$query = "SELECT fullname FROM mdl_course";
$courses = $DB->get_records_sql($query);
$courses = array_values($courses);

echo $OUTPUT->header();

//var_dump($notes);

//echo '<h1> here we take notes </h1>';
$templatecontext = (object)[
    'notes' => $notes,
    'courses' => $courses,
    'editurl' => new moodle_url(url:'edit.php'),
    'currenturl' => new moodle_url(url:'mynotes.php')
];
echo $OUTPUT->render_from_template('local_personalnotes/mynotes', $templatecontext);

global $DB;

    $notes = $DB->get_records(table:'local_notes');

    foreach($notes as $note){
        $timeadded = new DateTime();
        $timeadded->setTimestamp($note->timeadded);

        switch ($note->notetype) {
            case "0":
                $noteType = 'QuickNote';
                break;
            case "1":
                $noteType = 'Important';
                break;
            case "2":
                $noteType = 'Progress Information';
                break;
            case "3":
                $noteType = 'Reminder';
                break;
            case "4":
                $noteType = 'ToDo';
                break;
            default:
        }
    }

echo $OUTPUT->footer();

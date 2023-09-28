<?php

/**
 * Plugin version and other meta-data are defined here.
 *
 * @package     local_personalnotes
 * @copyright   2023 Ahmad Abeer <ahmad.abeer11@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class edit extends moodleform {
    //Add elements to form

    public function __construct(protected int $id = -3){
        parent::__construct();
    }
    public function definition() {
        global $DB, $CFG;
       
        $mform = $this->_form; // Don't forget the underscore! 

        $query = "SELECT fullname FROM mdl_course";
        $result = $DB->get_records_sql($query);
        $courses = array();
        $courses['General'] = 'General';
        foreach($result as $course){
            $courses[$course->fullname] = $course->fullname;
        }
        $mform->addElement('select', 'selectCourse', 'Choose Course', $courses);
        //$mform->setDefault('selectCourse', '0');


        $mform->addElement('textarea', 'note', 'Add Note'); // Add elements to your form.
        $mform->setType('note', PARAM_NOTAGS);                   // Set type of element.
        //$mform->setDefault('note', 'Make a quick note');        // Default value.
    
        $noteType = array();
        $noteType['Quick Note'] = 'Quick Note';
        $noteType['Important'] = 'Important';
        $noteType['Progress Information'] = 'Progress Information';
        $noteType['Reminder'] = 'Reminder';
        $noteType['To Do'] = 'To Do';
        
        $mform->addElement('select', 'noteType', 'Note Type', $noteType);
        if($this->id < 0){
            $mform->setDefault('selectCourse', '0');
            $mform->setDefault('note', 'Make a quick note');        // Default value.
            $mform->setDefault('noteType', $this->id);
        }else{
            $query2 = "SELECT * FROM mdl_local_notes WHERE id = {$this->id}";
            $result2 = $DB->get_records_sql($query2);
            foreach($result2 as $note){
                $mform->setDefault('selectCourse', $note->course);
                $mform->setDefault('note', $note->notetext);        // Default value.
                $mform->setDefault('noteType', $note->notetype);
            }
        }

        $this->add_action_buttons();
    }
    public function getId(): int{
        return $this->id;
    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}
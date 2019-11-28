<?php

namespace App\Http\Controllers;

use App\Kiosk;
use App\Event;
use App\Course;
use App\Student;
use App\Student_course;
use App\EventStudentList;
use App\Event_Student;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Kiosk $kiosk)
    {
        // return view('events.create')->withKioskID($kiosk);
        return view('events.create', compact('kiosk'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedEvent = $request->validate([
            'name' => ['unique:events', 'required', 'string', 'max:30', 'min:3'],
        ]);

        //TODO: verify that starttime  <= late time <= end time
        Event::create([
            'kiosk_id' => $request->kioskID,
            'name' => $validatedEvent['name'],
            'date' => $request->date,
            'startTime' => $request->startTime,
            'lateTime' => $request->lateTime,
            'endTime' => $request->endTime,
        ]);

        return redirect('/kiosks/' . $request->kioskID . '/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /* This loads a page that has various buttons to do other things with the event
       In partiucular, it allows the user to create and modify a class list for the event */
    public function settings($id)
    {
        $event = Event::find($id);
        $slist = EventStudentList::where('event_id', $id)->with('student')->get();
        $studentList = $slist->sortBy('studentID')->sortBy('student.firstname')->sortBy('student.lastname');

        $isPast = false;
        $today = Carbon::today()->toDateString();
        if ($event->date < $today) $isPast = true;
        
        return view('events.settings', compact('event','studentList','isPast'));
    }

    /**
     * Add a list of students to the event
     */
   public function addStudents($id)
    {
        $event = Event::find($id);

        $slist = EventStudentList::where('event_id', $id)->with('student')->get();
        $studentList = $slist->sortBy('studentID')->sortBy('student.firstname')->sortBy('student.lastname');

        return view('events.addStudents', compact('event', 'studentList'));
    }

    /* Add students by course to the event (the id is in the request)
       Returns to the view that called it.
    */
    public function addStudentsByCourse(Request $request)
    {
        $eventID = $request->eventID;
        if ($eventID == null) {
            return back()->with('error', 'Error: no event id passed to event controller.');
        }
        $courseCode = $request->courseCode;
        $course = Course::find($courseCode);
        if ($course == null) {
            return back()->with('error', 'Invalid course code. Course not found.');
        }


        $students = Student_course::all()->where('coursecode', $courseCode);
        //dd($students);
        foreach ($students as $student) {
            //print_r($course->coursecode ." ... " . $student->studentID . "<br>");
            //TODO: how to handle create when there is a unique contstraint?
            $test = EventStudentList::where('event_id', $eventID)->where('student_id', $student->studentID);
            if ($test->get()->count()) {
                continue;
            }
            EventStudentList::create([
                'event_id' => $eventID,
                'student_id' => $student->studentID,
            ]);
        }
        return back();
    }

    /* Copy the list of students from one event to another
    *  from sourceID to eventID
    */
    public function copyStudentList(Request $request)
    {

        $destID = $request->eventID;
        if ($destID == null) {
            return back()->with('error', 'Error: no event id passed to event controller.');
        }
        $sourceID = $request->sourceID;
        if ($sourceID == null) {
            return back()->with('error', 'Error: no source event id passed to event controller.');
        }

        if ($sourceID == $destID) {
            return back()->with('error', 'Error: You can\'t copy from the current event.');
        }

        $students = EventStudentList::where('event_id', $sourceID)->get();
        if (!$students->count()) {
            return back()->with('error', 'No students found. Ensure that event ID is correct.');
        }
        //print_r($destID . " ".$students->count()."<br>");
        foreach ($students as $student) {

            $test = EventStudentList::where('event_id', $destID)->where('student_id', $student->student_id)->get();

            if ($test->count()) {
                //    dd("duplicate!");
                continue;
            }
            // print_r($destID ." ".$student->student_id."<br>");
            /* this does not work. I don't know why */
            // EventStudentList::create([
            //     'event_id'=>$destID,
            //     'student_id'=>$student->student_id,
            // ]);
            $record = new EventStudentList();
            $record->event_id = $destID;
            $record->student_id = $student->student_id;
            $record->save();
        }
        //dd('here2'.$eventID." ".$sourceID);

        return back();
        // return redirect('/events/' . $destID . '/addStudents');
    }

    /* Add student by student number */
    public function addStudent(Event $event, Student $student)
    {
        //make sure that the student is not already on that eventlist
            $test = EventStudentList::where('event_id', $event->id)->where('student_id', $student->studentID)->get();
            if ($test->count()) {
                return;
            }

        //any other checks necessary?

        //create and save record
        $record = new EventStudentList();
        $record->event_id = $event->id;
        $record->student_id = $student->studentID;
        $record->save();

        //return to the original view 
        //TODO: Does this reload it?
        return back();
    }

    /* Remove student by student number */
    public function removeStudent(Event $event, int $studentID)
    {
        //$record = EventStudentList::where('event_id', $event->id)->where('student_id', $student->studentID)->get();
        $record = EventStudentList::where('event_id', $event->id)->where('student_id', $studentID)->delete();
        return back();
    }

    /* Start the special terminal for events */
    public function terminal($id)
    {
        $event = Event::find($id);
        $kiosk = Kiosk::find($event->kiosk_id);
        return view('events.terminal', compact('kiosk', 'event'));
    }

    /* Toggle student in/out using their login ID to identify them
        OR their student number */
    public function signInStudent(Event $event, String $loginID)
    {
        $student = null;
        $loginID = strtolower($loginID);
        //return response()->json(['login' => $loginID, 'here' => 'here']);   //how to debug

        /* First we check to see if it is a student id number : ie. all digits */
        if (is_numeric($loginID)) {

            $student = Student::where('studentID', $loginID)->first();
            if ($student == null) {
                return response()->json(['status' => 'not found']);
            }
        } else {
            /* Next we check to see if it is a student login id */
            $student = Student::where('loginID', $loginID)->first();
            if ($student == null) {
                return response()->json(['status' => 'not found']);
            }
        }

        $studentID = $student->studentID;

        $present = Event_Student::isSignedIn($studentID, $event->id);
      
        if ($present) {
            return response()->json(['status' => 'already present', 'student' => $student->toArray()]);      
        } else {
            
            $statcode = 'PRESENT';
            $statresp = 'present';        
            //create a signedIn entry
           // $event->students()->attach($studentID); //Does not work. TODO: fix this.

           $record = new Event_Student();
           $record->event_id = $event->id;
           $record->student_id = $studentID;
           $record->save();
            //get photoURL in case it's needed
            $photoURL = $student->getPhotoURL($studentID);
            return response()->json(['status' => $statresp, 'photoURL' => $photoURL, 'student' => $student->toArray()]);
        }
    }

}

<?php

namespace App\Http\Controllers;
use App\Kiosk;
use App\Event;
use App\Course;
use App\Student;
use Illuminate\Http\Request;
use App\Student_course;
use App\EventStudentList;

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
        return view('events.create',compact('kiosk'));
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
            'kiosk_id'=>$request->kioskID,
            'name' => $validatedEvent['name'],
            'date' => $request->date,
            'startTime' => $request->startTime,
            'lateTime' => $request->lateTime,
            'endTime' => $request->endTime,
        ]);
        
        return redirect ('/kiosks/'.$request->kioskID.'/edit');        
        
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


    /* This loads a small page that has various buttons to do other things with the event */
    public function settings($id) 
    {
        $event = Event::find($id);


        return view('events.settings', compact('event'));
    }
    /**
     * Add a list of students to the event
     */
    public function addStudents($id) 
    {
        $event = Event::find($id);

        $slist = EventStudentList::where('event_id',$id)->with('student')->get();
        $studentList=$slist->sortBy('studentID')->sortBy('student.firstname')->sortBy('student.lastname');

        return view('events.addStudents', compact('event','studentList'));
    }

    /* Add students by course to the event (the id is in the request)
    */
    public function addStudentsByCourse(Request $request) 
    {
        $eventID = $request->eventID;
        if ($eventID == null) {
            return back()->with('error','Error: no event id passed to event controller.');
        }
        $courseCode = $request->courseCode;
        $course = Course::find($courseCode);
        if ($course == null) {
            return back()->with('error','Invalid course code. Course not found.');
        }


        $students = Student_course::all()->where('coursecode',$courseCode);
        //dd($students);
         foreach ($students as $student) {
            //print_r($course->coursecode ." ... " . $student->studentID . "<br>");
            //TODO: how to handle create when there is a unique contstraint?
            $test = EventStudentList::where('event_id',$eventID)->where('student_id',$student->studentID);
            if ($test->get()->count()) {
                continue;
            }  
            EventStudentList::updateOrCreate([
                'event_id'=>$eventID,
                'student_id'=>$student->studentID,                
            ]);  
         }  
         return back();
    }


    
}

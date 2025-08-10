<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Academic;
use App\Models\Department;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Exam;
use Illuminate\Support\Facades\DB;

class ExamsController extends Controller
{
    public function upload()
    {
        $exams = Exam::all();
        return view('admin.uploaded_documents', compact('exams'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'instructor_name' => 'required|string',
            'student_id' => 'required',
            'course_code' => 'required|string',
            'email' => 'required|string',
            'phone_number' => 'required|string',
            'course_title' => 'required|string',
            'faculty' => 'required|string',
            'semester' => 'required|string',
            'academic_year' => 'required|string',
            'exams_type' => 'required|string',
            'exam_date' => 'required|date',
            'exam_format' => 'required',
            'duration' => 'required|string',
            'exam_document' => 'required|file|mimes:pdf,docx',
            'answer_key' => 'file|mimes:pdf,docx',
            'special_instruction' => 'string|nullable',
        ]);

        $exam_document_path = $request->file('exam_document')->store('public/exam_documents');
        $validatedData['exam_document'] = $exam_document_path;
        $validatedData['document_id'] = random_int(1000000000, 9999999999);

        if ($request->hasFile('answer_key')) {
            $answer_key_path = $request->file('answer_key')->store('public/answer_keys');
            $validatedData['answer_key'] = $answer_key_path;
        }

        $validatedData['user_id'] = Auth::user()->id;

        Exam::create($validatedData);
        return redirect()->route('dashboard')->with('success', 'Exam Document deposited successfully.');
    }

    public function edit(Exam $exam)
    {
        return view('admin.edit_exam', [
            'exam' => $exam,
            'departments' => Department::all(),
            'years' => Academic::all(),
        ]);
    }

    public function update(Request $request, Exam $exam)
    {
        $validatedData = $request->validate([
            'instructor_name' => 'required|string',
            'student_id' => 'required',
            'course_code' => 'required|string',
            'email' => 'required|string',
            'phone_number' => 'required|string',
            'course_title' => 'required|string',
            'faculty' => 'required|string',
            'semester' => 'required|string',
            'academic_year' => 'required|string',
            'exams_type' => 'required|string',
            'exam_date' => 'required|date',
            'exam_format' => 'required',
            'duration' => 'required|string',
            'exam_document' => 'nullable|file',  // Changed to nullable
            'answer_key' => 'nullable|file',    // Changed to nullable
        ]);

        // Handle exam document update
        if ($request->hasFile('exam_document')) {
            // Delete old exam document if it exists
            if ($exam->exam_document && Storage::exists($exam->exam_document)) {
                Storage::delete($exam->exam_document);
            }
            
            $exam_document_path = $request->file('exam_document')->store('public/exam_documents');
            $validatedData['exam_document'] = $exam_document_path;
        } else {
            // Keep existing exam document if no new file is uploaded
            $validatedData['exam_document'] = $exam->exam_document;
        }

        // Handle answer key update
        if ($request->hasFile('answer_key')) {
            // Delete old answer key if it exists
            if ($exam->answer_key && Storage::exists($exam->answer_key)) {
                Storage::delete($exam->answer_key);
            }
            
            $answer_key_path = $request->file('answer_key')->store('public/answer_keys');
            $validatedData['answer_key'] = $answer_key_path;
        } else {
            // Keep existing answer key if no new file is uploaded
            $validatedData['answer_key'] = $exam->answer_key;
        }

        $exam->update($validatedData);

        return redirect()->route('dashboard')->with('success', 'Exam Document updated successfully.');
    }

    public function approve(Exam $exam)
    {
        $exam->update(['is_approve' => true]);

        return redirect()->route('dashboard.all.upload.document')->with('success', 'Document approved successfully');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()->back()->with('success', 'Document deleted successfully');
    }

    public function delete(Exam $exam)
    {
        $exam->delete();

        return redirect()->route('dashboard.upload.document')->with('success', 'Document deleted successfully');
    }

    public function filter(Request $request)
    {
        $facultyId = $request->input('faculty_id');
        $tags = $request->input('tags');
        $semesters = $request->input('semesters');
        $years = $request->input('years');

        $examsQuery = Exam::query();

        if ($facultyId) {
            $examsQuery->where('faculty', $facultyId);
        }

        if (!empty($tags)) {
            $examsQuery->whereIn('tags', $tags);
        }

        if (!empty($semesters)) {
            $examsQuery->whereIn('semester', $semesters);
        }

        if (!empty($years)) {
            $examsQuery->whereIn(DB::raw('YEAR(exam_date)'), $years);
        }

        $exams = $examsQuery->get();

        return response()->json($exams);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // $exams = Exam::where('is_approve', 1)
        //             ->where(function($q) use ($query) {
        //                 $q->where('student_id', 'LIKE', "%$query%")
        //                     ->orWhere('document_id', 'LIKE', "%$query%")
        //                     ->orWhere('faculty', 'LIKE', "%$query%")
        //                     ->orWhere('course_code', 'LIKE', "%$query%")
        //                     ->orWhere('course_title', 'LIKE', "%$query%")
        //                     ->orWhere('semester', 'LIKE', "%$query%")
        //                     ->orWhere('academic_year', 'LIKE', "%$query%")
        //                     ->orWhere('exams_type', 'LIKE', "%$query%")
        //                     ->orWhere('instructor_name', 'LIKE', "%$query%")
        //                     ->orWhere('exam_date', 'LIKE', "%$query%")
        //                     ->orWhere('exam_format', 'LIKE', "%$query%")
        //                     ->orWhere('duration', 'LIKE', "%$query%")
        //                     ->orWhere('tags', 'LIKE', "%$query%");

        //             })
        //             ->paginate(20);

        $exams = Exam::where('is_approve', 1)
        ->where(function($q) use ($query) {
            $q->where('student_id', 'LIKE', "%$query%")
                ->orWhere('document_id', 'LIKE', "%$query%")
                ->orWhere('faculty', 'LIKE', "%$query%")
                ->orWhere('course_code', 'LIKE', "%$query%")
                ->orWhere('course_title', 'LIKE', "%$query%")
                ->orWhere('semester', 'LIKE', "%$query%")
                ->orWhere('academic_year', 'LIKE', "%$query%")
                ->orWhere('exams_type', 'LIKE', "%$query%")
                ->orWhere('instructor_name', 'LIKE', "%$query%")
                ->orWhere('exam_date', 'LIKE', "%$query%")
                ->orWhere('exam_format', 'LIKE', "%$query%")
                ->orWhere('duration', 'LIKE', "%$query%")
                ->orWhere('tags', 'LIKE', "%$query%");
        })->get();

        $files = File::where('is_approve', 1)
                ->where(function ($q) use ($query) {
                    $q->where('depositor_name', 'LIKE', "%$query%")
                        ->orWhere('document_id', 'LIKE', "%$query%")
                        ->orWhere('file_title', 'LIKE', "%$query%")
                        ->orWhere('file_format', 'LIKE', "%$query%")
                        ->orWhere('year_created', 'LIKE', "%$query%")
                        ->orWhere('year_deposit', 'LIKE', "%$query%");
                })->get();

        $results = [
            'exams' => $exams,
            'files' => $files,
        ];
        $uniqueFaculties = $exams->pluck('faculty')->unique()->values()->all();
        $uniqueTags = $exams->pluck('tags')->unique()->values()->all();
        $uniqueSemesters = $exams->pluck('semester')->unique()->values()->all();

        return view('admin.documents',[
            'exams' => $results,
            'faculties' => $uniqueFaculties,
            'tags' => $uniqueTags,
            'semesters' => $uniqueSemesters,
            'years' => Exam::select(DB::raw('YEAR(created_at) as year'))->distinct()->pluck('year'),
        ]);
    }
}

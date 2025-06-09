<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $students = $query->latest()->paginate(10);

        return view('admin.student.index', compact('students', 'search'));
    }

    public function show(User $student)
    {
        return view('admin.students.show', compact('student'));
    }

    public function edit(User $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, User $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->id,
            'password' => 'nullable|string|min:8',
        ]);

        $student->name = $request->name;
        $student->email = $request->email;

        if ($request->filled('password')) {
            $student->password = Hash::make($request->password);
        }

        $student->save();

        flash()->addSuccess('Data siswa berhasil diperbarui.');
        return redirect()->route('students.index');
    }

    public function destroy(User $student)
    {
        $student->delete();
        flash()->addSuccess('Siswa berhasil dihapus.');
        return redirect()->route('students.index');
    }
}

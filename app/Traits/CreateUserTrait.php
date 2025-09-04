<?php

namespace App\Traits;

use App\Models\User;
use App\Enums\UserRoleEnum;
use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

trait CreateUserTrait
{
    private $privatePassword = 'password';

    /**
     * CreateAdmin
     *
     * @return User
     */
    public function CreateAdmin()
    {
        return User::create([
            'name' => $this->admin['name'],
            'email' => $this->admin['email'],
            'role' => UserRoleEnum::Admin,
            'password' => Hash::make($this->admin['password']),
        ]);
    }
    
    /**
     * CreateManager
     *
     * @param  int $school_id
     * @return User
     */
    public function CreateManager(int $school_id)
    {
        return User::create([
            'name' => $this->manager['name'],
            'email' => $this->manager['email'],
            'role' => UserRoleEnum::Manager,
            'password' => Hash::make($this->manager['password']),
            'school_id' => $school_id
        ]);
    }
    
    /**
     * CreateTeacher
     *
     * @param  int $school_id
     * @return User
     */
    public function CreateTeacher(int $school_id)
    {
        $user = User::create([
            'name' => $this->teacher['name'],
            'email' => $this->teacher['email'],
            'role' => UserRoleEnum::Teacher,
            'password' => Hash::make($this->privatePassword),
            'school_id' => $school_id
        ]);

        $user->teacher()->create([
            'phone' => $this->teacher['phone'],
            'job_number' => $this->teacher['job_number'],
            'job_title' => $this->teacher['job_title'],
        ]);
        return $user;
    }

    /**
     * CreateStudent
     *
     * @param  int $school_id
     * @return Student
     */
    public function CreateStudent(int $school_id)
    {
        $user = User::create([
            'name' => $this->student['name'],
            'email' => $this->student['email'],
            'role' => UserRoleEnum::Student,
            'password' => Hash::make($this->privatePassword),
            'school_id' => $school_id
        ]);
        $student = $user->student()->create([
            'phone' => $this->student['phone'],
            'code' => $this->student['code'],
            'school_id' => $school_id
        ]);
        return $student;
    }
    
    /**
     * CreateGuardian
     *
     * @param  int $school_id
     * @return Guardian
     */
    public function CreateGuardian(int $school_id)
    {
        $user = User::create([
            'name' => $this->guardian['name'],
            'email' => $this->guardian['email'],
            'role' => UserRoleEnum::Guardian,
            'password' => Hash::make($this->privatePassword),
            'school_id' => $school_id
        ]);
        $guardian = $user->guardian()->create([
            'school_id' => $school_id,
            'phone' => $this->guardian['phone'],
        ]);
        return $guardian;
    }
}
<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\School;
use App\Models\Activation;
use App\Models\Semester;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class DomyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // create School
        School::factory(5)->create()->each(function ($school) {

            // create manager
            User::factory()->create([
                'role' => 'manager',
                'school_id' => $school->id
            ]);

            // create classes
            collect(['grade-1', 'grade-2', 'grade-3'])->each(function ($className) use ($school) {

                $class = Semester::create(['name' => $className, 'school_id' => $school->id]);

                // create teacher
                User::factory(5)->create(['school_id' => $school->id, 'role' => 'teacher'])->each(function ($teacherUser, $i) use ($school, $class) {

                    $sections = ['arabic', 'math', 'engilsh', 'science', 'history'];
                    $teacher = Teacher::factory()->create([
                        'school_id' => $school->id,
                        'user_id' => $teacherUser->id
                    ]);

                    $teacher->sections()->create([
                        'name' => $sections[$i],
                        'school_id' => $school->id,
                        'semester_id' => $class->id
                    ]);
                });

                // create student
                User::factory()->count(10)->create(['school_id' => $school->id, 'role' => 'student'])->each(function ($user) use ($school, $class) {
                    $student = $user->student()->create([
                        'code' => strtoupper(\Illuminate\Support\Str::random(6)),
                        'phone' => fake()->phoneNumber,
                        'school_id' => $school->id,
                        'semester_id' => $class->id
                    ]);

                    // ولي أمر لكل طالب
                    User::factory(2)->create([
                        'role' => 'guardian',
                        'school_id' => $school->id,
                    ])->each(function ($user) use ($school, $student) {
                        $guardian = $user->guardian()->create([
                            'phone' => fake()->phoneNumber,
                            'school_id' => $school->id,
                        ]);
                        $student->guardians()->attach($guardian->id);
                    });
                });

                // create guardian
                User::factory(10)->create([
                    'role' => 'guardian',
                    'school_id' => $school->id,
                ])->each(function ($user) use ($school, $class) {
                    $guardian = $user->guardian()->create([
                        'phone' => fake()->phoneNumber,
                        'school_id' => $school->id,
                    ]);
                    User::factory()->count(2)->create(['school_id' => $school->id, 'role' => 'student'])->each(function ($user) use ($school, $class, $guardian) {
                        $student = $user->student()->create([
                            'code' => strtoupper(\Illuminate\Support\Str::random(6)),
                            'phone' => fake()->phoneNumber,
                            'school_id' => $school->id,
                            'semester_id' => $class->id
                        ]);
                        $student->guardians()->attach($guardian->id);
                    });
                });
            });

            $activation = Activation::factory()->create([
                'created_by' => 1,
                'school_id' => $school->id,
            ]);
            $activation->programs()->attach([1, 2], ['school_id' => $school->id]);
            $subscription_end = now()->addMonths((int)$activation->subscription_time);
            $school->is_active = true;
            $school->subscription_start = now();
            $school->subscription_end = $subscription_end;
            $school->save();
        });
    }
}

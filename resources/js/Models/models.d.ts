/**
 * This file is auto generated using 'php artisan typescript:generate'
 *
 * Changes to this file will be lost when the command is run again
 */

declare namespace App.Models {
    export interface Cours {
        id: number;
        name: string;
        description: string | null;
        number_hours: number;
        teacher_id: number;
        created_at: string | null;
        updated_at: string | null;
        teacher?: App.Models.Teacher | null;
    }

    export interface Enrollment {
        id: number;
        student_id: number;
        cours_id: number;
        semester: string;
        created_at: string | null;
        updated_at: string | null;
        student?: App.Models.Student | null;
        cours?: App.Models.Cours | null;
    }

    export interface Exam {
        id: number;
        cours_id: number;
        exam_date: string;
        teacher_id: number;
        created_at: string | null;
        updated_at: string | null;
        teacher?: App.Models.Teacher | null;
        cours?: App.Models.Cours | null;
    }

    export interface Filiere {
        id: number;
        name: string;
        description: string | null;
        number_hours: number;
        created_at: string | null;
        updated_at: string | null;
        courses?: Array<App.Models.Cours> | null;
        courses_count?: number | null;
    }

    export interface FiliereCourse {}

    export interface Student {
        id: number;
        first_name: string;
        last_name: string;
        specialty: string | null;
        phone_number: string | null;
        email: string;
        user_id: number;
        created_at: string | null;
        updated_at: string | null;
        user?: App.Models.User | null;
    }

    export interface Teacher {
        id: number;
        first_name: string;
        last_name: string;
        specialty: string | null;
        academic_degree: string | null;
        phone_number: string | null;
        email: string;
        user_id: number;
        created_at: string | null;
        updated_at: string | null;
        user?: App.Models.User | null;
    }

    export interface User {
        id: number;
        name: string;
        email: string;
        email_verified_at: string | null;
        password: string;
        role: string | null;
        remember_token: string | null;
        created_at: string | null;
        updated_at: string | null;
    }

}

Database: sipi-cst-portal

1. Table: fees
    Purpose: Stores fee-related information for students.
    Columns:
    - id (int, Primary Key): Unique identifier for each fee entry.
    - student_id (int, Foreign Key): References the id in the users table, linking fees to students.
    - fee_type (varchar(100)): Describes the type of fee (e.g., tuition, lab fees).
    - amount (decimal(10,2)): The monetary amount of the fee.
    - status (enum('paid','unpaid')): Indicates if the fee has been paid or remains unpaid.
    - created_at (timestamp): Records the timestamp when the fee entry was created.

2. Table: marks
    Purpose: Holds marks data for students in various subjects.
    Columns:
    - id (int, Primary Key): Unique identifier for each marks entry.
    - student_id (int, Foreign Key): References the id in the users table, linking marks to students.
    - subject_id (int, Foreign Key): References the id in the subjects table, linking marks to specific subjects.
    - total_marks (int): The total marks available for the subject.
    - obtained_marks (int): The marks obtained by the student.
    - created_at (timestamp): Timestamp for when the marks entry was created.
    - updated_at (timestamp): Timestamp for when the marks entry was last updated.

3. Table: notices
    Purpose: Contains notices or announcements for students and teachers.
    Columns:
    - id (int, Primary Key): Unique identifier for each notice.
    - title (varchar(255)): Title of the notice.
    - content (text): Detailed content of the notice.
    - created_at (timestamp): Timestamp for when the notice was created.
    - updated_at (timestamp): Timestamp for when the notice was last updated.

4. Table: results
    Purpose: Manages the results submitted by students for different semesters.
    Columns:
    - id (int, Primary Key): Unique identifier for each results entry.
    - student_id (int, Foreign Key): References the id in the users table, linking results to students.
    - semester_id (int, Foreign Key): References the id in the semesters table, indicating the semester associated with the results.
    - result_status (enum('submitted','pending')): Status of the result, whether it has been submitted or is pending.
    - created_at (timestamp): Timestamp for when the results entry was created.
    - updated_at (timestamp): Timestamp for when the results entry was last updated.

5. Table: roles
    Purpose: Defines user roles within the system (students, teachers, admin).
    Columns:
    - id (int, Primary Key): Unique identifier for each role.
    - role_name (enum('student','teacher','admin','')): The name of the role.

6. Table: routines
    Purpose: Stores class routine information for different semesters.
    Columns:
    - id (int, Primary Key): Unique identifier for each routine entry.
    - semester_id (int, Foreign Key): References the id in the semesters table, linking the routine to a specific semester.
    - routine_details (text): Detailed information about the routine.
    - created_at (timestamp): Timestamp for when the routine entry was created.
    - updated_at (timestamp): Timestamp for when the routine entry was last updated.

7. Table: semesters
    Purpose: Lists the semesters available in the academic program.
    Columns:
    - id (int, Primary Key): Unique identifier for each semester.
    - semester_name (varchar(50)): Name of the semester (e.g., Fall 2023).

8. Table: subjects
    Purpose: Stores information about subjects associated with semesters.
    Columns:
    - id (int, Primary Key): Unique identifier for each subject.
    - semester_id (int, Foreign Key): References the id in the semesters table, linking subjects to a specific semester.
    - subject_name (varchar(100)): Name of the subject.
    - created_at (timestamp): Timestamp for when the subject entry was created.

9. Table: users
    Purpose: Contains user information, including students, teachers, and admins.
    Columns:
    - id (int, Primary Key): Unique identifier for each user.
    - name (varchar(100)): Name of the user.
    - email (varchar(100)): Email address of the user.
    - password (varchar(255)): Hashed password for authentication.
    - role_id (int, Foreign Key): References the id in the roles table, linking users to their roles.
    - semester_id (int, Foreign Key): References the id in the semesters table, indicating the semester the user is associated with (if applicable).
    - department (varchar(100)): Department of the user (e.g., CSE).
    - phone_number (varchar(15)): Phone number of the user.
    - guardian_phone_number (varchar(15)): Guardian's phone number of the user.
    - address (text): Address of the user.
    - class_roll (int): Class roll number of the student.
    - board_roll (int): Board roll number of the student.
    - image (varchar(255)): File path to the user's image.

Relationships:
- users to roles: Each user has one role defined by role_id. Deleting a role will remove the association with users.
- users to fees: Each fee entry is linked to a student in the users table via student_id. Deleting a user will also delete their associated fees.
- users to marks: Marks for subjects are linked to users via student_id. Deleting a user will delete their associated marks.
- users to results: Results are linked to users via student_id. Deleting a user will delete their associated results.
- semesters to subjects: Each subject is linked to a semester via semester_id. Deleting a semester will delete all associated subjects.
- semesters to routines: Routines are linked to semesters via semester_id. Deleting a semester will delete all associated routines.
- semesters to results: Results are linked to semesters via semester_id. Deleting a semester will delete all associated results.

Additional Considerations:
- Constraints: The SQL dump includes foreign key constraints to ensure referential integrity, meaning that a fee, marks, results, or routines cannot exist without a corresponding user or semester.
- Auto-increment: Several tables are set to auto-increment their primary key fields, allowing for easy addition of new entries without manual ID management.
// Custom JS to show/hide fields based on user type
const userTypeSelect = document.getElementById('user_type');
const studentFields = document.getElementById('student-fields');
const teacherFields = document.getElementById('teacher-fields');

userTypeSelect.addEventListener('change', function() {
    const selectedType = this.value;
    if (selectedType === 'student') {
        studentFields.style.display = 'block';
        teacherFields.style.display = 'none';
        // Ensure session select is required when student is selected
        document.getElementById('session').setAttribute('required', 'required');
        document.getElementById('semester').setAttribute('required', 'required');
    } else if (selectedType === 'teacher') {
        teacherFields.style.display = 'block';
        studentFields.style.display = 'none';
        // Remove required attributes for session and semester
        document.getElementById('session').removeAttribute('required');
        document.getElementById('semester').removeAttribute('required');
    } else {
        studentFields.style.display = 'none';
        teacherFields.style.display = 'none';
        // Remove required attributes
        document.getElementById('session').removeAttribute('required');
        document.getElementById('semester').removeAttribute('required');
    }
});
// End of custom JS

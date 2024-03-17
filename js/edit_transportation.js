function validateForm() {
    var selectElement = document.getElementById("student_id");
    if (selectElement.value === "") {
        alert("Please select a student.");
        return false; 
    }
    return true; 
}
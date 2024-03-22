let course_image = document.getElementById("course_image");
let image_file = document.getElementById("image_file");

function change_image(){
    course_image.src = URL.createObjectURL(image_file.files[0]);
}
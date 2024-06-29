let course_id = document.getElementById("course_id").textContent;

let assistant_name;
let assistant_id;
let assistant_name_value;

let student_name;
let student_id;
// console.log(document.getElementById("course_image").src.substring(50));

function change_image(){
    let course_image = document.getElementById("course_image");
    course_image.src = URL.createObjectURL(image_file.files[0]);
    
}

// the chosen assistants in edit_course
let chosen_assistants = document.getElementById('assistants-data').textContent;
let saved_assistants = JSON.parse(chosen_assistants);

// Convert array of objects to a Map
let assistants_map = new Map();
saved_assistants.forEach(assistant => {
    assistants_map.set(assistant.id, assistant.full_name);
});

console.log(assistants_map);


let assistant_list = assistants_map.size > 0 ? assistants_map : new Map();


function chosen_assistant(p){
    assistant_name = p.textContent;
    assistant_id = p.id;
}

function add_assistant(){
    assistant_name_value = document.getElementById('select_assistant').value; 

    if(assistant_name_value === assistant_name){
        if(assistant_name !== ""){
            if (!assistant_list.has(assistant_id)) 
                assistant_list.set(assistant_id, assistant_name);
            else 
                return false;
        }
    }
    else{
        if(assistant_name_value !== null){
            const classes = document.getElementById('select_assistant').classList;
            if (classes.length == 2) {
                const id = classes[1];
                if (!assistant_list.has(id))
                    assistant_list.set(id, assistant_name_value);
                else
                    return false; 
            }
        }
    }

    add_assistant_html();
}    

function add_assistant_html(){
    let divs = document.getElementsByClassName('added_assistant');
    for (let i = divs.length - 1; i >= 0; i--) {
        divs[i].parentNode.removeChild(divs[i]);
    }

    assistant_list.forEach((value, key) => {
        let div = document.createElement('div');
        div.className = 'added_assistant';
        div.id = key;

        document.getElementById('selected_assistant').appendChild(div);

        let valueDiv = document.createElement('div');
        valueDiv.textContent = value;
        div.appendChild(valueDiv);

        let icon = document.createElement('i');
        icon.className = 'fa-solid fa-minus';
        icon.addEventListener('click', function(){
            div.parentNode.removeChild(div);
            assistant_list.delete(key);
            console.log(assistant_list);
            document.getElementById('selected_assistant').value = assistant_name_value;
            console.log(document.getElementById('selected_assistant').value);
        });
        div.appendChild(icon);
    }); 
}
add_assistant_html();


// the chosen assistants in edit_course
let chosen_students = document.getElementById('students-data').textContent;
let saved_students = JSON.parse(chosen_students);

// Convert array of objects to a Map
let student_map = new Map();
saved_students.forEach(student => {
    student_map.set(student.id, student.full_name);
});

console.log(student_map);


let student_list = student_map.size > 0 ? student_map : new Map();


function chosen_student(p){
    student_name = p.textContent
    student_id = p.id
}

function add_student(){
    console.log(student_list);
    let student_name_value = document.getElementById('select_student').value; 

    if(student_name_value === student_name){
        if(student_name !== ""){
            if (!student_list.has(student_id)) 
                student_list.set(student_id, student_name);
            else
                return false;
        }
    }
    else{
        if(student_name_value !== null){
            const classes = document.getElementById('select_student').classList;
            if (classes.length == 2) {
                const id = classes[1];
                if (!student_list.has(id))
                    student_list.set(id, student_name_value);
                else
                    return false; 
            }
        }
    }

    add_student_html();
}    

function add_student_html(){
    const tbody = document.querySelector('table tbody');
    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
    }

    student_list.forEach((value, key) => {
        full_name = value.split(" ");
        const newRow = document.createElement('tr');
        const cell1 = document.createElement('td');
        cell1.textContent = key.replace(/[^\d]/g, '');
        newRow.appendChild(cell1);

        const cell2 = document.createElement('td');
        cell2.textContent = full_name[0];
        newRow.appendChild(cell2);

        const cell3 = document.createElement('td');
        cell3.textContent = full_name[1]; 
        newRow.appendChild(cell3);

        const cell4 = document.createElement('td');
        cell4.style.textAlign = 'center';
        let icon = document.createElement('i');
        icon.className = 'fa-solid fa-trash delete';
        icon.addEventListener('click', function(){
            newRow.remove();
            student_list.delete(key);
        });
        cell4.appendChild(icon);
        newRow.appendChild(cell4);
        tbody.appendChild(newRow);
    });
}

add_student_html();


function update_database(event){
    event.preventDefault();

    let image_source = document.getElementById("course_image").src.substring(31);
    console.log(image_source);

    //step 1
    let formData = new FormData();
    let image_file = document.getElementById('image_file').files[0];
    formData.append('image', image_file);

    //step2
    let course_name = document.getElementById('course_name').value;
    let start_date = document.getElementById('start_date').value;
    let end_date = document.getElementById('end_date').value;

    //step3
    let teacher_name = document.getElementById('select_teacher').value;
    let teacher_classes = document.getElementById('select_teacher').classList;
    let teacher_id;
    if (teacher_classes.length == 2 && teacher_name != ""){
        teacher_id = teacher_classes[1].substring(7);
    } 
    console.log(teacher_id);
    
    //step4
    let assistant_map = new Map();
    assistant_list.forEach((value,key)=>{
        let number_key = key.replace('assistant','');
        assistant_map.set(number_key, value);
    });
    let assistat_array = Array.from(assistant_map.entries())

    //step5
    let student_map = new Map();
    student_list.forEach((value,key)=>{
        let number_key = key.replace('student','');
        student_map.set(number_key, value);
    });
    let student_array = Array.from(student_map.entries())

    $.ajax({
        type: "POST",
        url: "update_course.php",
        dataType: 'html',
        processData: false, 
        contentType: false,
        data: formData,
        success: function(response) {
            console.log("Image moved successfully:", response);
            image_path = response;
            $.ajax({
                type: "POST",
                url: "update_course.php",
                dataType: 'html',
                data: {
                    course_id: course_id,
                    course_name: course_name,
                    start_date: start_date,
                    end_date: end_date,
                    image_path: image_path,
                    teacher_id: teacher_id,
                    image_source: image_source,
                },
                success: function(response) {
                    console.log("Data saved successfully:", response);
                    if(response == "true"){
                        $.ajax({
                            type: "POST",
                            url: "update_course.php",
                            dataType: 'html',
                            data: {
                                course_id: course_id,
                                assistants: JSON.stringify(assistat_array)
                            },
                            success: function(response) {
                                console.log("Data saved successfully:", response);
                            },
                            error: function(xhr, status, error) {
                                console.error("Error saving data:", error);
                            }
                        });

                        $.ajax({
                            type: "POST",
                            url: "update_course.php",
                            dataType: 'html',
                            data: {
                                course_id: course_id,
                                students: JSON.stringify(student_array)
                            },
                            success: function(response) {
                                console.log("Data saved successfully:", response);
                            },
                            error: function(xhr, status, error) {
                                console.error("Error saving data:", error);
                            }
                        });
                        let success = document.getElementById('success');
                        success.style.display = 'block';
                    }
                    else{
                        let fail = document.getElementById('fail');
                        fail.style.display = 'block';
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error saving data:", error);
                }
            });
        },
        error: function(xhr, status, error) {
            console.error("Error saving data:", error);
        }

    });   
}
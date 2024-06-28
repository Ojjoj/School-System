let assistant_list = new Map();
let student_list = new Map();
let assistant_name;
let assistant_id;
let student_name;
let student_id;
let assistant_name_value;
let image_path = "";

function change_image(){
    let course_image = document.getElementById("course_image");
    course_image.src = URL.createObjectURL(image_file.files[0]);
}

function chosen_assistant(p){
    assistant_name = p.textContent
    assistant_id = p.id
}

function add_assistant(){
    console.log(assistant_list);
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

function get_keys(list){
    let keys = [];
    list.forEach((value, key) =>{
        let id = key.replace('assistant', '');
        keys.push(parseInt(id))
    });
    return keys
}

let success_add = false;

function save_to_database(event){
    event.preventDefault();

    //step 1
    let formData = new FormData();
    let image_file = document.getElementById('image_file').files[0];
    formData.append('image', image_file);

    //step2
    let course_name = document.getElementById('course_name').value;
    let start_date = document.getElementById('start_date').value;
    let end_date = document.getElementById('end_date').value;

    //step3
    let teacher_classes = document.getElementById('select_teacher').classList;
    let teacher_id;
    if (teacher_classes.length == 2){
        teacher_id = teacher_classes[1].substring(7);
    }  
    
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
    console.log("hi")
    console.log(student_array)


    $.ajax({
        type: "POST",
        url: "save_data.php",
        dataType: 'html',
        processData: false, 
        contentType: false,
        data: formData,
        success: function(response) {
            console.log("Image moved successfully:", response);
            image_path = response;
            $.ajax({
                type: "POST",
                url: "save_data.php",
                dataType: 'html',
                data: {
                    course_name: course_name,
                    start_date: start_date,
                    end_date: end_date,
                    image_path: image_path,
                    teacher_id: teacher_id,
                },
                success: function(response) {
                    console.log("Data saved successfully:", response);
                    if(response != ""){
                        success_add = true;
                        $.ajax({
                            type: "POST",
                            url: "save_data.php",
                            dataType: 'html',
                            data: {
                                course_id: response,
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
                            url: "save_data.php",
                            dataType: 'html',
                            data: {
                                course_id: response,
                                students: JSON.stringify(student_array)
                            },
                            success: function(response) {
                                console.log("Data saved successfully:", response);
                            },
                            error: function(xhr, status, error) {
                                console.error("Error saving data:", error);
                            }
                        });
                        localStorage.setItem('success_add', 'true');
                        location.reload();  
                    }
                    else{
                        localStorage.setItem('success_add', 'false');
                        location.reload();
                          
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

document.addEventListener('DOMContentLoaded', function() {
    
    if (localStorage.getItem('success_add') === 'true') {
        let success = document.getElementById('success');
        success.style.display = 'block';
        localStorage.removeItem('success_add');
    }
    else if (localStorage.getItem('success_add') === 'false') {
        let fail = document.getElementById('fail');
        fail.style.display = 'block';
        localStorage.removeItem('success_add');
    }
    
});

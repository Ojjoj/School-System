let assistant_list = new Map();
let student_list = new Map();
let assistant_name;
let assistant_id;
let student_name;
let student_id;

function change_image(){
    let course_image = document.getElementById("course_image");
    let image_file = document.getElementById("image_file");   
    course_image.src = URL.createObjectURL(image_file.files[0]);
}

function chosen_assistant(p){
    assistant_name = p.textContent
    assistant_id = p.id
}

function add_assistant(){
    console.log(assistant_list);
    let assistant_name_value = document.getElementById('select_assistant').value; 

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
                classes.remove(classes[1]);
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
        });
        div.appendChild(icon);
    }); 

    assistant_name = '';
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
                classes.remove(classes[1]);
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

    student_name = '';
}    

function get_keys(list){
    let keys = [];
    list.forEach((value, key) =>{
        let id = key.replace('assistant', '');
        keys.push(parseInt(id))
    });
    return keys
}

function save_to_database(event){
    event.preventDefault();

    let course_name = document.getElementById('course_name').value;
    let start_date = document.getElementById('start_date').value;
    let end_date = document.getElementById('end_date').value;

    console.log(course_name);
    const assistant_ids = get_keys(assistant_list) 
    console.log(assistant_ids)

    $.ajax({
        type: "POST",
        url: "save_data.php",
        dataType: 'html',
        data: {
            course_name: course_name,
            start_date: start_date,
            end_date: end_date,
            assistants: assistant_ids
        },
        success: function(response) {
            console.log("Data saved successfully:", response);
        },
        error: function(xhr, status, error) {
            console.error("Error saving data:", error);
        }
    });
}

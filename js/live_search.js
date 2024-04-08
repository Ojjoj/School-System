$('document').ready(function(){
    let teacher_names
    let assistant_names
    let student_names

    // teacher names -------------------------------------------
    $('#select_teacher').blur(function(){
        setTimeout(() => {
             $('#select_teacher_options').hide();
        }, 300);                
        if(teacher_names[0] != 'no result found'){
            if(teacher_names[0][0].toLowerCase() == $(this).val().charAt(0).toLowerCase())
                $(this).val(teacher_names[0]);
            else
                $(this).val('');
        } 
        else
            $(this).val('');  
    });

    $('#select_teacher').on('click keyup',function(){
        $('#select_teacher_options').show()
        let teacher_name =  $(this).val();
       
        $.ajax({
            url:'live_search.php',
            method:'POST',
            dataType: 'json',
            data:{teacher_name: teacher_name},

            success:function(data){
                teacher_names = data
                let i = 0
                $('#select_teacher_options').empty();   
                data.forEach(function(element) {
                    i++;
                    $('#select_teacher_options').append('<p class="teacher_option" id="teacher' + i + '">' + element +'</p>');
                });
            }
        });
    });

    // assistant names -------------------------------------------
    $('#select_assistant').blur(function(){
        setTimeout(() => {
             $('#select_assistant_options').hide();
        }, 300);                
        if(assistant_names[0]['full_name'] != 'no result found'){
            if(assistant_names[0]['full_name'].charAt(0).toLowerCase() == $(this).val().charAt(0).toLowerCase()){
                $(this).val(assistant_names[0]['full_name']);
                $(this).addClass("assistant"+assistant_names[0]['id']);
            }  
            else
                $(this).val('');
        } 
        else
            $(this).val('');  
    });

    $(document).on('click', '.teacher_option', function(){
        $('#select_teacher').val(this.innerText)
    });

    $('#select_assistant').on('click keyup',function(){
        $('#select_assistant_options').show()
        let assistant_name =  $(this).val();
        $.ajax({
            url:'live_search.php',
            method:'POST',
            dataType: 'json',
            data:{assistant_name: assistant_name},

            success: function (data) {
                assistant_names = data;
                $('#select_assistant_options').empty();   
                data.forEach(function (element) {
                  $('#select_assistant_options').append('<p class="assistant_option" id="assistant' + element.id + '" onclick="chosen_assistant(this)">' + element.full_name +'</p>');
                });
              },

            error: function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
              }
        });
    });

    $(document).on('click', '.assistant_option', function(){
        $('#select_assistant').val(this.innerText)
    });
    
    // student names -------------------------------------------
    $('#select_student').blur(function(){
        setTimeout(() => {
             $('#select_student_options').hide();
        }, 300);   
        if(student_names[0]['full_name'] != 'no result found'){
            if(student_names[0]['full_name'].charAt(0).toLowerCase() == $(this).val().charAt(0).toLowerCase()){
                $(this).val(student_names[0]['full_name']);
                $(this).addClass("student"+student_names[0]['id']);
            }  
            else
                $(this).val('');
        } 
        else
            $(this).val('');                 
    });

    $('#select_student').on('click keyup',function(){
        $('#select_student_options').show()
        let student_name =  $(this).val();

        $.ajax({
            url:'live_search.php',
            method:'POST',
            dataType: 'json',
            data:{student_name: student_name},

            success:function(data){
                student_names = data;
                $('#select_student_options').empty();   
                data.forEach(function (element) {
                  $('#select_student_options').append('<p class="student_option" id="student' + element.id + '" onclick="chosen_student(this)">' + element.full_name +'</p>');
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
              }
        });
    });

    $(document).on('click', '.student_option', function(){
        $('#select_student').val(this.innerText)
    });

});

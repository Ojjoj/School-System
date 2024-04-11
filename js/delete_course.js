$('document').ready(function(){
    let delete_course_id

    $('.delete_course').on('click', function(){
        delete_course_id = $(this).parent().attr('id');
    }),

    $('#delete').on('click', function(){
        console.log(delete_course_id);
        $.ajax({
            url: 'delete_course.php',
            method: 'POST',
            dataType: 'json',
            data: {delete_course: delete_course_id},

            success: function(data){
                $('#'+data).remove();
            },

            error: function(jqXHR, textStatus, errorThrown){
                console.error('AJAX Error:', textStatus, errorThrown);
            }

        })
    })
    
});
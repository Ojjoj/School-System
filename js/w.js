var calendar;
var Calendar = FullCalendar.Calendar;
var events = [];
$(function() {
    if (!!event_object) {
        Object.keys(event_object).map(k => {
            var row = event_object[k]
            events.push({ id: row.event_id, title: row.title, start: row.start_datetime, end: row.end_datetime });
        })
    }
    var date = new Date()
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear()

    calendar = new Calendar(document.getElementById('calendar'), {
        headerToolbar: {
            left: 'prev,next today',
            right: 'dayGridMonth,dayGridWeek,list',
            center: 'title',
        },
        selectable: true,
        themeSystem: 'bootstrap',
        //Random default events
        events: events,
        eventClick: function(info) {
            var _details = $('#event_modal')
            var id = info.event.id
            if (!!event_object[id]) {
                _details.find('#title').text(event_object[id].title)
                _details.find('#description').text(event_object[id].description)
                _details.find('#start_date').text(event_object[id].sdate)
                _details.find('#end_date').text(event_object[id].edate)
                _details.find('#edit_event,#delete_event').attr('data-id', id)
                _details.modal('show')
            } else {
                alert("Event is undefined");
            }
        },
        eventDidMount: function(info) {
            // Do Something after events mounted
        },
        editable: true
    });

    calendar.render();

    // Form reset listener
    $('#event_form').on('reset', function() {
        $(this).find('input:hidden').val('')
        $(this).find('input:visible').first().focus()
    })

    // Edit Button
    $('#edit_event').click(function() {
        var id = $(this).attr('data-id')
        if (!!event_object[id]) {
            var _form = $('#event_form')
            console.log(String(event_object[id].start_datetime), String(event_object[id].start_datetime).replace(" ", "\\t"))
            _form.find('[name="id"]').val(id)
            _form.find('[name="title"]').val(event_object[id].title)
            _form.find('[name="description"]').val(event_object[id].description)
            _form.find('[name="start_datetime"]').val(String(event_object[id].start_datetime).replace(" ", "T"))
            _form.find('[name="end_datetime"]').val(String(event_object[id].end_datetime).replace(" ", "T"))
            $('#event_modal').modal('hide')
            _form.find('[name="title"]').focus()
        } else {
            alert("Event is undefined");
        }
    })

    // Delete Button / Deleting an Event
    $('#delete_event').click(function() {
        var id = $(this).attr('data-id')
        if (!!event_object[id]) {
            var _conf = confirm("Are you sure to delete this scheduled event?");
            if (_conf === true) {
                location.href = "./delete_schedule.php?id=" + id;
            }
        } else {
            alert("Event is undefined");
        }
    })
})
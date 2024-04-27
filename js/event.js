let calendar;
let Calendar = FullCalendar.Calendar;
let events = [];

$(function(){
  if (event_object) {
    Object.keys(event_object).map(k => {
        let row = event_object[k]
        events.push({ id: row.event_id, title: row.title, start: row.start_datetime, end: row.end_datetime });
    });
  }

  let calendarEl = document.getElementById('calendar');

  calendar = new Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'multiMonthYear,dayGridMonth,timeGridWeek,timeGridDay'
      },
      initialView: 'dayGridMonth',
      editable: false,
      selectable: true,
      dayMaxEvents: true, 
      events: events,
      eventClick: function(info){
        let details = $('#event_modal');
        let id = info.event.id;
        if(event_object[id]){
            details.find('#title').text(event_object[id].title)
            details.find('#description').text(event_object[id].description)
            details.find('#start_date').text(event_object[id].sdate)
            details.find('#end_date').text(event_object[id].edate)
            details.find('#edit_event,#delete_event').attr('data-id', id)
            details.modal('show')
        } 
        else{
            alert("Event is undefined");
        }
      },
    });

    calendar.render();

    // Form reset listener
    $('#event_form').on('reset', function() {
      $(this).find('input:hidden').val('');
      $(this).find('input:visible').first().focus();
    });

    // Edit Button
    $('#edit_event').click(function(){
      var id = $(this).attr('data-id');
      if(event_object[id]){
          let form = $('#event_form');
          console.log(String(event_object[id].start_datetime), String(event_object[id].start_datetime).replace(" ", "\\t"))
          form.find('[name="id"]').val(id)
          form.find('[name="title"]').val(event_object[id].title)
          form.find('[name="description"]').val(event_object[id].description)
          form.find('[name="start_datetime"]').val(String(event_object[id].start_datetime).replace(" ", "T"))
          form.find('[name="end_datetime"]').val(String(event_object[id].end_datetime).replace(" ", "T"))
          $('#event_modal').modal('hide')
          form.find('[name="title"]').focus()
      } else {
          alert("Event is undefined");
      }
  });

    // delete button
    $('#delete_event').click(function(){
      var id = $(this).attr('data-id')
      if (event_object[id]){
          let confirm_delete = confirm("Are you sure you want to delete this scheduled event?");
          if (confirm_delete === true){
              location.href = "./dashboard.php?id=" + id;
          }
      } 
      else{
          alert("Event is undefined");
      }
    });

});



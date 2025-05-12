window.addEventListener('pageshow', function (event) {
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
      location.reload(); // Reloads page and re-triggers PHP
    }
  });
    $(document).ready(function() {
      // Initialize DataTable
      // $('#usersTable').DataTable({
      //   paging: true,
      //   searching: true,
      //   ordering: true,
      //   lengthChange: true,
      //   pageLength: 10 
      // });


      let table = $('#usersTable').DataTable({
        processing: true,
        serverSide: false,
        ajax:  {
          url: './../../controllers/UserController.php', 
          type: 'GET',
          dataType: 'json',
          dataSrc: function(response) {
            if(response.data.length > 0){
              return response.data; 
            } else {
              alert('No accounts found.');
              return []; 
            }
         }
        },
        columns: [
          { data: 'id' },
          {
              data: null,
              render: function(data, type, row) {
                  return row.first_name + ' ' + row.last_name;
              }
          },
          { data: 'email' },
          { data: 'role_name', render: function(data) {
            return data.replace(/\b\w/g, char => char.toUpperCase()); 
            } 
          },
          { data: 'latest_login'}
        ],
        paging: true,
        searching: true,
        ordering: true,
        lengthChange: true,
        pageLength: 10
    });


    });
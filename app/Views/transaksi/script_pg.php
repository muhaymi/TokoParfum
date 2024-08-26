<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data List dengan Modal</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-5">
    <h1>Data List dengan Modal</h1>
    <input type="text" id="inputField" class="form-control" placeholder="Ketik dan tekan Enter">
    <datalist id="options">
      <!-- Options will be populated dynamically -->
    </datalist>
  </div>
  a
  <!-- Bootstrap Modal -->
  <div class="modal fade" id="optionsModal" tabindex="-1" role="dialog" aria-labelledby="optionsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="optionsModalLabel">Pilihan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <ul id="optionsList" class="list-group">
            <!-- Options will be populated dynamically -->
          </ul>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
      // Daftar pilihan
      var options = ['Pilihan 1', 'Pilihan 2', 'Pilihan 3'];

      // Memuat pilihan ke dalam datalist
      var datalist = $('#options');
      options.forEach(function(option) {
        datalist.append('<option value="' + option + '">');
      });

      // Menangani kejadian klik pada item modal
      $('#optionsList').on('click', 'li', function() {
        var selectedOption = $(this).text();
        var inputId = $('#optionsModal').data('input-id');
        $('#' + inputId).val(selectedOption);
        $('#optionsModal').modal('hide');
        $('#' + inputId).focus();
      });

      // Menangani tombol Enter di dalam input field
      $('#inputField').keydown(function(event) {
        if (event.keyCode === 13) { // 13 is the Enter key code
          var inputVal = $(this).val();
          $('#optionsList').empty();
          options.forEach(function(option) {
            if (option.toLowerCase().includes(inputVal.toLowerCase())) {
              $('#optionsList').append('<li class="list-group-item">' + option + '</li>');
            }
          });
          $('#optionsModal').data('input-id', $(this).attr('id')).modal('show');
          $(this).val('');
        }
      });

      // Menangani tombol Enter di dalam modal
      $('#optionsModal').on('keydown', function(e) {
        if (e.key === 'Enter') { // 'Enter' is the Enter key code
          var selectedOption = $('#optionsList li.active').text();
          var inputId = $('#optionsModal').data('input-id');
          if (selectedOption && inputId) {
            $('#' + inputId).val(selectedOption);
            $('#optionsModal').modal('hide');
            $('#' + inputId).focus();
          }
        }
      });

      // Menangani navigasi dengan tombol panah atas dan bawah di dalam modal
      $('#optionsModal').on('shown.bs.modal', function() {
        $('#optionsList li').first().addClass('active');
      });

      $('#optionsModal').on('keydown', function(e) {
        var active = $('#optionsList li.active');
        if (e.keyCode === 38) { // Up arrow
          var prev = active.prev();
          if (prev.length) {
            active.removeClass('active');
            prev.addClass('active');
          }
        } else if (e.keyCode === 40) { // Down arrow
          var next = active.next();
          if (next.length) {
            active.removeClass('active');
            next.addClass('active');
          }
        }
      });


      // Menangani tombol Ctrl+Enter untuk menambah input baru
      $(document).keydown(function(e) {
        if (e.ctrlKey && e.keyCode === 13) { // Ctrl+Enter
          e.preventDefault(); // Prevent default behavior (showing modal)
          var newInputId = 'inputField_' + $('.container input').length; // Generate unique ID for new input
          $('.container').append('<input type="text" id="' + newInputId + '" class="form-control mt-2 new-input" placeholder="Ketik dan tekan Enter">');
          // Menangani tombol Enter di dalam input baru
          $('#' + newInputId).keydown(function(event) {
            if (event.keyCode === 13) { // 13 is the Enter key code
              var inputVal = $(this).val();
              $('#optionsList').empty();
              options.forEach(function(option) {
                if (option.toLowerCase().includes(inputVal.toLowerCase())) {
                  $('#optionsList').append('<li class="list-group-item">' + option + '</li>');
                }
              });
              $('#optionsModal').data('input-id', $(this).attr('id')).modal('show');
              $(this).val('');
            }
          });
        }
      });
    });
  </script>
</body>

</html>
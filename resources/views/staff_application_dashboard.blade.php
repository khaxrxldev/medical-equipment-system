<!DOCTYPE html>
<html lang="en">
<head>
  @include('section.head')
  <script>
    $(function() {
      $('.selection.dropdown.condition')
        .dropdown()
      ;
      $('#datatable').DataTable({
        "paging": false,
        "ordering": true,
        "searching": true,
        "info": false,
        "language": {
          "search": ""
        }
      });

      getTable();
    });

    function getTable() {
      $('#datatable').DataTable().clear().destroy();

      $.ajax({
        type: 'GET',
        url: `/applications`
      }).then(function(res) {
        for (let application of res.data) {
          let returnButton = `<button class="ui right labeled icon brown button" onclick="returnPrompt('${application.returnId}')"><i class="info icon"></i>Pemulangan</button>`;

          let evidenceButton = '';
          if (application.returnCondition) {
            evidenceButton = `<button class="ui right labeled icon teal button" onclick="evidencePrompt('${application.returnId}')"><i class="expand alternate icon"></i>Bukti</button>`;
          }

          $('#datatable > tbody:last').append($('<tr>')
            .append($('<td>').append(application.clientName))
            .append($('<td>').append(application.equipmentName))
            .append($('<td>').append(`<a class="ui ${application.applicationColor} label">${application.applicationStatus}</a>`))
            .append($('<td>').append(`<a class="ui ${application.paymentColor} label">${application.paymentStatus}</a>`))
            .append($('<td>').append(returnButton).append(evidenceButton))
          );
        }

        $('#datatable').DataTable({
          "paging": false,
          "ordering": true,
          "searching": true,
          "info": false,
          "language": {
            "search": ""
          }
        });
      });
    }
  </script>
</head>
<body>
  @include('section.staff_top_nav')
  <div>
    <div class="ui visible left vertical sidebar menu bg-primary-almond">
      <a class="item h-100px" href="/staff_application_dashboard"></a>
      <a class="item active" href="/staff_application_dashboard">
        Permohonan Sewaan
      </a>
      <a class="item" href="/staff_history_dashboard">
        Sejarah Sewaan
      </a>
    </div>
    <div class="pusher border-none sidenav-content bg-primary-grey">
      <div class=" border-bottom content-header">
        <div class="content-small-header border-right"></div>
        <div class="content-large-header">
          <h2>PERMOHONAN SEWAAN</h2>
        </div>
      </div>
      <div class="p-2em">
        <div class="ui segment" style="overflow-x: scroll">
          <table id="datatable" class="display">
            <thead>
              <tr>
                <th>Nama Penuh</th>
                <th>Peralatan</th>
                <th>Status Permohonan</th>
                <th>Status Pembayaran</th>
                <th>Tindakan</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <form class="ui tiny modal return" id="returnFormId" method="post" enctype="multipart/form-data">
    <div class="header bg-primary-grey">Maklumat Pemulangan</div>
    <div class="content bg-primary-grey">
      <div class="ui form info">
        <div class="ui red message" id="returnMessageId"></div>
        <input type="hidden" name="returnId" id="returnId">
        <div class="field">
          <label>Tarikh Pemulangan</label>
          <input type="date" name="returnDate">
        </div>
        <div class="field">
          <label>Keadaan Peralatan</label>
          <div class="ui selection dropdown condition">
            <input type="hidden" name="returnCondition">
            <i class="dropdown icon"></i>
            <div class="text" id="returnCondition"></div>
            <div class="menu">
              <div class="item" data-value="BAIK">BAIK</div>
              <div class="item" data-value="ROSAK">ROSAK</div>
            </div>
          </div>
        </div>
        <div class="field">
          <label>Bukti Pemulangan</label>
          <input type="file" name="returnEvidence" id="returnEvidence" accept="image/jpeg, image/png">
        </div>
      </div>
    </div>
    <div class="actions bg-primary-grey">
      <button onclick="closeReturnMessage();" type="button" class="ui right labeled icon clear deny red button">
        <i class="close icon"></i>
        Batal
      </button>
      <button type="submit" class="ui right labeled icon green button">
        <i class="checkmark icon"></i>
        Simpan
      </button>
    </div>
  </form>
  <div class="ui small modal evidence">
    <div class="header bg-primary-grey">Bukti Pemulangan</div>
    <div class="scrolling content">
      <img id="returnEvidenceId" alt="Return Evidence">
    </div>
    <div class="actions">
      <button onclick="resetEvidencePrompt()" type="button" class="ui right labeled icon deny button">
        <i class="close icon"></i>
        Tutup
      </button>
      <a id="returnEvidenceDownloadId" class="ui right labeled icon blue button">
        <i class="arrow down icon"></i>
        Muat Turun
      </a>
    </div>
  </div>
  @include('section.staff_modal')
  @include('section.staff_modal_script')
  <script>
    $('#returnMessageId').hide();

    $('.ui.tiny.modal.return#returnFormId').form({
      fields: {
        returnDate : 'empty',
        returnCondition : 'empty',
        returnEvidence : 'empty',
      }
    });

    function returnPrompt(returnId) {
      $.ajax({
				type: 'GET',
				url: `/return/${returnId}`
			}).then(function(res) {
        onSetForm('returnFormId', res.data);
        $('#returnCondition').html(res.data.returnCondition);

        $('.ui.modal.return')
          .modal('setting', 'closable', false)
          .modal('show')
        ;
			});
    }

    $('#returnFormId').on('submit', function(event) {
      console.log("test ")
      event.preventDefault();
      
      let formData = new FormData(this);

      const maxSize = 2 * 1024 * 1024;
      let fileInput = $('#returnFormId #returnEvidence')[0].files[0];
      
      if (fileInput) {
        if (fileInput.size > maxSize) {
          $('#returnMessageId').show();
          $('#returnMessageId').html('Saiz gambar melebihi 2MB. Sila pilih gambar dengan saiz yang lebih kecil.');
        } else {
          $('#returnMessageId').hide();
          $('#returnMessageId').html('');

          if ($('.ui.tiny.modal.return#returnFormId').form('is valid')) {
            $.ajax({
              url: '/return/update',
              method: 'POST',
              data: formData,
              contentType: false,
              processData: false,
              success: function(res) {
                if (res) {
                  getTable();
                  $('#returnFormId').form('reset');

                  $('.ui.modal.return')
                    .modal('hide')
                  ;
                } else {
                  $('#returnMessageId').show();
                  $('#returnMessageId').html("Pemulangan Gagal.");
                }
              },
              error: function(err) {
                $('#returnMessageId').show();
                $('#returnMessageId').html("Pemulangan Gagal.");
                console.log('error: ' + err);
              }
            });
          }
        }
      }
    });

    function closeReturnMessage() {
      $('#returnMessageId').hide();
      $('#returnMessageId').html('');
    }

    function evidencePrompt(returnId) {
      $.ajax({
        type: 'GET',
        url: '/return/file/' + returnId
      }).then(function(res) {
        $('#returnEvidenceId').attr('src', `data:image/jpeg;base64,${res.data}`);
        $('#returnEvidenceDownloadId').attr('href', `data:image/jpeg;base64,${res.data}`);
        $('#returnEvidenceDownloadId').attr('download', 'Bukti Pemulangan');

        $('.ui.small.modal.evidence')
          .modal('show')
        ;
      });
    }

    function resetEvidencePrompt() {
      $('#returnEvidenceId').attr('src', '');
      $('#returnEvidenceDownloadId').attr('href', '');
      $('#returnEvidenceDownloadId').attr('download', '');
    }
  </script>
</body>
</html>
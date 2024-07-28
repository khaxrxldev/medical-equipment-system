<!DOCTYPE html>
<html lang="en">
<head>
  @include('section.head') 
  <script>
    $(function() {
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
        url: `/clients`
      }).then(function(res) {
        for (let client of res.data) {
          let detailButton = `<button class="ui right labeled icon olive button" onclick="detailPrompt('${client.clientId}')"><i class="info icon"></i>Butiran</button>`;
          let deleteButton = `<button class="ui right labeled icon orange button" onclick="deletePrompt('${client.clientId}')"><i class="eraser icon"></i>Hapus</button>`;

          $('#datatable > tbody:last').append($('<tr>')
            .append($('<td>').append(client.clientIcNumber))
            .append($('<td>').append(client.clientName))
            .append($('<td>').append(client.clientEmail))
            .append($('<td>').append(client.clientPhoneNo))
            .append($('<td>').append(client.clientMembership))
            .append($('<td>').append(detailButton).append(deleteButton))
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
  @include('section.admin_top_nav')
  <div>
    <div class="ui visible left vertical sidebar menu bg-primary-almond">
      <a class="item h-100px" href="/admin_dashboard"></a>
      <a class="item" href="/admin_dashboard">
        Laman Utama
      </a>
      <a class="item" href="/admin_staff_dashboard">
        Petugas
      </a>
      <a class="item active" href="/admin_customer_dashboard">
        Pelanggan
      </a>
      <a class="item" href="/admin_equipment_dashboard">
        Peralatan
      </a>
      <a class="item" href="/admin_application_dashboard">
        Permohonan Sewaan
      </a>
    </div>
    <div class="pusher border-none sidenav-content bg-primary-grey">
      <div class=" border-bottom content-header">
        <div class="content-small-header border-right"></div>
        <div class="content-large-header">
          <h2>PELANGGAN</h2>
        </div>
      </div>
      <div class="p-2em">
        <div class="ui segment" style="overflow-x: scroll">
          <table id="datatable" class="display">
            <thead>
              <tr>
                <th>Nombor KP</th>
                <th>Nama Penuh</th>
                <th>E-mel</th>
                <th>Nombor Telefon</th>
                <th>Keahlian</th>
                <th>Tindakan</th>
              </tr>
            </thead>
            <tbody></tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
  <form class="ui modal detail" id="detailFormId" method="post" enctype="multipart/form-data">
    <div class="header bg-primary-grey">Maklumat Pelanggan</div>
    <div class="content bg-primary-grey">
      <div class="ui form info">
        <div class="two fields">
          <div class="field">
            <label>Nombor KP</label>
            <input type="text" readonly name="clientIcNumber">
          </div>
          <div class="field">
            <label>Nama Penuh</label>
            <input type="text" readonly name="clientName">
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <label>E-mel</label>
            <input type="email" readonly name="clientEmail">
          </div>
          <div class="field">
            <label>Nombor Telefon</label>
            <input type="text" readonly name="clientPhoneNo">
          </div>
        </div>
        <div class="field">
          <label>Alamat</label>
          <textarea class="resize-none" rows="3" readonly name="clientAddress"></textarea>
        </div>
        <div class="field">
          <label>Pekerjaan</label>
          <input type="text" readonly name="clientJob">
        </div>
        <div class="two fields">
          <div class="field">
            <label>Jenis Kanser</label>
            <input type="text" readonly name="clientCancerType">
          </div>
          <div class="field">
            <label>Keahlian</label>
            <input type="text" readonly name="clientMembership">
          </div>
        </div>
      </div>
    </div>
    <div class="actions bg-primary-grey">
      <button type="button" class="ui right labeled icon deny button">
        <i class="close icon"></i>
        Tutup
      </button>
    </div>
  </form>
  <div class="ui tiny modal delete">
    <div class="content">
      <input type="hidden" id="deleteInputId">
      Adakah anda pasti untuk <b>hapuskan</b> data berikut?
    </div>
    <div class="actions">
      <button type="button" class="ui right labeled icon deny red button">
        <i class="close icon"></i>
        Batal
      </button>
      <button type="button" onclick="deleteData()" class="ui right labeled icon green button">
        <i class="checkmark icon"></i>
        Hapus
      </button>
    </div>
  </div>
  @include('section.staff_modal')
  @include('section.staff_modal_script')
  <script>
    function deletePrompt(deleteId) {
      $('#deleteInputId').val(deleteId);
      $('.ui.tiny.modal.delete')
        .modal('show')
      ;
    }

    function deleteData() {
      $.ajax({
        type: 'DELETE',
        url: `/client/${$('#deleteInputId').val()}`
      }).then(function(res) {
        if (res.data) {
          getTable();

          $('.ui.tiny.modal.delete')
            .modal('hide')
          ;
        }
      });
    }

    function detailPrompt(staffId) {
      $.ajax({
        type: 'GET',
        url: '/client/' + staffId
      }).then(function(res) {
        onSetForm('detailFormId', res.data);

        $('.ui.modal.detail')
          .modal('show')
        ;
      });
    }
  </script>
</body>
</html>
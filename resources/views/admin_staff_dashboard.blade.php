<!DOCTYPE html>
<html lang="en">
<head>
  @include('section.head')
  <script>
    $(function() {
      $('.selection.dropdown')
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
        url: `/staffs`
      }).then(function(res) {
        for (let staff of res.data) {
          let detailButton = `<button class="ui right labeled icon olive button" onclick="detailPrompt('${staff.staffId}')"><i class="info icon"></i>Butiran</button>`;
          let deleteButton = `<button class="ui right labeled icon orange button" onclick="deletePrompt('${staff.staffId}')"><i class="eraser icon"></i>Hapus</button>`;

          $('#datatable > tbody:last').append($('<tr>')
            .append($('<td>').append(staff.staffIcNumber))
            .append($('<td>').append(staff.staffName))
            .append($('<td>').append(staff.staffEmail))
            .append($('<td>').append(staff.staffPhoneNo))
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
      <a class="item active" href="/admin_staff_dashboard">
        Petugas
      </a>
      <a class="item" href="/admin_customer_dashboard">
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
          <h2>PETUGAS</h2>
        </div>
      </div>
      <div class="p-2em">
        <div class="ui top attached segment">
          <button class="ui right labeled violet icon button" onclick="insert()">
            <i class="plus icon"></i>
            Daftar Baru
          </button>
        </div>
        <div class="ui bottom attached segment" style="overflow-x: scroll">
          <table id="datatable" class="display">
            <thead>
              <tr>
                <th>Nombor KP</th>
                <th>Nama Penuh</th>
                <th>E-mel</th>
                <th>Peranan</th>
                <th>Tindakan</th>
              </tr>
            </thead>
            <tbody></tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
  <form class="ui modal insert" id="insertFormId" method="post" enctype="multipart/form-data">
    <div class="header bg-primary-grey">Maklumat Akaun</div>
    <div class="content bg-primary-grey">
      <div class="ui form info">
        <div class="ui red message" id="insertMessageId"></div>
        <div class="two fields">
          <div class="field">
            <label>Nombor Kad Pengenalan</label>
            <input type="text" placeholder="sila isi nombor kad pengenalan - e.g: 000000-00-0000" name="staffIcNumber">
          </div>
          <div class="field">
            <label>Nama Penuh</label>
            <input type="text" placeholder="sila isi nama penuh" name="staffName">
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <label>E-mel</label>
            <input type="email" placeholder="sila isi alamat e-mel" name="staffEmail">
          </div>
          <div class="field">
            <label>Nombor Telefon</label>
            <input type="text" placeholder="sila isi nombor telefon - e.g: 000-00000000" name="staffPhoneNo">
          </div>
        </div>
        <div class="field">
          <label>Alamat</label>
          <textarea class="resize-none" rows="3" name="staffAddress"></textarea>
        </div>
        <div class="field">
          <label>Peranan</label>
          <div class="ui selection dropdown profile role">
            <input type="hidden" name="staffRole">
            <i class="dropdown icon"></i>
            <div class="text" id="staffRole"></div>
            <div class="menu">
              <div class="item" data-value="PETUGAS">PETUGAS</div>
              <div class="item" data-value="PENTADBIR">PENTADBIR</div>
            </div>
          </div>
        </div>
        <div class="field">
          <label>Kata Laluan</label>
          <input type="password" placeholder="sila isi kata laluan" name="staffPassword">
        </div>
        <div class="ui info message">
          <div class="header">Garis Panduan</div>
          <ul class="list">
            <li>Perlu mengandungi lebih daripada 8 karakter.</li>
            <li>Perlu mengandungi gabungan huruf, nombor & simbol.</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="actions bg-primary-grey">
      <button type="button" class="ui right labeled icon clear deny red button">
        <i class="close icon"></i>
        Batal
      </button>
      <button type="button" class="ui right labeled icon reset yellow button">
        <i class="refresh icon"></i>
        Set Semula
      </button>
      <button type="submit" class="ui right labeled icon green button">
        <i class="checkmark icon"></i>
        Simpan
      </button>
    </div>
  </form>
  <form class="ui modal detail" id="detailFormId" method="post" enctype="multipart/form-data">
    <div class="header bg-primary-grey">Maklumat Akaun</div>
    <div class="content bg-primary-grey">
      <div class="ui form info">
        <div class="two fields">
          <div class="field">
            <label>Nombor KP</label>
            <input type="text" readonly name="staffIcNumber">
          </div>
          <div class="field">
            <label>Nama Penuh</label>
            <input type="text" readonly name="staffName">
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <label>E-mel</label>
            <input type="email" readonly name="staffEmail">
          </div>
          <div class="field">
            <label>Nombor Telefon</label>
            <input type="text" readonly name="staffPhoneNo">
          </div>
        </div>
        <div class="field">
          <label>Alamat</label>
          <textarea class="resize-none" rows="3" readonly name="staffAddress"></textarea>
        </div>
        <div class="field">
          <label>Peranan</label>
          <input type="text" readonly name="staffRole">
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
    onUpperCaseForm('insertFormId');
    $('#insertMessageId').hide();

    $('.ui.modal.insert#insertFormId').form({
      fields: {
        staffIcNumber : {
          identifier: 'staffIcNumber',
          rules: [{
            type: 'regExp[/^\\d{6}-\\d{2}-\\d{4}$/]',
          }]
        },
        staffName : 'empty',
        staffEmail : 'empty',
        staffPhoneNo : {
          identifier: 'staffPhoneNo',
          rules: [{
            type: 'regExp[/^\\d{3}-\\d{7,8}$/]',
          }]
        },
        staffAddress : 'empty',
        staffRole : 'empty',
        staffPassword : 'empty',
      }
    });

    function insert() {
      $('.ui.modal.insert')
        .modal('setting', 'closable', false)
        .modal('show')
      ;
    }

    $('#insertFormId').on('submit', function(event) {
      event.preventDefault();
      
      if ($('.ui.modal.insert#insertFormId').form('is valid')) {
        $.ajax({
          url: '/staff',
          method: 'POST',
          data: $('#insertFormId').serialize(),
          success: function(res) {
            if (res) {
              getTable();
              $('#insertFormId').form('reset');
              
              $('.ui.modal.insert')
                .modal('hide')
              ;
            } else {
              $('#insertMessageId').show();
              $('#insertMessageId').html("Kemasukan Data Gagal.");
            }
          },
          error: function(err) {
            $('#insertMessageId').show();
            $('#insertMessageId').html("Kemasukan Data Gagal.");
            console.log('error: ' + err);
          }
        });
      }
    });

    function detailPrompt(staffId) {
      $.ajax({
        type: 'GET',
        url: '/staff/' + staffId
      }).then(function(res) {
        onSetForm('detailFormId', res.data);

        $('.ui.modal.detail')
          .modal('show')
        ;
      });
    }

    function deletePrompt(deleteId) {
      $('#deleteInputId').val(deleteId);

      $('.ui.tiny.modal.delete')
        .modal('show')
      ;
    }
    
    function deleteData() {
      $.ajax({
				type: 'DELETE',
				url: `/staff/${$('#deleteInputId').val()}`
			}).then(function(res) {
        if (res.data) {
          getTable();

          $('.ui.tiny.modal.delete')
            .modal('hide')
          ;
        }
			});
    }
  </script>
</body>
</html>
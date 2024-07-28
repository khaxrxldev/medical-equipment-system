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
        url: `/equipments`
      }).then(function(res) {
        for (let equipment of res.data) {
          let updateButton = `<button class="ui right labeled icon olive button" onclick="updatePrompt('${equipment.equipmentId}')"><i class="pen icon"></i>Kemaskini</button>`;
          let deleteButton = `<button class="ui right labeled icon orange button" onclick="deletePrompt('${equipment.equipmentId}')"><i class="eraser icon"></i>Hapus</button>`;
          let fileButton = `<button class="ui right labeled icon yellow button" onclick="filePrompt('${equipment.equipmentId}', '${equipment.equipmentName}')"><i class="expand alternate icon"></i>Gambar</button>`;

          $('#datatable > tbody:last').append($('<tr>')
            .append($('<td>').append(equipment.equipmentName))
            .append($('<td>').append(equipment.equipmentBuyDate))
            .append($('<td>').append(equipment.equipmentBuyPrice))
            // .append($('<td>').append(equipment.equipmentRentPrice))
            .append($('<td>').append(equipment.equipmentQuantity))
            .append($('<td>').append(equipment.equipmentSponsor))
            .append($('<td>').append(updateButton).append(deleteButton).append(fileButton))
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
      <a class="item" href="/admin_customer_dashboard">
        Pelanggan
      </a>
      <a class="item active" href="/admin_equipment_dashboard">
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
          <h2>PERALATAN PERUBATAN</h2>
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
                <th>Nama</th>
                <th>Tarikh Beli</th>
                <th>Harga Belian</th>
                <!-- <th>Harga Sewaan</th> -->
                <th>Kuantiti</th>
                <th>Penaja</th>
                <th>Tindakan</th>
              </tr>
            </thead>
            <tbody></tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
  <form class="ui modal insert" id="insertFormId" enctype="multipart/form-data">
    <div class="header bg-primary-grey">Maklumat Peralatan</div>
    <div class="content bg-primary-grey">
      <div class="ui form info">
        <div class="ui red message" id="insertMessageId"></div>
        <input type="hidden" name="equipmentId" id="equipmentId">
        <div class="field">
          <label>Nama Peralatan</label>
          <input type="text" placeholder="sila isi nama peralatan" name="equipmentName">
        </div>
        <div class="two fields">
          <div class="field">
            <label>Harga Belian</label>
            <div class="ui left labeled input">
              <div class="ui basic label">RM</div>
              <input type="text" placeholder="sila isi harga belian - e.g: 10.00" name="equipmentBuyPrice">
            </div>
          </div>
          <!-- <div class="field">
            <label>Harga Sewaan</label>
            <div class="ui left labeled input">
              <div class="ui basic label">RM</div>
              <input type="text" placeholder="sila isi harga sewaan - e.g: 10.00" name="equipmentRentPrice">
            </div>
          </div> -->
          <div class="field">
            <label>Kuantiti</label>
            <input type="number" placeholder="sila isi kuantiti" name="equipmentQuantity">
          </div>
        </div>
        <div class="three fields">
          <div class="field">
            <label>Tarikh Beli</label>
            <input type="date" placeholder="sila isi tarikh beli" name="equipmentBuyDate">
          </div>
          <div class="field">
            <label>Penaja</label>
            <input type="text" placeholder="sila isi nama penaja" name="equipmentSponsor">
          </div>
          <div class="field">
            <label>Gambar</label>
            <input type="file" name="equipmentImage" id="equipmentImage" accept="image/jpeg, image/png">
          </div>
        </div>
      </div>
    </div>
    <div class="actions bg-primary-grey">
      <button onclick="closeInsertMessage();" type="button" class="ui right labeled icon clear deny red button">
        <i class="close icon"></i>
        Batal
      </button>
      <button onclick="resetInsertForm();" type="button" class="ui right labeled icon reset yellow button">
        <i class="refresh icon"></i>
        Set Semula
      </button>
      <button type="submit" class="ui right labeled icon green button">
        <i class="checkmark icon"></i>
        Simpan
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
  <div class="ui small modal file">
    <div class="header bg-primary-grey">Gambar Peralatan</div>
    <div class="scrolling content">
      <img id="equipmentImageId" alt="Equipment Image">
    </div>
    <div class="actions">
      <button onclick="resetFilePrompt()" type="button" class="ui right labeled icon deny button">
        <i class="close icon"></i>
        Tutup
      </button>
      <a id="equipmentImageDownloadId" class="ui right labeled icon blue button">
        <i class="arrow down icon"></i>
        Muat Turun
      </a>
    </div>
  </div>
  @include('section.staff_modal')
  @include('section.staff_modal_script')
  <script>
    onUpperCaseForm('insertFormId');
    $('#insertMessageId').hide();

    $('.ui.modal.insert#insertFormId').form({
      fields: {
        equipmentName : 'empty',
        equipmentBuyPrice : {
          identifier: 'equipmentBuyPrice',
          rules: [{
            type: 'regExp[/^\\d+(\\.\\d{1,2})?$/]',
          }]
        },
        // equipmentRentPrice : {
        //   identifier: 'equipmentRentPrice',
        //   rules: [{
        //     type: 'regExp[/^\\d+(\\.\\d{1,2})?$/]',
        //   }]
        // },
        equipmentQuantity : 'empty',
        equipmentBuyDate : 'empty',
        equipmentSponsor : 'empty',
        equipmentImage : 'empty',
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
      
      let formData = new FormData(this);

      const maxSize = 2 * 1024 * 1024;
      let fileInput = $('#insertFormId #equipmentImage')[0].files[0];
      
      if (fileInput) {
        if (fileInput.size > maxSize) {
          $('#insertMessageId').show();
          $('#insertMessageId').html('Saiz gambar melebihi 2MB. Sila pilih gambar dengan saiz yang lebih kecil.');
        } else {
          $('#insertMessageId').hide();
          $('#insertMessageId').html('');

          if ($('.ui.modal.insert#insertFormId').form('is valid')) {
            $.ajax({
              url: $('#insertFormId #equipmentId').val() ? '/equipment/update': '/equipment',
              method: 'POST',
              data: formData,
              contentType: false,
              processData: false,
              success: function(res) {
                if (res) {
                  getTable();
                  $('#insertFormId').form('reset');
                  
                  $('.ui.modal.insert')
                    .modal('hide')
                  ;
                } else {
                  $('#insertMessageId').show();
                  $('#insertMessageId').html('Kemasukan Data Gagal.');
                }
              },
              error: function(err) {
                $('#insertMessageId').show();
                $('#insertMessageId').html('Kemasukan Data Gagal.');
                console.log('error: ' + err);
              }
            });
          }
        }
      }
    });

    function resetInsertForm() {
      if ($('#equipmentId').val()) {
        $.ajax({
          type: 'GET',
          url: '/equipment/' + $('#equipmentId').val()
        }).then(function(res) {
          onSetForm('insertFormId', res.data);
          closeInsertMessage();
        });
      }
    }

    function closeInsertMessage() {
      $('#insertMessageId').hide();
      $('#insertMessageId').html('');
    }

    function updatePrompt(equipmentId) {
      $.ajax({
        type: 'GET',
        url: '/equipment/' + equipmentId
      }).then(function(res) {
        onSetForm('insertFormId', res.data);

        const base64Image = 'data:image/jpeg;base64,' + res.data.equipmentImage;
        const filename = res.data.equipmentName + '.jpeg';

        setFileInput(base64Image, filename, 'equipmentImage');

        $('.ui.modal.insert')
          .modal('setting', 'closable', false)
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
        url: `/equipment/${$('#deleteInputId').val()}`
      }).then(function(res) {
        if (res.data) {
          getTable();

          $('.ui.tiny.modal.delete')
            .modal('hide')
          ;
        }
      });
    }

    function filePrompt(equipmentId, equipmentName) {
      $.ajax({
        type: 'GET',
        url: '/equipment/file/' + equipmentId
      }).then(function(res) {
        $('#equipmentImageId').attr('src', `data:image/jpeg;base64,${res.data}`);
        $('#equipmentImageDownloadId').attr('href', `data:image/jpeg;base64,${res.data}`);
        $('#equipmentImageDownloadId').attr('download', equipmentName);

        $('.ui.small.modal.file')
          .modal('show')
        ;
      });
    }

    function resetFilePrompt() {
      $('#equipmentImageId').attr('src', '');
      $('#equipmentImageDownloadId').attr('href', '');
      $('#equipmentImageDownloadId').attr('download', '');
    }

    function base64ToFile(base64, filename) {
      const [metadata, data] = base64.split(',');
      const mime = metadata.match(/:(.*?);/)[1];
      const binary = atob(data);
      const array = [];
      for (let i = 0; i < binary.length; i++) {
        array.push(binary.charCodeAt(i));
      }
      return new File([new Uint8Array(array)], filename, { type: mime });
    }

    function setFileInput(base64, filename, inputId) {
      const file = base64ToFile(base64, filename);
      const dataTransfer = new DataTransfer();
      dataTransfer.items.add(file);
      document.getElementById(inputId).files = dataTransfer.files;
    }
  </script>
</body>
</html>
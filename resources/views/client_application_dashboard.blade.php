<!DOCTYPE html>
<html lang="en">
<head>
  @include('section.head')
  <script>
    $(function() {
      $('#clientId').val(sessionStorage.getItem('user_id'));

      $.ajax({
        type: 'GET',
        url: '/equipments'
      }).then(function(res) {
        if (res.data.length) {
          res.data.forEach((element, index, array) => {
            $('#equipmentOptionId').append(`<div class="item" data-value="${element.equipmentId}">${element.equipmentName}</div>`);
          });
        }
      });

      $('.selection.dropdown.equipment')
        .dropdown()
      ;
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
				url: `/applications/client/${sessionStorage.getItem('user_id')}`
			}).then(function(res) {
				for (let application of res.data) {
          let detailButton = `<button class="ui right labeled icon olive button" onclick="detailPrompt('${application.applicationId}')"><i class="info icon"></i>Butiran</button>`;
          let deleteButton = `<button class="ui right labeled icon orange button" onclick="deletePrompt('${application.applicationId}')"><i class="eraser icon"></i>Hapus</button>`;
          let medicLetterButton = `<button class="ui right labeled icon purple button" onclick="medicalLetterPrompt('${application.applicationId}')"><i class="expand alternate icon"></i>Surat Sakit</button>`;
          
          let paymentButton = '';
          if (application.applicationStatus === 'BERJAYA' && application.paymentStatus === 'BELUM DIBAYAR') {
            paymentButton = `<button class="ui right labeled icon teal button" onclick="paymentPrompt('${application.paymentId}')"><i class="credit card outline icon"></i>Bayar</button>`;
          }
          let receiptButton = '';
          if (application.paymentStatus !== 'BELUM DIBAYAR') {
            receiptButton = `<button class="ui right labeled icon teal button" onclick="receiptPrompt('${application.paymentId}')"><i class="expand alternate icon"></i>Resit</button>`;
          }

					$('#datatable > tbody:last').append($('<tr>')
						.append($('<td>').append(application.clientName))
						.append($('<td>').append(application.equipmentName))
						.append($('<td>').append(`<a class="ui ${application.applicationColor} label">${application.applicationStatus}</a>`))
						.append($('<td>').append(`<a class="ui ${application.paymentColor} label">${application.paymentStatus}</a>`))
						.append($('<td>').append(paymentButton).append(detailButton).append(medicLetterButton).append(receiptButton))
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
  @include('section.client_top_nav')
  <div>
    <div class="ui visible left vertical sidebar menu bg-primary-almond">
      <a class="item h-100px" href="/client_admin_dashboard"></a>
      <a class="item" href="/client_admin_dashboard">
        Laman Utama
      </a>
      <a class="item active" href="/client_application_dashboard">
        Permohonan Sewaan
      </a>
      <a class="item" href="/client_history_dashboard">
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
        <div class="ui top attached segment">
          <button class="ui right labeled violet icon button" onclick="insertPrompt()">
            <i class="plus icon"></i>
            Permohonan Baru
          </button>
        </div>
        <div class="ui bottom attached segment" style="overflow-x: scroll">
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
  <form class="ui modal insert" id="insertFormId" method="post" enctype="multipart/form-data">
    <div class="header bg-primary-grey">Maklumat Permohonan</div>
    <div class="content bg-primary-grey">
      <div class="ui form info">
        <div class="ui red message" id="insertMessageId"></div>
        <input type="hidden" name="clientId" id="clientId">
        <input type="hidden" name="applicationStatus" value="DALAM PROSES">
        <div class="two fields">
          <div class="field">
            <label>Peralatan</label>
            <div class="ui selection dropdown equipment">
              <input type="hidden" name="equipmentId">
              <i class="dropdown icon"></i>
              <div class="default text">sila pilih peralatan</div>
              <div class="menu" id="equipmentOptionId"></div>
            </div>
          </div>
          <div class="field">
            <label>Surat Sakit</label>
            <input type="file" name="applicationMedicLetter" id="applicationMedicLetter" accept="image/jpeg, image/png">
          </div>
        </div>
        <div class="three fields">
          <div class="field">
            <label>Tarikh Mula Sewaan</label>
            <input type="date" id="applicationStartDate" name="applicationStartDate" oninput="setMinMax()">
          </div>
          <div class="field">
            <label>Tarikh Tamat Sewaan</label>
            <input type="date" id="applicationEndDate" name="applicationEndDate" oninput="setMinMax()">
          </div>
          <div class="field">
            <label>Kuantiti</label>
            <input type="number" placeholder="sila isi kuantiti peralatan" name="applicationQuantity">
          </div>
        </div>
      </div>
    </div>
    <div class="actions bg-primary-grey">
      <button onclick="resetInsertForm()" type="button" class="ui right labeled icon deny red button">
        <i class="close icon"></i>
        Batal
      </button>
      <button type="submit" class="ui right labeled icon green button">
        <i class="checkmark icon"></i>
        Simpan
      </button>
    </div>
  </form>
  <form class="ui modal detail" id="detailFormId" method="post" enctype="multipart/form-data">
    <div class="header bg-primary-grey">Maklumat Permohonan</div>
    <div class="content bg-primary-grey">
      <div class="ui form info">
        <div class="two fields">
          <div class="field">
            <label>Peralatan</label>
            <input type="text" readonly name="equipmentName">
          </div>
          <div class="field">
            <label>Status Permohonan</label>
            <input type="text" readonly name="applicationStatus">
          </div>
        </div>
        <div class="three fields">
          <div class="field">
            <label>Kuantiti</label>
            <input type="text" readonly name="applicationQuantity">
          </div>
          <div class="field">
            <label>Tarikh Mula Sewaan</label>
            <input type="text" readonly name="applicationStartDate">
          </div>
          <div class="field">
            <label>Tarikh Tamat Sewaan</label>
            <input type="text" readonly name="applicationEndDate">
          </div>
        </div>
        <div class="three fields">
          <div class="field">
            <label>Harga Sewaan</label>
            <input type="text" readonly name="applicationRentPrice">
          </div>
          <div class="field">
            <label>Status Pembayaran</label>
            <input type="text" readonly name="paymentStatus">
          </div>
          <div class="field">
            <label>Tarikh Pembayaran</label>
            <input type="text" readonly name="paymentDate">
          </div>
        </div>
      </div>
    </div>
    <div class="actions bg-primary-grey">
      <button type="button" class="ui right labeled icon deny grey button">
        <i class="close icon"></i>
        Tutup
      </button>
    </div>
  </form>
  <form class="ui tiny modal payment" id="paymentFormId" method="post" enctype="multipart/form-data">
    <div class="header bg-primary-grey">Pembayaran</div>
    <div class="content bg-primary-grey">
      <div class="ui form info">
        <div class="ui message" id="paymentMessageId"></div>
        <input type="hidden" name="paymentId" id="paymentId">
        <input type="hidden" name="paymentDate" id="paymentDate">
        <input type="hidden" name="paymentStatus" id="paymentStatus">
        <div class="field">
          <label>Peralatan</label>
          <input type="text" readonly name="equipmentName">
        </div>
        <div class="field">
          <label>Jumlah</label>
          <input type="number" readonly name="paymentAmount">
        </div>
        <div class="field">
          <label>Resit</label>
          <input type="file" name="paymentReceipt" id="paymentReceipt" accept="image/jpeg, image/png">
        </div>
      </div>
    </div>
    <div class="actions bg-primary-grey">
      <button onclick="resetPaymentForm()" type="button" class="ui right labeled icon deny red button">
        <i class="close icon"></i>
        Batal
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
  <div class="ui small modal medical letter">
    <div class="header bg-primary-grey">Gambar Surat Sakit</div>
    <div class="scrolling content">
      <img id="applicationMedicLetterId" alt="Medical Letter">
    </div>
    <div class="actions">
      <button onclick="resetMedicalLetterPrompt()" type="button" class="ui right labeled icon deny button">
        <i class="close icon"></i>
        Tutup
      </button>
      <a id="applicationMedicLetterDownloadId" class="ui right labeled icon blue button">
        <i class="arrow down icon"></i>
        Muat Turun
      </a>
    </div>
  </div>
  <div class="ui small modal receipt">
    <div class="header bg-primary-grey">Gambar Resit</div>
    <div class="scrolling content">
      <img id="paymentReceiptId" alt="Payment Receipt">
    </div>
    <div class="actions">
      <button onclick="resetReceiptPrompt()" type="button" class="ui right labeled icon deny button">
        <i class="close icon"></i>
        Tutup
      </button>
      <a id="paymentReceiptDownloadId" class="ui right labeled icon blue button">
        <i class="arrow down icon"></i>
        Muat Turun
      </a>
    </div>
  </div>
  @include('section.client_modal')
  @include('section.client_modal_script')
  <script>
    function setMinMax() {
      $('#applicationEndDate').attr('min', $('#applicationStartDate').val());
      $('#applicationStartDate').attr('max', $('#applicationEndDate').val());
    }

    $('#insertMessageId').hide();
    $('#paymentMessageId').hide();

    $('.ui.modal.insert#insertFormId').form({
      fields: {
        clientId : 'empty',
        applicationStatus : 'empty',
        equipmentId : 'empty',
        applicationStartDate : 'empty',
        applicationEndDate : 'empty',
        applicationQuantity : 'empty',
        applicationMedicLetter : 'empty',
      }
    });

    $('.ui.tiny.modal.payment#paymentFormId').form({
      fields: {
        paymentReceipt : 'empty',
      }
    });

    function insertPrompt() {
      $('.ui.modal.insert')
        .modal('setting', 'closable', false)
        .modal('show')
      ;
    }
    
    $('#insertFormId').on('submit', function(event) {
      event.preventDefault();
      
      let formData = new FormData(this);

      const maxSize = 2 * 1024 * 1024;
      let fileInput = $('#insertFormId #applicationMedicLetter')[0].files[0];
      
      if (fileInput) {
        if (fileInput.size > maxSize) {
          $('#insertMessageId').show();
          $('#insertMessageId').html('Saiz gambar melebihi 2MB. Sila pilih gambar dengan saiz yang lebih kecil.');
        } else {
          $('#insertMessageId').hide();
          $('#insertMessageId').html('');

          if ($('.ui.modal.insert#insertFormId').form('is valid')) {
            $.ajax({
              url: '/application',
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
        }
      }
    });

    function resetInsertForm() {
      $('.ui.modal.insert#insertFormId').form('clear');
    }

    function detailPrompt(applicationId) {
      $.ajax({
				type: 'GET',
				url: `/application/${applicationId}`
			}).then(function(res) {
        onSetForm('detailFormId', res.data);

        $('.ui.modal.detail')
          .modal('show')
        ;
			});
    }

    function paymentPrompt(paymentId) {
      $.ajax({
				type: 'GET',
				url: `/payment/${paymentId}`
			}).then(function(res) {
        onSetForm('paymentFormId', res.data);

        let today = new Date();
        let formattedDate = today.toISOString().substr(0, 10);
        $('#paymentDate').val(formattedDate);
        $('#paymentStatus').val('TELAH DIBAYAR');

        $('.ui.tiny.modal.payment')
          .modal('setting', 'closable', false)
          .modal('show')
        ;
			});
    }

    function resetPaymentForm() {
      $('#paymentMessageId').hide();
    }

    $('#paymentFormId').on('submit', function(event) {
      event.preventDefault();
      
      let formData = new FormData(this);

      const maxSize = 2 * 1024 * 1024;
      let fileInput = $('#paymentFormId #paymentReceipt')[0].files[0];
      
      if (fileInput) {
        if (fileInput.size > maxSize) {
          $('#paymentMessageId').show();
          $('#paymentMessageId').html('Saiz gambar melebihi 2MB. Sila pilih gambar dengan saiz yang lebih kecil.');
        } else {
          $('#paymentMessageId').hide();
          $('#paymentMessageId').html('');
          
          if ($('.ui.tiny.modal.payment#paymentFormId').form('is valid')) {
            $.ajax({
              url: '/payment/update',
              method: 'POST',
              data: formData,
              contentType: false,
              processData: false,
              success: function(res) {
                if (res) {
                  getTable();
                  
                  $('#paymentMessageId').show();
                  $('#paymentMessageId').html("Pembayaran BERJAYA.");
                  $('#paymentMessageId').addClass('green');
                } else {
                  $('#paymentMessageId').show();
                  $('#paymentMessageId').html("Pembayaran Gagal.");
                  $('#paymentMessageId').addClass('red');
                }
              },
              error: function(err) {
                $('#paymentMessageId').show();
                $('#paymentMessageId').html("Pembayaran Gagal.");
                $('#paymentMessageId').addClass('red');
                console.log('error: ' + err);
              }
            });
          }
        }
      }
    });

    function deletePrompt(deleteId) {
      $('#deleteInputId').val(deleteId);
      $('.ui.tiny.modal.delete')
        .modal('setting', 'closable', false)
        .modal('show')
      ;
    }
    
    function deleteData() {
      $.ajax({
				type: 'DELETE',
				url: `/application/${$('#deleteInputId').val()}`
			}).then(function(res) {
        if (res.data) {
          getTable();

          $('.ui.tiny.modal.delete')
            .modal('hide')
          ;
        }
			});
    }

    function medicalLetterPrompt(applicationId) {
      $.ajax({
        type: 'GET',
        url: '/application/file/' + applicationId
      }).then(function(res) {
        $('#applicationMedicLetterId').attr('src', `data:image/jpeg;base64,${res.data}`);
        $('#applicationMedicLetterDownloadId').attr('href', `data:image/jpeg;base64,${res.data}`);
        $('#applicationMedicLetterDownloadId').attr('download', 'Surat Sakit');

        $('.ui.small.modal.medical.letter')
          .modal('show')
        ;
      });
    }

    function resetMedicalLetterPrompt() {
      $('#applicationMedicLetterId').attr('src', '');
      $('#applicationMedicLetterDownloadId').attr('href', '');
      $('#applicationMedicLetterDownloadId').attr('download', '');
    }

    function receiptPrompt(paymentId) {
      $.ajax({
        type: 'GET',
        url: '/payment/file/' + paymentId
      }).then(function(res) {
        $('#paymentReceiptId').attr('src', `data:image/jpeg;base64,${res.data}`);
        $('#paymentReceiptDownloadId').attr('href', `data:image/jpeg;base64,${res.data}`);
        $('#paymentReceiptDownloadId').attr('download', 'Surat Sakit');

        $('.ui.small.modal.receipt')
          .modal('show')
        ;
      });
    }

    function resetReceiptPrompt() {
      $('#paymentReceiptId').attr('src', '');
      $('#paymentReceiptDownloadId').attr('href', '');
      $('#paymentReceiptDownloadId').attr('download', '');
    }
  </script>
</body>
</html>
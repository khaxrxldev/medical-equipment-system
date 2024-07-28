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
				url: `/returns/client/${sessionStorage.getItem('user_id')}`
			}).then(function(res) {
				for (let returnData of res.data) {
          $('#datatable > tbody:last').append($('<tr>')
						.append($('<td>').append(returnData.clientIcNumber))
						.append($('<td>').append(returnData.clientName))
						.append($('<td>').append(returnData.equipmentName))
						.append($('<td>').append(returnData.returnDate))
						.append($('<td>').append(`<a class="ui ${returnData.returnColor} label">${returnData.returnCondition}</a>`))
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
      <a class="item" href="/client_application_dashboard">
        Permohonan Sewaan
      </a>
      <a class="item active" href="/client_history_dashboard">
        Sejarah Sewaan
      </a>
    </div>
    <div class="pusher border-none sidenav-content bg-primary-grey">
      <div class=" border-bottom content-header">
        <div class="content-small-header border-right"></div>
        <div class="content-large-header">
          <h2>SEJARAH SEWAAN</h2>
        </div>
      </div>
      <div class="p-2em">
        <div class="ui segment" style="overflow-x: scroll">
          <table id="datatable" class="display">
            <thead>
              <tr>
                <th>Nombor KP</th>
                <th>Nama Penuh</th>
                <th>Peralatan</th>
                <th>Tarikh Pemulangan</th>
                <th>Keadaan</th>
              </tr>
            </thead>
            <tbody></tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
  @include('section.client_modal')
  @include('section.client_modal_script')
  <script></script>
</body>
</html>
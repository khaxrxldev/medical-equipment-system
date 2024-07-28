<!DOCTYPE html>
<html lang="en">
<head>
  @include('section.head') 
  <script>
    $(function() {
      displayCurrentTime('displayDate');
      displayDashboard();
      displayNotification();
    });

    function displayCurrentTime(htmlClass) {
      const currentDate = new Date();

      const optionsDate = { 
        day: '2-digit', 
        month: 'short', 
        year: 'numeric' 
      };

      const optionsTime = { 
        hour: '2-digit', 
        minute: '2-digit', 
        hour12: true 
      };

      const formattedDate = currentDate.toLocaleDateString('en-GB', optionsDate);
      const formattedTime = currentDate.toLocaleTimeString('en-US', optionsTime);

      $(`.${htmlClass}`).html(`data sehingga ${formattedDate}, ${formattedTime}`);
    }

    function displayDashboard() {
      $.ajax({
        type: 'GET',
        url: '/dashboard/admin'
      }).then(function(res) {
        $('#totalStaff').html(res.data.totalStaff);
        $('#totalClient').html(res.data.totalClient);
        $('#totalEquipment').html(res.data.totalEquipment);
        $('#totalApplication').html(res.data.totalApplication);
      });
    }

    function displayNotification() {
      $.ajax({
        type: 'GET',
        url: '/dashboard/admin/noti'
      }).then(function(res) {
        if (res.data.length) {
          res.data.forEach((element, index, array) => {

            if (element.adminNotiStatus === 0) {
              $.toast({
                displayTime: 10000,
                message: 'Anda mempunyai permohonan baru. <a href="/admin_application_dashboard" style="text-decoration: underline;">Lihat</a>',
                class : 'yellow',
                className: {
                  toast: 'ui message'
                }
              });
            }

            var $segment = $('<div>', { class: 'ui segment' });

            var $paragraph = $('<p>').html('Anda mempunyai permohonan baru. <a href="/admin_application_dashboard" style="text-decoration: underline;">Lihat</a>');
            $segment.append($paragraph);

            $('#segmentContainer').append($segment);
          })
        }
      });
    }
  </script>
</head>
<body>
  @include('section.admin_top_nav')
  <div>
    <div class="ui visible left vertical sidebar menu bg-primary-almond">
      <a class="item h-100px" href="/admin_dashboard"></a>
      <a class="item active" href="/admin_dashboard">
        Laman Utama
      </a>
      <a class="item" href="/admin_staff_dashboard">
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
          <h2>LAMAN UTAMA</h2>
        </div>
      </div>
      <div class="p-2em">
        <div class="grid-4-equal">
          <div>
            <div class="ui card w-100pct">
              <div class="content">
                <div class="header">Jumlah Petugas</div>
                <div class="meta displayDate" style="margin-top: 4px;"></div>
              </div>
              <div class="content">
                <h1 id="totalStaff"></h1>
              </div>
              <div class="extra content">
                <button class="ui right labeled icon teal button w-100pct" onclick="window.location.href='/admin_staff_dashboard'">
                  <i class="right arrow icon"></i>
                  Lihat Butiran
                </button>
              </div>
            </div>
          </div>
          <div>
            <div class="ui card w-100pct">
              <div class="content">
                <div class="header">Jumlah Pelangggan</div>
                <div class="meta displayDate" style="margin-top: 4px;"></div>
              </div>
              <div class="content">
                <h1 id="totalClient"></h1>
              </div>
              <div class="extra content">
                <button class="ui right labeled icon teal button w-100pct" onclick="window.location.href='/admin_customer_dashboard'">
                  <i class="right arrow icon"></i>
                  Lihat Butiran
                </button>
              </div>
            </div>
          </div>
          <div>
            <div class="ui card w-100pct">
              <div class="content">
                <div class="header">Jumlah Peralatan Perubatan</div>
                <div class="meta displayDate" style="margin-top: 4px;"></div>
              </div>
              <div class="content">
                <h1 id="totalEquipment"></h1>
              </div>
              <div class="extra content">
                <button class="ui right labeled icon teal button w-100pct" onclick="window.location.href='/admin_equipment_dashboard'">
                  <i class="right arrow icon"></i>
                  Lihat Butiran
                </button>
              </div>
            </div>
          </div>
          <div>
            <div class="ui card w-100pct">
              <div class="content">
                <div class="header">Jumlah Permohonan</div>
                <div class="meta displayDate" style="margin-top: 4px;"></div>
              </div>
              <div class="content">
                <h1 id="totalApplication"></h1>
              </div>
              <div class="extra content">
                <button class="ui right labeled icon teal button w-100pct" onclick="window.location.href='/admin_application_dashboard'">
                  <i class="right arrow icon"></i>
                  Lihat Butiran
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('section.staff_modal')
  @include('section.staff_modal_script')
  <script></script>
</body>
</html>
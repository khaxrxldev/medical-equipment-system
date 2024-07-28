<!DOCTYPE html>
<html lang="en">
<head>
  @include('section.head')
  <script>
    $(function() {
      displayDashboard();
      displayNotification();
    });

    function displayDashboard() {
      $.ajax({
        type: 'GET',
        url: '/dashboard/client'
      }).then(function(res) {
        let currentTime = displayCurrentTime();

        if (res.data.length) {
          res.data.forEach((element, index, array) => {
            let div = $('<div>');
            
            var card = $('<div>', { class: 'ui card', css: { width: '100%' } });

            var imageDiv = $('<div>', { class: 'image' });
            var img = $('<img>', { src: `data:image/jpeg;base64,${element.equipmentImage}` });
            imageDiv.append(img);

            var contentDiv = $('<div>', { class: 'content' });
            var header = $('<a>', { class: 'header', text: element.equipmentName });
            var metaDiv = $('<div>', { class: 'meta' });
            var metaLink = $('<a>', { text: currentTime });
            metaDiv.append(metaLink);

            contentDiv.append(header).append(metaDiv);

            var extraContentDiv = $('<div>', { class: 'extra content' });
            var blueLabel = $('<a>', { class: 'ui blue label', text: 'Total' });
            var blueDetail = $('<div>', { class: 'detail', text: element.totalEquipment });
            blueLabel.append(blueDetail);

            var greenLabel = $('<a>', { class: 'ui green label', text: 'Available' });
            var greenDetail = $('<div>', { class: 'detail', text: element.totalAvailableEquipment });
            greenLabel.append(greenDetail);

            var redLabel = $('<a>', { class: 'ui red label', text: 'Unavailable' });
            var redDetail = $('<div>', { class: 'detail', text: element.totalUnavailableEquipment });
            redLabel.append(redDetail);

            extraContentDiv.append(blueLabel).append(greenLabel).append(redLabel);

            card.append(imageDiv).append(contentDiv).append(extraContentDiv);

            div.append(card);
            $('#cardContainer').append(div);
          });
        }
        console.log(res.data)
      });
    }

    function displayCurrentTime() {
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

      return `data sehingga ${formattedDate}, ${formattedTime}`;
    }
    
    function displayNotification() {
      $.ajax({
        type: 'GET',
        url: '/dashboard/client/noti'
      }).then(function(res) {
        if (res.data.length) {
          res.data.forEach((element, index, array) => {
            let message = element.applicationStatus === 'BERJAYA' ? 'diluluskan' : 'ditolak';
            let color = element.applicationStatus === 'BERJAYA' ? 'green' : 'red';

            if (element.clientNotiStatus === 0) {
              $.toast({
                displayTime: 10000,
                message: `Permohonan anda telah <b>${message}</b>`,
                class : color,
                className: {
                  toast: 'ui message'
                }
              });
            }

            var $segment = $('<div>', { class: 'ui segment' });
            
            var $paragraph = $('<p>').text('Permohonan ');
            var $link = $('<a>', { href: '/client_application_dashboard', text: element.equipmentName });
            var $textAfterLink = document.createTextNode(` anda telah ${message}.`);
            
            $paragraph.append($link).append($textAfterLink);
            $segment.append($paragraph);
            
            $('#segmentContainer').append($segment);
          })
        }
      });
    }
  </script>
</head>
<body>
  @include('section.client_top_nav')
  <div>
    <div class="ui visible left vertical sidebar menu bg-primary-almond">
      <a class="item h-100px" href="/client_admin_dashboard"></a>
      <a class="item active" href="/client_admin_dashboard">
        Laman Utama
      </a>
      <a class="item" href="/client_application_dashboard">
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
          <h2>LAMAN UTAMA</h2>
        </div>
      </div>
      <div class="p-2em">
        <div class="grid-3-equal" id="cardContainer"></div>
      </div>
    </div>
  </div>
  @include('section.client_modal')
  @include('section.client_modal_script')
  <script></script>
</body>
</html>
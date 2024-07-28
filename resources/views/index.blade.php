<!DOCTYPE html>
<html lang="en">
<head>
  @include('section.head')
  <script>
    $(function() {
      $('.tabular.menu .item').tab();
      $('.selection.dropdown.member')
        .dropdown()
      ;
    });
  </script>
</head>
<body>
  <div class="topnav border-top border-bottom">
    <a class="p-15px-25px" href="#">Peralatan Perubatan</a>
    <a class="p-15px-25px" href="javascript:void(0);" onclick="register()">Daftar Masuk</a>
    <a class="p-15px-25px" href="#">Tentang Kami</a>
  </div>
  <div class="index-grid-3">
    <div class="grid-landing-page-item p-5em">
      <div class="ui piled segment">
        <h4 class="ui header">A header</h4>
        <p>Te eum doming eirmod, nominati pertinacia argumentum ad his. Ex eam alia facete scriptorem, est autem aliquip detraxit at. Usu ocurreret referrentur at, cu epicurei appellantur vix. Cum ea laoreet recteque electram, eos choro alterum definiebas in. Vim dolorum definiebas an. Mei ex natum rebum iisque.</p>
         <p>Audiam quaerendum eu sea, pro omittam definiebas ex. Te est latine definitiones. Quot wisi nulla ex duo. Vis sint solet expetenda ne, his te phaedrum referrentur consectetuer. Id vix fabulas oporteat, ei quo vide phaedrum, vim vivendum maiestatis in.</p>
         <p>Eu quo homero blandit intellegebat. Incorrupte consequuntur mei id. Mei ut facer dolores adolescens, no illum aperiri quo, usu odio brute at. Qui te porro electram, ea dico facete utroque quo. Populo quodsi te eam, wisi everti eos ex, eum elitr altera utamur at. Quodsi convenire mnesarchum eu per, quas minimum postulant per id.</p>
      </div>
    </div>
    <div class="grid-landing-page-item p-5em-2em">
      <div class="ui tabular menu m-0">
        <div class="item w-50pct cursor-pointer" data-tab="staff-login">Petugas</div>
        <div class="item w-50pct cursor-pointer" data-tab="client-login">Pelanggan</div>
      </div>
      <div class="ui tab p-40px border-bottom border-left border-right border-bottom-radius bg-primary-grey" data-tab="staff-login">
        <form class="ui form info" id="staffSigninId" method="post" enctype="multipart/form-data">
          <div class="ui red message" id="staffMessageId"></div>
          <div class="field">
            <label>Nombor KP</label>
            <input type="text" placeholder="sila isi nombor kad pengenalan" name="staffIcNumber" value="990507-02-5545">
          </div>
          <div class="field">
            <label>Kata Laluan</label>
            <input type="password" placeholder="sila isi kata laluan" name="staffPassword" value="password123">
          </div>
          <div class="ui info message">
            <div class="header">Garis Panduan</div>
            <ul class="list">
              <li>Perlu mengandungi lebih daripada 8 karakter.</li>
              <li>Perlu mengandungi gabungan huruf, nombor & simbol.</li>
            </ul>
          </div>
          <!-- <button class="ui right labeled icon blue button" onclick="window.location.href='client_admin_dashboard.html'"> -->
          <button type="submit" class="ui right labeled icon blue button">
            <i class="right arrow icon"></i>
            Log Masuk
          </button>
        </form>
      </div>
      <div class="ui tab p-40px border-bottom border-left border-right border-bottom-radius bg-primary-grey" data-tab="client-login">
        <form class="ui form info" id="clientSigninId" method="post" enctype="multipart/form-data">
        <div class="ui red message" id="clientMessageId"></div>
          <div class="field">
            <label>Nombor KP</label>
            <input type="text" placeholder="sila isi nombor kad pengenalan" name="clientIcNumber" value="990507-01-4474">
          </div>
          <div class="field">
            <label>Kata Laluan</label>
            <input type="password" placeholder="sila isi kata laluan" name="clientPassword" value="password123">
          </div>
          <div class="ui info message">
            <div class="header">Garis Panduan</div>
            <ul class="list">
              <li>Perlu mengandungi lebih daripada 8 karakter.</li>
              <li>Perlu mengandungi gabungan huruf, nombor & simbol.</li>
            </ul>
          </div>
          <!-- <button class="ui right labeled icon blue button" onclick="window.location.href='client_admin_dashboard.html'"> -->
          <button type="submit" class="ui right labeled icon blue button">
            <i class="right arrow icon"></i>
            Log Masuk
          </button>
        </form>
      </div>
    </div>
  </div>
  <form class="ui modal register" id="registerFormId" method="post" enctype="multipart/form-data">
    <div class="header bg-primary-grey">Daftar Akaun</div>
    <div class="content bg-primary-grey">
      <div class="ui form info">
        <div class="ui message" id="registerMessageId"></div>
        <div class="two fields">
          <div class="field">
            <label>Nombor KP</label>
            <input type="text" placeholder="sila isi nombor kad pengenalan - e.g: 000000-00-0000" name="clientIcNumber">
          </div>
          <div class="field">
            <label>Nama Penuh</label>
            <input type="text" placeholder="sila isi nama penuh" name="clientName">
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <label>E-mel</label>
            <input type="email" placeholder="sila isi alamat e-mel" name="clientEmail">
          </div>
          <div class="field">
            <label>Nombor Telefon</label>
            <input type="text" placeholder="sila isi nombor telefon - e.g: 000-00000000" name="clientPhoneNo">
          </div>
        </div>
        <div class="field">
          <label>Alamat</label>
          <textarea class="resize-none" rows="2" name="clientAddress"></textarea>
        </div>
        <div class="field">
          <label>Pekerjaan</label>
          <input type="text" placeholder="sila isi pekerjaan" name="clientJob">
        </div>
        <div class="two fields">
          <div class="field">
            <label>Jenis Kanser</label>
            <input type="text" placeholder="sila isi jenis kanser" name="clientCancerType">
          </div>
          <div class="field">
            <label>Keahlian</label>
            <div class="ui selection dropdown member">
              <input type="hidden" name="clientMembership">
              <i class="dropdown icon"></i>
              <div class="default text">sila pilih jenis keahlian</div>
              <div class="menu">
                <div class="item" data-value="AHLI">AHLI</div>
                <div class="item" data-value="BUKAN AHLI">BUKAN AHLI</div>
              </div>
            </div>
          </div>
        </div>
        <div class="field">
          <label>Kata Laluan</label>
          <input type="password" placeholder="sila isi kata laluan" name="clientPassword">
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
      <button onclick="resetRegisterForm()" type="button" class="ui right labeled icon deny clear red button">
        <i class="close icon"></i>
        Batal
      </button>
      <button onclick="resetRegisterForm()" type="button" class="ui right labeled icon reset yellow button">
        <i class="refresh icon"></i>
        Set Semula
      </button>
      <button type="submit" class="ui right labeled icon green button">
        <i class="checkmark icon"></i>
        Daftar
      </button>
    </div>
  </form>
  <script>
    onUpperCaseForm('registerFormId');

    $('#staffMessageId').hide();
    $('#clientMessageId').hide();
    $('#registerMessageId').hide();

    $('.ui.form.info#staffSigninId').form({
      fields: {
        staffIcNumber : 'empty',
        staffPassword : {
          identifier: 'staffPassword',
          rules: [{
            type: 'regExp[/^[a-zA-Z\\d\\W_]{9,}$/]',
          }]
        },
      }
    });
    $('.ui.form.info#clientSigninId').form({
      fields: {
        clientIcNumber : 'empty',
        clientPassword : {
          identifier: 'clientPassword',
          rules: [{
            type: 'regExp[/^[a-zA-Z\\d\\W_]{9,}$/]',
          }]
        },
      }
    });
    $('.ui.modal.register#registerFormId').form({
      fields: {
        clientIcNumber : {
          identifier: 'clientIcNumber',
          rules: [{
            type: 'regExp[/^\\d{6}-\\d{2}-\\d{4}$/]',
          }]
        },
        clientName : 'empty',
        clientEmail : 'empty',
        clientPhoneNo : {
          identifier: 'clientPhoneNo',
          rules: [{
            type: 'regExp[/^\\d{3}-\\d{7,8}$/]',
          }]
        },
        clientAddress : 'empty',
        clientJob : 'empty',
        clientCancerType : 'empty',
        clientMembership : 'empty',
        clientPassword : {
          identifier: 'clientPassword',
          rules: [{
            type: 'regExp[/^[a-zA-Z\\d\\W_]{9,}$/]',
          }]
        },
      }
    });

    function register() {
      $('.ui.modal.register')
        .modal('setting', 'closable', false)
        .modal('show')
      ;
    }

    $('#registerFormId').on('submit', function(event) {
      event.preventDefault();
      
      if($('.ui.modal.register#registerFormId').form('is valid')) {
        $.ajax({
          url: '/client',
          method: 'POST',
          data: $('#registerFormId').serialize(),
          success: function(res) {
            if (res) {
              $('#registerFormId').trigger('reset');

              $('#registerMessageId').show();
              $('#registerMessageId').html("Pendaftaran BERJAYA.");
              $('#registerMessageId').addClass('green');
            } else {
              $('#registerMessageId').show();
              $('#registerMessageId').html("Pendaftaran Gagal.");
              $('#registerMessageId').addClass('red');
            }
          },
          error: function(err) {
            $('#registerMessageId').show();
            $('#registerMessageId').html("Pendaftaran Gagal.");
            $('#registerMessageId').addClass('red');
            console.log('error: ' + err);
          }
        });
      }
    });

    function resetRegisterForm() {
      $('#registerMessageId').hide();
      $('registerFormId').form('clear');
    }
    
    $('#clientSigninId').on('submit', function(event) {
      event.preventDefault();
      
      if($('.ui.form.info#clientSigninId').form('is valid')) {
        $.ajax({
          url: '/client/signin',
          method: 'POST',
          data: $('#clientSigninId').serialize(),
          success: function(res) {
            if (res.data.responseStatus) {
              sessionStorage.setItem('user_id', res.data.responseId);
              window.location.href = '/client_admin_dashboard';
            } else {
              $('#clientMessageId').show();
              $('#clientMessageId').html(res.data.responseMessage);
            }
          },
          error: function(err) {
            console.log('error: ' + err);
          }
        });
      }
    });

    $('#staffSigninId').on('submit', function(event) {
      event.preventDefault();

      if($('.ui.form.info#staffSigninId').form('is valid')) {
        $.ajax({
          url: '/staff/signin',
          method: 'POST',
          data: $('#staffSigninId').serialize(),
          success: function(res) {
            if (res.data.responseStatus) {
              sessionStorage.setItem('user_id', res.data.responseId);
              if (res.data.responseRole === 'PETUGAS') {
                window.location.href = '/staff_application_dashboard';
              } else if (res.data.responseRole === 'PENTADBIR') {
                window.location.href = '/admin_dashboard';
              }
            } else {
              $('#staffMessageId').show();
              $('#staffMessageId').html(res.data.responseMessage);
            }
          },
          error: function(err) {
            console.log('error: ' + err);
          }
        });
      }
    });
  </script>
</body>
</html>
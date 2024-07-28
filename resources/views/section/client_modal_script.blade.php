<script>
  $('#updateProfileMessageId').hide();

  $('.ui.modal.profile#updateProfileFormId').form({
    fields: {
      clientIcNumber : 'empty',
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

  function promptLogout() {
    $('.ui.tiny.modal.logout')
      .modal('show')
    ;
  }

  function logout() {
    sessionStorage.clear();
    window.location.href = '/';
  }

  function displayProfile() {
    $.ajax({
      type: 'GET',
      url: '/client/' + sessionStorage.getItem('user_id')
    }).then(function(res) {
      onSetForm('updateProfileFormId', res.data);
      $('#clientMembership').html(res.data.clientMembership);

      $('.ui.modal.profile')
        .modal('setting', 'closable', false)
        .modal('show')
      ;
    });
  }

  $('#updateProfileFormId').on('submit', function(event) {
    event.preventDefault();
    
    if($('.ui.modal.profile#updateProfileFormId').form('is valid')) {
      $.ajax({
        url: '/client',
        method: 'PUT',
        data: $('#updateProfileFormId').serialize(),
        success: function(res) {
          if (res) {
            onSetForm('updateProfileFormId', res.data);
            $('#clientMembership').html(res.data.clientMembership);
            
            $('#updateProfileMessageId').show();
            $('#updateProfileMessageId').html("Pendaftaran BERJAYA.");
            $('#updateProfileMessageId').addClass('green');
          } else {
            $('#updateProfileMessageId').show();
            $('#updateProfileMessageId').html("Pendaftaran Gagal.");
            $('#updateProfileMessageId').addClass('red');
          }
        },
        error: function(err) {
          $('#updateProfileMessageId').show();
          $('#updateProfileMessageId').html("Pendaftaran Gagal.");
          $('#updateProfileMessageId').addClass('red');
          console.log('error: ' + err);
        }
      });
    }
  });

  function resetUpdateProfileForm() {
    $('#updateProfileMessageId').hide();
    $('#updateProfileFormId').form('clear');
  }

  function displayNotificationList() {
    $('.ui.tiny.modal.notification')
      .modal('show')
    ;
  }
</script>
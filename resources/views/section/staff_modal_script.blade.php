<script>
  onUpperCaseForm('updateProfileFormId');
  $('#updateMessageId').hide();
  $('.ui.modal.profile#updateProfileFormId').form({
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
      staffPassword : {
        identifier: 'staffPassword',
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
    $('#updateMessageId').hide();
    $('#updateMessageId').html('');
    $('#updateMessageId').removeClass().addClass('ui message');

    $.ajax({
      type: 'GET',
      url: '/staff/' + sessionStorage.getItem('user_id')
    }).then(function(res) {
      onSetForm('updateProfileFormId', res.data);
      $('#profileStaffRole').html(res.data.staffRole);

      $('.ui.modal.profile')
        .modal('show')
      ;
    });
  }

  $('#updateProfileFormId').on('submit', function(event) {
    event.preventDefault();
    
    if ($('.ui.modal.profile#updateProfileFormId').form('is valid')) {
      $.ajax({
        url: '/staff',
        method: 'PUT',
        data: $('#updateProfileFormId').serialize(),
        success: function(res) {
          if (res) {
            onSetForm('updateProfileFormId', res.data);
            $('#profileStaffRole').html(res.data.staffRole);

            $('#updateMessageId').show();
            $('#updateMessageId').html("Kemaskini BERJAYA.");
            $('#updateMessageId').addClass('green');
          } else {
            $('#updateMessageId').show();
            $('#updateMessageId').html("Kemaskini Gagal.");
            $('#updateMessageId').addClass('red');
          }
        },
        error: function(err) {
          $('#updateMessageId').show();
          $('#updateMessageId').html("Kemaskini Gagal.");
          $('#updateMessageId').addClass('red');
          console.log('error: ' + err);
        }
      });
    }
  });

  function displayNotificationList() {
    $('.ui.tiny.modal.notification')
      .modal('show')
    ;
  }
</script>
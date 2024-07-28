<!-- profile modal -->
<form class="ui modal profile" id="updateProfileFormId" method="post" enctype="multipart/form-data">
  <div class="header bg-primary-grey">Maklumat Akaun</div>
  <div class="content bg-primary-grey">
    <div class="ui form info">
      <div class="ui message" id="updateMessageId"></div>
      <input type="hidden" name="staffId">
      <div class="two fields">
        <div class="field">
          <label>Nombor Kad Pengenalan</label>
          <input type="text" name="staffIcNumber" readonly>
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
          <div class="text" id="profileStaffRole"></div>
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
    <button onclick="displayProfile()" type="button" class="ui right labeled icon reset yellow button">
      <i class="refresh icon"></i>
      Set Semula
    </button>
    <button type="submit" class="ui right labeled icon green button">
      <i class="checkmark icon"></i>
      Simpan
    </button>
  </div>
</form>
<!-- logout prompt modal -->
<div class="ui tiny modal logout">
  <div class="content">
    Adakah anda pasti untuk <i>log keluar?</i>
  </div>
  <div class="actions">
    <button class="ui right labeled icon deny red button">
      <i class="close icon"></i>
      Batal
    </button>
    <button class="ui right labeled icon green button" onclick="logout()">
      <i class="checkmark icon"></i>
      Log Keluar
    </button>
  </div>
</div>
<!-- notification modal -->
<div class="ui tiny modal notification">
  <div class="header bg-primary-grey">Notifikasi</div>
  <div class="content">
    <div class="ui segments" id="segmentContainer"></div>
  </div>
  <div class="actions">
    <button class="ui right labeled icon deny button">
      <i class="close icon"></i>
      Tutup
    </button>
  </div>
</div>
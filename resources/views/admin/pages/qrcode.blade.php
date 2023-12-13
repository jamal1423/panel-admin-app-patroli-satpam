<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Cetak QR Code | SMKN 1 Wongsorejo</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" />
  <style>
    .card {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      transition: 0.3s;
      border-radius: 5px;
      padding: 10px;
      top: 10%;
    }

    .card:hover {
      box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    .container {
      padding: 2px 16px;
    }

    img {
      border-radius: 5px 5px 0 0;
    }

    .center-text {
      text-align: center;
    }

    .mg-top {
      margin-top: 10px;
    }
    
    @media print {
      #printButton {
        display: none;
      }

      #buttonBack {
        display: none;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row justify-content-md-center" id="printArea">
      <div class="col-md-auto">
        <center>
        <div class="card center-text">
          <h4 class="card-title center-text mg-top">SMKN 1 WONGSOREJO</h4><br>
          {!! QrCode::size(400)->generate($kelas) !!}
          <div class="container">
            <div class="row justify-content-md-center">
              <div class="col-md-auto center-text">
                <br>
                <h4><b>Kelas {{ $kelas }}</b></h4>
                <p>Harap Scan QR Code Ini</p>
                <button class="btn btn-primary" type="button" id="printButton" onclick="printDiv('printArea')"> <i class="fa fa-print"> Cetak</i> </button>
                <a href="{{ url('/dashboard') }}"><button class="btn btn-primary" id="buttonBack" type="button"> <i class="fa fa-home"> Kembali</i> </button></a>
              </div>
            </div>
          </div>
        </div>
        </center>
      </div>
    </div>
  </div>
</body>

<script>
  function printDiv(printArea) {
    var printContents = document.getElementById(printArea).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
  }
</script>

<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script> -->

</html>
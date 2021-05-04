<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- jQuery  -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!-- bootstrap JS -->
  <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

  <!-- bootstrap CSS -->
  <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">

  <title>Document</title>
</head>

<body>
  <div class="row">
    <table id="example-table-1" width="100%" class="table table-bordered table-hover text-center">
      <thead>
        <tr>
          <th>No. </th>
          <th>아이디</th>
          <th>이름</th>
          <th>이메일</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>user01</td>
          <td>홍길동</td>
          <td>hong@gmail.com</td>
        </tr>
        <tr>
          <td>2</td>
          <td>user02</td>
          <td>김사부</td>
          <td>kim@naver.com</td>
        </tr>
        <tr>
          <td>3</td>
          <td>user03</td>
          <td>존</td>
          <td>John@gmail.com</td>
        </tr>
      </tbody>
    </table>
    <div class="col-lg-12" id="ex1_Result1"></div>
    <div class="col-lg-12" id="ex1_Result2"></div>
  </div>

  <script>
    $("#example-table-1 tr").click(function() {
      var tr = $(this);
      var td = tr.children();

      var no = td.eq(0).text();
      var userid = td.eq(1).text();
      var name = td.eq(2).text();
      var email = td.eq(3).text();

      // console.log(no + ' ' + userid + ' ' + name + ' ' + email);

      // 여기서 key를 다음 페이지에 넘기면 된다.
      // 키를 post로 다음 페이지에 넘기는 js 코드 작성...
      

    });
  </script>
</body>

</html>
<head>
  <!DOCTYPE html>
  <html lang="en">
  <meta charset="UTF-8">
  <meta name="author" content="ASW027">
  <title>REGISTER | UniRent</title>
  <link rel="shortcut icon" type="image/jpg" href="#">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="./CSS/style.scss">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/bd64e92c1e.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>  
  <script src="https://www.gstatic.com/firebasejs/8.6.0/firebase.js"></script>
        <script>
        
        var config = {
            apiKey: "AIzaSyD8o4OnimxIsq-3B7e05FeBj5qUq65HTXA",
            authDomain: "projetoptiptr-307918.firebaseapp.com",
        };
        firebase.initializeApp(config);
        </script>
</head>

<body>
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark p-md-3">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="img/logo/UniRent-V2.png" alt="" width="100">
      </a>
      <button class="navbar-toggler bg-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <div class="mx-auto"></div>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link text-black text-end" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-black text-end" href="signin">Sign In</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-black text-end" href="signup">Sign Up</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- END Nav bar -->
  
  <!-- Banner -->
  <div class="banner-image w-100 vh-100 d-flex justify-content-center align-items-center">
    <div class="content text-center">
      <h1 class="m-5 blue-font">Sign Up</h1>
      <form action="{{url('/createUser') }}" method="POST" id="formRegistar">
        <a href="{{url('/registerSenhorio') }}"><button type="button" class="mt-1 mb-4 btn btn-light btn-host" ><i class="fas fa-key p-1"></i>Became a Host</button></a>
        <div class="">
          <label for="fname">Username:</label><br>
          <input type="text" name="username" ><br>

          <label for="fname">First name:</label><br>
          <input type="text" name="firstName"><br>

          <label for="lname">Last name:</label><br>
          <input type="text" id="lname" name="lastName"><br>

          <label for="lname">Email:</label><br>
          <input type="text" id="mail" name="mail"><br>

          <label for="lname">Nacionalidade:</label><br>
          <input type="text" id="lname" name="nacionalidade"><br>

          <label for="lname">Morada:</label><br>
          <input type="text" id="lname" name="morada"><br>

          <label for="lname">Data Nascimento:</label><br>
          <input type="date" id="lname" name="nascimento"><br>

          <label for="lname">Telemovel:</label><br>
          <input type="number" id="lname" name="movel"><br>

          <label for="lname">Password:</label><br>
          <input type="password" id="passUser" name="pass"><br>
          <input type="checkbox" onclick="showPass()">Show Password<br>

          <button type="button" class="mt-1 mb-4 btn btn-host" onclick="confirmation();" id="buttonSub">Submit</button>
        </div>
      </form>
    
  </div>
  <!-- END Banner -->
  <script>
    function showPass() {
      var x = document.getElementById("passUser");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }

    function confirmation(){
    alert("OLA");
    
    var email = document.getElementById("mail").value;
    var password = document.getElementById("passUser").value;

    firebase.auth().createUserWithEmailAndPassword(email, password)
    .then((userCredential) => {
      // Signed in
      document.getElementById('formRegistar').submit();
      var user = userCredential.user;
      // ...
    })
    .catch((error) => {
      var errorCode = error.code;
      var errorMessage = error.message;
      // ..
    });

    $("#formRegistar").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
          type: "POST",
          url: url,
          data: form.serialize(), // serializes the form's elements.
          success: function(data)
          {
              alert(data); // show response from the php script.
              window.location = "signin"; 
          }
        });


    });

}
</script>
</body>
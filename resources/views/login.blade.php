
<head>
  <!DOCTYPE html>
  <html lang="en">
  <meta charset="UTF-8">
  <meta name="author" content="UniRent">
  <title>LOGIN | UniRent</title>
  <link rel="shortcut icon" type="image/jpg" href="img/logo/UniRent-V2.png"/>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="./CSS/style.scss">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
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
      <h1 class="m-5 blue-font">Sign In</h1>    
      <form action="{{url('/login')}}" type="get" id="formsubmit">
        <div class="form-floating mb-4">
          <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" required>
          <label for="floatingInput">Email address</label>
        </div>
          <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required>
            <label for="floatingPassword">Password</label>
            <small id="emailHelp" class="form-text text-muted nav-link">
              <a id="forgot-psswd" href="">
                Forgot password
              </a>
            </small>
          </div>
             <button type="button" id="botaoLogin" onclick="confirmation();" class="m-5 btn btn-primary btn-lg btn-block">Sign in</button> 
          </div>
          <script>
            function confirmation(){


              var email = document.getElementById("floatingInput").value;
              var password = document.getElementById("floatingPassword").value;
            
              firebase.auth().onAuthStateChanged(function(user) {
              if (user) {
                alert ('Bem vindo !');
                document.getElementById('formsubmit').submit();
              } else {
                alert ('Inseriu dados incorretos !');
                return false;
              }
              });

              firebase.auth().signInWithEmailAndPassword(email, password).catch(function(error) {
                alert ('Nao fiz login');
                return false;
              });


            }
            
          </script>    
      </form>
    </div>


  </div>

</body>

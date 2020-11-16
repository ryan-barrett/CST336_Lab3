<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up Page</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/main.css" type="text/css">
</head>
<body>
<main>
    <h1>Sign Up</h1>
    <hr>
    <form id="signupForm" action="welcome.php">
        First Name: <input type="text" name="fName"><br>
        Last Name: <input type="text" name="lName"><br>
        Gender:
        <div id="gender-container">
            <span><input type="radio" name="gender" value="m">Male<br></span>
            <span><input type="radio" name="gender" value="f">Female<br></span>
        </div>

        Zip Code: <input type="text" id="zip" name="zip"><br>
        City: <span id="city"></span><br>
        Latitude: <span id="latitude"></span><br>
        Longitude: <span id="longitude"></span><br><br>

        State:
        <select id="state" name="state">
            <option>Select One</option>
            <option value="ca">California</option>
            <option value="ny">New York</option>
            <option value="tx">Texas</option>
        </select><br>

        Select a County: <select id="county"></select><br>

        Desired Username: <input type="text" id="username" name="username"><br>
        <span id="usernameFeedback"></span><br>

        Password: <input type="password" id="password" name="password"><br>
        Password Again: <input type="password" id="passwordAgain">
        <span id="passwordAgainFeedback"></span> <br><br>
        <button type="submit">Sign Up!</button>
    </form>
</main>
<script>
  let usernameAvailable = false;

  $('#zip').on('change', async function () {
    const zipCode = $('#zip').val();
    const url = `https://itcdland.csumb.edu/~milara/ajax/cityInfoByZip?zip=${zipCode}`;
    const response = await fetch(url);
    const data = await response.json();

    $('#city').html(data.city);
    $('#latitude').html(data.latitude);
    $('#longitude').html(data.longitude);
  });

  $('#state').on('change', async function () {
    const state = $('#state').val();
    const url = `https://itcdland.csumb.edu/~milara/ajax/countyList.php?state=${state}`;
    const response = await fetch(url);
    const data = await response.json();

    $('#county').html('<option> Select One</option>');
    for (const item of data) {
      $('#county').append(`<option>${item.county}</option>`);
    }
  });

  $('#username').on('change', async function () {
    const userName = $('#username');
    const url = `https://cst336.herokuapp.com/projects/api/usernamesAPI.php?username=${userName}`;
    const response = await fetch(url);
    const data = await response.json();

    if (data.available) {
      usernameAvailable = true;
      $('#usernameFeedback').html('Username available!');
      $('#usernameFeedback').css('color', 'green');
    }
    else {
      usernameAvailable = false;
      $('#usernameFeedback').html('Username not available!');
      $('#usernameFeedback').css('color', 'red');
    }
  });

  $('#signupForm').on('submit', function (event) {
    if (!formIsValid()) {
      event.preventDefault();
    }
  });

  function formIsValid() {
    if ($('#username').val().length === 0) {
      $('#usernameFeedback').html('Username is required');
      $('#usernameFeedback').css('color', 'red');
      return false;
    }

    if ($('#password').val() !== $('#passwordAgain').val()) {
      $('#passwordAgainFeedback').html('Password Mismatch!');
      return false;
    }

    if ($('#password').val().length < 6) {
      $('#passwordAgainFeedback').html('Password must be at least 6 characters!');
      return false;
    }

    return usernameAvailable;
  }
</script>
</body>
</html>

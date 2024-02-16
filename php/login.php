<!DOCTYPE html>
<head lang="en">
    <title>Sing In</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="external/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
      <form>
        <div>
          <h2>Sign In</h2 >
          <hr>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Username</label>
          <input type="email" class="form-control" id="email">
          <span>The Email field is required</span>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password">
          <span>The Password field is required</span>
        </div>
        <div>
          <button type="submit" class="btn btn-primary pos">Submit</button>
        </div>
      </form>

    </div>
</body>
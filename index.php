<?php require_once('./db.php'); ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/jpg" href="favicon.ico"/>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Notes App</title>
  </head>
  <body>
    <div class="container text-center py-5 px-3">
      <h1><span class="emoji" style="font-size:1.8rem;">✅</span> My Notes <span class="emoji" style="font-size:1.8rem;">✅</span></h1>
      <p class="lead">Remind your future self, what's up! 🚀</p>
      <button class="btn btn-success my-4" type="button" data-bs-toggle="modal" data-bs-target="#addModal">Add Note 📝</button>
    </div>
    <div class="container">

      <div class="row">
        <div class="col-md-10 offset-md-1">
          
          <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col" class="col-md-10">Note</th>
      <th scope="col" class="text-center">Actions</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Call the president</td>
      <td class="text-center">
        <a href="#" class="text-decoration-none mx-2" title="Update">✏️</a>
        <a href="#" class="text-decoration-none mx-2" title="Delete">❌</a>
      </td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Hang out with Dart Vader</td>
      <td class="text-center">
        <a href="#" class="text-decoration-none mx-2" title="Update">✏️</a>
        <a href="#" class="text-decoration-none mx-2" title="Delete">❌</a>
      </td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Hack the CIA</td>
      <td class="text-center">
        <a href="#" class="text-decoration-none mx-2" title="Update">✏️</a>
        <a href="#" class="text-decoration-none mx-2" title="Delete">❌</a>
      </td>
    </tr>
  </tbody>
</table>
        </div>
      </div>
    </div>


<!-- Modal Add Note -->
    <div id="addModal" class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">📝 Add A Note </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
          <div class="mb-3">
            <!-- <label for="note" class="form-label">Tell me what's crackin!</label> -->
            <input type="text" class="form-control" id="note" required autofocus placeholder="Tell me what's crackin!">
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success" name="addNote">Add</button>
          </div>          
        </form>
      </div>
    </div>
  </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
  </body>
</html>

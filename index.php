<?php require_once('./db.php'); ?>
<?php 
session_start();

// get all notes
$sql = "SELECT * FROM notes";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$notes = $stmt->fetchAll(PDO::FETCH_OBJ);
$count = 1;

// add note
if(isset($_POST['addNote'])){
  $note = trim($_POST['note']);

  if(strlen($note) == 0){
    $_SESSION['msg'] = 'Please enter something';
    header('Location: index.php');
    exit();
  }

  $sql = "INSERT INTO notes (name) VALUES (:name)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':name' => $note]);
}


?>
<!doctype html>
<html lang="en">
  <head>
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
              <?php foreach($notes as $note): ?>
              <tr>
                <th scope="row"><?php echo $count++; ?></th>
                <td><?php echo $note->name; ?></td>
                <td class="text-center">
                  <a href="#" class="text-decoration-none mx-2" title="Update">✏️</a>
                  <a href="#" class="text-decoration-none mx-2" title="Delete">❌</a>
                </td>
              </tr>
              <?php endforeach; ?>
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
                <input type="text" class="form-control" name="note" id="note" required placeholder="Tell me what's crackin!">
                <?php if(isset($_SESSION['msg'])): ?>
                <p id="add-msg" class="text-danger"><?php echo $_SESSION['msg']; ?></p>
                <?php endif; ?>
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
    <?php if(isset($_SESSION['msg'])): ?>
    <script>new bootstrap.Modal(document.getElementById('addModal')).show();</script>
    <?php endif; ?>
    <script>
      var myModal = document.getElementById('addModal')
      var myInput = document.getElementById('note')

      myModal.addEventListener('shown.bs.modal', function () {
        myInput.focus()
      })
    </script>
    <script>
      var myModal = document.getElementById('addModal')
      myModal.addEventListener('hidden.bs.modal', function (event) {
        var errorMessage= document.getElementById('add-msg')
        if(errorMessage) errorMessage.remove()
      })

    </script>
  </body>
</html>
<?php if(isset($_SESSION['msg'])){ unset($_SESSION['msg']); } ?>
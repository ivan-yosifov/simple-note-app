<?php require_once('./db.php'); ?>
<?php 
session_start();

// Pagination
$page = 1;
if(isset($_GET['page'])){
  $page = (int)$_GET['page'];
}

$perPage = 5;
if(isset($_GET['per-page']) && (int)$_GET['per-page'] <= 50){
  $perPage = (int)$_GET['per-page'];
}

$start = 0;
if($page > 1){
  $start = ($page * $perPage) - $perPage;
}


// searchNote
if(isset($_POST['searchNote'])){
  $searchFor = trim($_POST['searchFor']);

  if(strlen($searchFor) == 0){
    $_SESSION['search-msg'] = 'Please enter something';
    header('Location: index.php');
    exit();
  }


  $searchString = '%'.$searchFor.'%';

  $sql = "SELECT * FROM notes WHERE name LIKE :searchFor";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':searchFor', $searchString, PDO::PARAM_STR);
  $stmt->execute();

  $notes = $stmt->fetchAll(PDO::FETCH_OBJ);

  $total = $pdo->prepare("SELECT COUNT(*) FROM notes");
  $total->execute();
  $totalCount = $stmt->rowCount();

  $pages = ceil($totalCount / $perPage);
  $count = 1;

  
}else{
  // get all notes
  $sql = "SELECT * FROM notes LIMIT :start, :perPage";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':start', $start, PDO::PARAM_INT);
  $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
  $stmt->execute();

  $notes = $stmt->fetchAll(PDO::FETCH_OBJ);

  $total = $pdo->prepare("SELECT COUNT(*) FROM notes");
  $total->execute();
  $totalCount = $total->fetchColumn();

  $pages = ceil($totalCount / $perPage);
  $count = 1;
}

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

  header('Location: index.php');
  exit();
}

// update note
if(isset($_POST['updateNote'])){
  $id = $_POST['updateId'];
  $note = trim($_POST['updateText']);

  if(strlen($note) == 0){
    $_SESSION['update-msg'] = 'Please enter something';
    header('Location: index.php');
    exit();
  }

  $sql = "UPDATE notes SET name = :name WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':name' => $note, ':id' => $id]);

  header('Location: index.php');
  exit();
}

// delete note
if(isset($_POST['deleteNote'])){
  $id = $_POST['deleteId'];
  $sql = "DELETE FROM notes WHERE id = :id LIMIT 1";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':id' => $id]);

  header('Location: index.php');
  exit();
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
    <style>
      #clearSearch{display:none;position: absolute;right: 65px;top: 5px;cursor: pointer;}
    </style>
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
          <form class="mb-4" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="d-flex position-relative">
              <input class="form-control me-2" type="search" id="searchInput" name="searchFor" value="<?php if(isset($_POST['searchFor'])) echo $searchFor; ?>" placeholder="Search" aria-label="Search">
              <span id="clearSearch">❎</span>
              <button class="btn btn-link text-decoration-none" type="submit" name="searchNote">🔍</button>
            </div>
            <?php if(isset($_SESSION['search-msg'])): ?>
            <p id="search-msg" class="text-danger"><?php echo $_SESSION['search-msg']; ?></p>
            <?php endif; ?>
          </form>

          <?php if($stmt->rowCount() == 0): ?>
          <p class="lead text-warning">Nothing found</p>
          <?php else: ?>
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col" class="col-md-10">Note</th>
                <th scope="col" class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($notes as $note): ?>
              <tr class="align-middle">
                <th scope="row"><?php echo $count++; ?></th>
                <td><?php echo $note->name; ?></td>
                <td class="text-center">
                  <button type="button" class="btn btn-link text-decoration-none mx-2 updateBtn" data-bs-toggle="modal" data-bs-target="#updateModal" title="Update" data-id="<?php echo $note->id; ?>" data-text="<?php echo $note->name; ?>">✏️</button>
                  <button type="button" class="btn btn-link text-decoration-none mx-2 deleteBtn" data-bs-toggle="modal" data-bs-target="#deleteModal" title="Delete" data-id="<?php echo $note->id; ?>" >❌</button>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <?php if(!isset($searchFor)): ?>
          <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
              <?php for($i = 1; $i <= $pages; $i++): ?>
              <li class="page-item"><a class="page-link" href="?page=<?php echo $i ?>&per-page=<?php echo $perPage; ?>"><?php echo $i; ?></a></li>
              <?php endfor; ?>
            </ul>
          </nav>
          <?php endif; ?>

          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Modal Add Note -->
    <div id="addModal" class="modal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header text-white bg-success">
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

    <!-- Modal Update Note -->
    <div id="updateModal" class="modal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header text-white bg-warning">
            <h5 class="modal-title">✏️ Update A Note </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
              <div class="mb-3">
                <input type="text" class="form-control" name="updateText" id="updateText" required placeholder="Tell me what's crackin!" value="">
                <?php if(isset($_SESSION['update-msg'])): ?>
                <p id="update-msg" class="text-danger"><?php echo $_SESSION['update-msg']; ?></p>
                <?php endif; ?>
              </div>
              <div class="d-flex justify-content-end">
                <input type="hidden" name="updateId" id="updateId" value="">
                <button type="submit" class="btn btn-warning me-2" name="updateNote">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
              
            </form>

            
          </div>
        </div>
      </div>
    </div>


    <!-- Modal Delete Note -->
    <div id="deleteModal" class="modal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header text-white bg-danger">
            <h5 class="modal-title">Delete A Note </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete this note?</p>
          </div>
          <div class="modal-footer">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="d-inline-block" >
              <input type="hidden" name="deleteId" id="deleteId" value="">
              <button type="submit" class="btn btn-danger" name="deleteNote">Yes, Delete</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, I changed my mind</button>
            </form>            
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <?php if(isset($_SESSION['msg'])): ?>
    <script>new bootstrap.Modal(document.getElementById('addModal')).show();</script>
    <?php endif; ?>

    <?php if(isset($_SESSION['update-msg'])): ?>
    <script>new bootstrap.Modal(document.getElementById('updateModal')).show();</script>
    <?php endif; ?>

    <script>
      var myModal = document.getElementById('addModal')

      // focus input field
      var myInput = document.getElementById('note')
      myModal.addEventListener('shown.bs.modal', function () {
        myInput.focus()
      })

      // remove error on addModal close
      myModal.addEventListener('hidden.bs.modal', function (event) {
        var errorMessage= document.getElementById('add-msg')
        if(errorMessage) errorMessage.remove()
      })


      var updateModal = document.getElementById('updateModal')

      // focus input field
      var myInput = document.getElementById('updateText')
      updateModal.addEventListener('shown.bs.modal', function () {
        myInput.focus()
      })

      // remove error on updateModal close
      updateModal.addEventListener('hidden.bs.modal', function (event) {
        var errorMessage= document.getElementById('update-msg')
        if(errorMessage) errorMessage.remove()
      })


      // add id to deleteModal
      var deleteBtns = document.getElementsByClassName('deleteBtn');
      for (let i = 0; i < deleteBtns.length; i++){
        deleteBtns[i].addEventListener('click', function(e){
          var id = e.target.dataset.id;
          document.getElementById('deleteId').setAttribute('value', id);   
        })
      }

      // add id and text to updateModal
      var updateBtns = document.getElementsByClassName('updateBtn');
      for(let i = 0; i < updateBtns.length; i++){
        updateBtns[i].addEventListener('click', function(e){
          var id = e.target.dataset.id;
          var taskText = e.target.dataset.text;
          document.getElementById('updateId').setAttribute('value', id);
          document.getElementById('updateText').value = taskText;
        })
      }
      
      document.getElementById('searchInput').addEventListener('keyup', function(e){
        console.log(e.target.value.trim());
        if(e.target.value.trim().length != 0){
          document.getElementById('clearSearch').style.display = 'block';
        }else{
          document.getElementById('clearSearch').style.display = 'none';
        }
      })

      window.addEventListener('DOMContentLoaded', function(){
        if(document.getElementById('searchInput').value.length != 0){
          document.getElementById('clearSearch').style.display = 'block';
        }

        document.getElementById('clearSearch').addEventListener('click', function(e){
          document.getElementById('searchInput').value = '';
          this.style.display = 'none';
          window.location.href = 'index.php';
        })
      })
    </script>
  </body>
</html>
<?php if(isset($_SESSION['msg'])){ unset($_SESSION['msg']); } ?>
<?php if(isset($_SESSION['update-msg'])){ unset($_SESSION['update-msg']); } ?>
<?php if(isset($_SESSION['search-msg'])){ unset($_SESSION['search-msg']); } ?>
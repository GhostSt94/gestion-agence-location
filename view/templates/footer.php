<!-- Footer -->
  <footer class="bg-white mt-5">
    <div class="container py-4">
      <div class="row pt-4 pb-3">
        <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
        <h6 class="font-weight-bold mb-4">locationVoiture.ma</h6>
          <p class="font-italic text-muted " style="text-align: justify;">De grandes offres pour les locations de voitures, journaliers, en semaine, ou de longue durée. Trouver les meilleurs tarifs en ligne, pour votre prochaine Location de Voiture en quatre étapes. Réservez maintenant à de tarifs bas et économisez!</p>
          <ul class="list-inline mt-4">
            <li class="list-inline-item"><a href="mailto:gestion.agence.location.voiture@gmail.com" target="_blank" title="mail"><i class="fas fa-envelope"></i></a></li>
            <li class="list-inline-item"><a href="https://www.facebook.com/Gestion-Agence-Location-105845118351720" target="_blank" title="facebook"><i class="fa fa-facebook"></i></a></li>
          </ul>
        </div>
        <div class="col-lg-4 col-md-2 mb-4 mb-lg-0 d-flex justify-content-center">
          <div>
            <h6 class="text-uppercase font-weight-bold mb-4">Liens</h6>
            <ul class="list-unstyled mb-0">
              <li class="mb-2"><a href="/Gestion Agence Location" class="text-muted">Acceuil</a></li>
              <li class="mb-2"><a href="<?= $viewLink ?>/voiture/nos-voiture.php" class="text-muted">Voitures</a></li>
              <li class="mb-2"><a href="<?= $viewLink ?>/agence/nos-agence.php" class="text-muted">Agences</a></li>
            </ul>
          </div>
        </div>

        <form class="col-lg-4 col-md-6 mb-lg-0" method="post" action="<?= $controllerLink ?>/utilisateurController.php?action=sendMessage&from=<?=$_SERVER['PHP_SELF']?>" id="frmContact">
          <?php
          if(isset($_SESSION["flash"]["danger"])){
        ?>
            <div class="alert alert-danger p-1">
              <?= $_SESSION["flash"]["danger"]; ?>
            </div>>
        <?php

          }else if(isset($_SESSION["flash"]["success"])){
        ?>
            <div class="alert alert-success p-1">
              <?= $_SESSION["flash"]["success"]; ?>
            </div>
        <?php
          }
          unset($_SESSION["flash"]);
        ?>
          <h6 class="text-uppercase font-weight-bold mb-2">Nous Contacter</h6>
          <p class="text-danger mb-0" id="erreurNousContacter"></p>
          <div class="form-group p-2">
            <input type="email" class="form-control" name="emailMsg" id="emailMsg" placeholder="Entrer votre E-mail" required>
          </div>
          <div class="form-group p-2">
            <textarea style="resize: none;" placeholder="Entrer votre message" class=" form-control" name="message" id="message"  rows="4" required></textarea>
          </div>
  
            <button type="submit" class="btn btn-primary float-end m-2" id="btnEnvoyerMsg" >Envoyer</button>

          
        </form>
      </div>
    </div>

    <!-- Copyrights -->
    <div class="bg-light py-3">
      <div class="container text-center">
        <p class="text-muted mb-0 py-1">© 2021 Tous les droits sont réservés.</p>
      </div>
    </div>
  </footer>
  <!-- End -->
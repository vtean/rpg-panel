    </div>
    </main>
    <footer class="dv-footer">
        <div class="dv-choose-lang">
            <a href="<?php echo BASE_URL . '/ro'; ?>"<?php if ($_SESSION['user_lang'] == 'ro'): ?>class="active"<?php endif; ?>><img src="<?php echo BASE_URL . '/public/resources/img/lang/ro.png'; ?>" alt="RO"></a>
            <a href="<?php echo BASE_URL . '/en'; ?>"<?php if ($_SESSION['user_lang'] == 'en'): ?>class="active"<?php endif; ?>><img src="<?php echo BASE_URL . '/public/resources/img/lang/en.png'; ?>" alt="EN"></a>
        </div>
        <div class="dv-copyright">
            <p>Developed with <i class="fas fa-heart"></i> and a lot of <i class="fas fa-coffee"></i> by <a href="<?php echo BASE_URL . '/users/profile/Lust'; ?>">Lust</a> and <a href="<?php echo BASE_URL . '/users/profile/Indigo'; ?>">Indigo</a></p>
            <p>© DreamVibe Community <?php echo date("Y"); ?></p>
            <p>Version 0.4 Beta</p>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="<?php echo BASE_URL . '/public/resources/3rd_party/bootstrap/bootstrap.min.js'; ?>"></script>
    <script src="<?php echo BASE_URL . '/public/resources/3rd_party/datatables/datatables.min.js'; ?>"></script>
    <script src="<?php echo BASE_URL . '/public/resources/js/scripts.js'; ?>"></script>
</body>
</html>